<?php
/**
 * Gaurikrit Bio Products — Homepage (V18 client-asset integration).
 *
 * THE STORY: one natural resource → multiple useful material solutions →
 * one circular-economy mission. A visitor understands the company from
 * this page alone (§74 story test).
 *
 * Section order (V18 §39) — exact:
 *   01 HERO                    limewash      TWO real objects: Prakritik
 *                                           pair (main) + client-supplied
 *                                           cow-dung-log plate (secondary)
 *   02 FROM WASTE TO RESOURCE  paper         RAW MATERIAL → MATERIAL
 *                                           DEVELOPMENT → USEFUL APPLICATIONS
 *   03 ONE RESOURCE, FOUR      haldi-wash    2×2 editorial chapters;
 *      DIRECTIONS                           Eco-Paints + GoCast = real
 *                                           client imagery; Bio-Coal +
 *                                           Utility = type/material plates
 *   04 NOTHING GOES TO WASTE   paper         7-stage continuous circular
 *                                           loop, progressive highlight
 *   05 DOCUMENTED ECO-PAINT    cool-wash     real pair plate + the two
 *      FAMILY                                documented formats + colour &
 *                                           tool links
 *   06 RESEARCH & INNOVATION   limewash      5 focus areas → /innovation/;
 *                                           real material samples
 *   07 VISION + MISSION        forest        two columns
 *   08 PARTNERSHIP CTA         paper         audience strip + 2 CTAs
 *   09 FOOTER                  forest        (shared include)
 *
 * Factual data unchanged from data.php. No invented metrics, dates,
 * facilities, partners or certifications.
 */
declare(strict_types=1);

$pageTitle       = 'Gaurikrit — Circular Material Solutions from Natural Resources';
$pageDescription = 'Gaurikrit builds a material ecosystem around one natural resource — cow dung — from Prakritik Eco-Paints to GoCast and Bio-Coal fuel directions and utility products. Circular economy from Khurja, Uttar Pradesh.';
$pageCanonical   = '/';
$pageClass       = 'home';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $FAMILIES, $CIRCULAR_STAGES, $PRODUCTS,
       $INNOVATION_AREAS, $PARTNER_AUDIENCES;

