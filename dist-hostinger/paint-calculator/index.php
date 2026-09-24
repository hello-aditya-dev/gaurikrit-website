<?php
/**
 * Gaurikrit Bio Products — Paint Calculator (V3 rebuild).
 * Task V3-PAGES.
 *
 * Composition:
 *   - Hero (intro).
 *   - Calculator page: 42% sticky calculator-wall-scene / 58% steps.
 *   - Steps: 01 PAINTING (Fresh/Repainting) / 02 LOCATION
 *     (Interior/Exterior) / 03 PRODUCT (Distemper/Emulsion) / 04 AREA.
 *   - Result: project summary (NO prices). "Automatic commercial rates
 *     have not yet been configured." CTA "Request Estimate".
 *
 * The calculator JS builds the 4-step UI inside [data-calculator]. This page
 * supplies the surrounding hero, the sticky visual, and the JSON config.
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
  /* ===== HERO ===== */
  .calc-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
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

  /* ===== CALCULATOR PAGE — 42% sticky visual / 58% steps ===== */
  .calculator-page {
    padding-top: clamp(2rem, 4vw, 3rem);
    padding-bottom: clamp(4rem, 7vw, 6rem);
    display: grid; gap: 2.5rem;
  }
  @media (min-width: 1024px) {
    .calculator-page {
      grid-template-columns: 42fr 58fr;
      align-items: start;
    }
  }
  @media (max-width: 1023px) {
    .calculator-page { grid-template-columns: 1fr; }
  }
  .calculator-page__visual {
    position: sticky; top: calc(var(--header-h) + 1rem);
    background: var(--limewash); border: 1px solid var(--border);
    border-radius: var(--r-panel); aspect-ratio: 4/3;
    display: flex; align-items: center; justify-content: center;
    padding: 2rem; overflow: hidden;
  }
  @media (max-width: 1023px) {
    .calculator-page__visual { position: relative; top: auto; aspect-ratio: 16/9; }
  }
  .calculator-page__visual svg { width: 100%; height: 100%; display: block; }

  /* The actual calculator mount — JS builds the UI inside it. */
  .calculator-page__steps { display: grid; gap: 1.5rem; }

  /* Override the JS-built .calc-step / .calc-result styles to match V3. */
  .calc-step {
    padding: 1.5rem; background: var(--paper);
    border: 1px solid var(--border); border-radius: var(--r-panel);
    transition: border-color var(--dur);
  }
  .calc-step[data-selected="true"] {
    border-color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 6%, var(--paper));
  }
  .calc__cards { display: grid; gap: 0.75rem; margin-top: 1rem; }
  @media (min-width: 640px) { .calc__cards { grid-template-columns: 1fr 1fr; } }
  .calc__card {
    padding: 1rem 1.25rem; border: 1.5px solid var(--border-strong);
    background: var(--paper); border-radius: var(--r-btn);
    text-align: left; cursor: pointer; min-height: 44px;
    display: flex; flex-direction: column; gap: 0.25rem;
    transition: background var(--dur), border-color var(--dur), color var(--dur);
  }
  .calc__card:hover { border-color: var(--forest); color: var(--forest); }
  .calc__card[aria-pressed="true"] {
    background: color-mix(in srgb, var(--haldi) 18%, var(--paper));
    border-color: var(--forest); color: var(--forest);
  }
  .calc__card-title { font-weight: 600; font-size: 1rem; }
  .calc__card-desc  { font-size: 0.8125rem; color: var(--fg-muted); }

  /* Progress indicator styling */
  .calc__progress {
    list-style: none; display: flex; gap: 0.5rem; margin: 0 0 1.5rem;
    padding: 0; flex-wrap: wrap;
  }
  .calc__progress-item { display: flex; align-items: center; gap: 0.5rem; }
  .calc__progress-btn {
    background: transparent; border: 0; padding: 0;
    display: flex; align-items: center; gap: 0.5rem;
    cursor: pointer; color: var(--fg-muted);
    font-size: 0.875rem; font-weight: 500;
  }
  .calc__progress-btn[disabled] { cursor: not-allowed; opacity: 0.5; }
  .calc__progress-dot {
    display: inline-flex; align-items: center; justify-content: center;
    width: 1.5rem; height: 1.5rem; border-radius: 50%;
    border: 1.5px solid var(--border-strong);
    font-family: var(--font-display); font-weight: 700; font-size: 0.75rem;
    color: var(--fg-muted);
  }
  .calc__progress-item.is-current .calc__progress-dot {
    border-color: var(--forest); color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 18%, var(--paper));
  }
  .calc__progress-item.is-done .calc__progress-dot {
    background: var(--forest); border-color: var(--forest); color: var(--paper);
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

  /* Helper / contact aside at the bottom */
  .calc-helper {
    margin-top: 2.5rem; padding: 1.5rem;
    background: var(--limewash); border-left: 3px solid var(--haldi);
    border-radius: var(--r-input);
  }
</style>

<!-- ===== HERO ===== -->
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

<!-- ===== CALCULATOR PAGE — 42% sticky visual / 58% steps ===== -->
<section class="bg-limewash" style="padding-top: 0;">
  <div class="container">
    <div class="calculator-page" data-reveal>
      <!-- LEFT: sticky interactive wall scene -->
      <div class="calculator-page__visual" aria-hidden="true">
        <?php render_illustration('calculator-wall-scene'); ?>
      </div>

      <!-- RIGHT: 4-step calculator mount -->
      <div class="calculator-page__steps">
        <script type="application/json" id="calculator-config"><?= $calcConfigJson /* raw JSON */ ?></script>
        <div data-calculator></div>

        <div class="calc-helper">
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
<?php require ROOT_PATH . '/includes/footer.php';
