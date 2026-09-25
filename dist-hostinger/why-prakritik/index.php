<?php
/**
 * Gaurikrit Bio Products — Why Prakritik (V4 asset replacement pass).
 * Task V4-ASSETS.
 *
 * Composition unchanged from V3. This pass replaces coded SVG illustrations
 * with real editorial artwork. SVG kept only for interactive
 * ashta-laabh-seal.
 *
 * Illustrated editorial essay. Hero with zebu-study. Six numbered chapters
 * (each visually distinct):
 *   01 MATERIAL    — zebu-study.webp (1536×1024) large
 *   02 TRADITION    — courtyard-study.webp (1942×809) large
 *   03 MATERIAL TO WALL — 3-panel composition (interior + group + exterior)
 *   04 ASHTA        — full-size interactive ashta-laabh-seal SVG (kept)
 *   05 FORMATS      — real Distemper + Emulsion product photos
 *   06 CONTEXT      — rural-landscape.webp with annotation
 * CTA "Explore Products" → /products/.
 */
declare(strict_types=1);

$pageTitle       = 'Why Prakritik Paint — An Old Material, Reconsidered | Gaurikrit';
$pageDescription = 'Cow dung has been used on Indian walls for generations. Prakritik Paint carries that material into a contemporary paint format. The material, the tradition, the wall.';
$pageCanonical   = '/why-prakritik/';
$pageClass        = 'why-prakritik';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $MATERIAL_JOURNEY;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
$groupImage = '/assets/products/prakritik-group.jpg';

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

  /* ===== HERO (zebu-study) ===== */
  .why-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .why-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .why-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .why-hero__lockup { max-width: 42rem; }
  .why-hero__art {
    position: relative; aspect-ratio: 1536/1024;
    background: var(--limewash); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-hero__art .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  /* Remove the legacy cow/wall composition — single editorial photo replaces it. */
  .why-hero__art .why-cow,
  .why-hero__art .why-wall { display: none; }
  .why-hero__title { font-size: clamp(2.2rem, 5vw, 4rem); }

  /* ===== NUMBERED CHAPTERS ===== */
  .why-chapter {
    display: grid; gap: 2rem; padding-block: clamp(3.5rem, 6vw, 5rem);
  }
  @media (min-width: 1024px) {
    .why-chapter { grid-template-columns: 4fr 8fr; gap: 3rem; align-items: start; }
  }
  .why-chapter--reverse > :first-child { order: 2; }
  @media (min-width: 1024px) {
    .why-chapter--reverse > :first-child { order: 0; }
  }
  .why-chapter__num {
    font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700; color: var(--haldi-deep); line-height: 1;
  }
  .why-chapter__eyebrow {
    display: block; margin-top: 0.875rem; font-size: 0.75rem;
    font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--primary);
  }
  .why-chapter__title {
    margin-top: 0.5rem; font-family: var(--font-display);
    font-size: clamp(1.75rem, 4vw, 2.75rem); line-height: 1.1;
    letter-spacing: -0.02em; text-wrap: balance;
  }
  .why-chapter__body {
    margin-top: 1.25rem; color: var(--fg-muted);
    font-size: 1.0625rem; line-height: 1.75; max-width: 60ch;
  }
  .why-chapter__body p + p { margin-top: 1.25rem; }
  .why-chapter__pull {
    margin-top: 1.5rem; font-family: var(--font-display);
    font-style: italic; font-size: clamp(1.25rem, 2.5vw, 1.625rem);
    line-height: 1.4; color: var(--primary);
    padding-left: 1.5rem; border-left: 3px solid var(--haldi);
  }

  /* === Chapter 01 — MATERIAL: zebu-study large === */
  .why-material-sample {
    position: relative; aspect-ratio: 1536/1024;
    background: var(--paper); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-material-sample .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  /* Legacy patch element kept hidden — replaced by the editorial photo. */
  .why-material-sample__patch,
  .why-material-sample__tag { display: none; }

  /* === Chapter 02 — TRADITION: large courtyard === */
  .why-tradition-art {
    width: 100%; aspect-ratio: 1942/809;
    background: var(--limewash); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-tradition-art .editorial-image {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }

  /* === Chapter 03 — MATERIAL TO WALL: 3-panel composition === */
  .why-flow-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-flow-panels {
    display: grid; gap: 1rem; margin-top: 2rem;
    grid-template-columns: 1fr;
  }
  @media (min-width: 768px) {
    .why-flow-panels { grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; }
  }
  .why-flow-panel {
    position: relative;
    aspect-ratio: 1344/768;
    background: var(--limewash);
    overflow: hidden; border-radius: var(--r-panel);
  }
  .why-flow-panel--group { aspect-ratio: 1280/621; }
  .why-flow-panel .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  .why-flow-panel-label {
    position: absolute; left: 0.875rem; bottom: 0.875rem;
    background: rgba(250, 248, 241, 0.88);
    padding: 0.375rem 0.75rem;
    border-radius: var(--r-pill);
    font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--fg);
  }

  /* === Chapter 04 — ASHTA: full-size seal === */
  .why-ashta-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .ashta-section__seal { max-width: 38rem; margin-inline: auto; }

  /* === Chapter 05 — FORMATS: two real product visuals === */
  .why-formats-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-formats {
    display: grid; gap: 2rem; margin-top: 2rem;
  }
  @media (min-width: 768px) { .why-formats { grid-template-columns: 1fr 1fr; } }
  .why-format-card {
    position: relative;
    background: linear-gradient(160deg, var(--paper), var(--limewash));
    border: 1px solid var(--border); border-top: 3px solid var(--indigo);
    border-radius: var(--r-panel); overflow: hidden;
    display: flex; align-items: center; justify-content: center; padding: 1.5rem;
    min-height: 22rem;
  }
  .why-format-card--emulsion { border-top-color: var(--leaf); }
  .why-format-card .format-product {
    display: block;
    max-height: 26rem; max-width: 100%;
    width: auto; height: auto;
    object-fit: contain;
    filter: drop-shadow(0 14px 20px rgba(34, 36, 27, 0.16));
  }
  .why-format-card__caption {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.9); padding: 0.5rem 0.875rem;
    border-radius: var(--r-pill); font-size: 0.8125rem; font-weight: 600;
  }
  .why-format-card--distemper .why-format-card__caption { color: var(--indigo); }
  .why-format-card--emulsion  .why-format-card__caption { color: var(--leaf); }

  /* === Chapter 06 — CONTEXT: rural-landscape with annotation === */
  .why-context-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-context-band {
    position: relative; width: 100%; aspect-ratio: 1344/768;
    background: var(--limewash); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-context-band .editorial-image {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }
  .why-context-band__annot {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.88);
    padding: 0.5rem 0.875rem; border-radius: var(--r-pill);
    font-size: 0.75rem; font-weight: 600;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--fg-muted);
  }
