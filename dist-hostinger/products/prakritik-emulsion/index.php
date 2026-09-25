<?php
/**
 * Gaurikrit Bio Products — Prakritik Emulsion Product Detail (V4 asset pass).
 * Task V4-ASSETS.
 *
 * Composition unchanged from V3. This pass replaces coded SVG bucket
 * illustration with real product photography (450×621, NOT upscaled, complete bucket) and
 * uses exterior-wall-study-v2.webp as the hero environment. SVG kept only for
 * typographic benefits grid (app.css §18).
 *
 * Composition (REVERSED — product left, copy right):
 *   - Warm leaf / haldi material environment (.product-detail--warm).
 *   - Hero: product 7 (left) / copy 5 (right) — real photo, natural size.
 *   - Spec sheet: same numbered ruled system, different layout.
 *   - Coverage disclaimer.
 *   - Ashta Laabh grid.
 *   - CTA "Enquire About Emulsion".
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Emulsion Paint — Cow Dung-Based | Gaurikrit';
$pageDescription = 'Prakritik Emulsion Paint: cow dung-based, matt finish, 1-20 litre packs, 300 sq.ft.** coverage, Interior & Exterior usage. From Gaurikrit Bio Products, Khurja, Uttar Pradesh.';
$pageCanonical   = '/products/prakritik-emulsion/';
$pageClass       = 'product-emulsion';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $ASHTA_LAABH, $COVERAGE_DISCLAIMER;

$product = get_product('prakritik-emulsion');
if (!$product) {
    http_response_code(404);
    exit;
}

$distemper = get_product('prakritik-distemper');

$specRows = [
    ['num' => '01', 'label' => 'Packaging',   'value' => $product['packagingShort'], 'note' => '1 litre / 4 litre / 10 litre / 20 litre packs'],
    ['num' => '02', 'label' => 'Colour',      'value' => $product['colour']],
    ['num' => '03', 'label' => 'Finish',      'value' => $product['finish']],
    ['num' => '04', 'label' => 'Drying time', 'value' => $product['dryingTime']],
    ['num' => '05', 'label' => 'Coverage',    'value' => $product['coverage'], 'note' => '** ' . $COVERAGE_DISCLAIMER],
    ['num' => '06', 'label' => 'V.O.C.',      'value' => $product['voc']],
    ['num' => '07', 'label' => 'Usage',       'value' => $product['usage']],
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

  /* ===== HERO — REVERSED (product left, copy right — warm env) ===== */
  .product-detail { padding-bottom: clamp(3rem, 6vw, 5rem); }
  .product-detail__hero {
    display: grid; gap: 2rem; padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 2rem; align-items: center;
  }
  @media (min-width: 1024px) {
    .product-detail__hero {
      grid-template-columns: 7fr 5fr; gap: clamp(2.5rem, 5vw, 4rem);
    }
    /* Reversed: product is the first child, on the left. */
    .product-detail--warm .product-detail__hero > :first-child { order: 1; }
    .product-detail--warm .product-detail__hero > :last-child  { order: 2; }
  }
  /* V12: media is ONE designed catalogue panel (same language as the home
     product chapters, app.css §14) — soft neutral wall plate tinted with
     the format wash, complete pack anchored toward the base, slim
     wall-finish strip. Hairline border only: no 3px accent stripe,
     no shadow. */
  .product-detail__media {
    display: flex; flex-direction: column;
    background: color-mix(in srgb, var(--paper-leaf) 25%, var(--paper));
    border: 1px solid var(--border);
    border-radius: var(--r-panel); overflow: hidden;
  }
  .product-detail__stage {
    position: relative;
    height: clamp(17rem, 36vw, 25rem);
    display: grid; place-items: center;
    padding: clamp(1.5rem, 3.5vw, 3rem) clamp(1.5rem, 3.5vw, 3rem) clamp(0.75rem, 1.5vw, 1.25rem);
  }
  .product-detail__stage .media-product {
    /* Absolute-fill + object-fit: contain — the pack photo stays
       COMPLETE inside the fixed-height stage (never cropped). The box
       is biased downward so the pack stands toward the panel's base. */
    position: absolute;
    top: clamp(1.5rem, 3.5vw, 3rem);
    left: clamp(1.5rem, 3.5vw, 3rem);
    width: calc(100% - 2 * clamp(1.5rem, 3.5vw, 3rem));
    height: calc(100% - clamp(1.5rem, 3.5vw, 3rem) - clamp(0.75rem, 1.5vw, 1.25rem));
    object-fit: contain;
  }
  .product-detail__strip {
    height: clamp(6rem, 13vw, 9rem);
    border-top: 1px solid var(--border);
    overflow: hidden;
    background: var(--limewash);
  }
  .product-detail__strip .media-strip {
    display: block; width: 100%; height: 100%;
    object-fit: cover;
  }
  .product-detail__info { display: flex; flex-direction: column; gap: 0.75rem; }
  .product-detail__name { margin-top: 0.5rem; }
  .product-detail__descriptor { color: var(--leaf); }

  /* ===== SPEC SHEET ===== */
  .emulsion-specs-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 1.5rem; }
  .spec-sheet__list { grid-template-columns: 1fr; }

  /* ===== COVERAGE DISCLAIMER ===== */
  .coverage-disclaimer { margin-top: 2rem; border-left-color: var(--leaf); }

  /* ===== ASHTA LAABH — the shared typographic grid (app.css §18) ===== */
  .emulsion-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .emulsion-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
