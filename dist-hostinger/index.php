<?php
/**
 * Gaurikrit Bio Products — Homepage (V12 finishing pass).
 *
 * One visual system, end to end:
 *   - Section rhythm locked to the global five families (app.css §4):
 *     limewash hero → paper material → cool distemper → warm emulsion →
 *     paper material-flow → warm-wash benefits → paper colours → forest
 *     mission → limewash calculator → paper pathways → forest footer.
 *   - Ashta Laabh is the shared typographic eight-benefit grid (no radial
 *     seal, no cow diagram) — identical to Products / Why / detail pages.
 *   - Hero group photo on a quiet catalogue plate: hairline border, paper
 *     ground, no accent stripe, no shadow; shown complete.
 *   - Colours of India recolours ONLY the wall plane via an SVG paint mask
 *     aligned to the elevation photo (door + window stay untouched).
 * Factual data unchanged from data.php.
 *
 * Composition:
 *   1. Hero — text 5 / visual 7. Real group photo (1280×621) eager+
 *      high-priority on the catalogue plate.
 *   2. Material Statement — 42/58. raw-material-study (plaster surface).
 *   3. Distemper chapter — catalogue plate + interior-finish strip (cool).
 *   4. Emulsion chapter — catalogue plate + exterior-finish strip (warm,
 *      reversed).
 *   5. Material Journey — 3 equal step cards (raw material / paint /
 *      finished wall) with ruled caption bars.
 *   6. Ashta Laabh — the shared typographic benefits grid.
 *   7. Colours of India — colour-wall-study elevation with the SVG
 *      wall-plane paint mask driven by --wall-color.
 *   8. Mission — forest band, rural-landscape engraving at 0.10 opacity.
 *   9. Calculator Teaser — miniature of the real calculator UI.
 *  10. Pathways — 4 ruled columns.
 */
declare(strict_types=1);

$pageTitle       = 'Gaurikrit — Prakritik Paint & Bio Products';
$pageDescription = 'Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls. Gaurikrit Bio Products, Khurja, District Bulandshahr, Uttar Pradesh.';
$pageCanonical   = '/';
$pageClass       = 'home';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $COLOUR_STUDY, $PROJECT_PATHWAYS;