// V20 — hero transitioning product showcase. Four client-supplied
// product directions (originals dated 2026-10-16, stored untouched in
// source-assets/client-originals/). Derived responsive ladders live in
// assets/images/ecosystem/hero-<slug>-<W>.{avif,webp,jpg} and are emitted
// through the same eco_srcset()/eco_srcset_webp() helpers as the rest of
// the V19 image system. Each width is the ACTUAL pixel width of that
// file, so the srcset w-descriptor stays truthful — the portrait utility
// poster therefore advertises 426w / 853w (not a long-edge label).
$HERO_SLIDES = [
  ['stem'=>'hero-eco-paints',           'widths'=>[640,1280], 'w'=>1280,'h'=>853,
   'label'=>'Eco-Paints',          'sub'=>'Prakritik Paint family',
   'alt'=>'Three Prakritik Paint buckets — Emulsion, Emulsion and Distemper — eco-friendly cow dung paint by Gaurikrit'],
  ['stem'=>'hero-bio-coal-logs',        'widths'=>[640,1024], 'w'=>1024,'h'=>1024,
   'label'=>'Bio-Coal Logs',       'sub'=>'Bio-Briquettes',
   'alt'=>'Gaurikrit Bio-Briquettes — premium renewable biomass fuel, cylindrical hollow briquettes'],
  ['stem'=>'hero-cow-dung-logs',        'widths'=>[640,1024], 'w'=>1024,'h'=>1024,
   'label'=>'Cow-Dung Logs',       'sub'=>'Premium biomass fuel',
   'alt'=>'Gaurikrit Cow-Dung Logs — premium biomass fuel for havan, crematorium, boiler and industrial use'],
  ['stem'=>'hero-eco-utility-products','widths'=>[426,853],  'w'=>853, 'h'=>1280,
   'label'=>'Eco Utility Products','sub'=>'Dhoop, diyas, plates, cups',
   'alt'=>'Gaurikrit Eco Utility Products — dhoop cups, cow-dung diyas, biodegradable plates and eco glasses'],
];
$HERO_SIZES = '(min-width: 1200px) 58vw, (min-width: 900px) 50vw, calc(100vw - 2.5rem)';
?>
<style>
  /* ===== 01. HERO — story lockup 5 / one composed photograph 7 ===== */
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
  .hero__title { font-size: clamp(2.375rem, 5.5vw, 5rem); line-height: 1.04; }
  .hero__body { max-width: 40rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V20 — transitioning product showcase. One stable 4/3 frame (no
     layout shift), four client product posters crossfade inside it on
     object-fit:contain so every label, pack and claim stays fully
     visible (no cropping of factual identity). Captions + dots +
     arrows sit below the frame. Autoplay/pause/keyboard/reduced-motion
     behaviour is in assets/js/hero-carousel.js. */
  .hero-showcase { position: relative; }
  .hero-showcase__frame {
    position: relative;
    aspect-ratio: 4 / 3;
    background: var(--paper-warm);
    border: 1px solid var(--border);
    border-radius: 0.25rem;
    box-shadow: 0 1px 2px rgba(32,30,25,0.06), 0 10px 28px -14px rgba(32,30,25,0.18);
    overflow: hidden;
  }
  .hero-showcase__track { position: absolute; inset: 0; }
  .hero-showcase__slide {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    margin: 0; padding: clamp(0.875rem, 2.2vw, 1.75rem);
    opacity: 0; visibility: hidden;
    transition: opacity 0.9s cubic-bezier(0.22,1,0.36,1), visibility 0s linear 0.9s;
    pointer-events: none;
  }
  .hero-showcase__slide[aria-hidden="false"] {
    opacity: 1; visibility: visible;
    transition: opacity 0.9s cubic-bezier(0.22,1,0.36,1), visibility 0s;
    pointer-events: auto;
  }
  .hero-showcase__slide picture { display: block; max-width: 100%; max-height: 100%; margin: 0; }
  .hero-showcase__slide img {
    display: block; max-width: 100%; max-height: 100%;
    width: auto; height: auto; margin: 0 auto;
    border-radius: 0.125rem;
  }
  .hero-showcase__controls {
    display: flex; align-items: center; justify-content: space-between;
    gap: 0.75rem 1.25rem; margin-top: 1rem; flex-wrap: wrap;
  }
  .hero-showcase__caption { display: flex; flex-direction: column; gap: 0.0625rem; min-width: 0; }
  .hero-showcase__label {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--forest);
  }
  .hero-showcase__sub {
    font-size: 0.75rem; font-weight: 500; letter-spacing: 0.02em;
    color: var(--fg-muted);
  }
  .hero-showcase__dots { display: flex; gap: 0.4375rem; align-items: center; }
  .hero-showcase__dot {
    width: 0.5rem; height: 0.5rem; padding: 0; margin: 0; border: 0;
    border-radius: 999px; background: var(--border-strong);
    cursor: pointer; appearance: none; -webkit-appearance: none;
    transition: background 0.3s ease, width 0.3s ease;
  }
  .hero-showcase__dot[aria-selected="true"] { background: var(--forest); width: 1.5rem; }
  .hero-showcase__dot:focus-visible { outline: 2px solid var(--haldi); outline-offset: 3px; }
  .hero-showcase__arrows { display: flex; gap: 0.5rem; }
  .hero-showcase__arrow {
    width: 2.25rem; height: 2.25rem; display: inline-flex;
    align-items: center; justify-content: center;
    border: 1px solid var(--border-strong); border-radius: 999px;
    background: var(--paper); color: var(--forest);
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
  }
  .hero-showcase__arrow:hover { background: var(--forest); color: var(--paper); border-color: var(--forest); }
  .hero-showcase__arrow:focus-visible { outline: 2px solid var(--haldi); outline-offset: 2px; }
  .hero-showcase__arrow svg { width: 1.125rem; height: 1.125rem; }
  @media (prefers-reduced-motion: reduce) {
    .hero-showcase__slide,
    .hero-showcase__dot,
    .hero-showcase__arrow { transition: none; }
  }
  @media (max-width: 560px) {
    .hero-showcase__controls { flex-direction: column; align-items: center; gap: 0.875rem; }
    .hero-showcase__caption { order: 1; align-items: center; }
    .hero-showcase__dots { order: 2; }
    .hero-showcase__arrows { order: 3; }
    .hero-showcase__arrow { width: 2.75rem; height: 2.75rem; }
    .hero-showcase__dot { width: 0.625rem; height: 0.625rem; }
    .hero-showcase__dot[aria-selected="true"] { width: 1.75rem; }
  }

  /* ===== 02. RESOURCE STEPS — one frame system for all three (§28) ===== */
  .resource-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 03. FOUR SOLUTIONS — page-local rhythm (structure §42.3) ===== */
  .families-section__head { max-width: 48rem; margin-bottom: 2.75rem; }

  /* ===== 04. CIRCULAR MODEL — page-local rhythm (structure §42.4) ===== */
  .circular-section__head { max-width: 48rem; margin-bottom: 2.75rem; }

  /* ===== 05. DOCUMENTED ECO-PAINT FAMILY — page-local rhythm ===== */
  .eco-documented .section-heading { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 06. INNOVATION TEASER — one research composition (§33) ===== */
  .innov-teaser__grid {
    display: grid; grid-template-columns: 1fr; gap: 2.5rem; align-items: center;
  }
  @media (min-width: 1024px) { .innov-teaser__grid { grid-template-columns: 5fr 7fr; gap: 3.5rem; } }
  .innov-composition { margin: 0; }
  .innov-composition img {
    width: 100%; height: auto; display: block; border-radius: 0.1875rem;
  }
  .innov-composition__captions {
    display: flex; gap: 1rem; margin-top: 0.875rem;
  }
  .innov-composition__caption {
    flex: 1; font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted);
    padding-top: 0.5rem; border-top: 1px solid var(--border);
  }
  .innov-composition__caption em {
    display: block; font-style: normal; font-weight: 500; letter-spacing: 0.04em;
    color: var(--fg-muted); opacity: 0.75; margin-top: 0.1875rem;
    text-transform: none; font-size: 0.6875rem;
  }

  /* ===== 08. PARTNERSHIP — page-local rhythm ===== */
  .partnership__head { max-width: 48rem; margin-bottom: 1.5rem; }