</style>

<!-- ===== HERO — REVERSED (warm env) ===== -->
<section class="product-detail product-detail--warm" aria-labelledby="emulsion-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <a href="/products/">Products</a><span>›</span>
      <span>Prakritik Emulsion</span>
    </nav>

    <div class="product-detail__hero" data-reveal>
      <figure class="product-detail__media">
        <div class="product-detail__stage">
          <picture>
            <source type="image/webp" srcset="<?= asset_url($product['officialImageWebp']) ?>">
            <img class="media-product"
                 src="<?= asset_url($product['officialImage']) ?>"
                 alt="<?= e($product['name']) ?> paint pack"
                 width="<?= $product['officialImageW'] ?>" height="<?= $product['officialImageH'] ?>"
                 loading="eager" fetchpriority="high" decoding="async">
          </picture>
        </div>
        <div class="product-detail__strip" aria-hidden="true">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/exterior-finish-study.webp') ?>">
            <img class="media-strip"
                 src="<?= asset_url('/assets/editorial/exterior-finish-study.jpg') ?>"
                 alt=""
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </div>
      </figure>

      <div class="product-detail__info">
        <span class="emulsion-hero__eyebrow">Format 02 — Emulsion</span>
        <h1 class="product-detail__name" id="emulsion-title"><?= e($product['name']) ?></h1>
        <p class="product-detail__descriptor"><?= e($product['descriptor']) ?></p>
        <p class="emulsion-hero__body">
          Cow dung-based paint listed for interior and exterior
          walls. Supplied in <?= e($product['packagingShort']) ?> packs.
        </p>
        <div class="emulsion-hero__cta-row">
          <a class="btn btn--primary btn--lg"
             href="/contact/?interest=prakritik-emulsion">Enquire About Emulsion</a>
          <a class="btn btn--outline" href="/products/">View All Products</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SPEC SHEET (numbered 01-07 ruled rows) ===== -->
<section class="section section--paper emulsion-specs-section" aria-labelledby="specs-title">
  <div class="container">
    <div class="spec-sheet__head section-heading section-heading--left" data-reveal>
      <span class="spec-sheet__eyebrow">Specifications</span>
      <h2 class="spec-sheet__title" id="specs-title">Product specifications.</h2>
      <!-- V9: print affordance — window.print() + the app.css §36 print
           stylesheet turns this page into a printable spec sheet. -->
      <button type="button" class="spec-sheet__print" data-print-spec>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
        <span>Print spec sheet</span>
      </button>
    </div>

    <dl class="spec-sheet__list" data-reveal>
      <?php foreach ($specRows as $row): ?>
        <div class="spec-sheet__item">
          <span class="spec-sheet__num"><?= e($row['num']) ?></span>
          <div>
            <dt class="spec-sheet__label"><?= e($row['label']) ?></dt>
            <dd class="spec-sheet__value">
              <?= e($row['value']) ?>
              <?php if (!empty($row['note'])): ?>
                <small><?= e($row['note']) ?></small>
              <?php endif; ?>
            </dd>
          </div>
        </div>
      <?php endforeach; ?>
    </dl>

    <p class="coverage-disclaimer" data-reveal>
      <span class="coverage-disclaimer__label">Coverage note</span>
      <span class="coverage-disclaimer__text"><?= e($COVERAGE_DISCLAIMER) ?></span>
    </p>
  </div>
</section>

<!-- ===== ASHTA LAABH — the shared typographic eight-benefit grid ===== -->
<section class="section section--haldi-wash emulsion-ashta-section" aria-labelledby="emulsion-ashta-title">
  <div class="container">
    <div class="emulsion-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="emulsion-ashta-title">Eight benefits of Prakritik Paint.</h2>
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

<!-- ===== CROSS-LINK ===== -->
<section class="section section--paper" aria-labelledby="cross-title">
  <div class="container">
    <div class="emulsion-cta" data-reveal>
      <div class="emulsion-cta__inner">
        <div>
          <span class="emulsion-hero__eyebrow">Looking at the other format?</span>
          <h2 class="emulsion-cta__title" id="cross-title">Prakritik Distemper.</h2>
          <p class="emulsion-cta__body">
            Cow dung-based Distemper Paint. Coverage <?= e($distemper['coverage']) ?>.
            Supplied in <?= e($distemper['packagingShort']) ?> packs.
          </p>
        </div>
        <div class="emulsion-cta__actions">
          <a class="btn btn--secondary" href="<?= e($distemper['route']) ?>">View Distemper</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
