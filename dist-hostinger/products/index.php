<?php
/**
 * Gaurikrit Bio Products — Products Overview (V5 finish pass).
 * Task V5-FINISH.
 *
 * Refines the V4 composition: spec-matrix gets a header row + zebra
 * striping + taller padding + bolder labels; benefits strip gets haldi
 * dot indicators beside each number + bolder name typography; FAQ gets
 * more breathing room above + a haldi divider line. Factual data
 * unchanged from data.php.
 *
 *   1. Hero — 45% text / 55% product group visual (real group photo).
 *   2. Distemper Product Chapter — interior-wall-study env + real photo.
 *   3. Emulsion Product Chapter — exterior-wall-study env + real photo (reversed).
 *   4. Spec Matrix — V5: ruled comparison with header row, zebra striping
 *      at 0.03 opacity, taller rows, bolder labels.
 *   5. Benefits — V5: haldi dot indicators beside each number + bolder
 *      name typography, 4×2 grid on desktop.
 *   6. FAQ — V5: more spacing above + haldi divider line before.
 *   7. "Need help choosing?" CTA → /contact/.
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Paint Products — Distemper & Emulsion | Gaurikrit';
$pageDescription = 'Two formats of Prakritik Paint: Distemper (1, 5, 10 and 20 kg packs) and Emulsion (1, 4, 10 and 20 litre packs). Matt finish, interior & exterior use. Cow-dung-based, from Gaurikrit Bio Products.';
$pageCanonical   = '/products/';
$pageClass       = 'products';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $FAQ, $COVERAGE_DISCLAIMER;

$distemper   = get_product('prakritik-distemper');
$emulsion    = get_product('prakritik-emulsion');
$groupImage  = '/assets/products/prakritik-pair.jpg';
$groupImageWebp = '/assets/products/prakritik-pair.webp';
// V11: the products hero carries the client's official two-bucket comparison
// image (Distemper left, Emulsion right) — it is the visual argument for
// "Two formats of Prakritik Paint". The higher-resolution three-bucket shelf
// photo stays on the home + about heroes (prakritik-group.jpg).
?>
<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== 1. PRODUCTS HERO (45 / 55) — the official pair photo on a quiet
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

  /* ===== 2/3. PRODUCT CHAPTERS — catalogue plates (structure in
     app.css §14: white product stage + wall-finish strip); nothing
     page-local needed. ===== */

  /* ===== SPEC MATRIX (V5: header row + zebra striping + taller rows
     + bolder labels — a real product comparison, not a sparse list) ===== */
  .spec-matrix-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-matrix-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  /* V5: wrap the matrix in a soft paper panel so the striping reads. */
  .spec-matrix {
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    overflow: hidden;
    background: var(--paper);
  }
  .spec-matrix__row {
    grid-template-columns: 1fr; gap: 0.75rem;
    padding: 1.75rem 1.25rem;  /* V5: taller, more padding */
    border-bottom: 1px solid var(--border);
  }
  @media (min-width: 768px) {
    .spec-matrix__row {
      grid-template-columns: 12rem 1fr 1fr; gap: 1.5rem; padding: 1.75rem 1.5rem;
    }
  }
  /* V5: zebra striping — alternating rows at haldi 3% opacity. */
  .spec-matrix__row:nth-child(even) {
    background: color-mix(in srgb, var(--haldi) 3%, transparent);
  }
  /* V7: header row clearly legible — forest text, tinted ground, strong rule. */
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
  /* V5: bolder spec labels. */
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
  /* V7: below 640px the 3-column matrix is unreadable — two stacked spec
     sheets instead (Distemper block + Emulsion block). */
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

  /* ===== BENEFITS — the shared typographic grid (structure in app.css
     §18: identical to Home / Why / detail pages). Nothing page-local. ===== */
  .benefits-strip { padding-block: clamp(3rem, 6vw, 5rem); }
  .benefits-strip__head { max-width: 48rem; margin-bottom: 2rem; }

  /* ===== FAQ (V5: more spacing above + haldi divider line) ===== */
  .faq-section {
    padding-block: clamp(4.5rem, 8vw, 6.5rem);  /* V5: increased from clamp(3rem, 6vw, 5rem) */
    position: relative;
  }
  /* V7: haldi divider line aligned to the content grid (container), never
     the viewport edge. FAQ constrained to a readable 64rem measure. */
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
     1. HERO — 45 / 55 (text / product group visual)
     ============================================================ -->
<section class="products-hero bg-limewash" aria-labelledby="products-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Products</span>
    </nav>
    <div class="products-hero__grid">
      <div class="products-hero__lockup" data-reveal>
        <span class="eyebrow"><span class="products-hero__eyebrow-dot" aria-hidden="true"></span>Prakritik Paint</span>
        <hr class="products-hero__rule">
        <h1 class="products-hero__title" id="products-hero-title">Two formats of Prakritik Paint.</h1>
        <p class="products-hero__sub">
          Cow dung-based paint, made for interior and exterior walls. Prakritik
          Distemper and Prakritik Emulsion. Two formats, one
          material idea.
        </p>
      </div>
      <div class="products-hero__visual" data-reveal>
        <picture>
          <source type="image/webp" srcset="<?= asset_url($groupImageWebp) ?>">
          <img class="hero-group-photo"
               src="<?= asset_url($groupImage) ?>"
               alt="Prakritik Distemper and Emulsion paint packs"
               width="1420" height="618"
               loading="eager" fetchpriority="high" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. DISTEMPER PRODUCT CHAPTER — catalogue plate
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
        <span class="product-chapter__eyebrow">Format 01 — Distemper</span>
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
     3. EMULSION PRODUCT CHAPTER (reversed) — catalogue plate
     (complete pack photo + exterior-finish strip; structure in app.css §14)
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
     4. SPEC MATRIX — large ruled comparison, NO outer card
     ============================================================ -->
<section class="section section--paper spec-matrix-section" aria-labelledby="compare-title">
  <div class="container">
    <div class="spec-matrix-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Side by side</span>
      <h2 class="section-heading__title" id="compare-title">Compare the two formats.</h2>
    </div>

    <div class="spec-matrix" data-reveal>
      <!-- Column header row -->
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
     5. BENEFITS — the shared typographic eight-benefit grid
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
     6. FAQ (consumed here per spec — only styled for Products / Why-Prakritik)
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
     7. NEED HELP CHOOSING — CTA
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
