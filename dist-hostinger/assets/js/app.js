/**
 * Gaurikrit Bio Products — app.js
 * Main entry. Loaded last (after the other module files).
 *
 * Responsibilities (per spec):
 *  - On DOMContentLoaded: call init() on each module.
 *  - Theme toggle: read from localStorage, toggle data-theme on <html>.
 *  - Back-to-top: show/hide after 600px scroll, smooth scroll on click.
 *  - FAQ accordion: click .faq-item__q toggles data-open.
 *  - Claims search: filter .claims-table rows by search + category.
 *  - Product image system: load/error on .product-media img.
 *  - Coverage calculator: client-side compute using #paint-specs JSON.
 *  - Header scroll state is handled by navigation.js (init call below).
 *  - Scroll-spy, mobile menu, reveal, count-up, hero stroke, forms,
 *    ashta-laabh, colour-study — each in its own module, initialised here.
 *
 * Vanilla. No bundler. No dependencies. ES5+ compatible where reasonable.
 */
(function () {
    'use strict';

    var G = window.GaurikritApp = window.GaurikritApp || {};

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    // ---------- Theme toggle ----------
    function initThemeToggle() {
        var root = document.documentElement;
        var toggle = document.querySelector('[data-theme-toggle]');
        if (!toggle) return;

        // Read stored theme (or fall back to system preference on first visit).
        var stored = null;
        try { stored = localStorage.getItem('gk-theme'); } catch (e) {}
        if (stored === 'light' || stored === 'dark') {
            root.setAttribute('data-theme', stored);
        } else if (window.matchMedia) {
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
            if (prefersDark && prefersDark.matches) {
                root.setAttribute('data-theme', 'dark');
            }
        }

        toggle.addEventListener('click', function () {
            var current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
            var next = current === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            try { localStorage.setItem('gk-theme', next); } catch (e) {}
            toggle.setAttribute('aria-pressed', next === 'dark' ? 'true' : 'false');
        });

        // Respond to OS theme changes when user hasn't explicitly chosen.
        if (window.matchMedia) {
            var mq = window.matchMedia('(prefers-color-scheme: dark)');
            if (mq.addEventListener) {
                mq.addEventListener('change', function (e) {
                    var explicit = null;
                    try { explicit = localStorage.getItem('gk-theme'); } catch (er) {}
                    if (!explicit) {
                        root.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                    }
                });
            } else if (mq.addListener) {
                // Older Safari fallback.
                mq.addListener(function (e) {
                    var explicit = null;
                    try { explicit = localStorage.getItem('gk-theme'); } catch (er) {}
                    if (!explicit) {
                        root.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                    }
                });
            }
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
    function initFaq() {
        var items = document.querySelectorAll('[data-faq-item]');
        items.forEach(function (item) {
            var q = item.querySelector('.faq-item__q');
            if (!q) return;
            q.addEventListener('click', function () {
                var isOpen = item.getAttribute('data-open') === 'true';
                // Close siblings in the same .faq-list (single-open accordion per list).
                var parent = item.closest('.faq-list');
                if (parent) {
                    var openSibs = parent.querySelectorAll('.faq-item[data-open="true"]');
                    openSibs.forEach(function (s) {
                        if (s !== item) {
                            s.removeAttribute('data-open');
                            var sq = s.querySelector('.faq-item__q');
                            if (sq) sq.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
                if (isOpen) {
                    item.removeAttribute('data-open');
                    q.setAttribute('aria-expanded', 'false');
                } else {
                    item.setAttribute('data-open', 'true');
                    q.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    // ---------- Claims search + category filter ----------
    function initClaimsSearch() {
        var input = document.querySelector('[data-claims-search]');
        var filter = document.querySelector('[data-claims-filter]');
        var table = document.querySelector('[data-claims-table]');
        var empty = document.querySelector('[data-claims-empty]');
        if (!table) return;
        var rows = table.querySelectorAll('tbody tr');
        if (!rows.length) return;

        function applyFilter() {
            var q = (input ? input.value.toLowerCase().trim() : '');
            var cat = filter ? filter.value : 'all';
            var visibleCount = 0;
            rows.forEach(function (row) {
                var text = row.getAttribute('data-claim-text') || '';
                var rowCat = row.getAttribute('data-claim-category') || '';
                var matchQ = q === '' || text.indexOf(q) !== -1;
                var matchCat = cat === 'all' || rowCat === cat;
                if (matchQ && matchCat) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            if (empty) empty.hidden = visibleCount !== 0;
        }

        if (input) {
            input.addEventListener('input', applyFilter);
            input.addEventListener('change', applyFilter);
        }
        if (filter) filter.addEventListener('change', applyFilter);
        applyFilter();
    }

    // ---------- Claims reference copy ----------
    function initClaimsCopy() {
        var refs = document.querySelectorAll('[data-copy-ref]');
        refs.forEach(function (el) {
            el.addEventListener('click', function () {
                var ref = el.getAttribute('data-copy-ref');
                if (!ref) return;
                var done = function () {
                    if (window.GaurikritApp && window.GaurikritApp.Forms && window.GaurikritApp.Forms.toast) {
                        window.GaurikritApp.Forms.toast({
                            title: 'Reference copied',
                            msg: ref,
                            type: 'success',
                            timeout: 2500
                        });
                    }
                };
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(ref).then(done).catch(function () {
                        fallbackCopy(ref); done();
                    });
                } else {
                    fallbackCopy(ref); done();
                }
            });
            // Visual hint.
            el.title = 'Click to copy reference';
            el.style.userSelect = 'all';
        });
    }

    function fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
    }

    // ---------- Product image system ----------
    // For each .product-media[data-official-image], the inner <img> has
    // onload/onerror handlers set inline (PHP) — they set data-loaded /
    // data-loaded-error. CSS uses [data-loaded] to toggle fallback opacity.
    // Here we make the logic defensive: if a media wrapper hasn't resolved
    // within a reasonable window, leave the fallback visible (already the
    // default). We also re-trigger when officialImage src changes.
    function initProductMedia() {
        var wrappers = document.querySelectorAll('.product-media[data-official-image]');
        wrappers.forEach(function (wrapper) {
            var img = wrapper.querySelector('.product-media__official');
            if (!img) return;
            // If already loaded (cached image), the inline onload may have fired
            // before our listener attaches — check naturalWidth.
            if (img.complete && img.naturalWidth > 0) {
                wrapper.setAttribute('data-loaded', 'true');
            }
            // Belt + braces — in case inline handlers were stripped.
            img.addEventListener('load', function () {
                wrapper.setAttribute('data-loaded', 'true');
            });
            img.addEventListener('error', function () {
                wrapper.removeAttribute('data-loaded');
                wrapper.setAttribute('data-loaded-error', '1');
            });
        });
    }

    // ---------- Cert badge click (trust bar) ----------
    function initCertBadges() {
        var badges = document.querySelectorAll('[data-cert-name]');
        if (!badges.length) return;
        badges.forEach(function (badge) {
            if (badge.tagName !== 'BUTTON' && badge.getAttribute('role') !== 'button') {
                badge.setAttribute('role', 'button');
                badge.setAttribute('tabindex', '0');
            }
            var handler = function () {
                var name = badge.getAttribute('data-cert-name') || '';
                var desc = badge.getAttribute('data-cert-desc') || '';
                if (window.GaurikritApp && window.GaurikritApp.Forms && window.GaurikritApp.Forms.toast) {
                    window.GaurikritApp.Forms.toast({
                        title: name,
                        msg: desc,
                        type: 'success',
                        timeout: 4000
                    });
                }
            };
            badge.addEventListener('click', handler);
            badge.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    handler();
                }
            });
        });
    }

    // ---------- Coverage calculator ----------
    function initCoverageCalculator() {
        var form = document.querySelector('[data-coverage-form]');
        var result = document.querySelector('[data-coverage-result]');
        var empty = document.querySelector('[data-coverage-empty]');
        var rowsHolder = result ? result.querySelector('[data-coverage-rows]') : null;
        var note = result ? result.querySelector('[data-coverage-note]') : null;
        if (!form || !result) return;

        var specsEl = document.getElementById('paint-specs');
        var specs = null;
        try {
            specs = specsEl ? JSON.parse(specsEl.textContent || '{}') : null;
        } catch (e) { specs = null; }
        if (!specs) return;

        function fmt(n) {
            // Round to 1 decimal if not integer, else show as integer.
            return (Math.round(n * 10) / 10).toLocaleString('en-IN');
        }

        function packBreakdown(totalUnits, packs) {
            // Greedy pack split — try largest packs first.
            var remaining = Math.ceil(totalUnits);
            var parts = [];
            for (var i = packs.length - 1; i >= 0; i--) {
                var p = packs[i];
                var count = Math.floor(remaining / p);
                if (count > 0) {
                    parts.push(count + ' × ' + p + ' ' + 'unit');
                    remaining -= count * p;
                }
            }
            // If there's remainder, add one more of the smallest pack.
            if (remaining > 0 && packs.length) {
                parts.push('1 × ' + packs[0] + ' ' + 'unit');
            }
            return parts.join(', ');
        }

        function compute(area, productKey, withPrimer) {
            var product = specs[productKey];
            if (!product) return null;
            var primer = specs['primer'];
            var coats = 2;
            var perCoat = area / product.coverage;
            var totalUnits = perCoat * coats;
            // Apply a 10% safety margin for absorption.
            totalUnits = totalUnits * 1.1;
            var topcoatCost = totalUnits * product.pricePerUnit;

            var out = {
                rows: [
                    { label: 'Product', value: product.name },
                    { label: 'Wall area', value: fmt(area) + ' sq ft' },
                    { label: 'Coats', value: String(coats) },
                    { label: 'Coverage rate', value: product.coverage + ' sq ft / ' + product.unit + ' / coat' },
                    { label: 'Topcoat (with safety)', value: fmt(totalUnits) + ' ' + product.unit + ' (≈ ' + packBreakdown(totalUnits, product.packs) + ')' },
                    { label: 'Topcoat cost (est.)', value: '₹' + fmt(topcoatCost), strong: true }
                ],
                note: 'Estimate assumes 2 coats over a limewash primer, with a 10% absorption safety margin. Actual coverage varies with surface porosity.'
            };

            if (withPrimer && primer) {
                var primerUnits = (area / primer.coverage) * 1.1;
                var primerCost = primerUnits * primer.pricePerUnit;
                out.rows.splice(5, 0, { label: 'Prakritik Limewash Primer', value: fmt(primerUnits) + ' ' + primer.unit + ' · ₹' + fmt(primerCost) });
                var total = topcoatCost + primerCost;
                out.rows.push({ label: 'Total estimated', value: '₹' + fmt(total), strong: true });
            }
            return out;
        }

        function render(out) {
            if (!rowsHolder) return;
            rowsHolder.innerHTML = '';
            out.rows.forEach(function (r) {
                var row = document.createElement('div');
                row.className = 'calculator-result__row' + (r.strong ? ' calculator-result__total' : '');
                var l = document.createElement('span');
                l.textContent = r.label;
                var v = document.createElement('span');
                v.textContent = r.value;
                row.appendChild(l);
                row.appendChild(v);
                rowsHolder.appendChild(row);
            });
            if (note) note.textContent = out.note;
            result.removeAttribute('hidden');
            if (empty) empty.hidden = true;
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var areaInput = form.querySelector('[name="area"]');
            var productSelect = form.querySelector('[name="product"]');
            var primerInput = form.querySelector('[name="primer"]');
            if (!areaInput || !productSelect) return;
            var area = parseFloat(areaInput.value);
            if (!area || area <= 0 || isNaN(area)) {
                if (empty) {
                    empty.hidden = false;
                    empty.textContent = 'Please enter a wall area greater than 0.';
                }
                result.setAttribute('hidden', '');
                return;
            }
            var out = compute(area, productSelect.value, primerInput ? primerInput.checked : false);
            if (out) render(out);
        });
    }

    // ---------- Boot ----------
    function boot() {
        // Module init calls — guarded so a missing module never blocks others.
        var mods = ['Navigation', 'Animations', 'AshtaLaabh', 'ColourStudy', 'Forms'];
        mods.forEach(function (m) {
            if (G[m] && typeof G[m].init === 'function') {
                try { G[m].init(); } catch (e) { if (window.console) console.error(m + ' init failed:', e); }
            }
        });

        // App-level functionality.
        try { initThemeToggle(); } catch (e) {}
        try { initBackToTop(); } catch (e) {}
        try { initFaq(); } catch (e) {}
        try { initClaimsSearch(); } catch (e) {}
        try { initClaimsCopy(); } catch (e) {}
        try { initProductMedia(); } catch (e) {}
        try { initCoverageCalculator(); } catch (e) {}
        try { initCertBadges(); } catch (e) {}
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