$distemper   = get_product('prakritik-distemper');
$emulsion    = get_product('prakritik-emulsion');
$groupImage  = '/assets/products/prakritik-group.jpg';
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

  /* ===== 1. HERO — group photo dominant on a quiet catalogue plate ===== */
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
  .hero__title { font-size: clamp(2.5rem, 6vw, 5.5rem); line-height: 1.04; }
  .hero__body { max-width: 38rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V12 hero visual: the real group photo on a QUIET catalogue plate —
     paper ground, ONE hairline border, no 3px accent stripe, no shadow,
     no decorative paint swash. The photo keeps its own light studio
     ground and is shown complete (contain, natural 1280/621 aspect). */
  .hero__visual { position: relative; min-height: 0; width: 100%; }
  .hero__plate {
    position: relative; z-index: 2;
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    padding: clamp(0.75rem, 2vw, 1.5rem);
  }
  .hero__plate img.hero-group-photo {
    display: block;
    width: 100%; height: auto;
    object-fit: contain;
    aspect-ratio: 1280 / 621;
  }

  /* ===== 2. MATERIAL STATEMENT — raw-material-study large right (58%) ===== */
  .material-statement__visual {
    aspect-ratio: 1344/768;
    background: var(--limewash);
    overflow: hidden;
    padding: 0;
    position: relative;
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
  }
  .material-statement__visual .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }

  /* ===== 3/4. PRODUCT CHAPTERS — catalogue plate (shared app.css §14:
     white product stage + wall-finish strip; nothing page-local to add). ===== */

  /* ===== 5. MATERIAL JOURNEY — 3 equal step cards (structure in app.css
     §17 .material-step); page-local rhythm only. ===== */
  .material-flow { padding-block: clamp(3rem, 6vw, 5rem); }
  .material-flow__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 6. ASHTA LAABH — the shared typographic benefits grid
     (structure in app.css §18): numbered ruled entries, haldi numbering,
     forest names, Hindi secondary. Section ground = soft warm wash.
     No seal, no radial diagram, no page-local overrides needed. ===== */

  /* ===== 7. COLOURS OF INDIA — wall plane + SVG paint mask (structure in
     app.css §19: natural-aspect elevation photo + aligned mask path);
     page-local: label typography + swatch row only. ===== */
  .colours-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .colours-wall__label {
    font-family: var(--font-display); font-size: 1.125rem; font-weight: 700;
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
    flex: 0 0 auto;  /* V12: never let the swatch row flex-shrink the circles */
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
  /* V14: quiet share row under the swatches — only the copy button,
     revealed after a colour is chosen (no layout shift: reserved height). */
  .colours-share {
    min-height: 2rem;
    margin: 3.5rem 0 0;
    display: flex;
    align-items: center;
  }
  .colours-share .copy-btn { margin-left: 0; }

  /* ===== 8. MISSION — forest band with rural-landscape engraving ===== */
  .mission-band {
    position: relative; padding-block: clamp(4rem, 8vw, 6.5rem);
    background: var(--forest-deep); color: var(--primary-fg);
    overflow: hidden;
  }
  .mission-band__bg {
    position: absolute; inset: 0; opacity: 0.10; pointer-events: none;
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
    /* V9 fix: reset the legacy app.css .calc-teaser__art (flex + 4/3 aspect
       meant for the old single-artwork composition). The V7 mini-calculator
       sheet is a header + four stacked rows — block flow, content height. */
    display: block;
    aspect-ratio: auto;
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
     2. MATERIAL STATEMENT — copy 42 / raw-material-study 58
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
      <div class="material-statement__visual">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/raw-material-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
               alt="Raw lime-plastered wall surface — an Indian natural wall material"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. DISTEMPER PRODUCT CHAPTER (cool section, indigo accent)
     Catalogue plate: complete pack photo + interior-finish strip.
     ============================================================ -->
<section class="product-chapter product-chapter--distemper" aria-labelledby="distemper-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <picture>
            <source type="image/webp" srcset="<?= asset_url($distemper['officialImageWebp']) ?>">
            <img class="chapter-product chapter-product--distemper"
                 src="<?= asset_url($distemper['officialImage']) ?>"
                 alt="<?= e($distemper['name']) ?> paint pack"
                 width="<?= $distemper['officialImageW'] ?>" height="<?= $distemper['officialImageH'] ?>"
                 loading="lazy" decoding="async">
          </picture>
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-finish-study.webp') ?>">
            <img class="chapter-strip"
                 src="<?= asset_url('/assets/editorial/interior-finish-study.jpg') ?>"
                 alt=""
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </div>
      </figure>
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
     4. EMULSION PRODUCT CHAPTER (warm section, leaf accent, reversed)
     Catalogue plate: complete pack photo + exterior-finish strip.
     ============================================================ -->
<section class="product-chapter product-chapter--emulsion" aria-labelledby="emulsion-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <picture>
            <source type="image/webp" srcset="<?= asset_url($emulsion['officialImageWebp']) ?>">
            <img class="chapter-product chapter-product--emulsion"
                 src="<?= asset_url($emulsion['officialImage']) ?>"
                 alt="<?= e($emulsion['name']) ?> paint pack"
                 width="<?= $emulsion['officialImageW'] ?>" height="<?= $emulsion['officialImageH'] ?>"
                 loading="lazy" decoding="async">
          </picture>
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/exterior-finish-study.webp') ?>">
            <img class="chapter-strip"
                 src="<?= asset_url('/assets/editorial/exterior-finish-study.jpg') ?>"
                 alt=""
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </div>
      </figure>
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
     5. MATERIAL JOURNEY — three equal step cards
     ============================================================ -->
<section class="section section--paper material-flow" aria-labelledby="journey-title">
  <div class="container">
    <div class="material-flow__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Material to wall</span>
      <h2 class="section-heading__title" id="journey-title">From a natural material to a finished wall.</h2>
      <p class="section-heading__desc">
        The raw material, the paint made from it, and the finished surface —
        three steps, one material idea.
      </p>
    </div>
    <div class="material-steps" data-reveal>
      <article class="material-step">
        <figure class="material-step__figure">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/raw-material-study.webp') ?>">
            <img class="editorial-image"
                 src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
                 alt="Raw lime-plastered wall surface — natural material"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">01</span>
          <h3 class="material-step__title">Natural material</h3>
          <p class="material-step__desc">Cow dung is the material inspiration.</p>
        </div>
      </article>
      <article class="material-step material-step--product">
        <figure class="material-step__figure">
          <picture>
            <source type="image/webp" srcset="<?= asset_url($distemper['officialImageWebp']) ?>">
            <img class="material-step__product"
                 src="<?= asset_url($distemper['officialImage']) ?>"
                 alt="Prakritik Distemper paint pack"
                 width="<?= $distemper['officialImageW'] ?>" height="<?= $distemper['officialImageH'] ?>"
                 loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">02</span>
          <h3 class="material-step__title">Prakritik Paint</h3>
          <p class="material-step__desc">Available as Distemper and Emulsion.</p>
        </div>
      </article>
      <article class="material-step">
        <figure class="material-step__figure">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/finished-surface-study.webp') ?>">
            <img class="editorial-image"
                 src="<?= asset_url('/assets/editorial/finished-surface-study.jpg') ?>"
                 alt="Finished matte limewash wall surface"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">03</span>
          <h3 class="material-step__title">Finished wall</h3>
          <p class="material-step__desc">Both are listed for interior and exterior use.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     6. ASHTA LAABH — the shared typographic eight-benefit grid
     ============================================================ -->
<section class="section section--haldi-wash ashta-section" aria-labelledby="ashta-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="ashta-title">Eight benefits of Prakritik Paint.</h2>
      <p class="section-heading__desc">Benefits listed in the supplied Prakritik Paint material.</p>
    </div>
    <ol class="benefits-grid" data-reveal-stagger>
      <?php foreach ($ASHTA_LAABH as $i => $benefit): ?>
        <li class="benefits-grid__item">
          <span class="benefits-grid__num" aria-hidden="true"><?= e(sprintf('%02d', $i + 1)) ?></span>
          <span class="benefits-grid__name"><?= e($benefit['name']) ?></span>
          <span class="benefits-grid__deva"><?= e($benefit['hindi']) ?></span>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ============================================================
     7. COLOURS OF INDIA — wall-plane colour preview (SVG paint mask)
     The mask path traces ONLY the wall plane of the elevation photo
     (1344x768 pixel space); the door and window are cut out with
     fill-rule evenodd so they never recolour. preserveAspectRatio
     "xMidYMid slice" keeps the mask aligned with object-fit: cover.
     ============================================================ -->
<section class="section section--paper colour-study colours-section" aria-labelledby="colours-title" data-colour-study>
  <div class="container">
    <div class="colours-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Editorial colour study</span>
      <h2 class="colours-section__title" id="colours-title">Colours of India.</h2>
      <p class="colours-section__sub">
        Tap a swatch to preview the colour on the wall — only the wall plane
        changes; the door, window and surroundings stay as they are. These are
        editorial design moods — not currently available product shades.
      </p>
    </div>

    <div class="colours-wall" data-colour-wall data-reveal>
      <picture>
        <source type="image/webp" srcset="<?= asset_url('/assets/editorial/colour-wall-study.webp') ?>">
        <img class="colours-wall__art"
             src="<?= asset_url('/assets/editorial/colour-wall-study.jpg') ?>"
             alt="Indian lime-plastered wall elevation with door and window"
             width="1344" height="768"
             loading="lazy" decoding="async">
      </picture>
      <svg class="colours-wall__tint" viewBox="0 0 1344 768"
           preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
        <path class="colours-wall__paint" fill-rule="evenodd"
              d="M0,104 H1344 V724 H0 Z
                 M80,370 H304 V768 H80 Z
                 M894,346 H1180 V654 H894 Z" />
      </svg>
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
                data-colour-id="<?= e(strtolower($sw['name'])) ?>"
                aria-label="<?= e($sw['name']) ?> — <?= e($sw['label']) ?>">
          <span class="colours-swatch__label"><?= e($sw['name']) ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- V14: quiet share affordance — revealed by colour-study.js once a
         colour is selected; copies the current URL incl. #colour=<id>. -->
    <p class="colours-share">
      <button type="button" class="copy-btn" data-colour-copy data-copy="" hidden
              aria-label="Copy a link to this wall colour">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        <span class="copy-btn__label">Copy link to this colour</span>
      </button>
    </p>
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

<?php require ROOT_PATH . '/includes/footer.php';
