/**
 * Gaurikrit Bio Products — app.js
 * Main entry. Loaded last (after the other module files).
 *
 * This is the CORRECTION pass: light-only branded site. No dark mode,
 * no coverage calculator, no claims register, no testimonials, no
 * newsletter, no count-up, no certification modal.
 *
 * App-level responsibilities (per spec):
 *  - On DOMContentLoaded: call init() on each module.
 *  - Image handoff system for every [data-official-image] element
 *    (header logo, footer logo, hero product group, product images,
 *    brochure cover). On <img> load -> data-loaded="true" (fallback
 *    fades out). On error -> <img> hidden, fallback stays visible.
 *  - Back-to-top: show after 600px, smooth scroll on click.
 *  - FAQ accordion: toggle data-open on .faq-item.
 *  - Brochure PDF detection: HEAD-fetch the brochure URL on the
 *    downloads page; toggle data-brochure-state accordingly.
 *
 * Module-level functionality (each in its own file, initialised here):
 *  - navigation.js: scroll-spy, mobile menu, header scroll state.
 *  - animations.js: reveal on scroll, marquee duplication, hero
 *    paint-stroke reveal, material journey draw-in.
 *  - ashta-laabh.js: radial diagram node interaction.
 *  - colour-study.js: clickable swatch dots.
 *  - forms.js: contact + business form submit, toast helper.
 *  - calculator.js: 4-step painting budget calculator.
 *
 * Vanilla. No bundler. No dependencies. Respects prefers-reduced-motion.
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    // ---------- Image handoff system ----------
    // For every [data-official-image] element, find the inner <img>:
    //   * onload  -> set data-loaded="true" on the wrapper (CSS fades
    //                the official image in and the fallback SVG out).
    //   * onerror -> mark data-loaded-error, hide the broken <img>
    //                (CSS keeps the fallback visible).
    // Handles brand logo (header + footer), hero product group, product
    // detail images, brochure cover — anywhere the page uses the
    // [data-official-image] attribute.
    function initImageHandoff() {
        var wrappers = document.querySelectorAll('[data-official-image]');
        for (var i = 0; i < wrappers.length; i++) {
            (function (wrapper) {
                var img = wrapper.querySelector('img');
                if (!img) {
                    // No <img> to test — leave the fallback visible.
                    return;
                }

                function markLoaded() {
                    wrapper.setAttribute('data-loaded', 'true');
                    wrapper.removeAttribute('data-loaded-error');
                }
                function markError() {
                    wrapper.removeAttribute('data-loaded');
                    wrapper.setAttribute('data-loaded-error', 'true');
                    // Hide the broken <img> outright so its broken-icon
                    // never paints over the fallback.
                    img.style.visibility = 'hidden';
                }

                // Cached image — onload may have fired before we attached.
                if (img.complete) {
                    if (img.naturalWidth && img.naturalWidth > 0) {
                        markLoaded();
                    } else if (img.getAttribute('src')) {
                        // The browser gave up (broken). Treat as error.
                        markError();
                    }
                }

                img.addEventListener('load', markLoaded);
                img.addEventListener('error', markError);
            })(wrappers[i]);
        }
    }

    // ---------- Back-to-top ----------
    function initBackToTop() {
        var btn = document.querySelector('[data-back-to-top]');
        if (!btn) return;
        var lastShown = null;

        function update() {
            var show = (window.scrollY || window.pageYOffset) > 600;
            if (show !== lastShown) {
                if (show) { btn.removeAttribute('hidden'); }
                else { btn.setAttribute('hidden', ''); }
                lastShown = show;
            }
        }

        var ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () { update(); ticking = false; });
                ticking = true;
            }
        }, { passive: true });

        btn.addEventListener('click', function () {
            if (prefersReducedMotion()) {
                window.scrollTo(0, 0);
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        update();
    }

    // ---------- FAQ accordion ----------
    // Toggles [data-open] on .faq-item when its .faq-item__q is clicked.
    // Single-open accordion per .faq-list (siblings close automatically).
    function initFaq() {
        var items = document.querySelectorAll('.faq-item');
        for (var i = 0; i < items.length; i++) {
            (function (item) {
                var q = item.querySelector('.faq-item__q');
                if (!q) return;
                q.addEventListener('click', function () {
                    var isOpen = item.getAttribute('data-open') === 'true';
                    var parent = item.closest('.faq-list');
                    if (parent) {
                        var openSibs = parent.querySelectorAll('.faq-item[data-open="true"]');
                        for (var j = 0; j < openSibs.length; j++) {
                            if (openSibs[j] !== item) {
                                openSibs[j].removeAttribute('data-open');
                                var sq = openSibs[j].querySelector('.faq-item__q');
                                if (sq) sq.setAttribute('aria-expanded', 'false');
                            }
                        }
                    }
                    if (isOpen) {
                        item.removeAttribute('data-open');
                        q.setAttribute('aria-expanded', 'false');
                    } else {
                        item.setAttribute('data-open', 'true');
                        q.setAttribute('aria-expanded', 'true');
                    }
                });
            })(items[i]);
        }
    }

    // ---------- Brochure PDF detection ----------
    // On the downloads page, the page template wraps the brochure UI in
    // [data-brochure-detect] and provides two child blocks:
    //   [data-brochure-if-available]  -> the "View / Download" buttons.
    //   [data-brochure-if-missing]   -> the "will be available" note.
    // JS HEAD-fetches the brochure URL and toggles data-brochure-state
    // on the wrapper to "available" or "missing". CSS does the show/hide.
    function initBrochureDetection() {
        var wrapper = document.querySelector('[data-brochure-detect]');
        if (!wrapper) return;
        var url = wrapper.getAttribute('data-brochure-detect') ||
                  wrapper.getAttribute('data-brochure-url');
        if (!url) return;

        // Optimistic default: hide both until we know.
        wrapper.setAttribute('data-brochure-state', 'checking');

        if (!window.fetch) {
            // No fetch — assume available (page template's PHP is the
            // source of truth on Hostinger; JS detection is a bonus).
            wrapper.setAttribute('data-brochure-state', 'available');
            return;
        }

        // HEAD request — small, no body download. Some hosts disallow
        // HEAD on static assets; fall back to a ranged GET (0 bytes).
        fetch(url, { method: 'HEAD', redirect: 'follow' })
            .then(function (res) {
                if (res.ok) {
                    wrapper.setAttribute('data-brochure-state', 'available');
                } else {
                    wrapper.setAttribute('data-brochure-state', 'missing');
                }
            })
            .catch(function () {
                // Network/CORS error — assume available so the user can
                // still click through (the actual link will 404 visibly
                // only if the file truly isn't there).
                wrapper.setAttribute('data-brochure-state', 'available');
            });
    }

    // ---------- Boot ----------
    function boot() {
        // Module init calls — guarded so a missing module never blocks others.
        var mods = ['Navigation', 'Animations', 'AshtaLaabh', 'ColourStudy', 'Forms', 'Calculator'];
        for (var i = 0; i < mods.length; i++) {
            var m = mods[i];
            if (G[m] && typeof G[m].init === 'function') {
                try { G[m].init(); } catch (e) { if (window.console) console.error(m + ' init failed:', e); }
            }
        }

        // App-level functionality.
        try { initImageHandoff(); } catch (e) { if (window.console) console.error('image handoff:', e); }
        try { initBackToTop(); } catch (e) { if (window.console) console.error('back-to-top:', e); }
        try { initFaq(); } catch (e) { if (window.console) console.error('faq:', e); }
        try { initBrochureDetection(); } catch (e) { if (window.console) console.error('brochure:', e); }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
