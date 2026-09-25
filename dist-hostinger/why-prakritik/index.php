<?php
/**
 * Gaurikrit Bio Products — Why Prakritik (V3 rebuild).
 * Task V3-PAGES.
 *
 * Illustrated editorial essay. Hero with Indian cow + real wall/material
 * sample. Six numbered chapters (each visually distinct):
 *   01 MATERIAL    — physical material sample graphic
 *   02 TRADITION   — large indian-courtyard illustration
 *   03 MATERIAL TO WALL — full-width material-to-wall diagram
 *   04 ASHTA       — full-size ashta-laabh-seal
 *   05 FORMATS     — real Distemper + Emulsion product visual (image-handoff)
 *   06 CONTEXT     — rural-landscape with annotations
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
  /* ===== HERO (cow + wall sample) ===== */
  .why-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .why-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .why-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .why-hero__lockup { max-width: 42rem; }
  .why-hero__art {
    position: relative; aspect-ratio: 5/4; background: var(--limewash);
    border-radius: var(--r-panel); overflow: hidden;
    display: flex; align-items: center; justify-content: center;
  }
  .why-hero__art .why-cow {
    position: absolute; left: 6%; bottom: 8%; width: 46%; opacity: 0.85;
  }
  .why-hero__art .why-wall {
    position: absolute; right: 8%; top: 8%; bottom: 8%; width: 42%;
    background: linear-gradient(135deg, var(--limewash), color-mix(in srgb, var(--kraft) 35%, var(--limewash)));
    overflow: hidden;
  }
  .why-hero__art .why-wall::after {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(circle at 1px 1px, rgba(32, 30, 25, 0.08) 0.5px, transparent 0);
    background-size: 14px 14px;
  }
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

  /* === Chapter 01 — MATERIAL: physical material sample === */
  .why-material-sample {
    position: relative; aspect-ratio: 4/3;
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); overflow: hidden; padding: 2rem;
  }
  .why-material-sample__patch {
    position: absolute; left: 12%; top: 12%; right: 12%; bottom: 12%;
    background:
      radial-gradient(ellipse 70% 60% at 40% 35%, var(--mitti) 0%, color-mix(in srgb, var(--mitti) 80%, var(--charcoal)) 65%, transparent 92%),
      linear-gradient(135deg, var(--kraft), var(--mitti));
    border-radius: 4px;
  }
  .why-material-sample__patch::after {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(circle at 1px 1px, rgba(32, 30, 25, 0.12) 0.5px, transparent 0);
    background-size: 12px 12px;
  }
  .why-material-sample__tag {
    position: absolute; bottom: 1rem; left: 1rem;
    font-family: var(--font-display); font-style: italic;
    font-size: 0.875rem; color: var(--fg-muted);
    background: rgba(250, 248, 241, 0.85); padding: 0.25rem 0.75rem;
    border-radius: var(--r-pill);
  }

  /* === Chapter 02 — TRADITION: large courtyard === */
  .why-tradition-art {
    width: 100%; aspect-ratio: 16/9;
    background: var(--limewash); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-tradition-art svg { width: 100%; height: 100%; display: block; }

  /* === Chapter 03 — MATERIAL TO WALL: full-width diagram === */
  .why-flow-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-flow-svg { width: 100%; margin-inline: 0; }
  .why-flow-svg svg { width: 100%; height: auto; display: block; }

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
    position: relative; aspect-ratio: 4/5;
    background: linear-gradient(160deg, var(--paper), var(--limewash));
    border: 1px solid var(--border); border-top: 3px solid var(--indigo);
    border-radius: var(--r-panel); overflow: hidden;
    display: flex; align-items: center; justify-content: center; padding: 2rem;
  }
  .why-format-card--emulsion { border-top-color: var(--leaf); }
  .why-format-card .product-media { width: 100%; height: 100%; }
  .why-format-card .product-media__official { object-fit: contain; padding: 1.5rem; }
  .why-format-card__caption {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.9); padding: 0.5rem 0.875rem;
    border-radius: var(--r-pill); font-size: 0.8125rem; font-weight: 600;
  }
  .why-format-card--distemper .why-format-card__caption { color: var(--indigo); }
  .why-format-card--emulsion  .why-format-card__caption { color: var(--leaf); }

  /* === Chapter 06 — CONTEXT: rural-landscape with annotations === */
  .why-context-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-context-band {
    position: relative; width: 100%; aspect-ratio: 16/5;
    background: var(--limewash); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-context-band svg { width: 100%; height: 100%; display: block; }
  .why-context-band__annot {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.85);
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
        <img class="editorial-cow" src="/assets/illustrations/zebu-study.jpg" alt="" width="1536" height="1024">
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
        <img class="editorial-cow" src="/assets/illustrations/zebu-study.jpg" alt="" loading="lazy" width="1536" height="1024">
      </div>
    </div>
  </div>
</section>

<!-- ===== 02 TRADITION — large courtyard ===== -->
<section class="section section--limewash" aria-labelledby="chapter-02-title">
  <div class="container">
    <div class="why-chapter why-chapter--reverse" data-reveal>
      <div class="why-tradition-art" aria-hidden="true">
        <img class="editorial-courtyard" src="/assets/illustrations/courtyard-study.jpg" alt="" loading="lazy" width="1942" height="809">
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

<!-- ===== 03 MATERIAL TO WALL — full-width diagram ===== -->
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
    <div class="why-flow-svg" data-reveal>

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

<!-- ===== 04 ASHTA — full-size seal ===== -->
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
        <div class="product-media" data-official-image="<?= e($distemper['officialImage']) ?>">
          <img class="product-media__official"
               src="<?= e($distemper['officialImage']) ?>"
               alt="<?= e($distemper['name']) ?> pack"
               width="600" height="750" loading="lazy" decoding="async">
          <div class="product-media__fallback">
            <?php render_illustration('prakritik-distemper-bucket'); ?>
          </div>
        </div>
        <span class="why-format-card__caption"><?= e($distemper['packagingShort']) ?> packs</span>
      </div>
      <div class="why-format-card why-format-card--emulsion">
        <div class="product-media" data-official-image="<?= e($emulsion['officialImage']) ?>">
          <img class="product-media__official"
               src="<?= e($emulsion['officialImage']) ?>"
               alt="<?= e($emulsion['name']) ?> pack"
               width="600" height="750" loading="lazy" decoding="async">
          <div class="product-media__fallback">
            <?php render_illustration('prakritik-emulsion-bucket'); ?>
          </div>
        </div>
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
        <?php render_illustration('rural-landscape'); ?>
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
