<?php
/**
 * Gaurikrit Bio Products — Homepage (V7 surgical repair + responsive rebuild).
 * Task V5-FINISH.
 *
 * Refines the V4 composition: organic haldi field, exterior-wall-study-v2
 * on the Emulsion chapter, finished-wall-study on the Material-to-wall
 * triptych right panel, strengthened Ashta section, inline SVG wall-with-
 * dimension-lines for the Calculator teaser, business-context-study on
 * Pathways. Factual data unchanged from data.php.
 *
 * Composition:
 *   1. Hero — text 5 / visual 7. Real group photo (1280×621) eager+
 *      high-priority. Behind: organic CSS haldi field (irregular border-
 *      radius + layered radial gradients, no SVG). Zebu cow engraving at
 *      0.14 opacity. Rural landscape band at 0.12 opacity.
 *   2. Material Statement — 42/58. Zebu-study.webp large right (58%).
 *   3. Distemper chapter — interior-wall-study as env + real product
 *      photo (510×538, natural size). Ghost "DISTEMPER". Cool section.
 *   4. Emulsion chapter — exterior-wall-study-v2 as env + real product
 *      photo (355×486, natural size). Ghost "EMULSION". Warm. Reversed.
 *   5. Material Journey — 3-panel composition (interior + group +
 *      finished-wall-study).
 *   6. Ashta Laabh — strengthened seal (44rem), darker warm bg, bolder
 *      benefit labels. SVG seal kept.
 *   7. Colours of India — courtyard-study.webp (1942×809) large wall.
 *      Swatches recolor via --wall-color CSS var.
 *   8. Mission — forest section. Rural-landscape at 0.15 opacity.
 *   9. Calculator Teaser — inline SVG wall with dimension lines
 *      (no photo, no poster styling) + mini project-summary preview.
 *  10. Pathways — business-context-study shared + 4 ruled columns.
 */
declare(strict_types=1);

$pageTitle       = 'Gaurikrit — Prakritik Paint & Bio Products';
$pageDescription = 'Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls. Gaurikrit Bio Products, Khurja, District Bulandshahr, Uttar Pradesh.';
$pageCanonical   = '/';
$pageClass       = 'home';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $COLOUR_STUDY, $MATERIAL_JOURNEY, $PROJECT_PATHWAYS;

$distemper   = get_product('prakritik-distemper');
$emulsion    = get_product('prakritik-emulsion');
$groupImage  = '/assets/products/prakritik-group.jpg';

