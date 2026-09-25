<?php
/**
 * Gaurikrit Bio Products — Paint Calculator (V5 finish pass).
 * Task V5-FINISH.
 *
 * Refines the V4 composition: tighter hero top spacing for a balanced
 * first screen; more prominent step numbers + clearer selected card
 * state (haldi ring + lift); calc-helper (the post-result CTA box) is
 * now hidden by default and revealed only when the user completes all
 * 4 steps (the result panel becomes visible). Factual data unchanged.
 *
 * Composition:
 *   - Hero (intro) — V5: tighter top spacing.
 *   - Calculator page: the tool is the page — single quiet column
 *     58% steps. Interior-wall-study as background layer.
 *   - Steps: 01 PAINTING / 02 LOCATION / 03 PRODUCT / 04 AREA.
 *     V5: larger progress dots + clearer selected card state.
 *   - Result: project summary (NO prices).
 *   - Helper CTA: V5: hidden by default; shown only after the result
 *     panel becomes visible (4 steps complete).
 */
declare(strict_types=1);

$pageTitle       = 'Paint Calculator — Estimate Your Project | Gaurikrit';
$pageDescription = 'Walk through four quick choices to estimate your Prakritik Paint project. What you are painting, where, which format, and how much wall area. Send the summary to Gaurikrit.';
$pageCanonical   = '/paint-calculator/';
$pageClass        = 'paint-calculator';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY;

$calcConfig = require ROOT_PATH . '/includes/calculator-config.php';
$calcConfigJson = json_encode($calcConfig, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO (V5: tighter top spacing for a balanced first screen) ===== */
  .calc-hero { padding-top: calc(var(--header-h) + 1rem); padding-bottom: 1rem; }
  @media (min-width: 1024px) { .calc-hero { padding-top: calc(var(--header-h) + 1.5rem); padding-bottom: 1.5rem; } }
  .calc-hero__inner { display: grid; gap: 1rem; max-width: 60rem; }
  .calc-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .calc-hero__eyebrow-dot {
    display: inline-block; width: 0.375rem; height: 0.375rem;
    border-radius: 50%; background: var(--haldi);
  }
  .calc-hero__title {
    margin-top: 0.5rem; font-family: var(--font-display);
    font-size: clamp(2.2rem, 5vw, 4rem); letter-spacing: -0.02em;
    text-wrap: balance; line-height: 1.05;
  }
  .calc-hero__sub {
    margin-top: 1rem; color: var(--fg-muted);
    font-size: clamp(1rem, 2vw, 1.125rem); max-width: 60ch;
  }

  /* ===== CALCULATOR PAGE — V12: the tool IS the page. The decorative
     sticky wall-scene (photo + never-driven SVG) is retired — the UI is
     more important than the picture. Single column, max 60rem, generous
     vertical rhythm; the four steps + result read as one quiet flow. ===== */
  .calculator-page {
    padding-top: clamp(1.5rem, 3vw, 2.5rem);
    padding-bottom: clamp(4rem, 7vw, 6rem);
    display: grid; gap: 2.5rem;
    grid-template-columns: minmax(0, 60rem);
    justify-content: center;
  }

  /* The actual calculator mount — JS builds the UI inside it. */
  .calculator-page__steps { display: grid; gap: 1.5rem; }

  .calc__cards { display: grid; gap: 0.875rem; margin-top: 1rem; }
  @media (min-width: 640px) { .calc__cards { grid-template-columns: 1fr 1fr; } }
  .calc__card {
    padding: 1.25rem 1.5rem;  /* V5: was 1rem 1.25rem */
    border: 2px solid var(--border-strong);  /* V5: was 1.5px */
    background: var(--paper); border-radius: var(--r-btn);
    text-align: left; cursor: pointer; min-height: 44px;
    display: flex; flex-direction: column; gap: 0.25rem;
    transition: background var(--dur), border-color var(--dur), color var(--dur), transform var(--dur), box-shadow var(--dur);
  }
  .calc__card:hover {
    border-color: var(--forest); color: var(--forest);
    transform: translateY(-1px);  /* V5: subtle lift on hover */
  }
  .calc__card[aria-pressed="true"] {
    background: color-mix(in srgb, var(--haldi) 22%, var(--paper));  /* V5: 18% → 22% */
    border-color: var(--forest); color: var(--forest);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--haldi) 30%, transparent);  /* V5: haldi ring */
    transform: translateY(-1px);  /* V5: lift on selected */
  }
  .calc__card-title { font-weight: 700; font-size: 1.0625rem; }  /* V5: was 600 / 1rem */
  .calc__card-desc  { font-size: 0.8125rem; color: var(--fg-muted); }

  /* V5: progress indicator — larger dots, bolder type, clearer current/
     done states. Bigger visual difference between selected/unselected. */
  .calc__progress {
    list-style: none; display: flex; gap: 0.75rem; margin: 0 0 2rem;
    padding: 0; flex-wrap: wrap;
  }
  .calc__progress-item { display: flex; align-items: center; gap: 0.5rem; }
  .calc__progress-btn {
    background: transparent; border: 0; padding: 0;
    display: flex; align-items: center; gap: 0.5rem;
    cursor: pointer; color: var(--fg-muted);
    font-size: 0.9375rem; font-weight: 600;  /* V5: was 0.875rem / 500 */
  }
  .calc__progress-btn[disabled] { cursor: not-allowed; opacity: 0.5; }
  .calc__progress-dot {
    display: inline-flex; align-items: center; justify-content: center;
    width: 2rem; height: 2rem;  /* V5: was 1.5rem */
    border-radius: 50%;
    border: 2px solid var(--border-strong);  /* V5: was 1.5px */
    font-family: var(--font-display); font-weight: 700; font-size: 0.8125rem;  /* V5: was 0.75rem */
    color: var(--fg-muted);
    transition: background var(--dur), border-color var(--dur), color var(--dur), box-shadow var(--dur), transform var(--dur);
  }
  .calc__progress-item.is-current .calc__progress-dot {
    border-color: var(--forest); color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 22%, var(--paper));  /* V5: 18% → 22% */
    box-shadow: 0 0 0 4px color-mix(in srgb, var(--haldi) 12%, transparent);  /* V5: halo */
    transform: scale(1.05);  /* V5: subtle scale */
  }
  .calc__progress-item.is-done .calc__progress-dot {
    background: var(--forest); border-color: var(--forest); color: var(--paper);
    transform: scale(1.08);  /* V5: subtle scale */
  }

  .calc__step { padding: 0; background: transparent; border: 0; }
  .calc__step-title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem);
    margin-bottom: 0.5rem;
  }
  .calc__step-help { color: var(--fg-muted); margin-bottom: 1rem; font-size: 0.9375rem; }
  .calc__field { margin-bottom: 1.25rem; }
  .calc__result-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--haldi); }
  .calc__result-list { display: grid; gap: 0; margin-top: 1rem; }
  .calc__result-row {
    display: flex; justify-content: space-between; align-items: baseline;
    gap: 1rem; padding-block: 0.75rem;
    border-bottom: 1px solid rgba(250, 248, 241, 0.18);
  }
  .calc__result-key { color: rgba(250, 248, 241, 0.78); font-size: 0.875rem; }
  .calc__result-val {
    font-family: var(--font-display); font-weight: 700; color: var(--haldi);
    font-size: 1.125rem;
  }
  .calc__result-note {
    margin-top: 1rem; font-size: 0.8125rem;
    color: rgba(250, 248, 241, 0.6); line-height: 1.5;
  }
  .calc__result-cta-copy {
    margin-top: 0.5rem; font-size: 0.9375rem; color: rgba(250, 248, 241, 0.85);
  }
  .calc__result-actions { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.5rem; }

  /* Helper / contact aside at the bottom.
     V5: hidden by default; revealed only when the result panel is visible
     (i.e. when the user has completed all 4 steps). A small inline script
     watches [data-calc-result] for the `hidden` attribute and toggles the
     .is-shown class on this helper. */
  .calc-helper {
    display: none;  /* V5: hidden by default */
    margin-top: 2.5rem; padding: 1.5rem;
    background: var(--limewash); border-left: 3px solid var(--haldi);
    border-radius: var(--r-input);
  }
  .calc-helper.is-shown { display: block; }  /* V5: shown when 4 steps complete */
