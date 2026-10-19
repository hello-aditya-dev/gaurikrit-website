/**
 * Gaurikrit Bio Products — hero-carousel.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * V20 — drives the homepage hero transitioning product showcase. Four
 * client-supplied product directions (Eco-Paints, Bio-Coal Logs,
 * Cow-Dung Logs, Eco Utility Products) crossfade inside one stable 4/3
 * frame. The fade itself is pure CSS (opacity transition on
 * .hero-showcase__slide[aria-hidden]); this module only toggles
 * aria-hidden / aria-selected and updates the caption.
 *
 * Behaviour (per task spec):
 *  - Auto-advance every data-autoplay ms (default 5000, clamped >= 4500),
 *    on every device. The frame has a stable aspect-ratio so the page
 *    never shifts when the poster changes.
 *  - Pause on hover (desktop / fine pointer) and on focus-within.
 *  - Prev/next arrow buttons + dot indicators (role="tab").
 *  - ArrowLeft / ArrowRight / Home / End on the region navigate.
 *  - prefers-reduced-motion: autoplay disabled, switching is instant
 *    (the CSS media query also kills the opacity transition).
 *  - Pauses while the tab is hidden (visibilitychange) so it never
 *    burns CPU in the background.
 *  - Re-evaluates reduced-motion on media-query change.
 *
 * No CLS: the frame has a stable aspect-ratio; slides are absolutely
 * positioned. No image flashing: only slide 0 loads eagerly; others
 * load lazily and pre-decode before their first show.
 *
 * Exposes: window.GaurikritApp.HeroCarousel.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }
    function hasFinePointer() {
        return window.matchMedia && window.matchMedia('(pointer: fine)').matches;
    }

    function initCarousel(root) {
        var slides = Array.prototype.slice.call(
            root.querySelectorAll('.hero-showcase__slide'));
        var dots = Array.prototype.slice.call(
            root.querySelectorAll('.hero-showcase__dot'));
        var prevBtn = root.querySelector('[data-hero-prev]');
        var nextBtn = root.querySelector('[data-hero-next]');
        var caption = root.querySelector('[data-hero-caption]');
        var labelEl = caption ? caption.querySelector('.hero-showcase__label') : null;
        var subEl = caption ? caption.querySelector('.hero-showcase__sub') : null;

        var count = slides.length;
        if (!count) return;

        var current = 0;
        var rawAuto = parseInt(root.getAttribute('data-autoplay') || '5000', 10);
        var autoMs = (!isFinite(rawAuto) || rawAuto < 4500) ? 5000 : Math.min(rawAuto, 6000);
        var timer = null;
        var reduced = prefersReducedMotion();
        var finePointer = hasFinePointer();
        var hovering = false;
        var focused = false;

        function show(index) {
            var next = ((index % count) + count) % count; // wrap both ways
            if (next === current) return;
            for (var i = 0; i < count; i++) {
                var active = (i === next);
                slides[i].setAttribute('aria-hidden', active ? 'false' : 'true');
                if (dots[i]) {
                    dots[i].setAttribute('aria-selected', active ? 'true' : 'false');
                    if (active && dots[i].tabIndex !== undefined) {
                        // keep all dots in tab order; active is not specially tabbable
                    }
                }
            }
            if (labelEl) {
                var lbl = slides[next].getAttribute('data-label') || '';
                if (lbl) labelEl.textContent = lbl;
            }
            if (subEl) {
                var sub = slides[next].getAttribute('data-sub') || '';
                if (sub) subEl.textContent = sub;
            }
            current = next;
        }

        function goNext() { show(current + 1); }
        function goPrev() { show(current - 1); }

        function start() {
            // No autoplay under reduced motion, while hovering (desktop),
            // while a control has focus, or while the tab is hidden.
            if (reduced || hovering || focused) return;
            stop();
            timer = setTimeout(function tick() {
                show(current + 1);
                timer = setTimeout(tick, autoMs);
            }, autoMs);
        }
        function stop() {
            if (timer) { clearTimeout(timer); timer = null; }
        }
        function userNext() { goNext(); stop(); start(); }
        function userPrev() { goPrev(); stop(); start(); }
        function userPick(i) { show(i); stop(); start(); }

        // ---- Controls ----
        if (nextBtn) nextBtn.addEventListener('click', userNext);
        if (prevBtn) prevBtn.addEventListener('click', userPrev);
        dots.forEach(function (d, i) {
            d.addEventListener('click', function () { userPick(i); });
        });

        // ---- Keyboard on the region ----
        root.addEventListener('keydown', function (ev) {
            var k = ev.key;
            if (k === 'ArrowRight' || k === 'Right') { ev.preventDefault(); userNext(); }
            else if (k === 'ArrowLeft' || k === 'Left') { ev.preventDefault(); userPrev(); }
            else if (k === 'Home') { ev.preventDefault(); userPick(0); }
            else if (k === 'End') { ev.preventDefault(); userPick(count - 1); }
        });

        // ---- Pause on hover / focus (desktop / fine pointer only) ----
        if (finePointer) {
            root.addEventListener('mouseenter', function () { hovering = true; stop(); });
            root.addEventListener('mouseleave', function () { hovering = false; start(); });
        }
        root.addEventListener('focusin', function () { focused = true; stop(); });
        root.addEventListener('focusout', function () { focused = false; start(); });

        // ---- Pause when tab hidden ----
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) { stop(); }
            else { start(); }
        });

        // ---- React to reduced-motion changes at runtime ----
        if (window.matchMedia) {
            var mq = window.matchMedia('(prefers-reduced-motion: reduce)');
            var handler = function () {
                reduced = prefersReducedMotion();
                if (reduced) stop(); else start();
            };
            if (mq.addEventListener) mq.addEventListener('change', handler);
            else if (mq.addListener) mq.addListener(handler);
        }

        // ---- Swipedetect (basic) so touch users can advance manually ----
        // Keep it simple and passive — never blocks scroll.
        var touchStartX = null;
        root.addEventListener('touchstart', function (ev) {
            if (ev.changedTouches && ev.changedTouches.length) {
                touchStartX = ev.changedTouches[0].clientX;
            }
        }, { passive: true });
        root.addEventListener('touchend', function (ev) {
            if (touchStartX === null) return;
            var endX = ev.changedTouches[0].clientX;
            var dx = endX - touchStartX;
            touchStartX = null;
            if (Math.abs(dx) < 40) return; // ignore tiny drags
            if (dx < 0) userNext(); else userPrev();
        }, { passive: true });

        // ---- Boot ----
        if (!document.hidden) start();
    }

    G.HeroCarousel = {
        init: function () {
            var roots = document.querySelectorAll('[data-hero-carousel]');
            for (var i = 0; i < roots.length; i++) {
                try { initCarousel(roots[i]); }
                catch (e) { if (window.console) console.error('hero-carousel init failed:', e); }
            }
        }
    };
})();
