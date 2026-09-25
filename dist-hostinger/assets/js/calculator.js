/**
 * Gaurikrit Bio Products — calculator.js
 * 4-step painting budget calculator. Vanilla JS. No dependencies.
 *
 * NO RUPEE VALUES. Commercial rates have not been supplied by the
 * client; the calculator-config.php file ships with all rates set
 * to null and `enabled => false`. Until real rates are inserted
 * there, this calculator:
 *   - Walks the user through 4 project choices.
 *   - Echoes their choices back as a project summary.
 *   - Tells the user that automatic commercial rates are not yet
 *     configured.
 *   - Offers a "Request Estimate" CTA that hands the project
 *     details to the contact form via URL query params.
 *
 * === Page contract (what the page template must provide) ===
 *
 * 1. A mount element with the attribute `data-calculator`. The
 *    calculator builds its entire UI inside this element:
 *
 *        <div data-calculator></div>
 *
 * 2. OPTIONAL. A `<script type="application/json"
 *    id="calculator-config">` element containing a JSON object
 *    with this shape (mirrors includes/calculator-config.php):
 *
 *        {
 *          "enabled": false,
 *          "rates": {
 *            "distemper": { "fresh": { "interior": null, "exterior": null },
 *                            "repaint": { "interior": null, "exterior": null } },
 *            "emulsion":  { "fresh": { "interior": null, "exterior": null },
 *                            "repaint": { "interior": null, "exterior": null } }
 *          }
 *        }
 *
 *    When `enabled` is true AND all the rate cells the user's
 *    selection touches are non-null numbers, the result panel
 *    shows an estimated range. Otherwise the result panel shows
 *    the "rates not yet configured" copy. If the script tag is
 *    missing, the calculator defaults to enabled=false.
 *
 * 3. The page is responsible for any heading/hero/intro around
 *    the mount. The calculator renders ONLY the interactive 4-step
 *    widget (progress indicator, step panels, result panel).
 *
 * Exposes: window.GaurikritApp.Calculator.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    // ---- Option labels (display text per value) ----
    var LABELS = {
        painting_type: {
            fresh:   'Fresh Painting',
            repaint: 'Repainting'
        },
        location: {
            interior: 'Interior',
            exterior: 'Exterior'
        },
        paint: {
            distemper: 'Prakritik Distemper',
            emulsion:  'Prakritik Emulsion'
        }
    };

    var STEP_KEYS = ['painting_type', 'location', 'paint', 'area'];
    var TOTAL_STEPS = 4;

    // ---- Read the calculator-config JSON from the page, if any. ----
    function readConfig() {
        var script = document.getElementById('calculator-config');
        if (!script) {
            return { enabled: false, rates: null };
        }
        var raw = '';
        try {
            raw = script.textContent || script.innerText || '';
        } catch (e) {
            raw = '';
        }
        if (!raw.trim()) {
            return { enabled: false, rates: null };
        }
        try {
            var parsed = JSON.parse(raw);
            if (typeof parsed !== 'object' || parsed === null) {
                return { enabled: false, rates: null };
            }
            return {
                enabled: parsed.enabled === true,
                rates: parsed.rates || null
            };
        } catch (e) {
            return { enabled: false, rates: null };
        }
    }

    // ---- Small DOM helpers ----
    function el(tag, attrs, children) {
        var node = document.createElement(tag);
        if (attrs) {
            for (var k in attrs) {
                if (!Object.prototype.hasOwnProperty.call(attrs, k)) continue;
                if (k === 'class') {
                    node.className = attrs[k];
                } else if (k === 'text') {
                    node.textContent = attrs[k];
                } else if (k === 'html') {
                    node.innerHTML = attrs[k];
                } else if (attrs[k] !== null && attrs[k] !== undefined) {
                    node.setAttribute(k, attrs[k]);
                }
            }
        }
        if (children) {
            if (!Array.isArray(children)) children = [children];
            for (var i = 0; i < children.length; i++) {
                var c = children[i];
                if (c == null) continue;
                if (typeof c === 'string' || typeof c === 'number') {
                    node.appendChild(document.createTextNode(String(c)));
                } else if (c.nodeType) {
                    node.appendChild(c);
                }
            }
        }
        return node;
    }

    // ---- Build the calculator UI inside the mount ----
    function buildUI(mount, cfg) {
        // Clean slate (in case init() is called twice).
        mount.innerHTML = '';
        mount.setAttribute('data-calculator-ready', 'true');

        var root = el('div', { class: 'calc', role: 'group', 'aria-label': 'Painting budget calculator' });

        // ---- Progress indicator ----
        var progress = el('ol', { class: 'calc__progress', 'data-calc-progress': '', 'aria-label': 'Calculator steps' });
        var stepLabels = ['Type', 'Location', 'Paint', 'Area'];
        for (var i = 0; i < TOTAL_STEPS; i++) {
            var li = el('li', { class: 'calc__progress-item', 'data-step': String(i + 1) });
            var dot = el('span', { class: 'calc__progress-dot', 'aria-hidden': 'true', text: String(i + 1) });
            var lbl = el('span', { class: 'calc__progress-label', text: stepLabels[i] });
            li.appendChild(dot);
            li.appendChild(lbl);
            // Whole pill is a button so users can jump back to a prior step.
            var btn = el('button', {
                type: 'button',
                class: 'calc__progress-btn',
                'aria-label': 'Go to step ' + (i + 1) + ': ' + stepLabels[i],
                'data-goto-step': String(i + 1)
            });
            // Move dot + label inside the button.
            li.innerHTML = '';
            btn.appendChild(dot);
            btn.appendChild(lbl);
            li.appendChild(btn);
            progress.appendChild(li);
        }
        root.appendChild(progress);

        // ---- Step 1: What are you painting? ----
        root.appendChild(buildStep(1, 'What are you painting?', 'painting_type', [
            { value: 'fresh',   title: 'Fresh Painting', desc: 'New walls or first-time paint.' },
            { value: 'repaint', title: 'Repainting',     desc: 'Refresh existing painted walls.' }
        ]));

        // ---- Step 2: Where? ----
        root.appendChild(buildStep(2, 'Where?', 'location', [
            { value: 'interior', title: 'Interior', desc: 'Indoor walls and ceilings.' },
            { value: 'exterior', title: 'Exterior', desc: 'Outside walls and facades.' }
        ]));

        // ---- Step 3: Choose Paint ----
        root.appendChild(buildStep(3, 'Choose Paint', 'paint', [
            { value: 'distemper', title: 'Prakritik Distemper', desc: 'Cow-dung-based distemper paint.' },
            { value: 'emulsion',  title: 'Prakritik Emulsion',  desc: 'Cow-dung-based emulsion paint.' }
        ]));

        // ---- Step 4: Wall Area ----
        var step4 = el('section', { class: 'calc__step', 'data-calc-step': '4', hidden: '' });
        step4.appendChild(el('h2', { class: 'calc__step-title', text: 'Wall Area' }));
        step4.appendChild(el('p', { class: 'calc__step-help', text: 'Enter the total wall area you want painted.' }));

        var field = el('div', { class: 'calc__field' });
        var label = el('label', { class: 'form-label', for: 'calc-area', text: 'Wall area (sq.ft.)' });
        var input = el('input', {
            class: 'form-input',
            id: 'calc-area',
            type: 'number',
            name: 'area',
            min: '1',
            step: '1',
            inputmode: 'numeric',
            placeholder: 'e.g. 1200',
            'data-calc-input': 'area',
            autocomplete: 'off'
        });
        var errBox = el('div', { class: 'form-error', 'data-calc-error': 'area' });
        field.appendChild(label);
        field.appendChild(input);
        field.appendChild(errBox);
        step4.appendChild(field);

        var calcBtn = el('button', {
            type: 'button',
            class: 'btn btn--primary btn--lg',
            'data-calc-calculate': '',
            text: 'Calculate Estimate'
        });
        step4.appendChild(calcBtn);
        root.appendChild(step4);

        // ---- Result panel ----
        var result = el('section', { class: 'calc__result', 'data-calc-result': '', hidden: '', 'aria-live': 'polite' });
        result.appendChild(el('p', { class: 'calc__result-eyebrow', text: 'YOUR PROJECT' }));

        var list = el('dl', { class: 'calc__result-list' });
        list.appendChild(buildResultRow('Painting type', 'painting_type'));
        list.appendChild(buildResultRow('Location', 'location'));
        list.appendChild(buildResultRow('Paint', 'paint'));
        list.appendChild(buildResultRow('Wall area', 'area'));
        result.appendChild(list);

        // Rate line — populated dynamically.
        result.appendChild(el('p', { class: 'calc__result-rate', 'data-calc-rate': '', hidden: '' }));

        // Truthful copy: rates not configured.
        result.appendChild(el('p', {
            class: 'calc__result-note',
            text: 'Share this summary with Gaurikrit to discuss your project.'
        }));
        result.appendChild(el('p', {
            class: 'calc__result-cta-copy',
            text: 'For an accurate estimate, send these project details to Gaurikrit.'
        }));

        // CTA — link to the contact form with the project details as query params.
        var ctaWrap = el('div', { class: 'calc__result-actions' });
        var cta = el('a', {
            class: 'btn btn--primary btn--lg',
            'data-calc-cta': '',
            // Relative to the calculator page (/paint-calculator/) — works
            // on Hostinger, GitHub Pages and any sub-directory preview.
            href: '../contact/?interest=bulk-project',
            text: 'Request Estimate'
        });
        // V13: Copy-summary button — reuses the shared [data-copy]
        // clipboard handler from app.js (label swaps to "Copied" for 2s,
        // hidden automatically when the Clipboard API is unavailable).
        // The data-copy payload is refreshed every time a result renders.
        var copyBtn = el('button', {
            type: 'button',
            class: 'btn btn--outline',
            'data-calc-copy': '',
            'data-copy': '',
            'aria-label': 'Copy project summary to clipboard'
        });
        copyBtn.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" ' +
            'stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' +
            'aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/>' +
            '<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>' +
            '<span class="copy-btn__label">Copy summary</span>';
        var reset = el('button', {
            type: 'button',
            class: 'btn btn--outline',
            'data-calc-reset': '',
            text: 'Start over'
        });
        // V15: Print-summary button — window.print() plus the app.css
        // §36.8 print rules turn the computed result into an estimate
        // sheet (the page's .calc-print-sheet block provides the company
        // header; the date line is stamped before printing).
        var printBtn = el('button', {
            type: 'button',
            class: 'btn btn--outline',
            'data-calc-print': '',
            'aria-label': 'Print this project summary'
        });
        printBtn.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" ' +
            'stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ' +
            'aria-hidden="true"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>' +
            '<span class="copy-btn__label">Print summary</span>';
        ctaWrap.appendChild(cta);
        ctaWrap.appendChild(copyBtn);
        ctaWrap.appendChild(reset);
        ctaWrap.appendChild(printBtn);
        result.appendChild(ctaWrap);

        root.appendChild(result);

        mount.appendChild(root);
        return {
            root: root,
            progress: progress,
            input: input,
            errBox: errBox,
            calcBtn: calcBtn,
            result: result,
            cta: cta,
            copyBtn: copyBtn,
            printBtn: printBtn
        };
    }

    function buildStep(num, title, optionKey, options) {
        var s = el('section', { class: 'calc__step', 'data-calc-step': String(num), hidden: '' });
        s.appendChild(el('h2', { class: 'calc__step-title', text: title }));
        var cards = el('div', { class: 'calc__cards', role: 'group', 'aria-label': title });
        for (var i = 0; i < options.length; i++) {
            var o = options[i];
            var card = el('button', {
                type: 'button',
                class: 'calc__card',
                'data-calc-option': optionKey,
                'data-value': o.value,
                'aria-pressed': 'false'
            });
            card.appendChild(el('span', { class: 'calc__card-title', text: o.title }));
            if (o.desc) {
                card.appendChild(el('span', { class: 'calc__card-desc', text: o.desc }));
            }
            cards.appendChild(card);
        }
        s.appendChild(cards);
        return s;
    }

    function buildResultRow(labelText, key) {
        var row = el('div', { class: 'calc__result-row' });
        row.appendChild(el('dt', { class: 'calc__result-key', text: labelText }));
        row.appendChild(el('dd', { class: 'calc__result-val', 'data-calc-out': key }));
        return row;
    }

    // ---- State machine ----
    function createController(mount, ui, cfg) {
        var state = {
            painting_type: null,
            location: null,
            paint: null,
            area: null
        };
        var current = 1;

        function showStep(n) {
            n = Math.max(1, Math.min(TOTAL_STEPS, n));
            current = n;
            var steps = ui.root.querySelectorAll('[data-calc-step]');
            for (var i = 0; i < steps.length; i++) {
                var step = steps[i];
                var n2 = parseInt(step.getAttribute('data-calc-step'), 10);
                if (n2 === n) {
                    step.removeAttribute('hidden');
                } else {
                    step.setAttribute('hidden', '');
                }
            }
            updateProgress();
            // Move focus into the visible step for screen-reader + keyboard users.
            // Tiny delay so the browser finishes the layout swap.
            window.setTimeout(function () {
                var visible = ui.root.querySelector('[data-calc-step="' + n + '"]:not([hidden])');
                if (!visible) return;
                // Focus the step title for AT, fall back to first focusable.
                var title = visible.querySelector('.calc__step-title');
                if (title) {
                    title.setAttribute('tabindex', '-1');
                    title.focus();
                }
            }, 0);
        }

        function updateProgress() {
            var items = ui.progress.querySelectorAll('.calc__progress-item');
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                var stepNum = parseInt(item.getAttribute('data-step'), 10);
                item.classList.toggle('is-done', stepNum < current);
                item.classList.toggle('is-current', stepNum === current);
                var btn = item.querySelector('.calc__progress-btn');
                if (btn) {
                    // Disable going forward (only allow going back).
                    if (stepNum >= current) {
                        btn.setAttribute('disabled', '');
                        btn.setAttribute('aria-disabled', 'true');
                    } else {
                        btn.removeAttribute('disabled');
                        btn.removeAttribute('aria-disabled');
                    }
                }
            }
        }

        function clearSelected(optionKey) {
            var cards = ui.root.querySelectorAll('[data-calc-option="' + optionKey + '"]');
            for (var i = 0; i < cards.length; i++) {
                cards[i].classList.remove('is-active');
                cards[i].setAttribute('aria-pressed', 'false');
            }
        }

        function markSelected(optionKey, value) {
            var card = ui.root.querySelector(
                '[data-calc-option="' + optionKey + '"][data-value="' + value + '"]'
            );
            if (card) {
                card.classList.add('is-active');
                card.setAttribute('aria-pressed', 'true');
            }
        }

        function selectOption(optionKey, value) {
            clearSelected(optionKey);
            state[optionKey] = value;
            markSelected(optionKey, value);
            // Advance to the next step.
            var stepIndex = STEP_KEYS.indexOf(optionKey);
            if (stepIndex >= 0 && stepIndex + 1 <= TOTAL_STEPS) {
                showStep(stepIndex + 2);
            }
        }

        function gotoStep(n) {
            // Don't allow skipping forward beyond a filled step.
            if (n > 1) {
                for (var i = 0; i < n - 1; i++) {
                    if (!state[STEP_KEYS[i]]) return;
                }
            }
            // If jumping back to a step before the area step, clear the area
            // error so the user gets a clean slate.
            if (n < 4) {
                ui.errBox.textContent = '';
            }
            showStep(n);
        }

        function formatValue(key, value) {
            if (value === null || value === undefined || value === '') return '—';
            if (key === 'area') {
                var n = Number(value);
                if (!isFinite(n)) return String(value);
                // Group thousands for readability.
                try {
                    return n.toLocaleString('en-IN') + ' sq.ft.';
                } catch (e) {
                    return n + ' sq.ft.';
                }
            }
            var map = LABELS[key] || {};
            return map[value] || String(value);
        }

        // V15: stamp the "Prepared on" line of the page's print-only
        // estimate header (.calc-print-sheet). Called on every calculated
        // result (so Ctrl/Cmd+P users get it too) and right before the
        // print button fires.
        function stampPrintDate() {
            var line = document.querySelector('[data-print-date]');
            if (!line) return;
            var d = new Date();
            var text;
            try {
                text = d.toLocaleDateString('en-IN', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
            } catch (err) {
                text = d.toDateString();
            }
            line.textContent = 'Prepared on ' + text;
        }

        function calculate() {
            // Validate all 4 steps.
            ui.errBox.textContent = '';

            // Defensive: all of painting_type/location/paint must be set
            // (they were filled by selection). Still, check.
            if (!state.painting_type || !state.location || !state.paint) {
                // Find the first unfilled step and jump there.
                for (var i = 0; i < 3; i++) {
                    if (!state[STEP_KEYS[i]]) {
                        showStep(i + 1);
                        return;
                    }
                }
            }

            // Area must be a positive number.
            var raw = ui.input.value;
            var areaNum = parseFloat(raw);
            if (!raw.trim() || isNaN(areaNum) || areaNum <= 0) {
                ui.errBox.textContent = 'Please enter a positive number for the wall area.';
                ui.input.focus();
                return;
            }
            state.area = String(Math.floor(areaNum));

            // Render result.
            var outs = ui.result.querySelectorAll('[data-calc-out]');
            for (var j = 0; j < outs.length; j++) {
                var node = outs[j];
                var key = node.getAttribute('data-calc-out');
                node.textContent = formatValue(key, state[key]);
            }

            // Rate line (only if rates are enabled AND the selected cell is a
            // non-null number).
            renderRateLine(cfg);

            // Build the CTA URL with the project details.
            var url = '../contact/?interest=bulk-project' +
                '&painting_type=' + encodeURIComponent(state.painting_type || '') +
                '&location=' + encodeURIComponent(state.location || '') +
                '&paint=' + encodeURIComponent(state.paint || '') +
                '&area=' + encodeURIComponent(state.area || '');
            ui.cta.setAttribute('href', url);

            // V13: refresh the copy-summary payload to match this result.
            if (ui.copyBtn) {
                ui.copyBtn.setAttribute('data-copy',
                    'Prakritik Paint project details\n' +
                    'Painting type: ' + formatValue('painting_type', state.painting_type) + '\n' +
                    'Location: ' + formatValue('location', state.location) + '\n' +
                    'Paint: ' + formatValue('paint', state.paint) + '\n' +
                    'Wall area: ' + formatValue('area', state.area));
            }

            // Hide all step panels; show the result.
            var steps = ui.root.querySelectorAll('[data-calc-step]');
            for (var k = 0; k < steps.length; k++) {
                steps[k].setAttribute('hidden', '');
            }
            ui.result.removeAttribute('hidden');
            // V15: keep the print-sheet date in sync with this result.
            stampPrintDate();
            // Mark every progress dot as done.
            var items = ui.progress.querySelectorAll('.calc__progress-item');
            for (var m = 0; m < items.length; m++) {
                items[m].classList.add('is-done');
                items[m].classList.remove('is-current');
            }
            // Focus the result heading for AT users.
            window.setTimeout(function () {
                var eyebrow = ui.result.querySelector('.calc__result-eyebrow');
                if (eyebrow) {
                    eyebrow.setAttribute('tabindex', '-1');
                    eyebrow.focus();
                }
            }, 0);
        }

        function renderRateLine(cfgObj) {
            var rateEl = ui.result.querySelector('[data-calc-rate]');
            if (!rateEl) return;
            rateEl.hidden = true;
            rateEl.textContent = '';
            if (!cfgObj || !cfgObj.enabled || !cfgObj.rates) return;
            try {
                var rate = cfgObj.rates[state.paint] &&
                           cfgObj.rates[state.paint][state.painting_type] &&
                           cfgObj.rates[state.paint][state.painting_type][state.location];
                if (typeof rate === 'number' && isFinite(rate) && rate > 0) {
                    var area = Number(state.area);
                    var total = rate * area;
                    rateEl.textContent = 'Estimated paint cost: \u20B9' + total.toLocaleString('en-IN') +
                        ' (\u20B9' + rate.toLocaleString('en-IN') + ' / sq.ft. \u00D7 ' +
                        area.toLocaleString('en-IN') + ' sq.ft.)';
                    rateEl.hidden = false;
                }
            } catch (e) {
                rateEl.hidden = true;
            }
        }

        function reset() {
            state.painting_type = null;
            state.location = null;
            state.paint = null;
            state.area = null;
            ui.input.value = '';
            ui.errBox.textContent = '';
            clearSelected('painting_type');
            clearSelected('location');
            clearSelected('paint');
            ui.result.setAttribute('hidden', '');
            showStep(1);
        }

        // ---- Wire events ----
        // Card clicks (event delegation).
        ui.root.addEventListener('click', function (e) {
            var card = e.target.closest('[data-calc-option]');
            if (card) {
                selectOption(
                    card.getAttribute('data-calc-option'),
                    card.getAttribute('data-value')
                );
                return;
            }
            var calcBtnHit = e.target.closest('[data-calc-calculate]');
            if (calcBtnHit) {
                calculate();
                return;
            }
            var resetHit = e.target.closest('[data-calc-reset]');
            if (resetHit) {
                reset();
                return;
            }
            // V15: print the estimate sheet (steps/hero chrome drop away
            // via app.css §36.8; the date line is stamped first).
            var printHit = e.target.closest('[data-calc-print]');
            if (printHit) {
                stampPrintDate();
                if (window.print) window.print();
                return;
            }
            var gotoHit = e.target.closest('[data-goto-step]');
            if (gotoHit) {
                var n = parseInt(gotoHit.getAttribute('data-goto-step'), 10);
                if (!isNaN(n)) gotoStep(n);
                return;
            }
        });

        // Enter key on the area input triggers calculate.
        ui.input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                calculate();
            }
        });

        // Initial state.
        showStep(1);

        // ---- V14: deep links (?painting_type=&location=&paint=&area=) ----
        // A shared link (or the contact page's "recalculate" journey) can
        // open the calculator pre-filled. Same param names the result CTA
        // sends to the contact page. All four present → jump straight to
        // the computed result; partial → open the first unfilled step.
        function applyQueryDefaults() {
            if (!window.URLSearchParams) return;
            var params = new URLSearchParams(window.location.search);
            var VALID = {
                painting_type: ['fresh', 'repaint'],
                location: ['interior', 'exterior'],
                paint: ['distemper', 'emulsion']
            };
            var provided = {};
            for (var key in VALID) {
                if (!Object.prototype.hasOwnProperty.call(VALID, key)) continue;
                var v = params.get(key);
                if (v && VALID[key].indexOf(v) >= 0) provided[key] = v;
            }
            var areaRaw = params.get('area');
            var areaNum = areaRaw !== null ? parseFloat(areaRaw) : NaN;
            var hasArea = isFinite(areaNum) && areaNum > 0;

            var any = hasArea;
            for (var k in provided) { any = true; selectOption(k, provided[k]); }
            if (!any) return; // plain visit — normal step-1 start

            if (hasArea) ui.input.value = String(Math.floor(areaNum));

            if (provided.painting_type && provided.location && provided.paint && hasArea) {
                calculate();
                return;
            }
            // Partial prefill → land on the first missing step.
            var order = ['painting_type', 'location', 'paint'];
            for (var i = 0; i < order.length; i++) {
                if (!provided[order[i]]) { showStep(i + 1); return; }
            }
            showStep(4);
        }
        applyQueryDefaults();

        return {
            reset: reset,
            showStep: showStep,
            state: state
        };
    }

    // ---- Init ----
    function init() {
        var mounts = document.querySelectorAll('[data-calculator]');
        for (var i = 0; i < mounts.length; i++) {
            (function (mount) {
                if (mount.getAttribute('data-calculator-ready') === 'true') return;
                var cfg = readConfig();
                var ui = buildUI(mount, cfg);
                createController(mount, ui, cfg);
            })(mounts[i]);
        }
    }

    G.Calculator = {
        init: init
    };
})();
