<?php
/**
 * Gaurikrit Bio Products — Homepage (V3 rebuild).
 * Task V3-PAGES.
 *
 * Composition:
 *   1. Hero (12-col: text 5 / visual 7) — dominant product image, haldi
 *      paint-stroke field behind, cow line art at 0.16 opacity.
 *   2. Material Statement (5/7) — cow beside limewashed wall plane.
 *   3. Distemper Product Chapter — full-width split (cool env).
 *   4. Emulsion Product Chapter — full-width split (warm env, reversed).
 *   5. Material Journey — full-width material-to-wall diagram.
 *   6. Ashta Laabh — 60/40 split (seal + numbered list).
 *   7. Colours of India — large courtyard elevation, recolourable.
 *   8. Mission — deep forest band with rural-landscape engraving.
 *   9. Calculator Teaser — split with mini project-summary + wall art.
 *  10. Project Pathways — shared illustration + 4 ruled columns.
 *  11. Brand Close (footer.php renders the footer).
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
  /* ===== 1. HERO (V3: 12-col, text 5 / visual 7) ===== */
  .hero { padding-top: calc(var(--header-h) + 1.5rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) {
    .hero { min-height: 92svh; min-height: 92vh; display: flex; align-items: center;
            padding-top: calc(var(--header-h) + 2rem); padding-bottom: 2rem; }
  }
  /* Override default 5fr/7fr so the visual is truly dominant on desktop. */
  .hero__grid { align-items: center; }
  @media (min-width: 1024px) {
    .hero__grid { grid-template-columns: 5fr 7fr; gap: clamp(2rem, 4vw, 4rem); }
  }
  @media (max-width: 1023px) {
    /* Mobile: text → buttons → large visual below. */
    .hero__grid { grid-template-columns: 1fr; }
    .hero__visual { order: 3; min-height: 26rem; }
  }
  .hero__eyebrow-chip { margin-bottom: 0.875rem; }
  .hero__title { font-size: clamp(2.5rem, 6vw, 5.5rem); line-height: 1.02; }
  .hero__body { max-width: 38rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V3 hero visual stack: paint-stroke field → product image → cow line art. */
  .hero__visual { position: relative; min-height: 24rem; width: 100%; }
  @media (min-width: 768px)  { .hero__visual { min-height: 28rem; } }
  @media (min-width: 1024px) { .hero__visual { min-height: 34rem; } }
  /* Large irregular haldi paint-stroke field behind the product. */
  .hero__haldi-field {
    position: absolute; inset: -1rem -1rem 1.5rem; z-index: 0;
    display: flex; align-items: center; justify-content: center;
    pointer-events: none;
  }
  .hero__haldi-field::before { display: none; }   /* prefer the SVG paint-stroke */
  .hero__haldi-field .hero__stroke-svg {
    width: 92%; height: 80%; opacity: 0.95;
    filter: saturate(1.04);
  }
  /* Product image — visually dominant (70-80% of the region), on top of the haldi field. */
  .hero__bucket {
    position: absolute; left: 50%; top: 48%;
    width: 76%; height: 70%;
    transform: translate(-50%, -50%);
    z-index: 2;
  }
  .hero__bucket .product-media { width: 100%; height: 100%; }
  .hero__bucket .product-media__official { object-fit: contain; }
  /* Cow line art at low opacity — secondary line, not the hero. */
  .hero__cow {
    position: absolute; right: -1rem; bottom: 0.5rem;
    width: 48%; height: 36%;
    z-index: 3; opacity: 0.16; pointer-events: none;
  }

  /* ===== 2. MATERIAL STATEMENT (5/7 — cow beside limewashed wall) ===== */
  .material-statement__visual { aspect-ratio: 5/4; background: var(--limewash); }
  .material-statement__visual .ms-wall {
    right: 8%; top: 8%; bottom: 8%; width: 46%;
    background: linear-gradient(135deg, var(--limewash), color-mix(in srgb, var(--kraft) 35%, var(--limewash)));
    overflow: hidden;
  }
  .material-statement__visual .ms-wall::after {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(circle at 1px 1px, rgba(32, 30, 25, 0.08) 0.5px, transparent 0);
    background-size: 14px 14px;
  }
  .material-statement__visual .ms-cow { left: 6%; bottom: 8%; width: 42%; opacity: 0.85; }

  /* ===== 5. MATERIAL JOURNEY (full-width diagram, no card) ===== */
  .material-flow { padding-block: clamp(3rem, 6vw, 5rem); }
  .material-flow__svg-wrap { width: 100%; margin-inline: 0; }
  .material-flow__svg-wrap svg { width: 100%; height: auto; display: block; }
  .material-flow__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 6. ASHTA LAABH (60/40 split — seal + numbered list) ===== */
  .ashta-section__seal { max-width: 38rem; margin-inline: auto; }
  .ashta-benefit__num { font-feature-settings: "tnum"; }

  /* ===== 7. COLOURS OF INDIA (large courtyard, recolourable) ===== */
  .colours-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .colours-wall {
    aspect-ratio: 16/9; background: var(--limewash);
    border: 0; border-radius: 0; overflow: hidden;
    position: relative;
  }
  @media (min-width: 1024px) { .colours-wall { aspect-ratio: 21/9; } }
  .colours-wall__svg { width: 100%; height: 100%; display: block; }
  .colours-wall__label {
    position: absolute; bottom: 1rem; left: 1rem;
    font-family: var(--font-display); font-size: 1.125rem; font-weight: 700;
    color: var(--charcoal);
    background: rgba(250, 248, 241, 0.85);
    padding: 0.5rem 1rem; border-radius: var(--r-pill);
    -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px);
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
  .colours-swatch:hover { transform: scale(1.08); }
  .colours-swatch[data-active="true"] {
    border-color: var(--forest); transform: scale(1.12);
  }
  .colours-swatch__label {
    position: absolute; top: calc(100% + 0.5rem); left: 50%;
    transform: translateX(-50%); white-space: nowrap;
    font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }

  /* ===== 8. MISSION (deep forest band with rural-landscape engraving) ===== */
  .mission-band {
    position: relative; padding-block: clamp(4rem, 8vw, 6.5rem);
    background: var(--forest-deep); color: var(--primary-fg);
    overflow: hidden;
  }
  .mission-band__bg {
    position: absolute; inset: 0; opacity: 0.15; pointer-events: none;
    display: flex; align-items: flex-end; justify-content: center;
  }
  .mission-band__bg svg { width: 100%; height: auto; max-height: 100%; }
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

  /* ===== 9. CALCULATOR TEASER ===== */
  .calc-teaser { padding-block: clamp(3.5rem, 6vw, 5.5rem); }
  .calc-teaser__preview { padding: 1.75rem; }
  .calc-teaser__art { aspect-ratio: 4/3; }
  .calc-teaser__art::before { inset: 14% 14% 14% 14%; }

  /* ===== 10. PROJECT PATHWAYS ===== */
  .pathways-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .pathways-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .pathways-illustration {
    margin-bottom: 3rem; width: 100%; height: auto;
    opacity: 0.55;
  }
  .pathways-illustration svg { width: 100%; height: auto; display: block; }
</style>

<!-- ============================================================
     1. HERO — 12-col (text 5 / visual 7), dominant product image
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
        <!-- Haldi paint-stroke field behind the product -->
        <div class="hero__haldi-field" aria-hidden="true">
          <?php render_illustration('paint-brush-stroke', ['class' => 'hero__stroke-svg']); ?>
        </div>
        <!-- Product group image (image-handoff with emulsion-bucket fallback) -->
        <div class="hero__bucket">
          <div class="product-media" data-official-image="<?= e($groupImage) ?>">
            <img class="product-media__official"
                 src="<?= e($groupImage) ?>"
                 alt="Prakritik Distemper and Emulsion paint packs"
                 width="800" height="600" loading="eager" decoding="async">
            <div class="product-media__fallback">
              <?php render_illustration('prakritik-emulsion-bucket'); ?>
            </div>
          </div>
        </div>
        <!-- Cow line art at 0.16 opacity — secondary line, not the hero -->

      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. MATERIAL STATEMENT — copy 5 / visual 7 (cow beside wall)
     ============================================================ -->
<section class="section section--paper" aria-labelledby="material-title">
  <div class="container">
    <div class="material-statement" data-reveal>
      <div class="material-statement__copy">
        <span class="material-statement__eyebrow">An old Indian material idea</span>
        <h2 class="material-statement__headline" id="material-title">
          An old Indian material idea, reconsidered for modern walls.
        </h2>
        <hr class="material-statement__rule">
        <div class="material-statement__body">
          <p>
            Cow dung has been used on Indian walls and floors for generations — as a
            surface treatment, a renewal ritual, and a quiet form of care. Prakritik
            Paint carries that material into a contemporary format: two paints, made
            for brushing on interior and exterior walls.
          </p>
          <p>
            Two paint formats for interior and exterior walls.
          </p>
        </div>
      </div>
      <div class="material-statement__visual" aria-hidden="true">
        <img class="editorial-cow" src="/assets/illustrations/zebu-study.jpg" alt="" loading="lazy" width="1536" height="1024">
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
        <div class="product-media" data-official-image="<?= e($distemper['officialImage']) ?>">
          <img class="product-media__official"
               src="<?= e($distemper['officialImage']) ?>"
               alt="<?= e($distemper['name']) ?> pack"
               width="800" height="600" loading="lazy" decoding="async">
          <div class="product-media__fallback">
            <?php render_illustration('prakritik-distemper-bucket'); ?>
          </div>
        </div>
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
     ============================================================ -->
<section class="product-chapter product-chapter--emulsion" aria-labelledby="emulsion-chapter-title">
  <span class="product-chapter__ghost" aria-hidden="true">EMULSION</span>
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <div class="product-chapter__visual">
        <div class="product-media" data-official-image="<?= e($emulsion['officialImage']) ?>">
          <img class="product-media__official"
               src="<?= e($emulsion['officialImage']) ?>"
               alt="<?= e($emulsion['name']) ?> pack"
               width="800" height="600" loading="lazy" decoding="async">
          <div class="product-media__fallback">
            <?php render_illustration('prakritik-emulsion-bucket'); ?>
          </div>
        </div>
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
     5. MATERIAL JOURNEY — full-width 3-stage diagram, no card
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
    <div class="material-flow__svg-wrap" data-reveal>

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
     6. ASHTA LAABH — 60/40 split (seal + numbered list)
     ============================================================ -->
<section class="section ashta-section" aria-labelledby="ashta-title" data-ashta-laabh>
  <div class="container">
    <div class="ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="ashta-section__deva">अष्ट लाभ</span>
      <h2 class="section-heading__title" id="ashta-title">Eight benefits of Prakritik Paint.</h2>
      <p class="ashta-section__sub">
        The eight benefits Gaurikrit associates with Prakritik Paint.
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
     7. COLOURS OF INDIA — large courtyard, recolourable wall plane
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
      <img class="courtyard-study" src="/assets/illustrations/courtyard-study.jpg" alt="" loading="lazy" width="1942" height="809"><span class="courtyard-tint" aria-hidden="true"></span>
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
    <?php render_illustration('rural-landscape'); ?>
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
     9. CALCULATOR TEASER — mini project-summary + small wall art
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
          <a class="btn btn--primary btn--lg" href="/paint-calculator/">Estimate Your Project</a>
        </div>
      </div>
      <div class="calc-teaser__art" aria-hidden="true">
        <div class="calc-teaser__preview">
          <div class="calc-teaser__preview-row">
            <span class="calc-teaser__preview-label">Painting</span>
            <span class="calc-teaser__preview-value">Fresh / Repaint</span>
          </div>
          <div class="calc-teaser__preview-row">
            <span class="calc-teaser__preview-label">Location</span>
            <span class="calc-teaser__preview-value">Interior / Exterior</span>
          </div>
          <div class="calc-teaser__preview-row">
            <span class="calc-teaser__preview-label">Paint</span>
            <span class="calc-teaser__preview-value">Distemper / Emulsion</span>
          </div>
          <div class="calc-teaser__preview-row">
            <span class="calc-teaser__preview-label">Area</span>
            <span class="calc-teaser__preview-value">sq.ft.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     10. PROJECT PATHWAYS — shared illustration + 4 ruled columns
     ============================================================ -->
<section class="section section--paper pathways-section" aria-labelledby="pathways-title">
  <div class="container">
    <div class="pathways-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Project pathways</span>
      <h2 class="pathways-section__title" id="pathways-title">Who is Prakritik Paint for?</h2>
    </div>

    <div class="pathways-illustration" aria-hidden="true" data-reveal>
      <?php render_illustration('rural-landscape'); ?>
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

    // Custom colour-study bridge: when a swatch is clicked, also set the
    // courtyard SVG <rect id="courtyard-wall-plane"> fill attribute
    // directly (colour-study.js sets background-color on [data-colour-wall]
    // which doesn't recolour an SVG <rect>). Click handlers attach before
    // colour-study.js init() runs — both run, ours drives the SVG.
    var courtyard = document.querySelector('[data-colour-study] [data-colour-wall]');
    var rect = document.getElementById('courtyard-wall-plane');
    if (courtyard && rect) {
      var swatches = document.querySelectorAll('[data-colour-study] [data-shade]');
      swatches.forEach(function (s) {
        s.addEventListener('click', function () {
          var colour = s.getAttribute('data-shade');
          if (colour) rect.setAttribute('fill', colour);
        });
      });
      // Default to the first swatch so the wall starts recoloured.
      if (swatches.length) {
        var first = swatches[0];
        var colour = first.getAttribute('data-shade');
        var name = first.getAttribute('data-shade-name');
        if (colour) rect.setAttribute('fill', colour);
        var label = document.querySelector('[data-colour-label]');
        if (label && name) label.textContent = name;
        first.setAttribute('data-active', 'true');
        first.setAttribute('aria-checked', 'true');
      }
    }
  })();
</script>
<?php require ROOT_PATH . '/includes/footer.php';
