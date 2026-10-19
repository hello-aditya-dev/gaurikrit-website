/**
 * Gaurikrit Bio Products — story.js  (V16)
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities (§19–20, §54–55 of the story restructure):
 *  - Circular model: progressively highlight ONE stage at a time as the
 *    loop scrolls through the viewport. Purely a data-active attribute
 *    swap — all information stays visible without JS (progressive
 *    enhancement). Static under prefers-reduced-motion.
 *  - No count-up, no counters, no numbers. Ever. (§3)
 *
 * Exposes: window.GaurikritApp.Story.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    // ---- Circular model: progressive stage highlight -------------------
    // The loop element carries data-circular. Each stage is a .stage child
    // of .circular__track. As the visitor scrolls, the stage nearest the
    // viewport's focus band gets data-active="true" (one at a time).
    // Reduced motion / no IntersectionObserver: every stage gets
    // data-active at once (all information reads; nothing is hidden).
    function initCircular() {
        var wraps = document.querySelectorAll('[data-circular]');
        if (!wraps.length) return;

        for (var w = 0; w < wraps.length; w++) {
            var stages = wraps[w].querySelectorAll('.stage');
            if (!stages.length) continue;

            if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
                for (var s = 0; s < stages.length; s++) {
                    stages[s].setAttribute('data-active', 'true');
                }
                continue;
            }

            (function (stageList) {
                var observer = new IntersectionObserver(function (entries) {
                    // Find the entry closest to the focus band (35% down
                    // the viewport) among currently intersecting stages.
                    var focusY = window.innerHeight * 0.35;
                    var best = null;
                    var bestDist = Infinity;
                    for (var i = 0; i < entries.length; i++) {
                        if (!entries[i].isIntersecting) continue;
                        var r = entries[i].boundingClientRect;
                        var mid = r.top + r.height / 2;
                        var dist = Math.abs(mid - focusY);
                        if (dist < bestDist) { bestDist = dist; best = entries[i].target; }
                    }
                    if (!best) return;
                    for (var j = 0; j < stageList.length; j++) {
                        stageList[j].setAttribute('data-active', stageList[j] === best ? 'true' : 'false');
                    }
                }, {
                    root: null,
                    rootMargin: '-15% 0px -35% 0px',
                    threshold: 0
                });
                for (var k = 0; k < stageList.length; k++) {
                    observer.observe(stageList[k]);
                }
            })(stages);
        }
    }

    G.Story = {
        init: function () {
            initCircular();
        }
    };
})();
