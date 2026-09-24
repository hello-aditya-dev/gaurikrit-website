<?php
/**
 * Gaurikrit Bio Products — Painting Budget Calculator.
 * Task PAGES-LOCK. NEW ROUTE. Functional design tool.
 *
 * 4 steps: 1) Fresh Painting / Repainting  2) Interior / Exterior
 *          3) Prakritik Distemper / Prakritik Emulsion  4) Wall area
 *
 * Result section shows the 4 values + an "automatic commercial rates have
 * not yet been configured" message + a "Request Estimate" CTA to /contact/
 * that passes the values via query params.
 *
 * NO rupee values (calculator-config.php rates are null).
 * Form marked with data-calculator-form and data-step attributes for JS.
 *
 * The /assets/js/calculator.js is being built by another agent. The form
 * is fully functional even before that JS lands: a tiny inline script
 * toggles the result panel and builds the request-estimate URL.
 */
declare(strict_types=1);

$pageTitle       = 'Painting Budget Calculator — Gaurikrit Bio Products';
$pageDescription = 'Estimate your Prakritik Paint project. Pick painting type, location, paint format and wall area. An indicative project estimate from Gaurikrit Bio Products.';
$pageCanonical   = '/paint-calculator/';
$pageClass        = 'paint-calculator';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');

