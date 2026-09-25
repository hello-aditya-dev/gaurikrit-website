<?php
/**
 * Gaurikrit Bio Products — Prakritik Distemper Product Detail (V4 asset pass).
 * Task V4-ASSETS.
 *
 * Composition unchanged from V3. This pass replaces coded SVG bucket
 * illustration with real product photography (490×621, NOT upscaled, complete bucket) and
 * uses interior-wall-study.webp as the hero environment. SVG kept only for
 * interactive ashta-laabh-seal.
 *
 *   - Pale chuna / indigo material environment (.product-detail--cool).
 *   - Hero: copy 5 / product 7 (real photo, natural size, NO upscaling).
 *   - Spec sheet: large ruled rows numbered 01-07 (NOT pills).
 *   - Coverage disclaimer.
 *   - Ashta Laabh grid (interactive SVG seal kept).
 *   - CTA "Enquire About Distemper" → /contact/?interest=prakritik-distemper.
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Distemper Paint — Cow Dung-Based | Gaurikrit';
$pageDescription = 'Prakritik Distemper Paint: cow dung-based, matt finish, 1-20 kg packs, 200 sq.ft.** coverage, Interior & Exterior usage. From Gaurikrit Bio Products, Khurja, Uttar Pradesh.';
$pageCanonical   = '/products/prakritik-distemper/';
$pageClass       = 'product-distemper';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $ASHTA_LAABH, $COVERAGE_DISCLAIMER;

$product = get_product('prakritik-distemper');
if (!$product) {
    http_response_code(404);
    exit;
}

$emulsion = get_product('prakritik-emulsion');

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

$specRows = [
    ['num' => '01', 'label' => 'Packaging',  'value' => $product['packagingShort'], 'note' => '1 kg / 5 kg / 10 kg / 20 kg packs'],
    ['num' => '02', 'label' => 'Colour',     'value' => $product['colour']],
    ['num' => '03', 'label' => 'Finish',     'value' => $product['finish']],
    ['num' => '04', 'label' => 'Drying time','value' => $product['dryingTime']],
    ['num' => '05', 'label' => 'Coverage',   'value' => $product['coverage'], 'note' => '** ' . $COVERAGE_DISCLAIMER],
    ['num' => '06', 'label' => 'V.O.C.',     'value' => $product['voc']],
    ['num' => '07', 'label' => 'Usage',      'value' => $product['usage']],
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

  /* ===== HERO (copy 5 / product 7 — cool env) ===== */
  .product-detail { padding-bottom: clamp(3rem, 6vw, 5rem); }
  .product-detail__hero {
    display: grid; gap: 2rem; padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 2rem; align-items: center;
  }
  @media (min-width: 1024px) {
    .product-detail__hero {
      grid-template-columns: 5fr 7fr; gap: clamp(2.5rem, 5vw, 4rem);
    }
  }
  /* V10: media is a clean catalogue plate (same language as the home
     product chapters) — white product stage + slim wall-finish strip.
     The complete pack photo is shown at its natural proportion. */
  .product-detail__media {
    display: flex; flex-direction: column;
    background: var(--paper);
    border: 1px solid var(--border); border-top: 3px solid var(--indigo);
    border-radius: var(--r-panel); overflow: hidden;
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .product-detail__stage {
    position: relative;
    height: clamp(17rem, 36vw, 25rem);
    display: grid; place-items: center;
    padding: clamp(1.25rem, 3vw, 2.25rem);
  }
  .product-detail__stage .media-product {
    /* Absolute-fill + object-fit: contain — the pack photo stays
       COMPLETE inside the fixed-height stage (never cropped). */
    position: absolute;
    top: clamp(1.25rem, 3vw, 2.25rem);
    left: clamp(1.25rem, 3vw, 2.25rem);
    width: calc(100% - 2 * clamp(1.25rem, 3vw, 2.25rem));
    height: calc(100% - 2 * clamp(1.25rem, 3vw, 2.25rem));
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
  .product-detail__descriptor { color: var(--indigo); }

  /* ===== SPEC SHEET (numbered 01-07 ruled rows, NOT pills) ===== */
  .distemper-specs-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 1.5rem; }
  .spec-sheet__list {
    grid-template-columns: 1fr;
  }

  /* ===== COVERAGE DISCLAIMER ===== */
  .coverage-disclaimer { margin-top: 2rem; border-left-color: var(--indigo); }

  /* ===== ASHTA LAABH GRID ===== */
  .distemper-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); position: relative; overflow: hidden; }
  .distemper-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