</style>

<!-- ============================================================
     01. HERO — one resource, many applications (§13–14)
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
        <h1 class="hero__title" id="hero-title">
          Reimagining cow dung as a resource for sustainable living.
        </h1>
        <p class="hero__body">
          Nature provides the resource. Gaurikrit explores how cow dung can be
          carried into practical material solutions — from Prakritik Paint to
          fuel and utility applications.
        </p>
        <div class="hero__ctas">
          <a class="btn btn--primary btn--lg" href="/products/">Explore the Ecosystem</a>
          <a class="btn btn--secondary btn--lg" href="/about/">Our Story</a>
        </div>
      </div>

      <!-- V20 — transitioning product showcase. Four client-supplied
           product directions (2026-10-16 originals) crossfade inside one
           stable 4/3 frame. Autoplay 5s, pause on hover/focus, prev/next,
           dots, ArrowLeft/Right keyboard, prefers-reduced-motion aware
           (no autoplay, instant switching). See assets/js/hero-carousel.js. -->
      <div class="hero__visual" data-reveal>
        <div class="hero-showcase" data-hero-carousel
             role="region" aria-roledescription="carousel"
             aria-label="Gaurikrit product showcase — four natural-resource directions"
             data-autoplay="5000" tabindex="0">
          <div class="hero-showcase__frame">
            <div class="hero-showcase__track">
