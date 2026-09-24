/**
 * Gaurikrit Bio Products — animations.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities:
 *  - Reveal on scroll: IntersectionObserver on [data-reveal] and
 *    [data-reveal-stagger]. Sets data-revealed="true" when in view.
 *  - Count-up: animate [data-count-up] elements from 0 to value when in
 *    view, using easeOutExpo. Honours prefers-reduced-motion.
 *  - Hero paint-stroke reveal: clip-path animation on .hero__stroke.
 *  - Marquee: ensure .marquee__track is duplicated for seamless CSS loop.
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
            els.forEach(function (el) { el.setAttribute('data-revealed', 'true'); });
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

    // ---- Count-up ----
    function easeOutExpo(t) {
        return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
    }

    function animateCount(el) {
        var target = parseFloat(el.getAttribute('data-count-up'));
        if (isNaN(target)) return;
        var suffix = el.getAttribute('data-suffix') || '';
        var duration = 1600;
        var start = null;

        if (prefersReducedMotion()) {
            el.textContent = String(target) + suffix;
            return;
        }

        function step(ts) {
            if (start === null) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var v = Math.floor(easeOutExpo(progress) * target);
            el.textContent = String(v) + suffix;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = String(target) + suffix;
            }
        }
        window.requestAnimationFrame(step);
    }

    function initCountUp() {
        var counters = document.querySelectorAll('[data-count-up]');
        if (!counters.length) return;

        if (!('IntersectionObserver' in window)) {
            counters.forEach(function (el) { el.textContent = String(el.getAttribute('data-count-up')) + (el.getAttribute('data-suffix') || ''); });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function (el) { observer.observe(el); });
    }

    // ---- Hero paint-stroke reveal ----
    function initHeroStroke() {
        var stroke = document.querySelector('.hero__stroke');
        if (!stroke) return;
        if (prefersReducedMotion() || !window.requestAnimationFrame) return;

        // Use the Web Animations API when available (cleaner than keyframes).
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
        tracks.forEach(function (track) {
            // If the track isn't already duplicated, clone its children.
            // (PHP may have already duplicated; we leave it alone in that case.)
            if (track.getAttribute('data-marquee-duplicated') === 'true') return;
            var children = Array.prototype.slice.call(track.children);
            if (!children.length) return;
            children.forEach(function (child) {
                var clone = child.cloneNode(true);
                clone.setAttribute('aria-hidden', 'true');
                track.appendChild(clone);
            });
            track.setAttribute('data-marquee-duplicated', 'true');
        });
    }

    G.Animations = {
        init: function () {
            initMarquee();
            initReveal();
            initCountUp();
            initHeroStroke();
        }
    };
})();
