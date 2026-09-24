<?php
/**
 * Gaurikrit Bio Products — Prakritik Distemper Product Detail (V3 rebuild).
 * Task V3-PAGES.
 *
 * Composition:
 *   - Pale chuna / indigo material environment (.product-detail--cool).
 *   - Hero: copy 5 / product 7 (image-handoff with bucket fallback).
 *   - Spec sheet: large ruled rows numbered 01-07 (NOT pills).
 *   - Coverage disclaimer.
 *   - Ashta Laabh grid.
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
  .product-detail__media {
    position: relative; aspect-ratio: 1;
    background: linear-gradient(160deg, var(--paper), var(--limewash));
    border: 1px solid var(--border); border-top: 3px solid var(--indigo);
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
    font-weight: 700; color: var(--indigo); opacity: 0.12;
    line-height: 1; pointer-events: none;
  }
  .product-detail__info { display: flex; flex-direction: column; gap: 0.75rem; }
  .product-detail__name { margin-top: 0.5rem; }
  .product-detail__descriptor { color: var(--indigo); }

  /* ===== SPEC SHEET (numbered 01-07 ruled rows, NOT pills) ===== */
  .distemper-specs-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 1.5rem; }
  .spec-sheet__list {
    grid-template-columns: 1fr;  /* override the 1fr 1fr default — single column for editorial feel */
  }

  /* ===== COVERAGE DISCLAIMER ===== */
  .coverage-disclaimer { margin-top: 2rem; border-left-color: var(--indigo); }

  /* ===== ASHTA LAABH GRID ===== */
  .distemper-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); }
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
          A powder-format cow dung-based paint, brushed on interior and exterior
          walls. Supplied in <?= e($product['packagingShort']) ?> packs.
        </p>
        <div class="distemper-hero__cta-row">
          <a class="btn btn--primary btn--lg"
             href="/contact/?interest=prakritik-distemper">Enquire About Distemper</a>
          <a class="btn btn--outline" href="/products/">View All Products</a>
        </div>
      </div>

      <div class="product-detail__media">
        <span class="product-detail__media__num" aria-hidden="true">01</span>
        <div class="product-media" data-official-image="<?= e($product['officialImage']) ?>">
          <img class="product-media__official"
               src="<?= e($product['officialImage']) ?>"
               alt="<?= e($product['name']) ?> pack"
               width="800" height="800" loading="eager" decoding="async">
          <div class="product-media__fallback">
            <?php render_illustration('prakritik-distemper-bucket'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SPEC SHEET (numbered 01-07 ruled rows) ===== -->
<section class="section section--paper distemper-specs-section" aria-labelledby="specs-title">
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
<section class="section section--limewash distemper-ashta-section" aria-labelledby="distemper-ashta-title" data-ashta-laabh>
  <div class="container">
    <div class="distemper-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ — Eight benefits</span>
      <h2 class="section-heading__title" id="distemper-ashta-title">Ashta Laabh.</h2>
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
            A liquid-format cow dung-based paint. Coverage <?= e($emulsion['coverage']) ?>.
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
