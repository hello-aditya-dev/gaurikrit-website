/**
 * Gaurikrit Bio Products — ashta-laabh.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Interactive 8-benefit ("Ashta Laabh") radial diagram. Wires up
 * click + keyboard + focus interactions on any [data-ashta-laabh]
 * element present on the page. Each node carrying
 * [data-ashta-node="<id>"] is selectable; the matching
 * [data-ashta-detail="<id>"] becomes the active detail.
 *
 * If the diagram is not present on the page, this module no-ops.
 *
 * Exposes: window.GaurikritApp.AshtaLaabh.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function setActive(wrapper, id) {
        var nodes = wrapper.querySelectorAll('[data-ashta-node]');
        for (var i = 0; i < nodes.length; i++) {
            var n = nodes[i];
            var nId = n.getAttribute('data-ashta-node');
            var isMatch = nId === id;
            n.setAttribute('data-active', isMatch ? 'true' : 'false');
            n.setAttribute('aria-selected', isMatch ? 'true' : 'false');
        }
        var details = wrapper.querySelectorAll('[data-ashta-detail]');
        for (var j = 0; j < details.length; j++) {
            var d = details[j];
            var dId = d.getAttribute('data-ashta-detail');
            var match = dId === id;
            d.setAttribute('data-active', match ? 'true' : 'false');
            if (match) {
                d.removeAttribute('hidden');
            } else {
                d.setAttribute('hidden', '');
            }
        }
    }

    function initDiagram(wrapper) {
        var nodes = wrapper.querySelectorAll('[data-ashta-node]');
        if (!nodes.length) return;

        for (var i = 0; i < nodes.length; i++) {
            (function (node) {
                if (node.tagName !== 'BUTTON' && node.getAttribute('role') !== 'button') {
                    node.setAttribute('tabindex', '0');
                    node.setAttribute('role', 'button');
                }

                var handler = function () {
                    var id = node.getAttribute('data-ashta-node');
                    setActive(wrapper, id);
                };
                node.addEventListener('click', handler);
                node.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        handler();
                    }
                });
                node.addEventListener('focus', handler);
                node.addEventListener('mouseenter', handler);
            })(nodes[i]);
        }

        // Set the first node active by default.
        var firstId = nodes[0].getAttribute('data-ashta-node');
        if (firstId) setActive(wrapper, firstId);
    }

    G.AshtaLaabh = {
        init: function () {
            var diagrams = document.querySelectorAll('[data-ashta-laabh]');
            for (var i = 0; i < diagrams.length; i++) {
                initDiagram(diagrams[i]);
            }
        }
    };
})();