<?php foreach ($HERO_SLIDES as $i => $s):
  $is_active = $i === 0; ?>
              <figure class="hero-showcase__slide" role="group"
                      aria-label="Slide <?= $i + 1 ?> of <?= count($HERO_SLIDES) ?>: <?= e($s['label']) ?>"
                      aria-hidden="<?= $is_active ? 'false' : 'true' ?>"
                      data-slide="<?= $i ?>"
                      data-label="<?= e($s['label']) ?>"
                      data-sub="<?= e($s['sub']) ?>">
                <picture>
                  <source type="image/avif"
                          srcset="<?= eco_srcset($s['stem'], $s['widths']) ?>"
                          sizes="<?= $HERO_SIZES ?>">
                  <source type="image/webp"
                          srcset="<?= eco_srcset_webp($s['stem'], $s['widths']) ?>"
                          sizes="<?= $HERO_SIZES ?>">
                  <img src="<?= asset_url('/assets/images/ecosystem/' . $s['stem'] . '-' . end($s['widths']) . '.jpg') ?>"
                       alt="<?= e($s['alt']) ?>"
                       width="<?= $s['w'] ?>" height="<?= $s['h'] ?>"
                       <?= $is_active ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"' ?>
                       decoding="async">
                </picture>
              </figure>
<?php endforeach; ?>
            </div>
          </div>

          <div class="hero-showcase__controls">
            <span class="hero-showcase__caption" data-hero-caption>
              <span class="hero-showcase__label"><?= e($HERO_SLIDES[0]['label']) ?></span>
              <span class="hero-showcase__sub"><?= e($HERO_SLIDES[0]['sub']) ?></span>
            </span>
            <div class="hero-showcase__dots" role="tablist" aria-label="Choose product direction">
<?php foreach ($HERO_SLIDES as $i => $s): ?>
              <button type="button" class="hero-showcase__dot" role="tab"
                      aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                      aria-label="Show <?= e($s['label']) ?>"
                      data-dot="<?= $i ?>"></button>
<?php endforeach; ?>
            </div>
            <div class="hero-showcase__arrows">
              <button type="button" class="hero-showcase__arrow" data-hero-prev
                      aria-label="Previous product direction">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
              </button>
              <button type="button" class="hero-showcase__arrow" data-hero-next
                      aria-label="Next product direction">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     02. FROM WASTE TO RESOURCE — the Gaurikrit story (§15–16)
     ============================================================ -->
