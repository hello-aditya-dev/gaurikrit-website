/**
 * Gaurikrit Bio Products — forms.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities:
 *  - Contact form submit (fetch POST to /api/contact.php) with CSRF +
 *    honeypot. Sends as application/x-www-form-urlencoded so the PHP
 *    backend can populate $_POST directly.
 *  - Business form submit (same pattern, posts to
 *    /api/business-enquiry.php).
 *  - NO newsletter form handling.
 *  - Honeypot: if the hidden field is filled, do not submit — return
 *    fake success.
 *  - Field error display under each field.
 *  - Toast on success / error / network failure.
 *  - Pre-fill the contact form's interest select from ?interest= query.
 *
 * Toast contract:
 *  - Success → forest border-left, dismissible, auto-hide after 5s.
 *  - Error   → red border-left, dismissible, auto-hide after 5s.
 *
 * Exposes: window.GaurikritApp.Forms.init()
 *          window.GaurikritApp.Forms.toast(opts) — for other modules.
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    // ---- Toast helper ----
    function ensureToastRegion() {
        var region = document.querySelector('[data-toast-region]');
        if (!region) {
            region = document.createElement('div');
            region.className = 'toast-region';
            region.setAttribute('data-toast-region', '');
            region.setAttribute('aria-live', 'polite');
            region.setAttribute('aria-atomic', 'true');
            document.body.appendChild(region);
        }
        return region;
    }

    function toast(opts) {
        var o = opts || {};
        var title = o.title || '';
        var msg = o.msg || '';
        var type = o.type || 'success';
        var timeout = typeof o.timeout === 'number' ? o.timeout : 5000;

        var region = ensureToastRegion();
        // Remove any existing toast (one at a time for clarity).
        var existing = region.querySelector('.toast');
        if (existing) existing.remove();

        var el = document.createElement('div');
        el.className = 'toast toast--' + type;
        el.setAttribute('role', type === 'error' ? 'alert' : 'status');
        el.innerHTML =
            (title ? '<div class="toast__title"></div>' : '') +
            (msg ? '<div class="toast__msg"></div>' : '');
        if (title) el.querySelector('.toast__title').textContent = title;
        if (msg) el.querySelector('.toast__msg').textContent = msg;
        region.appendChild(el);

        // Force reflow then show.
        void el.offsetWidth;
        el.setAttribute('data-show', 'true');

        var t = setTimeout(function () {
            el.removeAttribute('data-show');
            setTimeout(function () { el.remove(); }, prefersReducedMotion() ? 0 : 350);
        }, timeout);

        // Click to dismiss.
        el.addEventListener('click', function () {
            clearTimeout(t);
            el.removeAttribute('data-show');
            setTimeout(function () { el.remove(); }, prefersReducedMotion() ? 0 : 350);
        });
    }

    // ---- Field errors ----
    function clearErrors(form) {
        var errs = form.querySelectorAll('[data-error-for]');
        for (var i = 0; i < errs.length; i++) {
            errs[i].textContent = '';
        }
    }

    function setError(form, field, message) {
        var holder = form.querySelector('[data-error-for="' + field + '"]');
        if (holder) holder.textContent = message;
    }

    function displayErrors(form, errors) {
        if (!errors || typeof errors !== 'object') return;
        Object.keys(errors).forEach(function (key) {
            setError(form, key, errors[key]);
        });
    }

    function setBusy(form, busy) {
        var btn = form.querySelector('[type="submit"]');
        if (!btn) return;
        if (busy) {
            btn.setAttribute('disabled', 'disabled');
            btn.dataset.busy = '1';
            var spinner = form.querySelector('[data-submit-spinner]');
            if (spinner) spinner.hidden = false;
            var label = form.querySelector('[data-submit-label]');
            if (label) label.textContent = 'Sending…';
        } else {
            btn.removeAttribute('disabled');
            delete btn.dataset.busy;
            var spinner2 = form.querySelector('[data-submit-spinner]');
            if (spinner2) spinner2.hidden = true;
            var label2 = form.querySelector('[data-submit-label]');
            if (label2) {
                // Restore the original label (stashed on first busy).
                var original = label2.getAttribute('data-original-label');
                if (original) label2.textContent = original;
            }
        }
    }

    function isHoneypotFilled(form) {
        // Standard honeypot field name across both forms.
        var hp = form.querySelector('.form-honeypot input[name="company"]');
        return !!(hp && hp.value !== '');
    }

    function getCsrfToken(form) {
        var input = form.querySelector('input[name="csrf_token"]');
        return input ? input.value : '';
    }

    function collectFormEntries(form) {
        var fields = form.querySelectorAll('input[name], select[name], textarea[name]');
        var entries = [];
        for (var i = 0; i < fields.length; i++) {
            var f = fields[i];
            if (f.closest('.form-honeypot')) continue; // never transmit honeypot
            if (f.type === 'checkbox') {
                entries.push([f.name, f.checked ? '1' : '']);
            } else if (f.type === 'radio') {
                if (f.checked) entries.push([f.name, f.value]);
            } else {
                entries.push([f.name, f.value]);
            }
        }
        // Append the CSRF token explicitly so it is always present even
        // if the page template uses an unusual input placement.
        var csrf = getCsrfToken(form);
        if (csrf) {
            var hasCsrf = false;
            for (var k = 0; k < entries.length; k++) {
                if (entries[k][0] === 'csrf_token') { hasCsrf = true; break; }
            }
            if (!hasCsrf) entries.push(['csrf_token', csrf]);
        }
        return entries;
    }

    function urlEncode(entries) {
        // application/x-www-form-urlencoded, percent-encoded per spec.
        return entries.map(function (pair) {
            return encodeURIComponent(pair[0]) + '=' + encodeURIComponent(pair[1]);
        }).join('&').replace(/%20/g, '+');
    }

    // Generic submit handler.
    // options.endpoint           — URL
    // options.successMsg         — toast body on success
    // options.networkErrorMsg    — toast body when fetch throws
    function handleSubmit(form, options) {
        var endpoint = options.endpoint;
        var successMsg = options.successMsg || 'Thank you. Your enquiry has been sent.';
        var networkErrorMsg = options.networkErrorMsg ||
            'We could not submit your enquiry right now. Please contact Gaurikrit directly by phone or email.';

        // Stash the original submit label so setBusy can restore it.
        var label = form.querySelector('[data-submit-label]');
        if (label && !label.getAttribute('data-original-label')) {
            label.setAttribute('data-original-label', label.textContent.trim());
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearErrors(form);

            // Honeypot — fail silently if filled (looks like a bot).
            if (isHoneypotFilled(form)) {
                toast({
                    title: 'Enquiry sent',
                    msg: successMsg,
                    type: 'success'
                });
                form.reset();
                return;
            }

            // HTML5 native validation first.
            if (typeof form.reportValidity === 'function' && !form.reportValidity()) {
                return;
            }

            // The GitHub Pages preview cannot run the PHP mail endpoint.
            // Open an email draft and let the visitor send it explicitly.
            if (form.hasAttribute('data-static-preview')) {
                var parts = collectFormEntries(form).filter(function (entry) {
                    return entry[0] !== 'csrf_token' && entry[0] !== 'consent';
                }).map(function (entry) { return entry[0] + ': ' + entry[1]; });
                var subject = form.hasAttribute('data-business-form') ?
                    'Gaurikrit business enquiry' : 'Gaurikrit product enquiry';
                window.location.href = 'mailto:seva@gaurikrit.com?subject=' +
                    encodeURIComponent(subject) + '&body=' + encodeURIComponent(parts.join('\n'));
                toast({title:'Email draft opened',msg:'Please send the draft from your email app.',type:'success'});
                return;
            }

            var body = urlEncode(collectFormEntries(form));

            setBusy(form, true);
            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'Accept': 'application/json'
                },
                body: body,
                credentials: 'same-origin'
            })
                .then(function (res) {
                    return res.json().then(function (json) {
                        return { status: res.status, json: json };
                    }, function () {
                        // Non-JSON response — treat as a generic error.
                        return { status: res.status, json: null };
                    });
                })
                .then(function (out) {
                    if (out.status >= 200 && out.status < 300) {
                        // Truthful response: prefer the server's `message`
                        // field (which differs when SMTP fails but DB saved,
                        // or when the enquiry is saved for later). Fall back
                        // to the canonical success copy only if the server
                        // did not provide one.
                        var okJson = out.json || {};
                        var msg = okJson.message || successMsg;
                        toast({
                            title: 'Enquiry sent',
                            msg: msg,
                            type: 'success'
                        });
                        form.reset();
                    } else {
                        var json = out.json || {};
                        var errors = json.fields || json.errors;
                        if (errors) {
                            displayErrors(form, errors);
                        }
                        var serverMsg = json.error || json.message;
                        toast({
                            title: 'Could not send',
                            msg: serverMsg || 'Please review the form and try again.',
                            type: 'error'
                        });
                    }
                })
                .catch(function () {
                    // Network failure / CORS / DNS — fetch threw.
                    toast({
                        title: 'Network issue',
                        msg: networkErrorMsg,
                        type: 'error'
                    });
                })
                .finally(function () {
                    setBusy(form, false);
                });
        });
    }

    function initContactForms() {
        var forms = document.querySelectorAll('[data-contact-form]');
        for (var i = 0; i < forms.length; i++) {
            handleSubmit(forms[i], {
                endpoint: '/api/contact.php',
                successMsg: 'Thank you. Your enquiry has been sent.',
                networkErrorMsg: 'We could not submit your enquiry right now. Please contact Gaurikrit directly by phone or email.'
            });
        }
        prefillInterestFromQuery();
    }

    function initBusinessForms() {
        var forms = document.querySelectorAll('[data-business-form]');
        for (var i = 0; i < forms.length; i++) {
            handleSubmit(forms[i], {
                endpoint: '/api/business-enquiry.php',
                successMsg: 'Thank you. Your enquiry has been sent.',
                networkErrorMsg: 'We could not submit your enquiry right now. Please contact Gaurikrit directly by phone or email.'
            });
        }
    }

    // Pre-fill the contact form's interest select from ?interest=.
    // The PHP page template already does this server-side, but doing it
    // again client-side covers SPA-style navigation and any future
    // contact form embedded elsewhere.
    function prefillInterestFromQuery() {
        if (!window.URLSearchParams) return;
        var params = new URLSearchParams(window.location.search);
        var interest = params.get('interest');
        if (!interest) return;

        var contactForm = document.querySelector('[data-contact-form]');
        if (!contactForm) return;
        var select = contactForm.querySelector('select[name="interest"]');
        if (!select) return;

        // Only pre-fill if the value is one of the offered options —
        // otherwise leave the select blank and let the user choose.
        var options = select.querySelectorAll('option');
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === interest) {
                select.value = interest;
                return;
            }
        }
    }

    G.Forms = {
        init: function () {
            initContactForms();
            initBusinessForms();
        },
        toast: toast
    };
})();