// Server-side feature flag: are rates configured?
$calcConfig = include INCLUDES_PATH . '/calculator-config.php';
$ratesEnabled = is_array($calcConfig) && !empty($calcConfig['enabled']);
?>
<style>
  /* HERO */
  .calc-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2rem, 4vw, 3rem); }
  .calc-hero__inner { max-width: 56rem; }
  .calc-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .calc-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .calc-hero__sub { margin-top: 1rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .calc-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }

  /* STEPS */
  .calc-steps { padding-block: clamp(2.5rem, 5vw, 4rem); }
  .calc-step { padding-block: clamp(1.75rem, 4vw, 2.5rem); border-top: 1px solid var(--border); }
  .calc-step:first-of-type { border-top: 0; }
  .calc-step__head { display: flex; align-items: baseline; gap: 1rem; margin-bottom: 1.5rem; }
  .calc-step__num { font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 700; color: var(--haldi-deep); line-height: 0.9; }
  .calc-step__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-step__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); line-height: 1.15; letter-spacing: -0.02em; }
  .calc-step__sub { margin-top: 0.25rem; font-size: 0.9375rem; color: var(--fg-muted); }

  /* RADIO CARDS */
  .radio-card-grid { display: grid; gap: 1rem; }
  @media (min-width: 640px) { .radio-card-grid { grid-template-columns: repeat(2, 1fr); } }
  .radio-card { position: relative; display: flex; flex-direction: column; gap: 0.375rem; padding: 1.25rem 1.5rem; border: 1.5px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); cursor: pointer; transition: border-color var(--dur), box-shadow var(--dur), transform var(--dur); min-height: 5rem; }
  .radio-card:hover { transform: translateY(-2px); border-color: var(--primary); box-shadow: var(--shadow-soft); }
  .radio-card input { position: absolute; opacity: 0; inset: 0; cursor: pointer; }
  .radio-card:has(input:checked) { border-color: var(--primary); background: oklch(0.42 0.05 150 / 0.06); box-shadow: var(--shadow-forest); }
  .radio-card:has(input:focus-visible) { outline: 2px solid var(--primary); outline-offset: 2px; }
  .radio-card__title { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; }
  .radio-card__desc { font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.5; }
  .radio-card__check { position: absolute; top: 0.75rem; right: 0.75rem; width: 1.25rem; height: 1.25rem; border-radius: var(--radius-full); border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; transition: background var(--dur), border-color var(--dur); }
  .radio-card:has(input:checked) .radio-card__check { background: var(--primary); border-color: var(--primary); }
  .radio-card:has(input:checked) .radio-card__check svg { display: block; }
  .radio-card__check svg { display: none; color: var(--primary-fg); }

  /* WALL AREA INPUT */
  .wall-input-wrap { display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: stretch; max-width: 32rem; }
  .wall-input-wrap .form-input { height: 3.25rem; flex: 1 1 14rem; font-size: 1.125rem; font-family: var(--font-display); font-weight: 600; padding: 0 1rem; }
  .wall-input-wrap .wall-input-unit { display: inline-flex; align-items: center; padding: 0 1.25rem; border: 1.5px solid var(--border); border-radius: var(--radius); background: var(--secondary-bg); font-size: 0.9375rem; font-weight: 600; color: var(--fg-muted); }
  .wall-input-hint { margin-top: 0.625rem; font-size: 0.8125rem; color: var(--fg-muted); }

  /* CALCULATE BUTTON */
  .calc-actions { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-start; }
  @media (min-width: 640px) { .calc-actions { flex-direction: row; align-items: center; gap: 1rem; } }

  /* RESULT SECTION (hidden until calculated) */
  .calc-result { margin-top: 2rem; padding: clamp(1.5rem, 4vw, 2.5rem); background: var(--bg-card); border: 1px solid var(--border); border-top: 4px solid var(--haldi-deep); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  .calc-result[hidden] { display: none; }
  .calc-result__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-result__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; letter-spacing: -0.02em; }
  .calc-result__grid { display: grid; gap: 1rem; margin-top: 1.5rem; }
  @media (min-width: 640px) { .calc-result__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .calc-result__grid { grid-template-columns: repeat(4, 1fr); } }
  .calc-result__cell { padding: 1rem 1.25rem; background: var(--secondary-bg); border-radius: var(--radius); border-left: 3px solid var(--haldi); }
  .calc-result__cell-label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
  .calc-result__cell-value { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; margin-top: 0.25rem; line-height: 1.2; }
  .calc-result__note { margin-top: 1.5rem; padding: 1rem 1.25rem; border-left: 3px solid var(--mitti); background: var(--secondary-bg); border-radius: var(--radius); font-size: 0.875rem; color: var(--fg-muted); line-height: 1.65; }
  .calc-result__cta { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* Helper / contact strip */
  .calc-helper { padding-block: clamp(2.5rem, 5vw, 4rem); background: var(--forest); color: var(--primary-fg); }
  .calc-helper__inner { display: grid; gap: 1rem; text-align: center; max-width: 48rem; margin-inline: auto; }
  .calc-helper__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); }
  .calc-helper__body { color: oklch(0.85 0.01 75); line-height: 1.65; }
  .calc-helper__actions { margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
</style>

<!-- HERO -->
<section class="calc-hero" id="calc-hero" data-reveal>
    <div class="container calc-hero__inner">
        <span class="calc-hero__eyebrow"><span class="calc-hero__eyebrow-dot" aria-hidden="true"></span>Painting Budget Calculator</span>
        <h1 class="calc-hero__title">Painting Budget Calculator.</h1>
        <p class="calc-hero__sub">Get an indicative project estimate using your wall area and paint requirements.</p>
        <hr class="calc-hero__rule">
    </div>
</section>

<!-- CALC FORM -->
<section class="calc-steps" id="calc-steps" data-reveal>
    <div class="container" style="max-width: 60rem;">
        <form data-calculator-form novalidate>

            <!-- STEP 1 — Painting type -->
            <fieldset class="calc-step" data-step="1">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 01</div>
                        <h2 class="calc-step__title">What are you painting?</h2>
                        <p class="calc-step__sub">Fresh painting on a new wall, or repainting an existing one?</p>
                    </div>
                </div>
                <div class="radio-card-grid" role="radiogroup" aria-label="Painting type">
                    <label class="radio-card">
                        <input type="radio" name="painting_type" value="fresh" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Fresh Painting</span>
                        <span class="radio-card__desc">New wall, first coat.</span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="painting_type" value="repaint" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Repainting</span>
                        <span class="radio-card__desc">Existing wall, refresh.</span>
                    </label>
                </div>
            </fieldset>

            <!-- STEP 2 — Location -->
            <fieldset class="calc-step" data-step="2">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 02</div>
                        <h2 class="calc-step__title">Where?</h2>
                        <p class="calc-step__sub">Both Prakritik formats list usage as Interior &amp; Exterior.</p>
                    </div>
                </div>
                <div class="radio-card-grid" role="radiogroup" aria-label="Painting location">
                    <label class="radio-card">
                        <input type="radio" name="location" value="interior" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Interior</span>
                        <span class="radio-card__desc">Inside walls.</span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="location" value="exterior" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Exterior</span>
                        <span class="radio-card__desc">Outside walls.</span>
                    </label>
                </div>
            </fieldset>

            <!-- STEP 3 — Paint choice -->
            <fieldset class="calc-step" data-step="3">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 03</div>
                        <h2 class="calc-step__title">Choose Paint.</h2>
                        <p class="calc-step__sub">Two Prakritik Paint formats — Distemper (powder, by kilogram) or Emulsion (liquid, by litre).</p>
                    </div>
                </div>
                <div class="radio-card-grid" role="radiogroup" aria-label="Paint format">
                    <label class="radio-card">
                        <input type="radio" name="paint" value="distemper" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Prakritik Distemper</span>
                        <span class="radio-card__desc">Coverage listed: <?= e($distemper['coverage']) ?> · <?= e($distemper['packagingShort']) ?></span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="paint" value="emulsion" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Prakritik Emulsion</span>
                        <span class="radio-card__desc">Coverage listed: <?= e($emulsion['coverage']) ?> · <?= e($emulsion['packagingShort']) ?></span>
                    </label>
                </div>
            </fieldset>

            <!-- STEP 4 — Wall area -->
            <fieldset class="calc-step" data-step="4">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 04</div>
                        <h2 class="calc-step__title">Wall Area.</h2>
                        <p class="calc-step__sub">Enter the wall area you plan to paint, in square feet.</p>
                    </div>
                </div>
                <div class="wall-input-wrap">
                    <input class="form-input" type="number" name="wall_area" id="calc-wall-area" min="1" step="1" inputmode="numeric" placeholder="e.g. 1200" required>
                    <span class="wall-input-unit">sq.ft.</span>
                </div>
                <p class="wall-input-hint">Tip: a typical room of 10 × 12 ft with 9-ft ceiling has roughly 396 sq.ft. of wall (minus doors and windows).</p>
            </fieldset>

            <!-- ACTIONS -->
            <div class="calc-actions">
                <button type="submit" class="btn btn--primary btn--lg" data-calc-submit>
                    <span data-submit-label>Calculate Estimate</span>
                    <svg data-submit-spinner hidden width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56" style="animation: spin 1s linear infinite"/></svg>
                </button>
                <button type="reset" class="btn btn--ghost btn--lg" data-calc-reset>Start over</button>
            </div>

            <!-- RESULT (hidden until calculate) -->
            <div class="calc-result" data-calc-result hidden role="status" aria-live="polite">
                <span class="calc-result__eyebrow">Your project</span>
                <h3 class="calc-result__title">Here's your indicative project summary.</h3>
                <div class="calc-result__grid">
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Painting type</div>
                        <div class="calc-result__cell-value" data-result-painting-type>—</div>
                    </div>
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Location</div>
                        <div class="calc-result__cell-value" data-result-location>—</div>
                    </div>
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Paint</div>
                        <div class="calc-result__cell-value" data-result-paint>—</div>
                    </div>
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Wall area</div>
                        <div class="calc-result__cell-value" data-result-area>—</div>
                    </div>
                </div>
                <p class="calc-result__note">Automatic commercial rates have not yet been configured. For an accurate estimate, send these project details to Gaurikrit.</p>
                <div class="calc-result__cta">
                    <a href="/contact/?interest=bulk-project" class="btn btn--primary btn--lg" data-calc-request-cta>Request Estimate</a>
                    <a href="/products/" class="btn btn--outline btn--lg">Explore Prakritik Paint</a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- HELPER STRIP -->
<section class="calc-helper" id="calc-helper" data-reveal>
    <div class="container">
        <div class="calc-helper__inner">
            <h2 class="calc-helper__title">Want a more accurate estimate?</h2>
            <p class="calc-helper__body">Send your project details and Gaurikrit will respond with what's currently available for your scale and format.</p>
            <div class="calc-helper__actions">
                <a href="/contact/?interest=bulk-project" class="btn btn--haldi btn--lg">Request Estimate</a>
                <a href="/for-business/" class="btn btn--outline btn--lg" style="border-color: var(--haldi); color: var(--haldi);">Discuss a Project</a>
            </div>
        </div>
    </div>
</section>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>

<script>
// Minimal inline calculator — works even before /assets/js/calculator.js
// loads. Once that file lands it can replace or augment this handler.
(function () {
    var form = document.querySelector('[data-calculator-form]');
    if (!form) return;
    var result = form.querySelector('[data-calc-result]');
    var requestCta = form.querySelector('[data-calc-request-cta]');
    var submit = form.querySelector('[data-calc-submit]');
    var submitLabel = form.querySelector('[data-submit-label]');
    var spinner = form.querySelector('[data-submit-spinner]');

    function val(name) {
        var el = form.querySelector('[name="' + name + '"]:checked');
        return el ? el.value : '';
    }
    function pretty(v, fallback) {
        if (!v) return fallback || '—';
        return v.charAt(0).toUpperCase() + v.slice(1);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (typeof form.reportValidity === 'function' && !form.reportValidity()) return;

        var paintType = pretty(val('painting_type'));
        var location = pretty(val('location'));
        var paint = val('paint');
        var paintLabel = paint === 'distemper' ? 'Prakritik Distemper' : paint === 'emulsion' ? 'Prakritik Emulsion' : '—';
        var area = (form.querySelector('[name="wall_area"]') || {}).value || '';

        form.querySelector('[data-result-painting-type]').textContent = paintType;
        form.querySelector('[data-result-location]').textContent = location;
        form.querySelector('[data-result-paint]').textContent = paintLabel;
        form.querySelector('[data-result-area]').textContent = area ? (parseInt(area, 10).toLocaleString('en-IN') + ' sq.ft.') : '—';

        // Build the Request Estimate URL with the project details.
        var params = new URLSearchParams();
        params.set('interest', 'bulk-project');
        if (paintType && paintType !== '—') params.set('painting_type', paintType);
        if (location && location !== '—') params.set('location', location);
        if (paint) params.set('paint', paint);
        if (area) params.set('wall_area', String(area));
        if (requestCta) requestCta.href = '/contact/?' + params.toString();

        if (result) result.removeAttribute('hidden');

        // Tiny submit affordance.
        if (submitLabel && spinner) {
            spinner.hidden = false;
            submit.setAttribute('disabled', 'disabled');
            setTimeout(function () {
                spinner.hidden = true;
                submit.removeAttribute('disabled');
                result.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        } else if (result) {
            result.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    var resetBtn = form.querySelector('[data-calc-reset]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (result) result.setAttribute('hidden', '');
        });
    }
})();
</script>

<?php require ROOT_PATH . '/includes/footer.php';