// Map Ashta Laabh names to seal SVG node IDs (so the radial seal reacts).
$ashtaIds = [
    'Antibacterial'              => 'antibacterial',
    'Antifungal'                 => 'antifungal',
    'Eco-Friendly'               => 'eco-friendly',
    'Natural Thermal Insulator'  => 'thermal-insulator',
    'Cost-Effective'             => 'cost-effective',
    'Free from Heavy Metals'     => 'heavy-metal-free',
    'Non-Toxic'                  => 'non-toxic',
    'Odourless'                  => 'odourless',
];
?>
<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .editorial-image--contain { object-fit: contain; }

  /* ===== 1. HERO — group photo dominant + CSS haldi field + cow engraving ===== */
  .hero { padding-top: calc(var(--header-h) + 1.5rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) {
    .hero { display: flex; align-items: center;
            padding-top: calc(var(--header-h) + 2rem); padding-bottom: 2rem; }
  }
  .hero__grid { align-items: center; position: relative; }
  @media (min-width: 1200px) {
    .hero__grid { grid-template-columns: 5fr 7fr; gap: clamp(2rem, 4vw, 4rem); }
  }
  @media (min-width: 900px) and (max-width: 1199px) {
    .hero__grid { grid-template-columns: 6fr 6fr; gap: clamp(1.5rem, 3vw, 3rem); }
  }
  @media (max-width: 899px) {
    .hero__grid { grid-template-columns: 1fr; }
    .hero__visual { order: 5; }
  }
  .hero__eyebrow-chip { margin-bottom: 0.875rem; }
  .hero__title { font-size: clamp(2.5rem, 6vw, 5.5rem); line-height: 1.02; }
  .hero__body { max-width: 38rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V7 hero visual: the real group photo deliberately placed inside a
     paper/material plate whose background visually merges with the page.
     No generic haldi semicircle, no faint cow engraving, no landscape band. */
  .hero__visual { position: relative; min-height: 0; width: 100%; }
  .hero__plate {
    position: relative; z-index: 2;
    background: var(--paper);
    border: 1px solid var(--border);
    border-top: 3px solid var(--haldi);
    border-radius: var(--r-panel);
    padding: clamp(1rem, 2.5vw, 2rem);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .hero__plate img.hero-group-photo {
    display: block;
    width: 100%; height: auto;
    object-fit: contain;
    aspect-ratio: 1280 / 621;
  }
  /* A restrained, irregular haldi paint field — reads as a painted wall
     sample (plaster swash), placed BEHIND the plate's bottom edge only. */
  .hero__paint-sample {
    position: absolute;
    left: -4%; right: 6%; bottom: -1.25rem;
    height: 34%;
    z-index: 0;
    pointer-events: none;
    border-radius: 46% 54% 48% 52% / 60% 54% 46% 40%;
    background:
      radial-gradient(ellipse 70% 62% at 50% 40%,
        color-mix(in srgb, var(--haldi) 26%, transparent) 0%,
        transparent 78%);
    opacity: 0.5;
  }
  @media (max-width: 899px) { .hero__paint-sample { display: none; } }

  /* ===== 2. MATERIAL STATEMENT — zebu-study large right (58%) ===== */
  .material-statement__visual {
    aspect-ratio: 1536/1024;
    background: var(--limewash);
    overflow: hidden;
    padding: 0;
    position: relative;
  }
  .material-statement__visual .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  /* Remove the legacy cow/wall composition — single editorial photo replaces it. */
  .material-statement__visual .ms-wall,
  .material-statement__visual .ms-cow,
  .material-statement__visual .ms-arrow { display: none; }

  /* ===== 3/4. PRODUCT CHAPTERS — editorial env + real product photo ===== */
  .product-chapter__visual {
    position: relative;
    aspect-ratio: 4/3;
    min-height: 22rem;
    background: var(--paper);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
  }
  @media (min-width: 1024px) {
    .product-chapter__visual { min-height: 30rem; }
  }
  /* Editorial environment image — fills the visual area. */
  .product-chapter__visual .chapter-env {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover;
  }
  /* Real product photo at its natural size — overlaid on the environment. */
  .product-chapter__visual .chapter-product {
    position: relative;
    z-index: 2;
    display: block;
    max-height: 80%;
    width: auto;
    max-width: 70%;
    object-fit: contain;
    /* Subtle drop shadow lifts the product off the environment. */
    filter: drop-shadow(0 18px 28px rgba(34, 36, 27, 0.18));
  }
  /* Distemper product cap: 510×538 — never wider than 480px CSS. */
  .product-chapter__visual .chapter-product--distemper {
    max-width: min(70%, 480px);
  }
  /* Emulsion product cap: 355×486 — never wider than 340px CSS. */
  .product-chapter__visual .chapter-product--emulsion {
    max-width: min(60%, 340px);
  }

  /* ===== 5. MATERIAL JOURNEY — 3-panel composition ===== */
  .material-flow { padding-block: clamp(3rem, 6vw, 5rem); }
  .material-flow__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .material-flow__panels {
    display: grid; gap: 1rem;
    grid-template-columns: 1fr;
    margin-bottom: 2.5rem;
  }
  @media (min-width: 768px) {
    .material-flow__panels { grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; }
  }
  .material-flow__panel {
    position: relative;
    aspect-ratio: 1344/768;
    background: var(--limewash);
    overflow: hidden;
    border-radius: var(--r-panel);
  }
  .material-flow__panel--group { aspect-ratio: 1280/621; }
  .material-flow__panel .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
    /* V7: one shared colour grade so the triptych reads as one composition. */
    filter: saturate(0.94) sepia(0.05);
  }
  .material-flow__panel-label {
    position: absolute; left: 0.875rem; bottom: 0.875rem;
    background: rgba(250, 248, 241, 0.88);
    padding: 0.375rem 0.75rem;
    border-radius: var(--r-pill);
    font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--fg);
  }

  /* ===== 6. ASHTA LAABH — strengthened (V5): darker warm bg, larger seal,
     bolder benefit labels. SVG seal kept interactive. ===== */
  .ashta-section {
    position: relative; overflow: hidden;
    /* Slightly darker warm tone — overrides section--limewash. */
    background: color-mix(in srgb, var(--haldi) 10%, var(--limewash));
  }
  /* V7: the giant faded cow background is REMOVED — two clear layers only:
     seal + list. Slightly stronger warm ground for the seal to read dark. */
  .ashta-section { background: color-mix(in srgb, var(--haldi) 12%, var(--limewash)); }
  .ashta-section__inner { position: relative; z-index: 1; }
  .ashta-section__grid { position: relative; z-index: 1; }
  /* V5: enlarge seal from 38rem → 44rem for more authority. */
  .ashta-section__seal { max-width: 44rem; margin-inline: auto; }
  .ashta-benefit__num { font-feature-settings: "tnum"; }
  /* V5: bolder / larger benefit labels (page-local override). */
  .ashta-benefit__name {
    font-weight: 700 !important;
    font-size: 1.0625rem !important;
    letter-spacing: 0.005em;
  }
  .ashta-benefit__deva {
    font-size: 0.9375rem !important;
    color: color-mix(in srgb, var(--haldi-deep) 60%, var(--fg-muted)) !important;
  }
  .ashta-benefit {
    padding: 1.25rem 0 !important;
  }

  /* ===== 7. COLOURS OF INDIA — courtyard-study.jpg large wall plane ===== */
  .colours-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .colours-wall {
    aspect-ratio: 1942/809;
    background: var(--limewash);
    border: 0; border-radius: 0;
    overflow: hidden;
    position: relative;
  }
  @media (min-width: 1024px) { .colours-wall { aspect-ratio: 21/9; } }
  /* The courtyard study fills the wall plane. */
  .colours-wall .colours-wall__art {
    position: absolute; inset: 0; width: 100%; height: 100%;
    display: block; object-fit: cover;
  }
  /* Tint overlay — recoloured via --wall-color. NO mix-blend-mode. */
  .colours-wall .colours-wall__tint {
    position: absolute; inset: 0;
    background: var(--wall-color, transparent);
    opacity: 0.55;
    pointer-events: none;
    transition: background 0.45s var(--ease);
  }
  .colours-wall__label {
    position: absolute; bottom: 1rem; left: 1rem;
    font-family: var(--font-display); font-size: 1.125rem; font-weight: 700;
    color: var(--charcoal);
    background: rgba(250, 248, 241, 0.88);
    padding: 0.5rem 1rem; border-radius: var(--r-pill);
    -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px);
    z-index: 2;
  }
  .colours-wall__label small {
    display: block; font-family: var(--font-sans); font-size: 0.625rem;
    font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--fg-muted); margin-top: 0.125rem;
  }
  .colours-swatches {
    display: flex; flex-wrap: wrap; gap: 1.5rem 1.75rem;
    margin-top: 2.5rem; justify-content: flex-start;
  }
  .colours-swatch {
    width: 2.75rem; height: 2.75rem; border-radius: 50%;
    border: 2px solid var(--border); padding: 0; cursor: pointer;
    position: relative; transition: transform var(--dur), border-color var(--dur);
  }
  .colours-swatch:hover { transform: translateY(-2px); }
  .colours-swatch[data-active="true"] {
    border-color: var(--forest); transform: translateY(-2px);
  }
  .colours-swatch__label {
    position: absolute; top: calc(100% + 0.5rem); left: 50%;
    transform: translateX(-50%); white-space: nowrap;
    font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }

  /* ===== 8. MISSION — forest band with rural-landscape engraving ===== */
  .mission-band {
    position: relative; padding-block: clamp(4rem, 8vw, 6.5rem);
    background: var(--forest-deep); color: var(--primary-fg);
    overflow: hidden;
  }
  .mission-band__bg {
    position: absolute; inset: 0; opacity: 0.15; pointer-events: none;
    overflow: hidden;
  }
  .mission-band__bg .editorial-image { width: 100%; height: 100%; object-fit: cover; }
  .mission-band__inner {
    position: relative; z-index: 1; max-width: 48rem;
  }
  .mission-band__eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--haldi);
  }
  .mission-band__title {
    margin-top: 0.875rem; font-family: var(--font-display); font-style: italic;
    font-size: clamp(1.75rem, 4vw, 3.25rem); line-height: 1.15;
    letter-spacing: -0.01em; color: var(--paper); text-wrap: balance;
  }
  .mission-band__sub {
    margin-top: 1.5rem; font-size: 1rem; line-height: 1.7;
    color: rgba(250, 248, 241, 0.78); max-width: 60ch;
  }
  .mission-band__cta { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* ===== 9. CALCULATOR TEASER (V7: a miniature of the actual calculator
     UI — 'this is an interactive estimator', not a W × H poster) ===== */
  .calc-teaser { padding-block: clamp(3.5rem, 6vw, 5.5rem); }
  .calc-teaser__art {
    position: relative;
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    overflow: hidden;
    padding: clamp(1.25rem, 2vw, 1.75rem);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .calc-teaser__sheet-head {
    display: flex; align-items: baseline; justify-content: space-between;
    gap: 1rem; padding-bottom: 0.875rem; margin-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
  }
  .calc-teaser__sheet-title {
    font-family: var(--font-display); font-size: 1.125rem; font-weight: 700;
    color: var(--primary);
  }
  .calc-teaser__sheet-tag {
    font-size: 0.625rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .calc-teaser__step {
    display: grid; grid-template-columns: 2.25rem 1fr auto; gap: 0.875rem;
    align-items: center;
    padding: 0.875rem 0;
    border-bottom: 1px dashed var(--border);
  }
  .calc-teaser__step:last-child { border-bottom: 0; }
  .calc-teaser__step-num {
    width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    background: color-mix(in srgb, var(--haldi) 22%, transparent);
    border: 1px solid var(--forest);
    font-size: 0.75rem; font-weight: 700; color: var(--forest);
  }
  .calc-teaser__step-label {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .calc-teaser__step-value {
    font-family: var(--font-display); font-size: 0.9375rem; font-weight: 700;
    color: var(--primary); text-align: right;
  }
  .calc-teaser__step-dot {
    width: 0.5rem; height: 0.5rem; border-radius: 50%;
    background: var(--haldi);
  }

  /* ===== 10. PROJECT PATHWAYS (V7: audiences are the design — no generic
     suburban house artwork) ===== */
  .pathways-section { padding-block: clamp(3rem, 6vw, 5rem); }
</style>

<!-- ============================================================
     1. HERO — 12-col (text 5 / visual 7), dominant group photo
     ============================================================ -->
<section class="hero bg-limewash" aria-labelledby="hero-title">
  <div class="container">
    <div class="hero__grid">
      <div class="hero__lockup">
        <span class="hero__eyebrow-chip">
          <span class="hero__eyebrow-dot" aria-hidden="true"></span>
          GAURIKRIT BIO PRODUCTS
        </span>
        <span class="hero__devanagari" aria-hidden="true"><?= e($COMPANY['devanagari']) ?></span>
        <h1 class="hero__title" id="hero-title"><?= e($COMPANY['headline']) ?></h1>
        <p class="hero__body">
          Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls.
        </p>
        <div class="hero__ctas">
          <a class="btn btn--primary btn--lg" href="/products/">Explore Prakritik Paint</a>
          <a class="btn btn--secondary btn--lg" href="/why-prakritik/">Why Prakritik?</a>
        </div>
      </div>

      <div class="hero__visual" data-reveal>
        <div class="hero__paint-sample" aria-hidden="true"></div>
        <div class="hero__plate">
          <img class="hero-group-photo"
               src="<?= asset_url($groupImage) ?>"
               alt="Prakritik Distemper and Emulsion paint packs"
               width="1280" height="621"
               loading="eager" fetchpriority="high" decoding="async">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. MATERIAL STATEMENT — copy 42 / zebu-study 58
     ============================================================ -->
<section class="section section--paper" aria-labelledby="material-title">
  <div class="container">
    <div class="material-statement" data-reveal style="grid-template-columns: 42fr 58fr;">
      <div class="material-statement__copy">
        <span class="material-statement__eyebrow">An old Indian material idea</span>
        <h2 class="material-statement__headline" id="material-title">
          An old Indian material idea, reconsidered for modern walls.
        </h2>
        <hr class="material-statement__rule">
        <div class="material-statement__body">
          <p>
            Traditional Indian homes have long used cow-dung-based coatings on walls
            and floors. Prakritik Paint brings that material idea into contemporary
            Distemper and Emulsion formats.
          </p>
          <p>
            Both formats are listed for interior and exterior use.
          </p>
        </div>
      </div>
      <div class="material-statement__visual" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/zebu-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/zebu-study.jpg') ?>"
               alt="Editorial study of an Indian zebu cow"
               width="1536" height="1024"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. DISTEMPER PRODUCT CHAPTER (cool / chuna / indigo env)
     ============================================================ -->
<section class="product-chapter product-chapter--distemper" aria-labelledby="distemper-chapter-title">
  <span class="product-chapter__ghost" aria-hidden="true">DISTEMPER</span>
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <div class="product-chapter__visual">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-wall-study.webp') ?>">
          <img class="chapter-env"
               src="<?= asset_url('/assets/editorial/interior-wall-study.jpg') ?>"
               alt=""
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <img class="chapter-product chapter-product--distemper"
             src="<?= asset_url($distemper['officialImage']) ?>"
             alt="<?= e($distemper['name']) ?>"
             width="510" height="538"
             loading="lazy" decoding="async">
      </div>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Format 01 — Distemper</span>
        <h3 class="product-chapter__name" id="distemper-chapter-title">
          <?= e($distemper['name']) ?>
        </h3>
        <p class="product-chapter__desc">
          <?= e($distemper['descriptor']) ?>. A paint listed for interior
          and exterior walls. Supplied in <?= e($distemper['packagingShort']) ?> packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row">
            <dt>Finish</dt><dd><?= e($distemper['finish']) ?></dd>
          </div>
          <div class="duo-panel__row">
            <dt>Drying time</dt><dd><?= e($distemper['dryingTime']) ?></dd>
          </div>
          <div class="duo-panel__row">
            <dt>Coverage</dt><dd><?= e($distemper['coverage']) ?></dd>
          </div>
          <div class="duo-panel__row">
            <dt>V.O.C.</dt><dd><?= e($distemper['voc']) ?></dd>
          </div>
        </dl>
        <div class="product-chapter__cta">
          <a class="btn btn--secondary" href="<?= e($distemper['route']) ?>">View Distemper</a>
          <a class="btn btn--outline" href="/contact/?interest=prakritik-distemper">Enquire About Distemper</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     4. EMULSION PRODUCT CHAPTER (warm / leaf / haldi env, reversed)
     V5: env replaced with exterior-wall-study-v2 (less AI-looking).
     ============================================================ -->
<section class="product-chapter product-chapter--emulsion" aria-labelledby="emulsion-chapter-title">
  <span class="product-chapter__ghost" aria-hidden="true">EMULSION</span>
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <div class="product-chapter__visual">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/exterior-wall-study-v2.webp') ?>">
          <img class="chapter-env"
               src="<?= asset_url('/assets/editorial/exterior-wall-study-v2.jpg') ?>"
               alt=""
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <img class="chapter-product chapter-product--emulsion"
             src="<?= asset_url($emulsion['officialImage']) ?>"
             alt="<?= e($emulsion['name']) ?>"
             width="355" height="486"
             loading="lazy" decoding="async">
      </div>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Format 02 — Emulsion</span>
        <h3 class="product-chapter__name" id="emulsion-chapter-title">
          <?= e($emulsion['name']) ?>
        </h3>
        <p class="product-chapter__desc">
          <?= e($emulsion['descriptor']) ?>. A paint listed for interior
          and exterior walls. Supplied in <?= e($emulsion['packagingShort']) ?> packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row">
            <dt>Finish</dt><dd><?= e($emulsion['finish']) ?></dd>
          </div>
          <div class="duo-panel__row">
            <dt>Drying time</dt><dd><?= e($emulsion['dryingTime']) ?></dd>
          </div>
          <div class="duo-panel__row">
            <dt>Coverage</dt><dd><?= e($emulsion['coverage']) ?></dd>
          </div>
          <div class="duo-panel__row">
            <dt>V.O.C.</dt><dd><?= e($emulsion['voc']) ?></dd>
          </div>
        </dl>
        <div class="product-chapter__cta">
          <a class="btn btn--secondary" href="<?= e($emulsion['route']) ?>">View Emulsion</a>
          <a class="btn btn--outline" href="/contact/?interest=prakritik-emulsion">Enquire About Emulsion</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     5. MATERIAL JOURNEY — full-width 3-panel composition
     ============================================================ -->
<section class="section section--limewash material-flow" aria-labelledby="journey-title">
  <div class="container">
    <div class="material-flow__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Material to wall</span>
      <h2 class="section-heading__title" id="journey-title">From a natural material to a finished wall.</h2>
      <p class="section-heading__desc">
        Natural material, Prakritik Paint, finished walls.
      </p>
    </div>
    <div class="material-flow__panels" data-reveal>
      <div class="material-flow__panel">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-wall-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/interior-wall-study.jpg') ?>"
               alt="Indian interior limewashed wall"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <span class="material-flow__panel-label">01 · Natural material</span>
      </div>
      <div class="material-flow__panel material-flow__panel--group">
        <img class="editorial-image"
             src="<?= asset_url($groupImage) ?>"
             alt="Prakritik Distemper and Emulsion paint packs"
             width="1280" height="621"
             loading="lazy" decoding="async">
        <span class="material-flow__panel-label">02 · Prakritik Paint</span>
      </div>
      <div class="material-flow__panel">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/finished-wall-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/finished-wall-study.jpg') ?>"
               alt="Indian finished limewashed wall"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <span class="material-flow__panel-label">03 · Finished wall</span>
      </div>
    </div>
    <ol class="material-journey__steps" data-reveal-stagger>
      <?php foreach ($MATERIAL_JOURNEY as $step): ?>
        <li class="material-journey__step">
          <span class="material-journey__num"><?= e($step['num']) ?></span>
          <h3 class="material-journey__title"><?= e($step['title']) ?></h3>
          <p class="material-journey__desc"><?= e($step['desc']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ============================================================
     6. ASHTA LAABH — keep SVG seal + zebu-study bg engraving
     ============================================================ -->
<section class="section ashta-section section--limewash" aria-labelledby="ashta-title" data-ashta-laabh>
  <div class="container ashta-section__inner">
    <div class="ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="ashta-section__deva">अष्ट लाभ</span>
      <h2 class="section-heading__title" id="ashta-title">Eight benefits of Prakritik Paint.</h2>
      <p class="ashta-section__sub">
        Eight benefits listed in the supplied Prakritik Paint material.
      </p>
      <p class="ashta-section__note">
        Benefits listed in the Prakritik Paint material.
      </p>
    </div>
    <div class="ashta-section__grid" data-reveal>
      <div class="ashta-section__seal">
        <?php render_illustration('ashta-laabh-seal'); ?>
      </div>
      <ol class="ashta-section__support" data-reveal-stagger>
        <?php foreach ($ASHTA_LAABH as $i => $benefit): ?>
          <?php $bid = $ashtaIds[$benefit['name']] ?? ('benefit-' . ($i + 1)); ?>
          <li class="ashta-benefit" data-ashta-node="<?= e($bid) ?>">
            <span class="ashta-benefit__num"><?= e(sprintf('%02d', $i + 1)) ?></span>
            <span class="ashta-benefit__name"><?= e($benefit['name']) ?></span>
            <span class="ashta-benefit__deva"><?= e($benefit['hindi']) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================
     7. COLOURS OF INDIA — courtyard-study.jpg as the wall plane
     ============================================================ -->
<section class="section section--paper colour-study colours-section" aria-labelledby="colours-title" data-colour-study>
  <div class="container">
    <div class="colours-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Editorial colour study</span>
      <h2 class="colours-section__title" id="colours-title">Colours of India.</h2>
      <p class="colours-section__sub">
        Click a swatch to recolour the wall plane. These are editorial design moods —
        not currently available product shades.
      </p>
    </div>

    <div class="colours-wall" data-colour-wall data-reveal>
      <picture>
        <source type="image/webp" srcset="<?= asset_url('/assets/editorial/courtyard-study.webp') ?>">
        <img class="colours-wall__art"
             src="<?= asset_url('/assets/editorial/courtyard-study.jpg') ?>"
             alt="Indian limewashed courtyard elevation"
             width="1942" height="809"
             loading="lazy" decoding="async">
      </picture>
      <span class="colours-wall__tint" aria-hidden="true"></span>
      <span class="colours-wall__label">
        <span data-colour-label>Limewash</span>
        <small>Editorial colour study</small>
      </span>
    </div>

    <div class="colours-swatches" data-reveal-stagger role="radiogroup" aria-label="Wall colour swatches">
      <?php foreach ($COLOUR_STUDY as $sw): ?>
        <button type="button"
                class="colours-swatch"
                role="radio"
                aria-checked="false"
                style="background: <?= e($sw['hex']) ?>;"
                data-shade="<?= e($sw['hex']) ?>"
                data-shade-name="<?= e($sw['name']) ?> (<?= e($sw['label']) ?>)"
                aria-label="<?= e($sw['name']) ?> — <?= e($sw['label']) ?>">
          <span class="colours-swatch__label"><?= e($sw['name']) ?></span>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     8. MISSION — deep forest band with rural-landscape engraving
     ============================================================ -->
<section class="mission-band" aria-labelledby="mission-title">
  <div class="mission-band__bg" aria-hidden="true">
    <picture>
      <source type="image/webp" srcset="<?= asset_url('/assets/editorial/rural-landscape.webp') ?>">
      <img class="editorial-image"
           src="<?= asset_url('/assets/editorial/rural-landscape.jpg') ?>"
           alt=""
           width="1344" height="768"
           loading="lazy" decoding="async">
    </picture>
  </div>
  <div class="container">
    <div class="mission-band__inner" data-reveal>
      <span class="mission-band__eyebrow">Our direction</span>
      <h2 class="mission-band__title" id="mission-title">
        <?= e($COMPANY['mission']) ?>
      </h2>
      <p class="mission-band__sub">
        <?= e($COMPANY['legalName']) ?> — <?= e($COMPANY['brandLine']) ?>
      </p>
      <div class="mission-band__cta">
        <a class="btn btn--haldi" href="/about/">About Gaurikrit</a>
        <a class="btn btn--secondary" href="/why-prakritik/">Why Prakritik</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     9. CALCULATOR TEASER (V7: miniature of the real calculator UI)
     ============================================================ -->
<section class="section section--limewash calc-teaser" aria-labelledby="calc-teaser-title">
  <div class="container">
    <div class="calc-teaser__inner" data-reveal>
      <div>
        <span class="calc-teaser__eyebrow">Planning to paint?</span>
        <h2 class="calc-teaser__heading" id="calc-teaser-title">Estimate your project.</h2>
        <p class="calc-teaser__body">
          Walk through four quick choices — what you are painting, where, which
          Prakritik format, and the wall area. We summarise the project for you to
          send to Gaurikrit to discuss your project.
        </p>
        <div class="calc-teaser__cta">
          <a class="btn btn--primary btn--lg" href="/paint-calculator/">Open Painting Calculator</a>
        </div>
      </div>
      <div class="calc-teaser__art" aria-hidden="true">
        <div class="calc-teaser__sheet-head">
          <span class="calc-teaser__sheet-title">Your project</span>
          <span class="calc-teaser__sheet-tag">4 steps</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">01</span>
          <span class="calc-teaser__step-label">Painting type</span>
          <span class="calc-teaser__step-value">Fresh / Repaint</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">02</span>
          <span class="calc-teaser__step-label">Location</span>
          <span class="calc-teaser__step-value">Interior / Exterior</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">03</span>
          <span class="calc-teaser__step-label">Paint</span>
          <span class="calc-teaser__step-value">Distemper / Emulsion</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">04</span>
          <span class="calc-teaser__step-label">Wall area</span>
          <span class="calc-teaser__step-value">sq.ft.</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     10. PROJECT PATHWAYS — rural-landscape shared + 4 ruled columns
     ============================================================ -->
<section class="section section--paper pathways-section" aria-labelledby="pathways-title">
  <div class="container">
    <div class="pathways-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Project pathways</span>
      <h2 class="pathways-section__title" id="pathways-title">Who is Prakritik Paint for?</h2>
    </div>

    <div class="pathways" data-reveal-stagger>
      <?php foreach ($PROJECT_PATHWAYS as $i => $p): ?>
        <div class="pathway">
          <span class="pathway__num"><?= e(sprintf('%02d', $i + 1)) ?></span>
          <h3 class="pathway__title"><?= e($p['title']) ?></h3>
          <p class="pathway__desc"><?= e($p['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pathways-foot">
      <a class="btn btn--secondary" href="/for-business/">Talk to Gaurikrit</a>
    </div>
  </div>
</section>

<!-- Inline bridge: copy the seal SVG node data-benefit → data-ashta-node
     so ashta-laabh.js can drive the seal's active state. -->
<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
<?php require ROOT_PATH . '/includes/footer.php';