<section class="section section--paper resource-section" aria-labelledby="resource-title">
  <div class="container">
    <div class="resource-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Gaurikrit Story</span>
      <h2 class="section-heading__title" id="resource-title">From Waste to Resource.</h2>
      <p class="section-heading__desc">
        Traditional India has long recognised cow dung as a useful material.
        Gaurikrit's direction is to carry that resource into practical
        contemporary applications — from naturally derived material to products
        for walls, energy and everyday use.
      </p>
    </div>

    <div class="resource-steps" data-reveal-stagger>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('rawmat', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('rawmat', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/rawmat-960.jpg') ?>"
                 alt="Raw material — natural biomass with straw fibre"
                 width="960" height="549" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 01</span>
          <h3 class="resource-step__title">Raw Material</h3>
          <p class="resource-step__desc">
            Cow dung — a natural material long valued in traditional Indian homes.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('material-development', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('material-development', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/material-development-960.jpg') ?>"
                 alt="Prakritik Distemper paint pack — developed material product with studio context"
                 width="960" height="640" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 02</span>
          <h3 class="resource-step__title">Material Development</h3>
          <p class="resource-step__desc">
            The resource is processed and developed into useful working materials.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('colours-wall', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('colours-wall', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/colours-wall-960.jpg') ?>"
                 alt="Finished limewash wall in a furnished room — a useful application"
                 width="960" height="549" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 03</span>
          <h3 class="resource-step__title">Useful Applications</h3>
          <p class="resource-step__desc">
            Products and material directions for walls, energy and everyday use.
          </p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     03. ONE RESOURCE, FOUR SOLUTIONS — the ecosystem (§17–18)
     Editorial chapters, NOT SaaS cards. Eco-Paints uses REAL
     photography; the other families are honest type/material plates.
     ============================================================ -->
<section class="section section--haldi-wash families-section" aria-labelledby="families-title">
  <div class="container">
    <div class="families-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Gaurikrit Ecosystem</span>
      <h2 class="section-heading__title" id="families-title">One resource. Four directions.</h2>
      <p class="section-heading__desc">
        Cow dung is the shared material beginning. Gaurikrit develops it in four
        directions — Eco-Paints is the documented family; the others are
        development directions presented without invented products.
      </p>
    </div>

    <div class="families" data-reveal-stagger>
<?php
      // V20 §29-30: every family now carries REAL client-supplied
      // imagery — Eco-Paints and GoCast client photography, plus the
      // 2026-10-16 client product posters for Bio-Coal (Bio-Briquettes)
      // and Utility (Eco Utility Products). Each visual is a clean 3/2
      // crop that preserves product identity and label text; the
      // "Category visual" honesty tag is no longer needed for the two
      // upgraded cards. One art-direction system: 3:2 frames, warm
      // backgrounds, consistent density.
      $familyMedia = [
          'eco-paints'        => ['stem' => 'eco-paints-pair', 'ladder' => [640, 960, 1280, 1920],
                                  'alt' => 'Prakritik Distemper and Prakritik Emulsion paint packs - the documented Eco-Paints family',
                                  'representative' => false],
          'gocast-logs'       => ['stem' => 'gocast-editorial', 'ladder' => [640, 960, 1280, 1920],
                                  'alt' => 'Client-supplied cow-dung logs on a terracotta plate with straw',
                                  'representative' => false],
          'bio-coal-logs'     => ['stem' => 'family-bio-coal-logs', 'ladder' => [640, 960, 1024],
                                  'alt' => 'Client-supplied Gaurikrit Bio-Briquettes product poster — premium renewable biomass fuel',
                                  'representative' => false],
          'utility-products'  => ['stem' => 'family-eco-utility-products', 'ladder' => [640, 853],
                                  'alt' => 'Client-supplied Gaurikrit Eco Utility Products poster — dhoop cups, cow-dung diyas, biodegradable plates and eco glasses',
                                  'representative' => false],
      ];
      foreach ($FAMILIES as $family): ?>
        <article class="family" id="family-<?= e($family['id']) ?>">
          <?php $m = $familyMedia[$family['id']]; ?>
          <figure class="family__media family__media--photo">
            <picture>
              <source type="image/avif" srcset="<?= eco_srcset($m['stem'], $m['ladder']) ?>"
                      sizes="(min-width: 768px) 45vw, calc(100vw - 2.5rem)">
              <source type="image/webp" srcset="<?= eco_srcset_webp($m['stem'], $m['ladder']) ?>"
                      sizes="(min-width: 768px) 45vw, calc(100vw - 2.5rem)">
              <img src="<?= asset_url('/assets/images/ecosystem/' . $m['stem'] . '-' . max($m['ladder']) . '.jpg') ?>"
                   alt="<?= e($m['alt']) ?>"
                   width="960" height="640" loading="lazy" decoding="async">
            </picture>
            <?php if ($m['representative']): ?>
              <span class="family__media-note">Category visual</span>
            <?php endif; ?>
          </figure>

          <div class="family__head">
            <span class="family__num" aria-hidden="true"><?= e($family['num']) ?></span>
            <h3 class="family__name"><?= e($family['name']) ?></h3>
          </div>
          <p class="family__line"><?= e($family['line']) ?></p>
          <p class="family__desc"><?= e($family['desc']) ?></p>
          <p class="family__meta">
            <span class="family__status<?= $family['status'] === 'Documented family' ? '' : ' family__status--direction' ?>">
              <?= e($family['status']) ?>
            </span>
          </p>
          <ul class="family__themes">
            <?php foreach ($family['themes'] as $theme): ?>
              <li><?= e($theme) ?></li>
            <?php endforeach; ?>
          </ul>
          <a class="family__cta" href="<?= e($family['href']) ?>">
            Explore <?= e($family['name']) ?> <span aria-hidden="true">→</span>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     04. A CIRCULAR MATERIAL DIRECTION — the circular model (§19–20)
     One continuous loop. Progressive highlight via story.js
     (progressive enhancement — everything readable without JS).
     ============================================================ -->
<section class="section section--paper circular-section" aria-labelledby="circular-title">
  <div class="container">
    <div class="circular-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Circular Model</span>
      <h2 class="section-heading__title" id="circular-title">A Circular Material Direction.</h2>
      <p class="section-heading__desc">
        One continuous cycle: the resource enters, is developed, becomes useful
        products — and the material cycle continues.
      </p>
    </div>

    <div class="circular" data-circular data-reveal>
      <ol class="circular__track">
        <?php foreach ($CIRCULAR_STAGES as $stage): ?>
          <li class="stage">
            <span class="stage__num"><?= e($stage['num']) ?></span>
            <h3 class="stage__name"><?= e($stage['name']) ?></h3>
            <p class="stage__desc"><?= e($stage['desc']) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
      <!-- The return path — the material cycle continues. -->
      <svg class="circular__loop-path" viewBox="0 0 1000 28" preserveAspectRatio="none" aria-hidden="true">
        <path d="M8,2 L8,20 C8,26 16,26 26,26 L974,26 C984,26 992,26 992,20 L992,10" />
      </svg>
      <span class="circular__loop-label" aria-hidden="true">The material cycle continues</span>
    </div>
  </div>
</section>

<!-- ============================================================
     05. THE DOCUMENTED ECO-PAINT FAMILY (V18 §39.05)
     The proven outcome: real pair photography + the two documented
     formats with their supplied specifications + colour + tool links.
     Ruled editorial rows, NOT a product-card grid.
     ============================================================ -->
<section class="section section--cool eco-documented" aria-labelledby="eco-documented-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Documented Family</span>
      <h2 class="section-heading__title" id="eco-documented-title">
        Eco-Paints, documented end to end.
      </h2>
      <p class="section-heading__desc">
        The one family with full product documentation — two formats, supplied
        specifications, real client photography and a shade catalogue.
      </p>
    </div>

    <div class="eco-documented__grid" data-reveal-stagger>
      <figure class="eco-documented__plate">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('eco-paints-pair', [640, 960, 1280, 1920]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('eco-paints-pair', [640, 960, 1280, 1920]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/eco-paints-pair-1280.jpg') ?>"
               alt="Prakritik Distemper and Prakritik Emulsion paint packs"
               width="1280" height="800" loading="lazy" decoding="async">
        </picture>
      </figure>

      <div class="eco-documented__rows">
        <?php foreach ($PRODUCTS as $product): ?>
          <div class="eco-documented__row">
            <h3 class="eco-documented__row-name">
              <a href="<?= e($product['route']) ?>"><?= e($product['name']) ?></a>
            </h3>
            <p class="eco-documented__row-meta">
              <strong><?= e($product['packagingShort']) ?></strong> ·
              <?= e($product['colour']) ?> · <?= e($product['finish']) ?> ·
              <?= e($product['coverage']) ?>
            </p>
            <a class="eco-documented__row-cta" href="<?= e($product['route']) ?>">
              View specifications <span aria-hidden="true">→</span>
            </a>
          </div>
        <?php endforeach; ?>
        <div class="eco-documented__links">
          <a href="/colours/">Explore Colours</a>
          <a href="/paint-calculator/">Painting Calculator</a>
          <a href="/why-prakritik/">Why Prakritik?</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     06. RESEARCH & INNOVATION — focus areas teaser (§25 / §28)
     Real material samples — paint + cow-dung log material — showing
     material → application.
     ============================================================ -->
<section class="section section--limewash innov-teaser" aria-labelledby="innov-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Research &amp; Innovation</span>
      <h2 class="section-heading__title" id="innov-title">Where Tradition Meets Technology.</h2>
    </div>
    <div class="innov-teaser__grid" data-reveal>
      <figure class="innov-composition" aria-label="Material research samples — raw biomass, processed log and finished coating">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('innovation-research', [640, 960, 1280, 1920]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('innovation-research', [640, 960, 1280, 1920]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/innovation-research-1280.jpg') ?>"
               alt="Material research samples — raw biomass, processed log and finished coating"
               width="1280" height="800" loading="lazy" decoding="async">
        </picture>
        <figcaption class="innov-composition__captions">
          <span class="innov-composition__caption">Raw material<em>biomass sample</em></span>
          <span class="innov-composition__caption">Processed<em>log sample</em></span>
          <span class="innov-composition__caption">Coating<em>finished sample</em></span>
        </figcaption>
      </figure>
      <div class="focus-rows">
        <?php foreach ($INNOVATION_AREAS as $focus): ?>
          <div class="focus-row">
            <span class="focus-row__num" aria-hidden="true"><?= e($focus['num']) ?></span>
            <h3 class="focus-row__name"><?= e($focus['name']) ?></h3>
            <p class="focus-row__desc"><?= e($focus['desc']) ?></p>
          </div>
        <?php endforeach; ?>
        <p class="impact-note" style="margin-top:1.25rem;">
          These are FOCUS AREAS — research directions, not proven
          accomplishments. <a href="/innovation/">Explore Innovation →</a>
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     07. VISION + MISSION — strong Forest section (§26)
     ============================================================ -->
<section class="section section--forest vision-mission" aria-labelledby="vision-title">
  <div class="container">
    <div class="vision-mission__grid">
      <div class="vision-mission__col">
        <span class="vision-mission__eyebrow">Vision</span>
        <h2 class="vision-mission__title" id="vision-title">
          A circular-economy company in the making.
        </h2>
        <p class="vision-mission__text">
          <?= e($COMPANY['vision']) ?>
        </p>
      </div>
      <div class="vision-mission__col vision-mission__col--mission">
        <span class="vision-mission__eyebrow">Mission</span>
        <h2 class="vision-mission__title">
          Practical alternatives, responsibly made.
        </h2>
        <p class="vision-mission__text">
          To develop practical, accessible and environmentally responsible
          material solutions — and to evaluate every direction for its
          environmental responsibility.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     08. PARTNERSHIP CTA (§27)
     ============================================================ -->
<section class="section section--paper partnership" aria-labelledby="partnership-title">
  <div class="container">
    <div class="partnership__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Partnership</span>
      <h2 class="section-heading__title" id="partnership-title">Let's Build a Greener Future Together.</h2>
    </div>
    <div class="partner-strip" data-reveal>
      <ul class="partner-strip__list">
        <?php foreach ($PARTNER_AUDIENCES as $audience): ?>
          <li class="partner-strip__item"><?= e($audience) ?></li>
        <?php endforeach; ?>
      </ul>
      <div class="partner-strip__ctas">
        <a class="btn btn--primary" href="/for-business/">Become a Partner</a>
        <a class="btn btn--secondary" href="/contact/">Request Product Information</a>
      </div>
    </div>
  </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
