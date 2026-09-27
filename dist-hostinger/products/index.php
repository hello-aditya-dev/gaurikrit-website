<?php
/**
 * Gaurikrit Bio Products — Products Overview (V16 ecosystem restructure).
 *
 * THE GAURIKRIT PRODUCT ECOSYSTEM — one natural resource, multiple useful
 * applications (§30–35):
 *   1. Hero — "One natural resource. Multiple useful applications." The
 *      official pair photo stays (the documented products).
 *   2. Eco-Paints family section (#eco-paints) — the DEEPEST section
 *      because verified content exists: intro + pair photo + the four
 *      contextual links (Distemper / Emulsion / Calculator / Why).
 *   3. Distemper chapter (cool format wash — catalogue plate).
 *   4. Emulsion chapter (warm format wash — catalogue plate, reversed).
 *   5. Spec matrix + coverage note (factual data only).
 *   6. Ashta Laabh benefits — paint-specific, INSIDE Eco-Paints context.
 *   7. GoCast Logs (#gocast-logs) — editorial family section, type/material
 *      led, NO invented specifications (§32).
 *   8. Bio-Coal Logs (#bio-coal-logs) — same truthful treatment (§33).
 *   9. Utility Products (#utility-products) — same (§34).
 *  10. Application map — "Where the Ecosystem Works." (§35).
 *  11. FAQ + final CTA (retained factual content).
 *
 * No fake category detail pages — the three undocumented families are
 * presented HERE properly, with enquiry links, never Lorem ipsum.
 */
declare(strict_types=1);

$pageTitle       = 'Products — Eco-Paints, Biomass & Sustainable Material Solutions | Gaurikrit';
$pageDescription = 'The Gaurikrit product ecosystem: Eco-Paints (Prakritik Distemper and Emulsion, fully documented) plus GoCast Logs, Bio-Coal Logs and Utility Product development directions — one natural resource, multiple applications.';
$pageCanonical   = '/products/';
$pageClass       = 'products';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $FAQ, $COVERAGE_DISCLAIMER, $FAMILIES, $APPLICATION_GROUPS;

