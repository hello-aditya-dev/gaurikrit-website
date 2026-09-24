/**
 * Gaurikrit Bio Products — colour-study.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Simple colour-wall visualizer. On product detail pages, if a
 * [data-colour-study] element exists, clicking a swatch button
 * changes the wall preview's background colour and updates the
 * active label.
 *
 * Exposes: window.GaurikritApp.ColourStudy.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function initStudy(wrapper) {
        var swatches = wrapper.querySelectorAll('[data-shade-hex]');
        var wall = wrapper.querySelector('[data-colour-wall]');
        var label = wrapper.querySelector('[data-colour-label]');
        if (!swatches.length || !wall) return;

        swatches.forEach(function (swatch) {
            swatch.addEventListener('click', function () {
                var hex = swatch.getAttribute('data-shade-hex');
                var name = swatch.getAttribute('data-shade-name') || '';
                wall.style.backgroundColor = hex;
                if (label) label.textContent = name;

                // Update active state + aria.
                swatches.forEach(function (s) {
                    s.setAttribute('data-active', 'false');
                    s.setAttribute('aria-checked', 'false');
                });
                swatch.setAttribute('data-active', 'true');
                swatch.setAttribute('aria-checked', 'true');
            });

            // Keyboard support for non-button elements.
            if (swatch.tagName !== 'BUTTON') {
                swatch.setAttribute('tabindex', '0');
                swatch.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        swatch.click();
                    }
                });
            }
        });
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
