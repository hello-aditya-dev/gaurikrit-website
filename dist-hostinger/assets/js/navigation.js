/**
 * Gaurikrit Bio Products — navigation.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities:
 *  - Scroll-spy: IntersectionObserver on <section id> elements toggles
 *    data-active="true" on matching nav links (desktop + mobile menu).
 *  - Mobile menu: open/close sheet, ESC to close, click backdrop to close.
 *  - Header scroll state: toggle data-scrolled on .site-header after 24px scroll.
 *
 * Exposes: window.GaurikritApp.Navigation.init()
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    // Map of section id -> nav href it should highlight.
    var SECTION_TO_HREF = {
        'home':          '/',
        'hero':          '/',
        'products':      '/products/',
        'why-prakritik': '/why-prakritik/',
        'about':         '/about/',
        'for-business':  '/for-business/',
        'contact':      '/contact/'
    };

    function setActiveNav(href) {
        var links = document.querySelectorAll('[data-nav-link]');
        for (var i = 0; i < links.length; i++) {
            var linkHref = links[i].getAttribute('data-nav-link');
            if (linkHref === href) {
                links[i].setAttribute('data-active', 'true');
                if (links[i].setAttribute) {
                    links[i].setAttribute('aria-current', 'page');
                }
            } else {
                links[i].removeAttribute('data-active');
                links[i].removeAttribute('aria-current');
            }
        }
    }

    function initScrollSpy() {
        if (!('IntersectionObserver' in window)) return;
        var sections = document.querySelectorAll('main section[id], main div[id]');
        if (!sections.length) return;

        var currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
        // On non-home pages, set active by current path immediately.
        if (currentPath !== '/' && currentPath !== '') {
            setActiveNav(currentPath + '/');
            setActiveNav(currentPath);
        }

        var visible = {};
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                var id = entry.target.id;
                if (!id) return;
                if (entry.isIntersecting) {
                    visible[id] = entry.intersectionRatio;
                } else {
                    delete visible[id];
                }
            });
            var topId = null, topRatio = 0;
            Object.keys(visible).forEach(function (id) {
                if (visible[id] > topRatio) {
                    topRatio = visible[id];
                    topId = id;
                }
            });
            if (topId && SECTION_TO_HREF[topId]) {
                setActiveNav(SECTION_TO_HREF[topId]);
            }
        }, {
            rootMargin: '-30% 0px -55% 0px',
            threshold: [0, 0.1, 0.25, 0.5, 0.75, 1]
        });

        sections.forEach(function (s) { observer.observe(s); });
    }

    function openMobileMenu(menu, toggle) {
        if (!menu) return;
        menu.removeAttribute('hidden');
        // Force a reflow so the transition takes effect from hidden.
        void menu.offsetWidth;
        menu.setAttribute('data-open', 'true');
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Close menu');
        }
        document.documentElement.style.overflow = 'hidden';
        // Focus first link for keyboard users.
        var firstLink = menu.querySelector('a, button');
        if (firstLink) firstLink.focus();
    }

    function closeMobileMenu(menu, toggle) {
        if (!menu) return;
        menu.removeAttribute('data-open');
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Open menu');
        }
        document.documentElement.style.overflow = '';
        // Hide after the transition completes.
        var onHide = function () {
            menu.setAttribute('hidden', '');
            menu.removeEventListener('transitionend', onHide);
        };
        // If no transition (reduced motion), hide immediately.
        if (prefersReducedMotion()) {
            menu.setAttribute('hidden', '');
        } else {
            menu.addEventListener('transitionend', onHide);
            // Safety fallback in case transitionend doesn't fire.
            setTimeout(function () { menu.setAttribute('hidden', ''); }, 400);
        }
        if (toggle) toggle.focus();
    }

    function initMobileMenu() {
        var menu = document.querySelector('[data-mobile-menu]');
        var toggle = document.querySelector('[data-menu-toggle]');
        var closeBtn = document.querySelector('[data-menu-close]');
        if (!menu || !toggle) return;

        toggle.addEventListener('click', function () {
            var isOpen = menu.getAttribute('data-open') === 'true';
            if (isOpen) {
                closeMobileMenu(menu, toggle);
            } else {
                openMobileMenu(menu, toggle);
            }
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                closeMobileMenu(menu, toggle);
            });
        }

        // Click backdrop (the .mobile-menu element itself, not the panel) closes.
        menu.addEventListener('click', function (e) {
            if (e.target === menu) {
                closeMobileMenu(menu, toggle);
            }
        });

        // ESC closes.
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menu.getAttribute('data-open') === 'true') {
                closeMobileMenu(menu, toggle);
            }
        });

        // Click any nav link closes (mobile).
        var navLinks = menu.querySelectorAll('a');
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                closeMobileMenu(menu, toggle);
            });
        });
    }

    function initHeaderScroll() {
        var header = document.querySelector('.site-header');
        if (!header) return;
        var lastState = null;
        function update() {
            var scrolled = window.scrollY > 24;
            var state = scrolled ? 'true' : 'false';
            if (state !== lastState) {
                header.setAttribute('data-scrolled', state);
                lastState = state;
            }
        }
        // Use passive listener for scroll performance.
        var ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    update();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
        update();
    }

    G.Navigation = {
        init: function () {
            initHeaderScroll();
            initScrollSpy();
            initMobileMenu();
        }
    };
})();
