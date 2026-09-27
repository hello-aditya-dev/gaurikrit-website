<?php
/**
 * Gaurikrit Bio Products — Innovation (V16 NEW route /innovation/).
 *
 * The strategic research direction (§40):
 *   HERO       Where Tradition Meets Technology.
 *   FOCUS      01 Natural Coatings
 *              02 Biomass Energy
 *              03 Bio-Composites
 *              04 Carbon Reduction Technologies
 *              05 Sustainable Building Materials
 *   METHOD     How Gaurikrit explores materials (qualitative)
 *   CTA        Discuss a Collaboration → /for-business/
 *
 * These are FOCUS AREAS — research directions, NOT proven
 * accomplishments. No patents, no research papers, no facilities,
 * no scientists and no laboratory claims are invented (§40).
 * Visuals: material samples, process language, real product context.
 */
declare(strict_types=1);

$pageTitle       = 'Research & Innovation — Gaurikrit';
$pageDescription = 'Gaurikrit\'s research focus areas: natural coatings, biomass energy, bio-composites, carbon reduction technologies and sustainable building materials — where tradition meets technology.';
$pageCanonical   = '/innovation/';
$pageClass       = 'innovation';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $INNOVATION_AREAS;

$methodItems = [
    ['name' => 'Material-first',  'desc' => 'Each direction begins with a natural material and its properties, not a market template.'],
    ['name' => 'Application-led', 'desc' => 'Research is guided by real applications — walls, fuel, ritual and daily use.'],
    ['name' => 'Tradition-aware', 'desc' => 'Indian material traditions inform where technologies should serve, not erase.'],
    ['name' => 'Verified before published', 'desc' => 'Directions are shared as directions. Results are shared only once verified.'],
];
?>
<style>
  /* ===== PAGE HERO — story-hero (shared §42.11) + research composition ===== */
  .innov-hero__grid {
    display: grid; gap: clamp(2rem, 4vw, 4rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) { .innov-hero__grid { grid-template-columns: 6fr 6fr; } }
  .innov-hero__composition { margin: 0; position: relative; }
  .innov-hero__composition img {
    display: block; width: 100%; height: auto; border-radius: 0.1875rem;
  }
  .innov-hero__composition figcaption {
    margin-top: 0.875rem; font-size: 0.75rem; color: var(--fg-muted);
    letter-spacing: 0.02em;
  }

  /* ===== FOCUS ROWS — shared §42.8 structure, page-local head only. ===== */
  .innov-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== METHOD — quiet numbered rows (shared measure-list language). ===== */
</style>

<!-- ============================================================
     HERO — Where Tradition Meets Technology.
     ============================================================ -->
<section class="story-hero bg-limewash" aria-labelledby="innov-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Innovation</span>
    </nav>
    <div class="innov-hero__grid" data-reveal>
      <div>
        <span class="eyebrow">Research &amp; Innovation</span>
        <h1 class="story-hero__title" id="innov-title">Where Tradition Meets Technology.</h1>
        <p class="story-hero__lead">
          Gaurikrit's research direction explores how a natural material
          understood by tradition can be developed with contemporary methods —
          into coatings, fuels, composites and building materials.
        </p>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--primary" href="#focus-areas">The Five Focus Areas</a>
          <a class="btn btn--secondary" href="/sustainability/">Sustainability</a>
        </div>
      </div>
      <figure class="innov-hero__composition" role="img"
              aria-label="Material research samples — raw biomass, processed log and finished coating on one studio sweep">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('innovation-research', [960, 1280, 1920, 2560]) ?>"
                  sizes="(min-width: 1024px) 48vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('innovation-research', [960, 1280, 1920, 2560]) ?>"
                  sizes="(min-width: 1024px) 48vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/innovation-research-1280.jpg') ?>"
               alt="Material research samples — raw biomass, processed log and finished coating"
               width="1280" height="800"
               loading="eager" fetchpriority="high" decoding="async">
        </picture>
        <figcaption>Raw material · processed biomass · finished coating — one research line.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     FOCUS AREAS — five horizontal rows (§40)
     Directions, not accomplishments. No patents, no fake labs.
     ============================================================ -->
<section class="section section--paper" id="focus-areas" aria-labelledby="focus-title">
  <div class="container">
    <div class="innov-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Focus Areas</span>
      <h2 class="section-heading__title" id="focus-title">Five directions under exploration.</h2>
      <p class="section-heading__desc">
        These are FOCUS AREAS — research directions. They are not presented as
        proven accomplishments, patents or facilities.
      </p>
    </div>
    <div class="focus-rows" data-reveal-stagger>
      <?php foreach ($INNOVATION_AREAS as $focus): ?>
        <div class="focus-row">
          <span class="focus-row__num" aria-hidden="true"><?= e($focus['num']) ?></span>
          <h3 class="focus-row__name"><?= e($focus['name']) ?></h3>
          <p class="focus-row__desc"><?= e($focus['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     METHOD — how Gaurikrit explores materials (qualitative)
     ============================================================ -->
<section class="section section--haldi-wash" id="method" aria-labelledby="method-title">
  <div class="container">
    <div class="innov-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">How we explore</span>
      <h2 class="section-heading__title" id="method-title">Material-first, application-led.</h2>
    </div>
    <div class="measure-list" data-reveal-stagger>
      <?php foreach ($methodItems as $item): ?>
        <div class="measure-item">
          <span class="measure-item__name"><?= e($item['name']) ?></span>
          <p class="measure-item__desc"><?= e($item['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     ECO-PAINTS CONTEXT — the documented research outcome (real
     product photography; where the direction became products)
     ============================================================ -->
<section class="section section--paper" id="documented" aria-labelledby="doc-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">01</span>
        <span class="story-chapter__kicker">Documented outcome</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="doc-title">Eco-Paints — where the direction became products.</h2>
        <div class="story-chapter__body">
          <p>
            The natural-coatings focus is the most developed: Prakritik
            Distemper and Prakritik Emulsion are documented, specified
            products — the reference point for how a research direction
            becomes a Gaurikrit family.
          </p>
        </div>
        <figure class="story-chapter__visual">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('eco-paints-pair', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 42vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('eco-paints-pair', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 42vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/eco-paints-pair-1280.jpg') ?>"
                 alt="Prakritik Distemper and Emulsion paint packs — the documented Eco-Paints outcome"
                 width="1280" height="800"
                 loading="lazy" decoding="async">
          </picture>
          <figcaption>Prakritik Distemper and Emulsion — the documented Eco-Paints family.</figcaption>
        </figure>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--secondary" href="/products/#eco-paints">Explore Eco-Paints</a>
          <a class="btn btn--outline" href="/why-prakritik/">Why Prakritik</a>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     CTA — Discuss a Collaboration (§40)
     ============================================================ -->
<section class="section section--forest" aria-labelledby="collab-title">
  <div class="container">
    <div class="why-cta" data-reveal>
      <span class="why-cta__eyebrow">Collaboration</span>
      <h2 class="why-cta__title" id="collab-title">Discuss a Collaboration.</h2>
      <p class="why-cta__sub">
        Research programmes, institutions and sustainability partners —
        talk to Gaurikrit about material directions and collaboration.
      </p>
      <div class="why-cta__actions">
        <a class="btn btn--haldi" href="/for-business/">Become a Partner</a>
        <a class="btn btn--secondary" href="/contact/">Contact Gaurikrit</a>
      </div>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