</style>

<!-- ===== HERO ===== -->
<section class="why-hero bg-limewash" aria-labelledby="why-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Why Prakritik</span>
    </nav>
    <div class="why-hero__container" data-reveal>
      <div class="why-hero__lockup">
        <span class="why-hero__eyebrow"><span class="why-hero__eyebrow-dot" aria-hidden="true"></span>An old Indian material idea</span>
        <hr class="why-hero__rule">
        <h1 class="why-hero__title" id="why-title">An old material idea, reconsidered for modern walls.</h1>
        <p class="why-hero__sub">
          Cow dung has been used on Indian walls and floors for generations — as
          surface treatment, renewal ritual, and a quiet form of care. Prakritik
          Paint carries that material into a contemporary paint format.
        </p>
      </div>
      <div class="why-hero__art" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/zebu-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/zebu-study.jpg') ?>"
               alt="Editorial study of an Indian zebu cow"
               width="1536" height="1024"
               loading="eager" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ===== 01 MATERIAL ===== -->
<section class="section section--paper" aria-labelledby="chapter-01-title">
  <div class="container">
    <div class="why-chapter" data-reveal>
      <div>
        <span class="why-chapter__num">01</span>
        <span class="why-chapter__eyebrow">The material</span>
        <h2 class="why-chapter__title" id="chapter-01-title">A natural material for modern walls.</h2>
        <div class="why-chapter__body">
          <p>
            Cow dung has a long history of use on walls and floors in India.
          </p>
          <p>
            Gaurikrit offers cow dung-based Prakritik Paint in Distemper and Emulsion formats.
          </p>
        </div>
        <p class="why-chapter__pull">
          Not a novelty. A useful material, reconsidered.
        </p>
      </div>
      <div class="why-material-sample" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/zebu-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/zebu-study.jpg') ?>"
               alt=""
               width="1536" height="1024"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ===== 02 TRADITION — large courtyard ===== -->
<section class="section section--limewash" aria-labelledby="chapter-02-title">
  <div class="container">
    <div class="why-chapter why-chapter--reverse" data-reveal>
      <div class="why-tradition-art" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/courtyard-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/courtyard-study.jpg') ?>"
               alt="Indian limewashed courtyard elevation"
               width="1942" height="809"
               loading="lazy" decoding="async">
        </picture>
      </div>
      <div>
        <span class="why-chapter__num">02</span>
        <span class="why-chapter__eyebrow">The tradition</span>
        <h2 class="why-chapter__title" id="chapter-02-title">Limewashed walls, courtyard elevations.</h2>
        <div class="why-chapter__body">
          <p>
            Indian vernacular architecture is full of limewashed walls, plinths,
            verandahs, and rectangular openings — plaster, lime and earth.
          </p>
          <p>
            The courtyard study shows a wall surface in an everyday Indian setting.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== 03 MATERIAL TO WALL — 3-panel composition ===== -->
