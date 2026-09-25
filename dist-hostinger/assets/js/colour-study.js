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

        function applySwatch(swatch) {
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
