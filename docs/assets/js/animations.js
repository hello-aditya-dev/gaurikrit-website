/**
 * Gaurikrit Bio Products — animations.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities:
 *  - Reveal on scroll: IntersectionObserver on [data-reveal] and
 *    [data-reveal-stagger]. Sets data-revealed="true" when in view.
 *  - Hero paint-stroke reveal: clip-path animation on .hero__stroke.
 *  - Marquee: ensure .marquee__track is duplicated for seamless CSS loop.
 *  - Material journey draw-in: animate the SVG paths in
 *    [data-material-journey] via stroke-dasharray when the diagram
 *    scrolls into view.
 *
 * Removed in the CORRECTION pass: count-up / animated counters.
 * The locked data.php carries no stats — there is nothing to count.
 *
 * Exposes: window.GaurikritApp.Animations.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    // ---- Reveal on scroll ----
    function initReveal() {
        var els = document.querySelectorAll('[data-reveal], [data-reveal-stagger]');
        if (!els.length) return;

        if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
            for (var i = 0; i < els.length; i++) {
                els[i].setAttribute('data-revealed', 'true');
            }
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.setAttribute('data-revealed', 'true');
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });

        els.forEach(function (el) { observer.observe(el); });
    }

    // ---- Hero paint-stroke reveal ----
    function initHeroStroke() {
        var stroke = document.querySelector('.hero__stroke');
        if (!stroke) return;
        if (prefersReducedMotion()) return;

        // Use the Web Animations API when available.
        if (stroke.animate) {
            stroke.animate(
                [
                    { clipPath: 'inset(0 100% 0 0)' },
                    { clipPath: 'inset(0 0% 0 0)' }
                ],
                { duration: 1100, easing: 'cubic-bezier(0.22,1,0.36,1)', fill: 'forwards', delay: 200 }
            );
            return;
        }
        // Fallback: CSS transition.
        stroke.style.transition = 'clip-path 1.1s cubic-bezier(0.22,1,0.36,1)';
        stroke.style.clipPath = 'inset(0 100% 0 0)';
        setTimeout(function () {
            stroke.style.clipPath = 'inset(0 0% 0 0)';
        }, 200);
    }

    // ---- Marquee duplication ----
    function initMarquee() {
        var tracks = document.querySelectorAll('[data-marquee-track]');
        for (var i = 0; i < tracks.length; i++) {
            (function (track) {
                if (track.getAttribute('data-marquee-duplicated') === 'true') return;
                var children = Array.prototype.slice.call(track.children);
                if (!children.length) return;
                children.forEach(function (child) {
                    var clone = child.cloneNode(true);
                    clone.setAttribute('aria-hidden', 'true');
                    track.appendChild(clone);
                });
                track.setAttribute('data-marquee-duplicated', 'true');
            })(tracks[i]);
        }
    }

    // ---- Material journey draw-in ----
    // Animate the SVG paths inside [data-material-journey] using
    // stroke-dasharray + stroke-dashoffset. The dash length is set to
    // the path's total length, then the offset is eased from full to 0
    // when the diagram scrolls into view.
    function initMaterialJourney() {
        var diagram = document.querySelector('[data-material-journey]');
        if (!diagram) return;
        if (prefersReducedMotion() || !('IntersectionObserver' in window)) return;

        var paths = diagram.querySelectorAll('path, line, polyline, rect, circle, ellipse');
        if (!paths.length) return;

        // Set up each path with a dash long enough to hide it, then
        // stash the length so we can ease it back to 0 on reveal.
        var prepared = [];
        for (var i = 0; i < paths.length; i++) {
            var p = paths[i];
            // getTotalLength only exists on SVGGeometryElement; check.
            if (typeof p.getTotalLength !== 'function') continue;
            var len = 0;
            try { len = p.getTotalLength(); } catch (e) { continue; }
            if (!isFinite(len) || len <= 0) continue;

            p.style.strokeDasharray = len + ' ' + len;
            p.style.strokeDashoffset = String(len);
            // Preserve existing transition none.
            p.style.transition = 'stroke-dashoffset 1.2s cubic-bezier(0.22, 1, 0.36, 1)';
            prepared.push({ el: p, len: len });
        }

        if (!prepared.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                // Stagger the draw-in slightly for editorial effect.
                for (var k = 0; k < prepared.length; k++) {
                    (function (item, idx) {
                        setTimeout(function () {
                            item.el.style.strokeDashoffset = '0';
                        }, idx * 90);
                    })(prepared[k], k);
                }
                observer.unobserve(entry.target);
            });
        }, { rootMargin: '0px 0px -15% 0px', threshold: 0.2 });

        observer.observe(diagram);
    }

    G.Animations = {
        init: function () {
            initMarquee();
            initReveal();
            initHeroStroke();
            initMaterialJourney();
        }
    };
})();
