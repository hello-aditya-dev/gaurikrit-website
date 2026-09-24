<?php
/**
 * Gaurikrit Bio Products — Prakritik Emulsion Product Detail (V3 rebuild).
 * Task V3-PAGES.
 *
 * Composition (REVERSED — product left, copy right):
 *   - Warm leaf / haldi material environment (.product-detail--warm).
 *   - Hero: product 7 (left) / copy 5 (right).
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
  .product-detail__media {
    position: relative; aspect-ratio: 1;
    background: linear-gradient(160deg, var(--paper), var(--paper-warm));
    border: 1px solid var(--border); border-top: 3px solid var(--leaf);
    border-radius: var(--r-panel); overflow: hidden;
    min-height: 22rem;
  }
  @media (min-width: 1024px) { .product-detail__media { min-height: 30rem; } }
  .product-detail__media .product-media { width: 100%; height: 100%; }
  .product-detail__media .product-media__official { object-fit: contain; padding: 2.5rem; }
  .product-detail__media .product-media__fallback { padding: 2rem; }
  .product-detail__media__num {
    position: absolute; top: 1rem; right: 1.25rem;
    font-family: var(--font-display); font-size: clamp(3rem, 8vw, 5rem);
    font-weight: 700; color: var(--leaf); opacity: 0.18;
    line-height: 1; pointer-events: none;
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

  /* ===== ASHTA LAABH ===== */
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
      <div class="product-detail__media">
        <span class="product-detail__media__num" aria-hidden="true">02</span>
        <div class="product-media" data-official-image="<?= e($product['officialImage']) ?>">
          <img class="product-media__official"
               src="<?= e($product['officialImage']) ?>"
               alt="<?= e($product['name']) ?> pack"
               width="800" height="800" loading="eager" decoding="async">
          <div class="product-media__fallback">
            <?php render_illustration('prakritik-emulsion-bucket'); ?>
          </div>
        </div>
      </div>

      <div class="product-detail__info">
        <span class="emulsion-hero__eyebrow">Format 02 — Emulsion</span>
        <h1 class="product-detail__name" id="emulsion-title"><?= e($product['name']) ?></h1>
        <p class="product-detail__descriptor"><?= e($product['descriptor']) ?></p>
        <p class="emulsion-hero__body">
          A liquid-format cow dung-based paint, brushed on interior and exterior
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
<section class="section section--limewash emulsion-ashta-section" aria-labelledby="emulsion-ashta-title" data-ashta-laabh>
  <div class="container">
    <div class="emulsion-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ — Eight benefits</span>
      <h2 class="section-heading__title" id="emulsion-ashta-title">Ashta Laabh.</h2>
      <p class="section-heading__desc">
        Client-supplied product benefits, not independently tested claims.
      </p>
    </div>

    <div class="ashta-section__grid" data-reveal>
      <div class="ashta-section__seal">
        <?php render_illustration('ashta-laabh-seal'); ?>
      </div>
      <ol class="ashta-section__support" data-reveal-stagger>
        <?php foreach ($ASHTA_LAABH as $i => $benefit): ?>
          <?php $bid = $ashtaIds[$benefit['name']] ?? ('benefit-' . ($i + 1)); ?>
          <li class="ashta-benefit emulsion-ashta__item" data-ashta-node="<?= e($bid) ?>">
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
    <div class="emulsion-cta" data-reveal>
      <div class="emulsion-cta__inner">
        <div>
          <span class="emulsion-hero__eyebrow">Looking at the other format?</span>
          <h2 class="emulsion-cta__title" id="cross-title">Prakritik Distemper.</h2>
          <p class="emulsion-cta__body">
            A powder-format cow dung-based paint. Coverage <?= e($distemper['coverage']) ?>.
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

<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
<?php require ROOT_PATH . '/includes/footer.php';
