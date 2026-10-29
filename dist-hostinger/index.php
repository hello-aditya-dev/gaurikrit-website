<?php
/**
 * Gaurikrit Bio Products — Homepage (V18 client-asset integration).
 *
 * THE STORY: one natural resource → multiple useful material solutions →
 * one circular-economy mission. A visitor understands the company from
 * this page alone (§74 story test).
 *
 * Section order (V18 §39) — exact:
 *   01 HERO                    limewash      brand lockup + 4-slide client
 *                                           product showcase (16/9 frame)
 *   02 FROM WASTE TO RESOURCE  paper         COW DUNG → PROCESSING &
 *                                           INNOVATION → PRODUCT PORTFOLIO
 *                                           → ENVIRONMENTAL IMPACT + mission
 *   03 ONE RESOURCE, FOUR      haldi-wash    2×2 editorial chapters; all
 *      SOLUTIONS                            four use the client's official
 *                                           product artworks (2026-10-29)
 *   04 CIRCULAR SUMMARY        paper         brief cycle statement + link to
 *                                           the full model on /sustainability/
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
$pageDescription = 'Gaurikrit builds a material ecosystem around one natural resource — cow dung — from Prakritik Eco-Paints to Cow-Dung Logs, Bio-Briquettes fuel and Eco Utility Products. Circular economy from Khurja, Uttar Pradesh.';
$pageCanonical   = '/';
$pageClass       = 'home';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $FAMILIES, $CIRCULAR_STAGES, $PRODUCTS,
       $INNOVATION_AREAS, $PARTNER_AUDIENCES;

// V22 — hero transitioning product showcase. Four final client-selected
// landscape artworks (~16:9, originals preserved untouched in
// source-assets/client-originals/2026-10-29-update/Gaurikrit_Final_4_Carousel_Images/).
// Derived responsive ladders (scripts/derive_client_assets_2026_10_29.py)
// live in assets/images/ecosystem/carousel-<slug>-<W>.{avif,webp,jpg} and
// are emitted through the same eco_srcset()/eco_srcset_webp() helpers as
// the rest of the V19 image system. Each width is the ACTUAL pixel width
// of that file, so the srcset w-descriptor stays truthful.
$HERO_SLIDES = [
  ['stem'=>'carousel-eco-paints',           'widths'=>[640,960,1280,1920], 'w'=>1920,'h'=>1080,
   'label'=>'Eco-Paints',          'sub'=>'Prakritik Paint family',
   'alt'=>'Gaurikrit Prakritik Paint — eco-friendly cow dung paint, Distemper and Emulsion buckets with natural backdrop'],
  ['stem'=>'carousel-bio-briquettes',       'widths'=>[640,960,1280,1920], 'w'=>1920,'h'=>1080,
   'label'=>'Bio-Briquettes',      'sub'=>'Futureline · Not yet in production',
   'alt'=>'Gaurikrit Bio-Briquettes — a Futureline product direction shown as client-supplied product artwork; not yet in production'],
  ['stem'=>'carousel-cow-dung-logs',        'widths'=>[640,960,1280],      'w'=>1672,'h'=>941,
   'label'=>'Cow-Dung Logs',       'sub'=>'Development direction',
   'alt'=>'Gaurikrit Cow-Dung Logs — a development direction shown as client-supplied product artwork'],
  ['stem'=>'carousel-eco-utility-products', 'widths'=>[640,960,1280,1920], 'w'=>1920,'h'=>1080,
   'label'=>'Eco Utility Products','sub'=>'Futureline · Not yet in production',
   'alt'=>'Gaurikrit Eco Utility Products — dhoop cups, cow-dung diyas, biodegradable plates and eco glasses shown as client-supplied product artwork; a Futureline product not yet in production'],
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
  .hero__title { font-size: clamp(1.75rem, 3vw, 2.5rem); line-height: 1.12; letter-spacing: -0.015em; }
  .hero__body { max-width: 40rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V21 — brand descriptor lockup: company name + secondary descriptor line */
  .hero__brand-lockup { display: flex; flex-direction: column; gap: 0.0625rem; margin-bottom: 0.875rem; }
  .hero__brand-name { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--forest); }
  .hero__brand-desc { font-size: 0.5625rem; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
  .hero__strapline { margin-top: 1.25rem; font-size: 0.8125rem; font-weight: 600; letter-spacing: 0.04em; color: var(--forest); font-style: italic; }

  /* V22 — transitioning product showcase. One stable 16/9 frame (no
     layout shift) matching the client's four ~16:9 landscape artworks.
     object-fit:contain keeps every label, pack and claim fully visible
     (no cropping of factual identity). Captions + dots + arrows sit
     below the frame. Autoplay/pause/keyboard/reduced-motion behaviour
     is in assets/js/hero-carousel.js. */
  .hero-showcase { position: relative; }
  .hero-showcase__frame {
    position: relative;
    aspect-ratio: 16 / 9;
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
    box-sizing: border-box;
    opacity: 0; visibility: hidden;
    transition: opacity 0.9s cubic-bezier(0.22,1,0.36,1), visibility 0s linear 0.9s;
    pointer-events: none;
  }
  .hero-showcase__slide[aria-hidden="false"] {
    opacity: 1; visibility: visible;
    transition: opacity 0.9s cubic-bezier(0.22,1,0.36,1), visibility 0s;
    pointer-events: auto;
  }
  /* V21 — bulletproof contain: picture fills the slide content box (definite
     height via inset:0 + box-sizing), img uses object-fit:contain so every
     poster — landscape, square or portrait — is shown in full without
     clipping packaging or labels. */
  .hero-showcase__slide picture {
    display: flex; align-items: center; justify-content: center;
    width: 100%; height: 100%; max-width: 100%; max-height: 100%;
    margin: 0;
  }
  .hero-showcase__slide img {
    display: block;
    max-width: 100%; max-height: 100%;
    width: auto; height: auto;
    object-fit: contain; object-position: center;
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
  .hero-showcase__arrows { display: flex; gap: 0.5rem; align-items: center; }
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
  /* V21 — accessible play/pause toggle */
  .hero-showcase__toggle {
    width: 2.25rem; height: 2.25rem; display: inline-flex;
    align-items: center; justify-content: center;
    border: 1px solid var(--border-strong); border-radius: 999px;
    background: var(--paper); color: var(--forest);
    cursor: pointer; margin-right: 0.25rem;
    transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
  }
  .hero-showcase__toggle:hover { background: var(--forest); color: var(--paper); border-color: var(--forest); }
  .hero-showcase__toggle:focus-visible { outline: 2px solid var(--haldi); outline-offset: 2px; }
  .hero-showcase__toggle svg { width: 1.125rem; height: 1.125rem; }
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
    .hero-showcase__arrow, .hero-showcase__toggle { width: 2.75rem; height: 2.75rem; }
    .hero-showcase__dot { width: 0.625rem; height: 0.625rem; }
    .hero-showcase__dot[aria-selected="true"] { width: 1.75rem; }
  }

  /* V21 — mission statement callout inside the story section */
  .resource-mission {
    margin-top: 1.75rem; padding: 1.25rem 1.5rem;
    border-left: 3px solid var(--haldi);
    background: color-mix(in srgb, var(--haldi) 6%, transparent);
    border-radius: 0 0.25rem 0.25rem 0;
  }
  .resource-mission__label {
    display: block; font-size: 0.5625rem; font-weight: 700;
    letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted);
    margin-bottom: 0.375rem;
  }
  .resource-mission__text {
    font-size: 1.0625rem; font-weight: 600; line-height: 1.4;
    color: var(--forest); margin: 0;
  }

  /* V22 — Stage 03 Product Portfolio: the client-supplied biodegradable
     product showcase artwork (portrait 2:3). object-fit:contain preserves
     the complete poster — embedded labels, logos and product imagery are
     never cropped to fill the frame. */
  .resource-step__figure--poster {
    display: flex; align-items: center; justify-content: center;
    background: var(--paper-warm); overflow: hidden;
  }
  .resource-step__figure--poster picture {
    display: block; width: 100%; height: 100%;
  }
  .resource-step__figure--poster img {
    width: 100%; height: 100%;
    object-fit: contain; object-position: center;
    display: block;
  }

  /* V21 — corporate tagline in the closing brand section */
  .brand-close__tagline {
    text-align: center; margin-top: 1.5rem; padding-top: 1.5rem;
    border-top: 1px solid color-mix(in srgb, var(--paper) 25%, transparent);
    font-size: 1rem; font-weight: 700; letter-spacing: 0.04em;
    color: var(--paper);
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
        <div class="hero__brand-lockup">
          <span class="hero__brand-name">GAURIKRIT&reg;</span>
          <span class="hero__brand-desc">Circular Economy &amp; Carbon Reduction Company</span>
        </div>
        <span class="hero__devanagari" aria-hidden="true"><?= e($COMPANY['devanagari']) ?></span>
        <h1 class="hero__title" id="hero-title">
          Reimagining Cow-Dung<br>as a Resource for Sustainable Living.
        </h1>
        <p class="hero__body">
          Nature provides the resource. Gaurikrit explores how natural waste
          can be carried into practical material solutions&mdash;from
          Prakritik Paint to organic fuel and environmentally friendly utility
          products that help build a cleaner future.
        </p>
        <p class="hero__strapline">
          Transforming Natural Resources. Redefining Sustainable Living.
        </p>
        <div class="hero__ctas">
          <a class="btn btn--primary btn--lg" href="/products/">Explore the Ecosystem</a>
          <a class="btn btn--secondary btn--lg" href="/about/">Our Story</a>
        </div>
      </div>

      <!-- V22 — transitioning product showcase. Four final client-selected
           landscape artworks (2026-10-29 originals) crossfade inside one
           stable 16/9 frame. Autoplay 5s, accessible play/pause, prev/next,
           dots, ArrowLeft/Right keyboard, swipe, prefers-reduced-motion aware
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
              <button type="button" class="hero-showcase__toggle" data-hero-toggle
                      aria-pressed="true" aria-label="Pause product showcase autoplay">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon-pause><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon-play hidden><path d="M7 4v16l13-8z"/></svg>
              </button>
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
        contemporary applications &mdash; from naturally derived material to products
        for walls, energy and everyday use.
      </p>
      <div class="resource-mission" data-reveal>
        <span class="resource-mission__label">Our Mission</span>
        <p class="resource-mission__text">
          Transforming Cow Dung into Innovative Solutions for Sustainable Living.
        </p>
      </div>
    </div>

    <div class="resource-steps" data-reveal-stagger>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('flow-cow-dung', [640, 960, 1280]) ?>"
                    sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('flow-cow-dung', [640, 960, 1280]) ?>"
                    sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/flow-cow-dung-960.jpg') ?>"
                 alt="Raw cow dung in a rural setting &mdash; the natural material starting point"
                 width="960" height="540" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 01</span>
          <h3 class="resource-step__title">Cow Dung</h3>
          <p class="resource-step__desc">
            A natural material long valued in traditional Indian homes &mdash; the shared starting point for every Gaurikrit direction.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('flow-processing', [640, 960]) ?>"
                    sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('flow-processing', [640, 960]) ?>"
                    sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/flow-processing-960.jpg') ?>"
                 alt="Conceptual visual of natural-waste processing &mdash; biomass handling and material development"
                 width="960" height="960" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 02</span>
          <h3 class="resource-step__title">Processing &amp; Innovation</h3>
          <p class="resource-step__desc">
            The resource is studied, processed and developed into useful working materials &mdash; from coatings to fuel formats.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure resource-step__figure--poster" aria-label="Gaurikrit biodegradable product showcase">
          <picture>
            <source type="image/avif" srcset="<?= asset_url('/assets/images/ecosystem/flow-portfolio-640.avif') ?> 640w, <?= asset_url('/assets/images/ecosystem/flow-portfolio-960.avif') ?> 960w" sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= asset_url('/assets/images/ecosystem/flow-portfolio-640.webp') ?> 640w, <?= asset_url('/assets/images/ecosystem/flow-portfolio-960.webp') ?> 960w" sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/flow-portfolio-960.jpg') ?>"
                 alt="Gaurikrit biodegradable product showcase &mdash; dhoop cups, cow-dung diyas, biodegradable plates and eco glasses" width="960" height="1440" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 03</span>
          <h3 class="resource-step__title">Product Portfolio</h3>
          <p class="resource-step__desc">
            Four solutions from one resource: Eco-Paints, Cow-Dung Logs, Bio-Briquettes and Eco Utility Products.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('flow-impact', [640, 960]) ?>"
                    sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('flow-impact', [640, 960]) ?>"
                    sizes="(min-width: 1100px) 22vw, (min-width: 768px) 45vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/flow-impact-960.jpg') ?>"
                 alt="Earth encircled by a leaf recycling symbol &mdash; a circular-economy direction"
                 width="960" height="960" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 04</span>
          <h3 class="resource-step__title">Environmental Impact</h3>
          <p class="resource-step__desc">
            Products that carry natural material back into everyday use &mdash; building a circular-economy direction for the future.
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
      <h2 class="section-heading__title" id="families-title">One resource. Four solutions.</h2>
      <p class="section-heading__desc">
        Cow dung is the shared material beginning. Gaurikrit develops it in four
        directions &mdash; Eco-Paints is the documented family; Cow-Dung Logs is
        a development direction; Bio-Briquettes and Eco Utility Products are
        Futureline product directions, not yet in production.
      </p>
      <p class="section-heading__desc">
        Every product we create contributes to a circular economy where waste becomes value and sustainability becomes practical.
      </p>
    </div>

    <div class="families" data-reveal-stagger>
<?php
      // V22: every family carries the final client-supplied landscape
      // artworks from the 2026-10-29 batch (the same official product
      // posters as the hero carousel — browser-cached, so no extra
      // download). 16:9 frames with object-fit:contain preserve product
      // identity and label text. Client terminology: "Cow-Dung Logs"
      // (formerly GoCast Logs) and "Bio-Briquettes" (formerly Bio-Coal
      // Logs) — see data.php and ASSET_PROVENANCE.md.
      $familyMedia = [
          'eco-paints'        => ['stem' => 'carousel-eco-paints', 'ladder' => [640, 960, 1280, 1920],
                                  'w' => 1920, 'h' => 1080,
                                  'alt' => 'Gaurikrit Eco-Paints — Prakritik Paint artwork, the documented product family'],
          'cow-dung-logs'     => ['stem' => 'carousel-cow-dung-logs', 'ladder' => [640, 960, 1280],
                                  'w' => 1672, 'h' => 941,
                                  'alt' => 'Gaurikrit Cow-Dung Logs — premium biomass fuel artwork'],
          'bio-briquettes'    => ['stem' => 'carousel-bio-briquettes', 'ladder' => [640, 960, 1280, 1920],
                                  'w' => 1920, 'h' => 1080,
                                  'alt' => 'Gaurikrit Bio-Briquettes — premium renewable biomass fuel artwork'],
          'utility-products'  => ['stem' => 'carousel-eco-utility-products', 'ladder' => [640, 960, 1280, 1920],
                                  'w' => 1920, 'h' => 1080,
                                  'alt' => 'Gaurikrit Eco Utility Products — dhoop cups, cow-dung diyas, biodegradable plates and eco glasses artwork'],
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
              <img src="<?= asset_url('/assets/images/ecosystem/' . $m['stem'] . '-' . end($m['ladder']) . '.jpg') ?>"
                   alt="<?= e($m['alt']) ?>"
                   width="<?= $m['w'] ?>" height="<?= $m['h'] ?>" loading="lazy" decoding="async">
            </picture>
          </figure>

          <div class="family__head">
            <span class="family__num" aria-hidden="true"><?= e($family['num']) ?></span>
            <h3 class="family__name"><?= e($family['name']) ?></h3>
          </div>
          <p class="family__line"><?= e($family['line']) ?></p>
          <p class="family__desc"><?= e($family['desc']) ?></p>
          <p class="family__meta">
            <?php
              $variant = $family['statusVariant'] ?? ($family['status'] === 'Documented family' ? 'documented' : 'development');
              $statusClass = $variant === 'documented' ? '' : ($variant === 'futureline' ? ' family__status--futureline' : ' family__status--direction');
              $titleAttr = $variant === 'futureline' ? ' title="Futureline product — not yet in production"' : '';
            ?>
            <span class="family__status<?= $statusClass ?>"<?= $titleAttr ?>>
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
     04. A CIRCULAR MATERIAL DIRECTION — compact cycle summary
     V22: the homepage four-stage flow above is now the main visual
     narrative. This section is a brief closing statement + link to the
     full seven-stage model on /sustainability/ (kept intact there) —
     removing the duplicated timeline without losing substance.
     ============================================================ -->
<section class="section section--paper circular-section" aria-labelledby="circular-title">
  <div class="container">
    <div class="circular-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Circular Model</span>
      <h2 class="section-heading__title" id="circular-title">A Circular Material Direction.</h2>
      <p class="section-heading__desc">
        The stages above repeat as one continuous cycle: the resource enters,
        is developed, becomes useful products &mdash; and further material
        opportunities keep the cycle going.
      </p>
      <p class="circular-section__cta" style="margin-top:1.25rem;">
        <a class="btn btn--outline" href="/sustainability/#circular-economy">Explore the Full Circular Model <span aria-hidden="true">→</span></a>
      </p>
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
          material solutions &mdash; and to evaluate every direction for its
          environmental responsibility.
        </p>
      </div>
    </div>
    <p class="brand-close__tagline">Redefining Resources. Regenerating the Future.</p>
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
