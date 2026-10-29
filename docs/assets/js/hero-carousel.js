/**
 * Gaurikrit Bio Products — hero-carousel.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * V21 — drives the homepage hero transitioning product showcase. Four
 * client-supplied product directions (Eco-Paints, Bio-Briquettes,
 * Cow-Dung Logs, Eco Utility Products) crossfade inside one stable 4/3
 * frame. The fade itself is pure CSS (opacity transition on
 * .hero-showcase__slide[aria-hidden]); this module only toggles
 * aria-hidden / aria-selected and updates the caption.
 *
 * Behaviour (per V21 client spec):
 *  - Auto-advance every data-autoplay ms (default 5000, clamped >= 4500).
 *    The frame has a stable aspect-ratio so the page never shifts.
 *  - The carousel KEEPS MOVING when the pointer rests over the hero on
 *    desktop. Hover no longer freezes autoplay (V20 hover-pause removed
 *    per client request — it left the carousel appearing frozen).
 *  - An accessible play/pause toggle ([data-hero-toggle]) lets visitors
 *    control autoplay intentionally. Its state is communicated to AT
 *    via aria-pressed + a dynamic aria-label.
 *  - Prev/next arrow buttons + dot indicators (role="tab").
 *  - ArrowLeft / ArrowRight / Home / End on the region navigate.
 *  - Keyboard focus inside the region briefly pauses autoplay (so the
 *    slide does not change under a keyboard user); it resumes on
 *    focusout unless the user explicitly pressed pause.
 *  - prefers-reduced-motion: autoplay disabled, switching is instant
 *    (the CSS media query also kills the opacity transition).
 *  - Pauses while the tab is hidden (visibilitychange) so it never
 *    burns CPU in the background, and resumes on return.
 *  - Re-evaluates reduced-motion on media-query change.
 *  - Subsequent slides are preloaded+decoded so switching never reveals
 *    a blank frame or broken-image flash.
 *
 * No CLS: the frame has a stable aspect-ratio; slides are absolutely
 * positioned.
 *
 * Exposes: window.GaurikritApp.HeroCarousel.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function initCarousel(root) {
        var slides = Array.prototype.slice.call(
            root.querySelectorAll('.hero-showcase__slide'));
        var dots = Array.prototype.slice.call(
            root.querySelectorAll('.hero-showcase__dot'));
        var prevBtn = root.querySelector('[data-hero-prev]');
        var nextBtn = root.querySelector('[data-hero-next]');
        var toggleBtn = root.querySelector('[data-hero-toggle]');
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
        var focused = false;       // keyboard focus inside the region
        var userPaused = false;    // user pressed the pause button

        // ---- Slide show / caption update ----
        function show(index) {
            var next = ((index % count) + count) % count; // wrap both ways
            if (next === current) return;
            for (var i = 0; i < count; i++) {
                var active = (i === next);
                slides[i].setAttribute('aria-hidden', active ? 'false' : 'true');
                if (dots[i]) {
                    dots[i].setAttribute('aria-selected', active ? 'true' : 'false');
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

        // ---- Autoplay timer ----
        function start() {
            // No autoplay when: reduced motion, user pressed pause,
            // keyboard focus is inside the region, or tab is hidden.
            if (reduced || userPaused || focused || document.hidden) return;
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

        // ---- Play/pause toggle ----
        function updateToggle() {
            if (!toggleBtn) return;
            var playing = !userPaused && !reduced;
            toggleBtn.setAttribute('aria-pressed', playing ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', playing
                ? 'Pause product showcase autoplay'
                : 'Play product showcase autoplay');
            // Swap the icon so the visual matches the action.
            var playIcon = toggleBtn.querySelector('[data-icon-play]');
            var pauseIcon = toggleBtn.querySelector('[data-icon-pause]');
            if (playIcon && pauseIcon) {
                playIcon.hidden = playing;   // show pause icon when playing
                pauseIcon.hidden = !playing;
            }
        }
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                userPaused = !userPaused;
                if (userPaused) {
                    stop();
                } else {
                    // User explicitly resumed — clear the focus-pause flag so
                    // autoplay starts immediately even though this button
                    // retains focus. (Keyboard users who tab in later will
                    // re-trigger the focus-pause via focusin.)
                    focused = false;
                    start();
                }
                updateToggle();
            });
        }

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

        // ---- Keyboard focus pause (accessibility) ----
        // Briefly pause when a control inside the region has focus so the
        // slide does not change under a keyboard user. Resumes on focusout
        // unless the user explicitly pressed the pause toggle.
        root.addEventListener('focusin', function () { focused = true; stop(); });
        root.addEventListener('focusout', function () { focused = false; start(); });

        // ---- Pause when tab hidden, resume on return ----
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) { stop(); }
            else { start(); }
        });

        // ---- React to reduced-motion changes at runtime ----
        if (window.matchMedia) {
            var mq = window.matchMedia('(prefers-reduced-motion: reduce)');
            var handler = function () {
                reduced = prefersReducedMotion();
                if (reduced) { stop(); } else { start(); }
                updateToggle();
            };
            if (mq.addEventListener) mq.addEventListener('change', handler);
            else if (mq.addListener) mq.addListener(handler);
        }

        // ---- Swipe detect (basic) so touch users can advance manually ----
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

        // ---- Preload + decode subsequent slides ----
        // Only slide 0 loads eagerly; the others use loading="lazy". To
        // avoid a blank/broken frame on first transition, kick off a
        // decode on every non-active slide shortly after boot so the
        // browser fetches and decodes them before they are shown.
        setTimeout(function () {
            for (var i = 0; i < count; i++) {
                if (i === current) continue;
                var img = slides[i].querySelector('img');
                if (img && !img.complete && img.decode) {
                    // best-effort decode; ignore errors (the <picture>
                    // fallback + onerror handoff handles real failures)
                    img.decode().catch(function () {});
                }
            }
        }, 1200);

        // ---- Boot ----
        updateToggle();
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