<section class="section section--paper why-flow-section" aria-labelledby="chapter-03-title">
  <div class="container">
    <div data-reveal>
      <span class="why-chapter__num">03</span>
      <span class="why-chapter__eyebrow">Material to wall</span>
      <h2 class="why-chapter__title" id="chapter-03-title">From a natural material to a finished wall.</h2>
      <p class="why-chapter__body">
        Natural material, Prakritik Paint, finished walls.
      </p>
    </div>
    <div class="why-flow-panels" data-reveal>
      <div class="why-flow-panel">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-wall-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/interior-wall-study.jpg') ?>"
               alt="Indian interior limewashed wall"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-flow-panel-label">01 · Natural material</span>
      </div>
      <div class="why-flow-panel why-flow-panel--group">
        <img class="editorial-image"
             src="<?= asset_url($groupImage) ?>"
             alt="Prakritik Distemper and Emulsion paint packs"
             width="1280" height="621"
             loading="lazy" decoding="async">
        <span class="why-flow-panel-label">02 · Prakritik Paint</span>
      </div>
      <div class="why-flow-panel">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/exterior-wall-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/exterior-wall-study.jpg') ?>"
               alt="Indian exterior wall"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-flow-panel-label">03 · Finished wall</span>
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

<!-- ===== 04 ASHTA — full-size seal (interactive SVG kept) ===== -->
<section class="section section--limewash why-ashta-section" aria-labelledby="chapter-04-title" data-ashta-laabh>
  <div class="container">
    <div class="why-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ</span>
      <h2 class="section-heading__title" id="chapter-04-title">Eight benefits.</h2>
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

<!-- ===== 05 FORMATS — real product visuals ===== -->
<section class="section section--paper why-formats-section" aria-labelledby="chapter-05-title">
  <div class="container">
    <div data-reveal>
      <span class="why-chapter__num">05</span>
      <span class="why-chapter__eyebrow">Two formats</span>
      <h2 class="why-chapter__title" id="chapter-05-title">Distemper and Emulsion.</h2>
      <p class="why-chapter__body">
        Two paint formats, one material idea. Both are listed for
        interior and exterior walls.
      </p>
    </div>

    <div class="why-formats" data-reveal-stagger>
      <div class="why-format-card why-format-card--distemper">
        <img class="format-product"
             src="<?= asset_url($distemper['officialImage']) ?>"
             alt="<?= e($distemper['name']) ?>"
             width="510" height="538"
             loading="lazy" decoding="async">
        <span class="why-format-card__caption"><?= e($distemper['packagingShort']) ?> packs</span>
      </div>
      <div class="why-format-card why-format-card--emulsion">
        <img class="format-product"
             src="<?= asset_url($emulsion['officialImage']) ?>"
             alt="<?= e($emulsion['name']) ?>"
             width="355" height="486"
             loading="lazy" decoding="async">
        <span class="why-format-card__caption"><?= e($emulsion['packagingShort']) ?> packs</span>
      </div>
    </div>
  </div>
</section>

<!-- ===== 06 CONTEXT — rural-landscape with annotation ===== -->
<section class="section section--limewash why-context-section" aria-labelledby="chapter-06-title">
  <div class="container">
    <div class="why-chapter" data-reveal>
      <div>
        <span class="why-chapter__num">06</span>
        <span class="why-chapter__eyebrow">Context</span>
        <h2 class="why-chapter__title" id="chapter-06-title">From Bulandshahr, Uttar Pradesh.</h2>
        <div class="why-chapter__body">
          <p>
            Prakritik Paint is made by <?= e($COMPANY['legalName']) ?>, in
            <?= e($COMPANY['address'][3] ?? '') ?>, <?= e($COMPANY['address'][4] ?? '') ?>.
            The company address is in Bulandshahr, Uttar Pradesh.
          </p>
        </div>
        <div class="mission-band__cta" style="margin-top: 1.5rem;">
          <a class="btn btn--primary" href="/products/">Explore Products</a>
          <a class="btn btn--outline" href="/about/">About Gaurikrit</a>
        </div>
      </div>
      <div class="why-context-band" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/rural-landscape.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/rural-landscape.jpg') ?>"
               alt="Indian rural landscape"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-context-band__annot"><?= e($COMPANY['address'][4] ?? '') ?>, <?= e($COMPANY['address'][5] ?? '') ?></span>
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