$distemper   = get_product('prakritik-distemper');
$emulsion    = get_product('prakritik-emulsion');
$pairImage   = '/assets/products/prakritik-pair.jpg';
$pairImageWebp = '/assets/products/prakritik-pair.webp';
// V11: the products hero carries the client's official two-bucket comparison
// image (Distemper left, Emulsion right) — the documented Eco-Paints family.
?>
<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== 1. ECOSYSTEM HERO (45 / 55) — the official pair photo on a quiet
     catalogue plate: hairline border, paper ground, natural 1420/618
     aspect. No min-height dead zones, no accent stripe, no shadow. ===== */
  .products-hero {
    padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 1.5rem;
  }
  .products-hero__grid {
    display: grid; gap: 2.5rem; align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) {
    .products-hero__grid { grid-template-columns: 45fr 55fr; gap: clamp(2rem, 4vw, 4rem); }
  }
  .products-hero__lockup { max-width: 42rem; }
  .products-hero__visual {
    position: relative; width: 100%;
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    padding: clamp(0.75rem, 2vw, 1.5rem);
    overflow: hidden;
  }
  .products-hero__visual .hero-group-photo {
    display: block;
    width: 100%; height: auto;
    aspect-ratio: 1420 / 618;
    object-fit: contain;
  }

  /* ===== 2. ECO-PAINTS FAMILY SECTION — documented family: intro copy,
     the pair photo as the family's real product photography, and the
     four contextual links (§31). ===== */
  .eco-family { padding-block: clamp(3rem, 6vw, 5rem); }
  .eco-family__grid {
    display: grid; gap: 2.5rem; align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) {
    .eco-family__grid { grid-template-columns: 5fr 7fr; gap: clamp(2rem, 4vw, 4rem); }
  }
  .eco-family__plate {
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    padding: clamp(0.75rem, 1.5vw, 1.25rem);
  }
  .eco-family__plate img {
    display: block; width: 100%; height: auto;
    object-fit: contain; aspect-ratio: 1420 / 618;
  }
  .eco-family__head { display: flex; align-items: baseline; gap: 0.875rem; }
  .eco-family__num {
    font-family: var(--font-display); font-size: clamp(2rem, 3vw, 2.75rem);
    font-weight: 700; color: var(--haldi-deep); line-height: 1;
    font-variant-numeric: tabular-nums;
  }
  .eco-family__name {
    font-family: var(--font-display); font-size: clamp(1.875rem, 3.5vw, 3rem);
    font-weight: 700; letter-spacing: -0.02em; line-height: 1.05;
  }
  .eco-family__line {
    font-family: var(--font-display); font-style: italic;
    font-size: 1.125rem; color: var(--primary); margin-top: 0.75rem;
  }
  .eco-family__sub { margin-top: 1rem; max-width: 40rem; line-height: 1.65; }
  .eco-family__links {
    margin-top: 1.75rem; display: flex; flex-wrap: wrap; gap: 0.75rem;
  }

  /* ===== 7/8/9. UNDOCUMENTED FAMILY SECTIONS (§32–34) — editorial split:
     copy left, quiet material plate right. Honest, never fabricated. ===== */
  .family-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .family-section__grid {
    display: grid; gap: 2.5rem; align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) {
    .family-section__grid { grid-template-columns: 7fr 5fr; gap: clamp(2.5rem, 5vw, 4.5rem); }
    .family-section--reverse .family-section__grid { grid-template-columns: 5fr 7fr; }
    .family-section--reverse .family-section__copy { order: 2; }
  }
  .family-section__num {
    font-family: var(--font-display); font-size: clamp(2rem, 3vw, 2.75rem);
    font-weight: 700; color: var(--haldi-deep); line-height: 1;
    font-variant-numeric: tabular-nums;
  }
  .family-section__name {
    font-family: var(--font-display); font-size: clamp(1.75rem, 3.5vw, 2.75rem);
    font-weight: 700; letter-spacing: -0.02em; line-height: 1.05; margin-top: 0.5rem;
  }
  .family-section__line {
    font-family: var(--font-display); font-style: italic;
    font-size: 1.125rem; color: var(--primary); margin-top: 0.625rem;
  }
  .family-section__desc { margin-top: 1rem; max-width: 40rem; line-height: 1.7; }
  .family-section__themes {
    list-style: none; margin-top: 1.25rem;
    display: flex; flex-direction: column; gap: 0.5rem;
    border-top: 1px solid var(--border); padding-top: 1.125rem;
  }
  .family-section__themes li {
    font-size: 0.875rem; color: var(--fg-muted);
    padding-left: 1.125rem; position: relative; line-height: 1.5;
  }
  .family-section__themes li::before {
    content: ""; position: absolute; left: 0; top: 0.5em;
    width: 0.4375rem; height: 1px; background: var(--primary);
  }
  .family-section__note {
    margin-top: 1.5rem; font-size: 0.8125rem; color: var(--fg-muted);
    line-height: 1.55; border-left: 2px solid var(--haldi);
    padding-left: 1rem; max-width: 40rem;
  }
  .family-section__plate {
    position: relative; aspect-ratio: 4 / 5; max-height: 28rem;
    border: 1px solid var(--border); border-radius: var(--r-panel);
    overflow: hidden; background: var(--paper);
  }
  .family-section__plate-texture {
    position: absolute; inset: 0; opacity: 0.15;
  }
  .family-section__plate-texture img { width: 100%; height: 100%; object-fit: cover; }
  .family-section__plate-word {
    position: absolute; inset: 0; display: flex; align-items: center;
    justify-content: center; text-align: center; padding: 2rem;
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(1.5rem, 2.5vw, 2.25rem); color: var(--primary);
    line-height: 1.15;
  }
  .family-section__plate-tag {
    position: absolute; left: 1rem; bottom: 0.875rem;
    font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .family-section__cta { margin-top: 1.75rem; }

  /* ===== SPEC MATRIX (V5: header row + zebra striping + taller rows) ===== */
  .spec-matrix-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-matrix-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .spec-matrix {
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    overflow: hidden;
    background: var(--paper);
  }
  .spec-matrix__row {
    grid-template-columns: 1fr; gap: 0.75rem;
    padding: 1.75rem 1.25rem;
    border-bottom: 1px solid var(--border);
  }
  @media (min-width: 768px) {
    .spec-matrix__row {
      grid-template-columns: 12rem 1fr 1fr; gap: 1.5rem; padding: 1.75rem 1.5rem;
    }
  }
  .spec-matrix__row:nth-child(even) {
    background: color-mix(in srgb, var(--haldi) 3%, transparent);
  }
  .spec-matrix__row:first-child {
    border-bottom: 2px solid var(--forest);
    background: color-mix(in srgb, var(--limewash) 80%, var(--paper));
  }
  .spec-matrix__row:last-child { border-bottom: 0; }
  .spec-matrix__col-head {
    font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--forest);
  }
  .spec-matrix__col-head--distemper { color: var(--indigo); }
  .spec-matrix__col-head--emulsion { color: var(--leaf); }
  .spec-matrix__label {
    font-weight: 700 !important;
    font-size: 0.875rem !important;
    color: var(--fg) !important;
    letter-spacing: 0.02em;
  }
  .spec-matrix__value {
    font-weight: 600 !important;
    color: var(--fg) !important;
  }
  .spec-matrix-mobile { display: none; }
  @media (max-width: 639px) {
    .spec-matrix { display: none; }
    .spec-matrix-mobile { display: grid; gap: 1.5rem; }
  }
  .spec-matrix-mobile__block {
    border: 1px solid var(--border);
    border-top: 3px solid var(--forest);
    border-radius: var(--r-panel);
    background: var(--paper);
    overflow: hidden;
  }
  .spec-matrix-mobile__block--emulsion { border-top-color: var(--leaf); }
  .spec-matrix-mobile__name {
    padding: 1rem 1.25rem;
    font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--forest);
    background: color-mix(in srgb, var(--limewash) 80%, var(--paper));
    border-bottom: 1px solid var(--border);
  }
  .spec-matrix-mobile__block--emulsion .spec-matrix-mobile__name { color: var(--leaf); }
  .spec-matrix-mobile__row {
    display: flex; justify-content: space-between; align-items: baseline; gap: 1rem;
    padding: 0.75rem 1.25rem;
    border-bottom: 1px solid var(--border);
  }
  .spec-matrix-mobile__row:last-child { border-bottom: 0; }
  .spec-matrix-mobile__row .k {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .spec-matrix-mobile__row .v { font-weight: 600; color: var(--fg); text-align: right; }

  /* ===== BENEFITS — the shared typographic grid (app.css §18) ===== */
  .benefits-strip { padding-block: clamp(3rem, 6vw, 5rem); }
  .benefits-strip__head { max-width: 48rem; margin-bottom: 2rem; }

  /* ===== APPLICATION MAP (§35) ===== */
  .appmap-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .appmap-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== FAQ ===== */
  .faq-section {
    padding-block: clamp(4.5rem, 8vw, 6.5rem);
    position: relative;
  }
  .faq-section .container::before {
    content: ''; display: block;
    width: 4rem; height: 2px;
    background: var(--haldi);
    margin: 0 0 3rem;
  }
  .faq-section__head { max-width: 48rem; margin-bottom: 2rem; }
  .faq-section .faq-list { max-width: 64rem; }
</style>

<!-- ============================================================
     1. HERO — THE GAURIKRIT PRODUCT ECOSYSTEM (§30)
     ============================================================ -->
<section class="products-hero bg-limewash" aria-labelledby="products-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Products</span>
    </nav>
    <div class="products-hero__grid">
      <div class="products-hero__lockup" data-reveal>
        <span class="eyebrow"><span class="products-hero__eyebrow-dot" aria-hidden="true"></span>The Gaurikrit Product Ecosystem</span>
        <hr class="products-hero__rule">
        <h1 class="products-hero__title" id="products-hero-title">One natural resource. Multiple useful applications.</h1>
        <p class="products-hero__sub">
          Cow dung is the shared material beginning. Gaurikrit develops it in
          four directions — Eco-Paints is the documented family; GoCast Logs,
          Bio-Coal Logs and Utility Products are development directions.
        </p>
      </div>
      <div class="products-hero__visual" data-reveal>
        <picture>
          <source type="image/webp" srcset="<?= asset_url($pairImageWebp) ?>">
          <img class="hero-group-photo"
               src="<?= asset_url($pairImage) ?>"
               alt="Prakritik Distemper and Emulsion paint packs — the documented Eco-Paints family"
               width="1420" height="618"
               loading="eager" fetchpriority="high" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. ECO-PAINTS — the documented family (§31)
     Deepest section: real product photography + contextual links.
     ============================================================ -->
<section class="section section--paper eco-family" id="eco-paints" aria-labelledby="eco-family-title">
  <div class="container">
    <div class="eco-family__grid" data-reveal>
      <div class="eco-family__copy">
        <div class="eco-family__head">
          <span class="eco-family__num" aria-hidden="true">01</span>
          <h2 class="eco-family__name" id="eco-family-title">Eco-Paints</h2>
        </div>
        <p class="eco-family__line">Healthy walls inspired by nature.</p>
        <p class="eco-family__sub">
          Cow dung-based wall coatings in Distemper and Emulsion formats — the
          most developed family in the Gaurikrit ecosystem, documented with
          full product specifications.
        </p>
        <div class="eco-family__links">
          <a class="btn btn--primary" href="<?= e($distemper['route']) ?>">View Distemper</a>
          <a class="btn btn--secondary" href="<?= e($emulsion['route']) ?>">View Emulsion</a>
          <a class="btn btn--outline" href="/paint-calculator/">Painting Calculator</a>
          <a class="btn btn--outline" href="/why-prakritik/">Why Prakritik?</a>
        </div>
      </div>
      <div class="eco-family__plate" data-reveal>
        <picture>
          <source type="image/webp" srcset="<?= asset_url($pairImageWebp) ?>">
          <img src="<?= asset_url($pairImage) ?>"
               alt="Prakritik Distemper and Emulsion paint packs — real Eco-Paints product photography"
               width="1420" height="618"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. DISTEMPER PRODUCT CHAPTER — catalogue plate
     (complete pack photo + interior-finish strip; structure in app.css §14)
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
        <span class="product-chapter__eyebrow">Eco-Paints — Distemper</span>
        <h2 class="product-chapter__name" id="distemper-chapter-title">
          <?= e($distemper['name']) ?>
        </h2>
        <p class="product-chapter__desc">
          <?= e($distemper['descriptor']) ?>. A paint listed for
          interior and exterior walls. Supplied in <?= e($distemper['packagingShort']) ?> packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row"><dt>Finish</dt><dd><?= e($distemper['finish']) ?></dd></div>
          <div class="duo-panel__row"><dt>Drying time</dt><dd><?= e($distemper['dryingTime']) ?></dd></div>
          <div class="duo-panel__row"><dt>Coverage</dt><dd><?= e($distemper['coverage']) ?></dd></div>
          <div class="duo-panel__row"><dt>V.O.C.</dt><dd><?= e($distemper['voc']) ?></dd></div>
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
     4. EMULSION PRODUCT CHAPTER (reversed) — catalogue plate
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
        <span class="product-chapter__eyebrow">Eco-Paints — Emulsion</span>
        <h2 class="product-chapter__name" id="emulsion-chapter-title">
          <?= e($emulsion['name']) ?>
        </h2>
        <p class="product-chapter__desc">
          <?= e($emulsion['descriptor']) ?>. A paint listed for
          interior and exterior walls. Supplied in <?= e($emulsion['packagingShort']) ?> packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row"><dt>Finish</dt><dd><?= e($emulsion['finish']) ?></dd></div>
          <div class="duo-panel__row"><dt>Drying time</dt><dd><?= e($emulsion['dryingTime']) ?></dd></div>
          <div class="duo-panel__row"><dt>Coverage</dt><dd><?= e($emulsion['coverage']) ?></dd></div>
          <div class="duo-panel__row"><dt>V.O.C.</dt><dd><?= e($emulsion['voc']) ?></dd></div>
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
     5. SPEC MATRIX — factual comparison of the two documented formats
     ============================================================ -->
<section class="section section--paper spec-matrix-section" aria-labelledby="compare-title">
  <div class="container">
    <div class="spec-matrix-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Eco-Paints — side by side</span>
      <h2 class="section-heading__title" id="compare-title">Compare the two formats.</h2>
    </div>

    <div class="spec-matrix" data-reveal>
      <div class="spec-matrix__row">
        <span class="spec-matrix__col-head">Specification</span>
        <span class="spec-matrix__col-head spec-matrix__col-head--distemper">Prakritik Distemper</span>
        <span class="spec-matrix__col-head spec-matrix__col-head--emulsion">Prakritik Emulsion</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Pack sizes</span>
        <span class="spec-matrix__value"><?= e($distemper['packagingShort']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['packagingShort']) ?></span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Colour</span>
        <span class="spec-matrix__value"><?= e($distemper['colour']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['colour']) ?></span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Finish</span>
        <span class="spec-matrix__value"><?= e($distemper['finish']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['finish']) ?></span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Drying time</span>
        <span class="spec-matrix__value"><?= e($distemper['dryingTime']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['dryingTime']) ?></span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Coverage</span>
        <span class="spec-matrix__value"><?= e($distemper['coverage']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['coverage']) ?></span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">V.O.C.</span>
        <span class="spec-matrix__value"><?= e($distemper['voc']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['voc']) ?></span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Usage</span>
        <span class="spec-matrix__value"><?= e($distemper['usage']) ?></span>
        <span class="spec-matrix__value"><?= e($emulsion['usage']) ?></span>
      </div>
    </div>

    <div class="spec-matrix-mobile" data-reveal>
      <div class="spec-matrix-mobile__block">
        <div class="spec-matrix-mobile__name"><?= e($distemper['name']) ?></div>
        <div class="spec-matrix-mobile__row"><span class="k">Pack sizes</span><span class="v"><?= e($distemper['packagingShort']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Colour</span><span class="v"><?= e($distemper['colour']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Finish</span><span class="v"><?= e($distemper['finish']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Drying time</span><span class="v"><?= e($distemper['dryingTime']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Coverage</span><span class="v"><?= e($distemper['coverage']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">V.O.C.</span><span class="v"><?= e($distemper['voc']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Usage</span><span class="v"><?= e($distemper['usage']) ?></span></div>
      </div>
      <div class="spec-matrix-mobile__block spec-matrix-mobile__block--emulsion">
        <div class="spec-matrix-mobile__name"><?= e($emulsion['name']) ?></div>
        <div class="spec-matrix-mobile__row"><span class="k">Pack sizes</span><span class="v"><?= e($emulsion['packagingShort']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Colour</span><span class="v"><?= e($emulsion['colour']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Finish</span><span class="v"><?= e($emulsion['finish']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Drying time</span><span class="v"><?= e($emulsion['dryingTime']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Coverage</span><span class="v"><?= e($emulsion['coverage']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">V.O.C.</span><span class="v"><?= e($emulsion['voc']) ?></span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Usage</span><span class="v"><?= e($emulsion['usage']) ?></span></div>
      </div>
    </div>

    <p class="coverage-disclaimer" style="margin-top: 2rem;">
      <span class="coverage-disclaimer__label">Coverage note</span>
      <span class="coverage-disclaimer__text"><?= e($COVERAGE_DISCLAIMER) ?></span>
    </p>
  </div>
</section>

<!-- ============================================================
     6. BENEFITS — the shared eight-benefit grid (Eco-Paints context)
     ============================================================ -->
<section class="section section--haldi-wash benefits-strip" aria-labelledby="benefits-title">
  <div class="container">
    <div class="benefits-strip__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="benefits-title">Eight benefits of Prakritik Paint.</h2>
      <p class="section-heading__desc">
        Benefits listed in the supplied Prakritik Paint material.
      </p>
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
     7. GOCAST LOGS — development direction (§32)
     Type/material-led family section. NO burn time, density, price,
     availability, size or wood-equivalent claims.
     ============================================================ -->
<section class="section section--paper family-section" id="gocast-logs" aria-labelledby="gocast-title">
  <div class="container">
    <div class="family-section__grid" data-reveal>
      <div class="family-section__copy">
        <span class="family-section__num" aria-hidden="true">02</span>
        <h2 class="family-section__name" id="gocast-title">GoCast Logs</h2>
        <p class="family-section__line">Saving trees without changing traditions.</p>
        <p class="family-section__desc">
          A dense log format developed as an alternative to conventional wood —
          directed at ceremonial and traditional applications where wood has
          long been the default.
        </p>
        <ul class="family-section__themes">
          <li>Alternative to conventional wood</li>
          <li>Traditional / ceremonial application direction</li>
          <li>Resource-conservation direction</li>
        </ul>
        <p class="family-section__note">
          GoCast is a development direction. Specifications, availability and
          product photography will be published when the client supplies
          verified information.
        </p>
        <div class="family-section__cta">
          <a class="btn btn--outline" href="/contact/?interest=gocast-logs">Enquire About GoCast</a>
        </div>
      </div>
      <figure class="family-section__plate" aria-label="GoCast Logs — material direction">
        <span class="family-section__plate-texture" aria-hidden="true">
          <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>" alt="" width="1344" height="768" loading="lazy" decoding="async">
        </span>
        <span class="family-section__plate-word">GoCast Logs</span>
        <span class="family-section__plate-tag">Material direction</span>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     8. BIO-COAL LOGS — development direction (§33)
     No calorific values, emissions percentages, "smokeless" or
     "carbon neutral" claims.
     ============================================================ -->
<section class="section section--limewash family-section family-section--reverse" id="bio-coal-logs" aria-labelledby="biocoal-title">
  <div class="container">
    <div class="family-section__grid" data-reveal>
      <div class="family-section__copy">
        <span class="family-section__num" aria-hidden="true">03</span>
        <h2 class="family-section__name" id="biocoal-title">Bio-Coal Logs</h2>
        <p class="family-section__line">Renewable energy from natural biomass.</p>
        <p class="family-section__desc">
          Biomass-based fuel logs — a renewable energy direction that explores
          how natural material streams can reduce reliance on fossil fuels.
        </p>
        <ul class="family-section__themes">
          <li>Biomass energy</li>
          <li>Reduced fossil-fuel reliance direction</li>
          <li>Alternative fuel applications</li>
          <li>Circular material use</li>
        </ul>
        <p class="family-section__note">
          Bio-Coal is a development direction. Composition, calorific value
          and test data will be published when the client supplies verified
          information.
        </p>
        <div class="family-section__cta">
          <a class="btn btn--outline" href="/contact/?interest=bio-coal-logs">Enquire About Bio-Coal</a>
        </div>
      </div>
      <figure class="family-section__plate" aria-label="Bio-Coal Logs — material direction">
        <span class="family-section__plate-texture" aria-hidden="true">
          <img src="<?= asset_url('/assets/editorial/exterior-finish-study.jpg') ?>" alt="" width="1344" height="768" loading="lazy" decoding="async">
        </span>
        <span class="family-section__plate-word">Bio-Coal Logs</span>
        <span class="family-section__plate-tag">Material direction</span>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     9. UTILITY PRODUCTS — development direction (§34)
     No individual products listed; no AI-generated 4-panel image.
     ============================================================ -->
<section class="section section--paper family-section" id="utility-products" aria-labelledby="utility-title">
  <div class="container">
    <div class="family-section__grid" data-reveal>
      <div class="family-section__copy">
        <span class="family-section__num" aria-hidden="true">04</span>
        <h2 class="family-section__name" id="utility-title">Eco-Friendly Utility Products</h2>
        <p class="family-section__line">Sustainable products for everyday living.</p>
        <p class="family-section__desc">
          Practical daily-use products from naturally derived materials — a
          plastic-reducing direction for homes, gardens and everyday routines.
        </p>
        <ul class="family-section__themes">
          <li>Plastic-reducing alternatives</li>
          <li>Material reuse</li>
          <li>Home / garden / lifestyle direction</li>
          <li>Circular-economy solutions</li>
        </ul>
        <p class="family-section__note">
          Utility Products is a development direction. A confirmed product
          list will be published when the client supplies verified information.
        </p>
        <div class="family-section__cta">
          <a class="btn btn--outline" href="/contact/?interest=utility-products">Enquire About Utility Products</a>
        </div>
      </div>
      <figure class="family-section__plate" aria-label="Utility Products — material direction">
        <span class="family-section__plate-texture" aria-hidden="true">
          <img src="<?= asset_url('/assets/editorial/courtyard-study.jpg') ?>" alt="" width="1344" height="768" loading="lazy" decoding="async">
        </span>
        <span class="family-section__plate-word">Utility Products</span>
        <span class="family-section__plate-tag">Material direction</span>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     10. APPLICATION MAP — where the ecosystem works (§35)
     ============================================================ -->
<section class="section section--haldi-wash appmap-section" aria-labelledby="appmap-title">
  <div class="container">
    <div class="appmap-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Application map</span>
      <h2 class="section-heading__title" id="appmap-title">Where the Ecosystem Works.</h2>
    </div>
    <div class="app-matrix" data-reveal-stagger>
      <?php foreach ($APPLICATION_GROUPS as $group): ?>
        <div class="app-group">
          <h3 class="app-group__title"><?= e($group['title']) ?></h3>
          <ul class="app-group__list">
            <?php foreach ($group['items'] as $item): ?>
              <li class="app-group__item<?= $item['live'] ? ' app-group__item--live' : ' app-group__item--direction' ?>">
                <?php if ($item['href']): ?>
                  <a href="<?= e($item['href']) ?>"><?= e($item['name']) ?></a>
                <?php else: ?>
                  <span><?= e($item['name']) ?></span>
                <?php endif; ?>
                <span class="app-group__item-tag"><?= $item['live'] ? 'Family' : 'Direction' ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="app-matrix-note" data-reveal>
      Entries marked <strong>Direction</strong> are application areas under exploration —
      not products currently for sale.
    </p>
  </div>
</section>

<!-- ============================================================
     11. FAQ (retained factual content)
     ============================================================ -->
<section class="section section--paper faq-section" aria-labelledby="faq-title">
  <div class="container">
    <div class="faq-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Common questions</span>
      <h2 class="section-heading__title" id="faq-title">Frequently asked.</h2>
    </div>
    <div class="faq-list" data-reveal>
      <?php foreach ($FAQ as $item): ?>
        <div class="faq-item">
          <button type="button" class="faq-item__q" aria-expanded="false">
            <span><?= e($item['q']) ?></span>
            <svg class="faq-item__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="faq-item__a">
            <div class="faq-item__a-inner"><?= $item['a'] /* FAQ HTML pre-escaped in data.php */ ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     12. NEED HELP CHOOSING — CTA
     ============================================================ -->
<section class="section section--forest" aria-labelledby="choose-cta-title">
  <div class="container">
    <div class="why-cta" data-reveal>
      <span class="why-cta__eyebrow">Still deciding?</span>
      <h2 class="why-cta__title" id="choose-cta-title">Need help choosing? Talk to Gaurikrit.</h2>
      <p class="why-cta__sub">
        We can walk through your project — interior or exterior, fresh walls or
        repainting — and help you pick the right Prakritik format.
      </p>
      <div class="why-cta__actions">
        <a class="btn btn--haldi" href="/contact/">Talk to Us</a>
        <a class="btn btn--secondary" href="/paint-calculator/">Estimate Your Project</a>
      </div>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
