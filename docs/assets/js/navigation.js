/**
 * Gaurikrit Bio Products — navigation.js
 * Vanilla JS module. No bundler. No dependencies.
 *
 * Responsibilities:
 *  - Scroll-spy: IntersectionObserver on <section id> elements toggles
 *    data-active="true" on matching nav links (desktop + mobile menu).
 *  - Mobile menu: open/close sheet, ESC to close, click backdrop to close.
 *  - Header scroll state: toggle data-scrolled on .site-header after 24px.
 *
 * Light-only site — no theme toggle is handled here.
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
    // Driven by the data attributes the page template emits on each nav
    // link ([data-nav-link="/products/"] etc.). The map below only adds
    // coverage for the homepage's anchor sections.
    var SECTION_TO_HREF = {
        'home':           '/',
        'hero':           '/',
        'products':       '/products/',
        'why-prakritik':  '/why-prakritik/',
        'about':          '/about/',
        'for-business':   '/for-business/',
        'contact':        '/contact/'
    };

    function setActiveNav(href) {
        var links = document.querySelectorAll('[data-nav-link]');
        for (var i = 0; i < links.length; i++) {
            var linkHref = links[i].getAttribute('data-nav-link');
            if (linkHref === href) {
                links[i].setAttribute('data-active', 'true');
                links[i].setAttribute('aria-current', 'page');
            } else {
                links[i].removeAttribute('data-active');
                links[i].removeAttribute('aria-current');
            }
        }
    }

    function initScrollSpy() {
        var currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
        // On non-home pages, set active by current path immediately.
        if (currentPath !== '/' && currentPath !== '') {
            setActiveNav(currentPath + '/');
            setActiveNav(currentPath);
        }

        if (!('IntersectionObserver' in window)) return;
        var sections = document.querySelectorAll('main section[id], main div[id]');
        if (!sections.length) return;

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
        var onHide = function () {
            menu.setAttribute('hidden', '');
            menu.removeEventListener('transitionend', onHide);
        };
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
        for (var i = 0; i < navLinks.length; i++) {
            navLinks[i].addEventListener('click', function () {
                closeMobileMenu(menu, toggle);
            });
        }
    }

    // ---- V19 §2–7: Products dropdown state machine --------------------
    // ONE source of truth: the `hidden` attribute + aria-expanded. The CSS
    // carries `.nav-menu[hidden] { display: none !important; }` so an author
    // `display: flex` can never defeat the closed state (the V18 bug).
    //
    // Behaviour:
    //  - hover opens (pointer users); a 130ms leave grace closes, cancelled
    //    by re-entering the group
    //  - click toggles; click outside / Escape / scroll / resize / link
    //    click / focus leaving the group / breakpoint change → close
    //  - keyboard: Enter/Space open; ArrowDown/ArrowUp open AND move focus
    //    (only keyboard opens ever move focus); Escape closes + refocuses
    //    the button; arrows wrap within the panel
    //  - the floating panel exists only while the desktop nav does (≥1024px)
    function initNavDropdown() {
        var items = document.querySelectorAll('[data-nav-menu]');
        var HOVER_Q = window.matchMedia ? window.matchMedia('(hover: hover) and (pointer: fine)') : null;
        var DESKTOP_Q = window.matchMedia ? window.matchMedia('(min-width: 1024px)') : null;
        var GRACE_MS = 130;

        for (var i = 0; i < items.length; i++) {
            (function (item) {
                var btn = item.querySelector('.site-nav__link--parent');
                var panel = item.querySelector('.nav-menu');
                if (!btn || !panel) return;
                var links = [].slice.call(panel.querySelectorAll('a'));
                var closeTimer = null;
                var openedByKeyboard = false;
                var suppressScrollUntil = 0;

                function desktopNav() {
                    return DESKTOP_Q ? DESKTOP_Q.matches : window.innerWidth >= 1024;
                }
                function hoverCapable() {
                    return HOVER_Q ? HOVER_Q.matches : false;
                }
                function isOpen() {
                    return !panel.hasAttribute('hidden');
                }
                function clearCloseTimer() {
                    if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                }
                function focusLink(idx) {
                    if (links[idx]) {
                        // preventScroll: focusing must never fire a scroll event
                        // (the scroll-close listener would instantly close the
                        // just-opened panel — the V19 keyboard-open bug).
                        try { links[idx].focus({ preventScroll: true }); }
                        catch (e) { links[idx].focus(); }
                        return true;
                    }
                    return false;
                }

                function open(source) {
                    // The floating panel only exists where the desktop nav does.
                    if (!desktopNav()) return;
                    clearCloseTimer();
                    panel.removeAttribute('hidden');
                    btn.setAttribute('aria-expanded', 'true');
                    // Mouse/touch opens never move focus — only openKeyboard does.
                    openedByKeyboard = false;
                }
                function openKeyboard(idx) {
                    if (!desktopNav()) return;
                    clearCloseTimer();
                    // suppress scroll-close briefly: a keyboard open must
                    // survive any in-flight programmatic smooth scrolling
                    suppressScrollUntil = Date.now() + 350;
                    panel.removeAttribute('hidden');
                    btn.setAttribute('aria-expanded', 'true');
                    openedByKeyboard = true;
                    if (!focusLink(idx)) btn.focus();
                }
                function close(returnFocus) {
                    clearCloseTimer();
                    var wasOpen = isOpen();
                    var wasKeyboard = openedByKeyboard;
                    panel.setAttribute('hidden', '');
                    btn.setAttribute('aria-expanded', 'false');
                    openedByKeyboard = false;
                    if (wasOpen && returnFocus && wasKeyboard) {
                        try { btn.focus({ preventScroll: true }); }
                        catch (e) { btn.focus(); }
                    }
                }

                // --- Button: click toggles (mouse, touch, Enter, Space) ---
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (isOpen()) { close(false); } else { open('pointer'); }
                });

                // --- Button: arrow keys open + focus (keyboard path) ---
                btn.addEventListener('keydown', function (e) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (!isOpen()) openKeyboard(0);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (!isOpen()) openKeyboard(links.length - 1);
                    } else if (e.key === 'Escape' && isOpen()) {
                        e.stopPropagation();
                        close(true);
                    }
                });

                // --- Panel: arrow navigation while open (wrap-around) ---
                panel.addEventListener('keydown', function (e) {
                    var active = document.activeElement;
                    var idx = links.indexOf(active);
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        focusLink((idx + 1 + links.length) % links.length);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        focusLink((idx - 1 + links.length) % links.length);
                    } else if (e.key === 'Home') {
                        e.preventDefault(); focusLink(0);
                    } else if (e.key === 'End') {
                        e.preventDefault(); focusLink(links.length - 1);
                    } else if (e.key === 'Escape') {
                        e.stopPropagation();
                        close(true);
                    } else if (e.key === 'Tab' && isOpen()) {
                        // Tabbing past the last/first item closes naturally.
                        setTimeout(function () {
                            if (!item.contains(document.activeElement)) close(false);
                        }, 0);
                    }
                });

                // --- Pointer: hover opens, leave starts the grace timer ---
                item.addEventListener('mouseenter', function () {
                    if (hoverCapable() && desktopNav()) open('pointer');
                });
                item.addEventListener('mouseleave', function () {
                    if (!hoverCapable()) return;
                    clearCloseTimer();
                    closeTimer = setTimeout(function () {
                        closeTimer = null;
                        close(false);
                    }, GRACE_MS);
                });

                // --- Outside click (capture phase catches stops too) ---
                document.addEventListener('click', function (e) {
                    if (isOpen() && !item.contains(e.target)) close(false);
                }, true);

                // --- Escape anywhere (mobile menu handles its own) ---
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && isOpen()) close(true);
                });

                // --- Page scroll closes (capture: nested scrollers too).
                //     Programmatic scrolls fired by our own focus() calls and
                //     in-flight smooth scrolling right after a keyboard open
                //     are ignored (suppressScrollUntil). ---
                window.addEventListener('scroll', function () {
                    if (Date.now() < suppressScrollUntil) return;
                    if (closeTimer) clearCloseTimer();
                    if (isOpen()) close(false);
                }, { passive: true, capture: true });

                // --- Viewport resize / desktop-nav breakpoint change ---
                window.addEventListener('resize', function () {
                    if (isOpen()) close(false);
                });
                if (DESKTOP_Q && DESKTOP_Q.addEventListener) {
                    DESKTOP_Q.addEventListener('change', function () { close(false); });
                }

                // --- Focus leaving the group closes ---
                item.addEventListener('focusout', function () {
                    setTimeout(function () {
                        if (!item.contains(document.activeElement)) close(false);
                    }, 0);
                });

                // --- Choosing a link closes immediately ---
                links.forEach(function (a) {
                    a.addEventListener('click', function () { close(false); });
                });

                // --- bfcache restore / route history navigation ---
                window.addEventListener('pageshow', function (e) {
                    if (e.persisted) close(false);
                });
            })(items[i]);
        }
    }

    function initHeaderScroll() {
        var header = document.querySelector('.site-header');
        if (!header) return;
        var lastState = null;
        function update() {
            var scrolled = (window.scrollY || window.pageYOffset) > 24;
            var state = scrolled ? 'true' : 'false';
            if (state !== lastState) {
                header.setAttribute('data-scrolled', state);
                lastState = state;
            }
        }
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
            initNavDropdown();
        }
    };
})();
