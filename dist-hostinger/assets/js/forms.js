/**
 * Gaurikrit Bio Products — forms.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities:
 *  - Contact form submit (fetch to /api/contact.php).
 *  - Business form submit (fetch to /api/business-enquiry.php).
 *  - Newsletter form submit (fetch to /api/newsletter.php).
 *  - Honeypot check (skip submit if honeypot filled).
 *  - CSRF token inclusion (auto-read from form's hidden input).
 *  - Field error display under each field.
 *  - Toast on success/error.
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
        var timeout = typeof o.timeout === 'number' ? o.timeout : 4500;

        var region = ensureToastRegion();
        // Remove any existing toast (only one at a time for clarity).
        var existing = region.querySelector('.toast');
        if (existing) existing.remove();

        var el = document.createElement('div');
        el.className = 'toast toast--' + type;
        el.setAttribute('role', 'status');
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
            // Wait for transition before removing.
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
        } else {
            btn.removeAttribute('disabled');
            delete btn.dataset.busy;
            var spinner2 = form.querySelector('[data-submit-spinner]');
            if (spinner2) spinner2.hidden = true;
        }
    }

    function isHoneypotFilled(form) {
        var hp = form.querySelector('.form-honeypot input[name="company"]');
        return hp && hp.value !== '';
    }

    function getCsrfToken(form) {
        var input = form.querySelector('input[name="csrf_token"]');
        return input ? input.value : '';
    }

    function collectFormData(form) {
        var data = {};
        var fields = form.querySelectorAll('input[name], select[name], textarea[name]');
        for (var i = 0; i < fields.length; i++) {
            var f = fields[i];
            // Skip honeypot — don't transmit it.
            if (f.closest('.form-honeypot')) continue;
            if (f.type === 'checkbox') {
                data[f.name] = f.checked ? '1' : '';
            } else if (f.type === 'radio') {
                if (f.checked) data[f.name] = f.value;
            } else {
                data[f.name] = f.value;
            }
        }
        return data;
    }

    // Generic submit handler.
    function handleSubmit(form, options) {
        var endpoint = options.endpoint;
        var successTitle = options.successTitle || 'Sent';
        var successMsg = options.successMsg || 'We will be in touch shortly.';
        var errorTitle = options.errorTitle || 'Could not send';
        var validationErrorTitle = options.validationErrorTitle || 'Please check the form';

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearErrors(form);

            // Honeypot — fail silently if filled (looks like a bot).
            if (isHoneypotFilled(form)) {
                toast({ title: successTitle, msg: successMsg, type: 'success' });
                form.reset();
                return;
            }

            // HTML5 native validation first.
            if (typeof form.reportValidity === 'function' && !form.reportValidity()) {
                return;
            }

            var data = collectFormData(form);
            data.csrf_token = getCsrfToken(form);

            setBusy(form, true);
            fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(function (res) {
                    return res.json().then(function (json) {
                        return { status: res.status, json: json };
                    });
                })
                .then(function (out) {
                    if (out.status >= 200 && out.status < 300) {
                        toast({ title: successTitle, msg: successMsg, type: 'success' });
                        form.reset();
                    } else {
                        var errors = out.json && out.json.errors;
                        if (errors) {
                            displayErrors(form, errors);
                            toast({
                                title: validationErrorTitle,
                                msg: 'Some fields need your attention.',
                                type: 'error'
                            });
                        } else {
                            toast({
                                title: errorTitle,
                                msg: (out.json && out.json.message) || 'Please try again in a moment.',
                                type: 'error'
                            });
                        }
                    }
                })
                .catch(function () {
                    toast({
                        title: errorTitle,
                        msg: 'Network issue — please try again, or email us directly.',
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
                successTitle: 'Message sent',
                successMsg: 'Thank you for writing in. We will reply within two business days.',
                errorTitle: 'Could not send',
                validationErrorTitle: 'Please check the form'
            });
        }
    }

    function initBusinessForms() {
        var forms = document.querySelectorAll('[data-business-form]');
        for (var i = 0; i < forms.length; i++) {
            handleSubmit(forms[i], {
                endpoint: '/api/business-enquiry.php',
                successTitle: 'Enquiry submitted',
                successMsg: 'Thank you. Our team will revert within two business days.',
                errorTitle: 'Could not submit',
                validationErrorTitle: 'Please check the form'
            });
        }
    }

    function initNewsletterForms() {
        var forms = document.querySelectorAll('[data-newsletter-form]');
        for (var i = 0; i < forms.length; i++) {
            handleSubmit(forms[i], {
                endpoint: '/api/newsletter.php',
                successTitle: 'Subscribed',
                successMsg: 'Welcome aboard. Look out for our next batch note.',
                errorTitle: 'Could not subscribe',
                validationErrorTitle: 'Please check the form'
            });
        }
    }

    G.Forms = {
        init: function () {
            initContactForms();
            initBusinessForms();
            initNewsletterForms();
        },
        toast: toast
    };
})();