</style>

<!-- ===== HERO (V5: tighter top spacing) ===== -->
<section class="calc-hero bg-limewash" aria-labelledby="calc-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Calculator</span>
    </nav>
    <div class="calc-hero__inner" data-reveal>
      <span class="calc-hero__eyebrow">
        <span class="calc-hero__eyebrow-dot" aria-hidden="true"></span>
        Estimate your project
      </span>
      <hr class="calc-hero__rule">
      <h1 class="calc-hero__title" id="calc-title">Planning to paint?</h1>
      <p class="calc-hero__sub">
        Walk through four quick choices — what you are painting, where, which
        Prakritik format, and how much wall area. We summarise the project for
        you to send to Gaurikrit.
      </p>
    </div>
  </div>
</section>

<!-- ===== CALCULATOR PAGE — the tool is the page (V12: decorative
     wall-scene visual retired; single quiet column) ===== -->
<section class="bg-limewash" style="padding-top: 0;">
  <div class="container">
    <div class="calculator-page" data-reveal>
      <!-- 4-step calculator mount -->
      <div class="calculator-page__steps">
        <script type="application/json" id="calculator-config"><?= $calcConfigJson /* raw JSON */ ?></script>
        <div data-calculator></div>

        <!-- V5: helper (post-result CTA) — hidden by default; revealed only
             after the calculator result panel becomes visible (4 steps
             complete). Inline script below toggles .is-shown. -->
        <div class="calc-helper" data-calc-helper>
          <h2 class="calc-helper__title">Need a more specific estimate?</h2>
          <p class="calc-helper__body">
            Send the project summary to Gaurikrit and we will respond with what
            we can practically supply for your site.
          </p>
          <div class="calc-helper__actions">
            <a class="btn btn--secondary" href="/contact/?interest=bulk-project">Talk to Us</a>
            <a class="btn btn--outline" href="/products/">Explore Products</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- V5: inline script — watches the calculator mount for the result panel
     becoming visible (hidden attribute removed). Toggles .is-shown on the
     .calc-helper so the post-result CTA appears only after 4 steps complete. -->
<script>
  (function () {
    'use strict';
    function setupCalcHelper() {
      var helper = document.querySelector('[data-calc-helper]');
      var mount = document.querySelector('[data-calculator]');
      if (!helper || !mount) return;
      function check() {
        var result = mount.querySelector('[data-calc-result]');
        if (result && !result.hasAttribute('hidden')) {
          helper.classList.add('is-shown');
        } else {
          helper.classList.remove('is-shown');
        }
      }
      if (typeof MutationObserver === 'function') {
        var obs = new MutationObserver(check);
        obs.observe(mount, { attributes: true, subtree: true, attributeFilter: ['hidden'] });
      }
      // Fallback poll in case MutationObserver is unavailable.
      setInterval(check, 700);
      check();
    }
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', setupCalcHelper);
    } else {
      setupCalcHelper();
    }
  })();
</script>
<?php require ROOT_PATH . '/includes/footer.php';
