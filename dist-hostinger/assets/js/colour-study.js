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

        for (var i = 0; i < swatches.length; i++) {
            (function (swatch) {
                function apply() {
                    var colour = swatch.getAttribute('data-shade') ||
                                 swatch.getAttribute('data-shade-hex') || '';
                    var name = swatch.getAttribute('data-shade-name') ||
                               swatch.getAttribute('aria-label') || '';
                    if (colour) wall.style.setProperty('--wall-color', colour);
                    if (label && name) label.textContent = name;

                    for (var k = 0; k < swatches.length; k++) {
                        swatches[k].setAttribute('data-active', 'false');
                        swatches[k].setAttribute('aria-checked', 'false');
                    }
                    swatch.setAttribute('data-active', 'true');
                    swatch.setAttribute('aria-checked', 'true');
                }

                swatch.addEventListener('click', apply);

                // Keyboard support for non-button elements.
                if (swatch.tagName !== 'BUTTON') {
                    swatch.setAttribute('tabindex', '0');
                    swatch.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            apply();
                        }
                    });
                }
            })(swatches[i]);
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