</style>

<!-- ===== HERO (cool env, copy 5 / product 7) ===== -->
<section class="product-detail product-detail--cool" aria-labelledby="distemper-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <a href="/products/">Products</a><span>›</span>
      <span>Prakritik Distemper</span>
    </nav>

    <div class="product-detail__hero" data-reveal>
      <div class="product-detail__info">
        <span class="distemper-hero__eyebrow">Format 01 — Distemper</span>
        <h1 class="product-detail__name" id="distemper-title"><?= e($product['name']) ?></h1>
        <p class="product-detail__descriptor"><?= e($product['descriptor']) ?></p>
        <p class="distemper-hero__body">
          Cow dung-based paint listed for interior and exterior
          walls. Supplied in <?= e($product['packagingShort']) ?> packs.
        </p>
        <div class="distemper-hero__cta-row">
          <a class="btn btn--primary btn--lg"
             href="/contact/?interest=prakritik-distemper">Enquire About Distemper</a>
          <a class="btn btn--outline" href="/products/">View All Products</a>
        </div>
      </div>

      <figure class="product-detail__media">
        <div class="product-detail__stage">
          <img class="media-product"
               src="<?= asset_url($product['officialImage']) ?>"
               alt="<?= e($product['name']) ?> paint pack"
               width="490" height="621"
               loading="eager" fetchpriority="high" decoding="async">
        </div>
        <div class="product-detail__strip" aria-hidden="true">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-finish-study.webp') ?>">
            <img class="media-strip"
                 src="<?= asset_url('/assets/editorial/interior-finish-study.jpg') ?>"
                 alt=""
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </div>
      </figure>
    </div>
  </div>
</section>

<!-- ===== SPEC SHEET (numbered 01-07 ruled rows) ===== -->
<section class="section section--paper distemper-specs-section" aria-labelledby="specs-title">
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

<!-- ===== ASHTA LAABH ===== -->
<section class="section section--limewash distemper-ashta-section" aria-labelledby="distemper-ashta-title" data-ashta-laabh>
  <div class="container">
    <div class="distemper-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ — Eight benefits</span>
      <h2 class="section-heading__title" id="distemper-ashta-title">Ashta Laabh.</h2>
      <p class="section-heading__desc">
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
          <li class="ashta-benefit distemper-ashta__item" data-ashta-node="<?= e($bid) ?>">
            <span class="ashta-benefit__num"><?= e(sprintf('%02d', $i + 1)) ?></span>
            <span class="ashta-benefit__name"><?= e($benefit['name']) ?></span>
            <span class="ashta-benefit__deva"><?= e($benefit['hindi']) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ===== CROSS-LINK ===== -->
<section class="section section--paper" aria-labelledby="cross-title">
  <div class="container">
    <div class="distemper-cta" data-reveal>
      <div class="distemper-cta__inner">
        <div>
          <span class="distemper-hero__eyebrow">Looking at the other format?</span>
          <h2 class="distemper-cta__title" id="cross-title">Prakritik Emulsion.</h2>
          <p class="distemper-cta__body">
            Cow dung-based Emulsion Paint. Coverage <?= e($emulsion['coverage']) ?>.
            Supplied in <?= e($emulsion['packagingShort']) ?> packs.
          </p>
        </div>
        <div class="distemper-cta__actions">
          <a class="btn btn--secondary" href="<?= e($emulsion['route']) ?>">View Emulsion</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
<?php require ROOT_PATH . '/includes/footer.php';
