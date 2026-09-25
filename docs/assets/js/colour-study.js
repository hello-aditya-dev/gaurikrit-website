/**
 * Gaurikrit Bio Products — colour-study.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Simple colour-wall visualizer. On any page where a [data-colour-study]
 * element exists, clicking a swatch button changes the wall preview's
 * background colour and updates the active label.
 *
 * Shade values may be ANY CSS color (hex / rgb / oklch / named). The
 * canonical attribute is [data-shade]; [data-shade-hex] is read as a
 * fallback for older page templates. The label is read from
 * [data-shade-name] (or the swatch's aria-label).
 *
 * Keyboard (V13): the swatches are a radiogroup, so arrows navigate.
 * ArrowRight/ArrowDown move forward, ArrowLeft/ArrowUp back, Home/End
 * jump to the first/last swatch. Moving focus also selects (standard
 * radio behaviour). Roving tabindex: only the checked (or first)
 * swatch is tabbable; every other one is reached via arrow keys.
 *
 * Deep links (V14): selecting a swatch writes #colour=<id> to the URL
 * (history.replaceState — no history spam, no scroll jump). Opening
 * the page with a matching #colour=<id> applies that swatch on load,
 * so a chosen wall colour can be shared as a link. Swatches without
 * a data-colour-id simply skip the URL sync.
 *
 * Exposes: window.GaurikritApp.ColourStudy.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function initStudy(wrapper) {
        var swatches = wrapper.querySelectorAll('[data-shade], [data-shade-hex]');
        var wall = wrapper.querySelector('[data-colour-wall]');
        var label = wrapper.querySelector('[data-colour-label]');
        if (!swatches.length || !wall) return;

        function applySwatch(swatch, opts) {
            var colour = swatch.getAttribute('data-shade') ||
                         swatch.getAttribute('data-shade-hex') || '';
            var name = swatch.getAttribute('data-shade-name') ||
                       swatch.getAttribute('aria-label') || '';
            if (colour) wall.style.setProperty('--wall-color', colour);
            if (label && name) label.textContent = name;

            for (var k = 0; k < swatches.length; k++) {
                swatches[k].setAttribute('data-active', 'false');
                swatches[k].setAttribute('aria-checked', 'false');
                swatches[k].setAttribute('tabindex', '-1');
            }
            swatch.setAttribute('data-active', 'true');
            swatch.setAttribute('aria-checked', 'true');
            swatch.setAttribute('tabindex', '0');

            // V14: reflect the selection in the URL so the chosen wall
            // colour is shareable. replaceState = no history entry, no
            // scroll. Skipped silently when called from the initial hash
            // restore (nothing to change) or for id-less swatches.
            var id = swatch.getAttribute('data-colour-id');
            if (id && !(opts && opts.fromHash) && window.history && history.replaceState) {
                history.replaceState(null, '',
                    location.pathname + location.search + '#colour=' + id);
            }

            // V14: reveal the quiet "Copy link to this colour" button and
            // point the shared [data-copy] clipboard handler (app.js) at
            // the full URL — the handler reads data-copy at click time,
            // so refreshing the attribute here is enough. The canCopy
            // guard mirrors app.js: on non-secure contexts app.js hides
            // every copy button, so we must not re-reveal this one.
            var copyBtn = wrapper.querySelector('[data-colour-copy]');
            var canCopy = (window.isSecureContext === true || window.isSecureContext === undefined);
            if (copyBtn && id && canCopy) {
                copyBtn.setAttribute('data-copy',
                    location.origin + location.pathname + location.search + '#colour=' + id);
                copyBtn.removeAttribute('hidden');
            }
        }

        // Roving tabindex: before any selection, only the first swatch
        // is tabbable (radio-group semantics).
        swatches[0].setAttribute('tabindex', '0');
        for (var r = 1; r < swatches.length; r++) {
            swatches[r].setAttribute('tabindex', '-1');
        }

        for (var i = 0; i < swatches.length; i++) {
            (function (swatch, index) {
                function apply() {
                    applySwatch(swatch);
                }

                swatch.addEventListener('click', apply);

                // Keyboard support for non-button elements.
                if (swatch.tagName !== 'BUTTON') {
                    swatch.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            apply();
                        }
                    });
                }

                // Radiogroup arrow navigation (buttons AND non-buttons —
                // native buttons get no arrow handling for free).
                swatch.addEventListener('keydown', function (e) {
                    var next = -1;
                    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                        next = (index + 1) % swatches.length;
                    } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                        next = (index - 1 + swatches.length) % swatches.length;
                    } else if (e.key === 'Home') {
                        next = 0;
                    } else if (e.key === 'End') {
                        next = swatches.length - 1;
                    }
                    if (next < 0) return;
                    e.preventDefault();
                    applySwatch(swatches[next]);
                    swatches[next].focus();
                });
            })(swatches[i], i);
        }

        // V14: restore a shared wall colour from #colour=<id> on load.
        var m = /^#colour=([a-z-]+)$/.exec(location.hash || '');
        if (m) {
            for (var h = 0; h < swatches.length; h++) {
                if (swatches[h].getAttribute('data-colour-id') === m[1]) {
                    applySwatch(swatches[h], { fromHash: true });
                    // V15: the hash matches no element id, so the browser
                    // keeps deep-link arrivals at the top of the page —
                    // quietly bring the study into view instead. Honors
                    // prefers-reduced-motion; scroll-margin-top (app.css
                    // §41.1) keeps the sticky header clear of it.
                    var reduce = window.matchMedia &&
                        window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    try {
                        wrapper.scrollIntoView({
                            behavior: reduce ? 'auto' : 'smooth',
                            block: 'start'
                        });
                    } catch (err) { /* older engines: scrollIntoView() only */ }
                    break;
                }
            }
        }
    }

    G.ColourStudy = {
        init: function () {
            var studies = document.querySelectorAll('[data-colour-study]');
            for (var i = 0; i < studies.length; i++) {
                initStudy(studies[i]);
            }
        }
    };
})();
