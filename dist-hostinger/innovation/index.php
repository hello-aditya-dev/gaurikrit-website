<?php
/**
 * Gaurikrit Bio Products — Innovation (V32 creative rebuild).
 *
 * THE MATERIALS OF TOMORROW — an editorial research publication.
 * Six-section progression:
 *   01 HERO       Where Tradition Meets Technology
 *   02 FOCUS      Five research directions (numbered index)
 *   03 METHOD     Four principles (connected composition)
 *   04 DOCUMENTED Eco-Paints — the proven outcome
 *   05 EXPLORATORY Futureline product directions
 *   06 CTA        Discuss a Collaboration
 *
 * No invented labs, patents, facilities, scientists or measured results.
 */
declare(strict_types=1);

$pageTitle       = 'Research & Innovation — Where Tradition Meets Technology | Gaurikrit';
$pageDescription = 'Gaurikrit research directions: natural coatings, biomass energy, bio-composites, carbon reduction technologies and sustainable building materials. Where tradition meets technology.';
$pageCanonical   = '/innovation/';
$pageClass       = 'innovation';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $INNOVATION_AREAS;

$methodItems = [
    ['num' => '01', 'name' => 'Material-first',  'desc' => 'Each direction begins with a natural material and its properties, not a market template.'],
    ['num' => '02', 'name' => 'Application-led', 'desc' => 'Research is guided by real applications — walls, fuel, ritual and daily use.'],
    ['num' => '03', 'name' => 'Tradition-aware', 'desc' => 'Indian material traditions inform where technologies should serve, not erase.'],
    ['num' => '04', 'name' => 'Verified before published', 'desc' => 'Directions are shared as directions. Results are shared only once verified.'],
];
?>
<style>
  /* ===== V32 INNOVATION PAGE — editorial research publication ===== */

  /* ===== 01. HERO — forest background, asymmetric editorial ===== */
  .innov-hero {
    background: var(--forest);
    color: var(--paper);
    padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: clamp(3rem, 6vw, 5rem);
  }
  .innov-hero__grid {
    display: grid; gap: clamp(2rem, 5vw, 4rem); align-items: center;
    grid-template-columns: minmax(0, 1fr);
  }
  @media (min-width: 1024px) {
    .innov-hero__grid { grid-template-columns: minmax(0, 7fr) minmax(0, 5fr); }
  }
  .innov-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--haldi); margin-bottom: 1.25rem;
  }
  .innov-hero__eyebrow::before {
    content: ""; width: 2rem; height: 1px; background: var(--haldi);
  }
  .innov-hero__title {
    font-family: var(--font-display);
    font-size: clamp(2.25rem, 6vw, 4.5rem);
    font-weight: 700; letter-spacing: -0.025em; line-height: 1.05;
    text-wrap: balance; margin-bottom: 1.5rem; color: var(--paper);
  }
  .innov-hero__lead {
    font-size: clamp(1.0625rem, 1.5vw, 1.25rem); line-height: 1.6;
    color: var(--paper); opacity: 0.85; max-width: 36rem; margin-bottom: 2rem;
  }
  .innov-hero__ctas { display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .innov-hero__composition {
    margin: 0; position: relative; overflow: hidden;
    border-radius: 0.25rem; aspect-ratio: 8 / 5;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  }
  .innov-hero__composition img {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }
  .innov-hero__caption {
    margin-top: 0.875rem; font-size: 0.6875rem; color: var(--paper);
    opacity: 0.6; letter-spacing: 0.02em; line-height: 1.5; font-style: italic;
  }

  /* ===== 02. FOCUS AREAS — numbered research index ===== */
  .innov-focus { padding-block: clamp(3rem, 6vw, 5rem); }
  .innov-focus__head { max-width: 48rem; margin-bottom: 3rem; }
  .innov-focus__grid {
    display: grid; gap: 1px; background: var(--border);
    border: 1px solid var(--border); border-radius: 0.25rem; overflow: hidden;
  }
  @media (min-width: 768px) {
    .innov-focus__grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (min-width: 1024px) {
    .innov-focus__grid { grid-template-columns: repeat(3, 1fr); }
  }
  .innov-focus__item {
    background: var(--paper); padding: clamp(1.75rem, 3vw, 2.5rem);
    display: flex; flex-direction: column; gap: 0.75rem;
    transition: background-color var(--dur) var(--ease);
  }
  .innov-focus__item:hover { background: var(--paper-warm); }
  .innov-focus__num {
    font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 3.75rem);
    font-weight: 700; color: var(--haldi); line-height: 1; letter-spacing: -0.03em;
  }
  .innov-focus__name {
    font-family: var(--font-display); font-size: clamp(1.125rem, 2vw, 1.5rem);
    font-weight: 700; color: var(--primary); letter-spacing: -0.01em;
    line-height: 1.2;
  }
  .innov-focus__desc {
    font-size: 0.875rem; line-height: 1.6; color: var(--fg-muted);
  }
  .innov-focus__disclaimer {
    margin-top: 2rem; padding: 1rem 1.25rem;
    background: color-mix(in srgb, var(--haldi) 8%, transparent);
    border-left: 3px solid var(--haldi); border-radius: 0 0.1875rem 0.1875rem 0;
    font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.5;
  }

  /* ===== 03. METHODOLOGY — four principles connected ===== */
  .innov-method {
    background: var(--limewash);
    padding-block: clamp(3rem, 6vw, 5rem);
  }
  .innov-method__head { max-width: 48rem; margin-bottom: 3rem; }
  .innov-method__grid {
    display: grid; gap: clamp(1.5rem, 3vw, 2.5rem);
    grid-template-columns: minmax(0, 1fr);
  }
  @media (min-width: 768px) {
    .innov-method__grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (min-width: 1024px) {
    .innov-method__grid { grid-template-columns: repeat(4, 1fr); }
  }
  .innov-method__item {
    position: relative; padding-top: 2rem;
    border-top: 2px solid var(--haldi);
  }
  .innov-method__num {
    position: absolute; top: -0.75rem; left: 0;
    font-family: var(--font-display); font-size: 0.75rem; font-weight: 700;
    letter-spacing: 0.15em; color: var(--haldi);
    background: var(--limewash); padding-right: 0.5rem;
  }
  .innov-method__name {
    font-family: var(--font-display); font-size: clamp(1.125rem, 2vw, 1.375rem);
    font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;
    letter-spacing: -0.01em; line-height: 1.2;
  }
  .innov-method__desc {
    font-size: 0.875rem; line-height: 1.6; color: var(--fg-muted);
  }

  /* ===== 04. DOCUMENTED OUTCOME — Eco-Paints ===== */
  .innov-documented { padding-block: clamp(3rem, 6vw, 5rem); }
  .innov-documented__grid {
    display: grid; gap: clamp(2rem, 5vw, 4rem); align-items: center;
    grid-template-columns: minmax(0, 1fr);
  }
  @media (min-width: 1024px) {
    .innov-documented__grid { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); }
  }
  .innov-documented__label {
    display: inline-block; font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase; color: var(--forest);
    background: color-mix(in srgb, var(--forest) 8%, transparent);
    padding: 0.3125rem 0.75rem; border-radius: 0.1875rem; margin-bottom: 1rem;
  }
  .innov-documented__title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem);
    font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;
    margin-bottom: 1rem; text-wrap: balance;
  }
  .innov-documented__body {
    font-size: 1rem; line-height: 1.7; color: var(--fg); max-width: 36rem;
    margin-bottom: 1.5rem;
  }
  .innov-documented__links { display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .innov-documented__image {
    position: relative; overflow: hidden; border-radius: 0.25rem;
    box-shadow: 0 4px 20px rgba(16, 47, 32, 0.1);
  }
  .innov-documented__image img {
    width: 100%; height: auto; display: block;
  }

  /* ===== 05. EXPLORATORY DIRECTIONS — Futureline ===== */
  .innov-exploratory {
    background: var(--paper-warm);
    padding-block: clamp(3rem, 6vw, 5rem);
  }
  .innov-exploratory__grid {
    display: grid; gap: clamp(2rem, 5vw, 4rem); align-items: center;
    grid-template-columns: minmax(0, 1fr);
  }
  @media (min-width: 1024px) {
    .innov-exploratory__grid { grid-template-columns: minmax(0, 7fr) minmax(0, 5fr); }
  }
  .innov-exploratory__label {
    display: inline-block; font-size: 0.6875rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase; color: var(--haldi);
    background: color-mix(in srgb, var(--haldi) 12%, transparent);
    border: 1px solid color-mix(in srgb, var(--haldi) 30%, transparent);
    padding: 0.3125rem 0.75rem; border-radius: 0.1875rem; margin-bottom: 1rem;
  }
  .innov-exploratory__title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem);
    font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;
    margin-bottom: 1rem; text-wrap: balance;
  }
  .innov-exploratory__body {
    font-size: 1rem; line-height: 1.7; color: var(--fg); max-width: 36rem;
    margin-bottom: 1.5rem;
  }
  .innov-exploratory__statuses {
    display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem;
  }
  .innov-exploratory__status {
    font-size: 0.8125rem; font-weight: 600; color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 10%, transparent);
    padding: 0.375rem 0.75rem; border-radius: 0.1875rem; width: fit-content;
  }
  .innov-exploratory__image {
    position: relative; overflow: hidden; border-radius: 0.25rem;
    background: var(--paper); box-shadow: 0 4px 20px rgba(16, 47, 32, 0.08);
  }
  .innov-exploratory__image img {
    width: 100%; height: auto; display: block;
  }
  .innov-exploratory__caption {
    padding: 0.75rem 1.25rem; font-size: 0.75rem; color: var(--fg-muted);
    border-top: 1px solid var(--border); font-style: italic; line-height: 1.5;
  }

  /* ===== 06. CTA — Collaboration ===== */
  .innov-cta {
    background: #102F20; color: var(--paper);
    padding-block: clamp(3rem, 6vw, 5rem); text-align: center;
  }
  .innov-cta__eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--haldi); margin-bottom: 1rem;
  }
  .innov-cta__title {
    font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 3rem);
    font-weight: 700; letter-spacing: -0.02em; line-height: 1.15;
    margin-bottom: 1rem; text-wrap: balance; color: var(--paper);
  }
  .innov-cta__sub {
    font-size: 1.0625rem; line-height: 1.6; color: var(--paper);
    opacity: 0.8; max-width: 36rem; margin: 0 auto 2rem;
  }
  .innov-cta__actions { display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
</style>

<!-- ============================================================
     01. HERO — Where Tradition Meets Technology
     ============================================================ -->
<section class="innov-hero" aria-labelledby="innov-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom: 1.5rem;">
      <a href="/" style="color: var(--paper); opacity: 0.6;">Home</a>
      <span style="color: var(--paper); opacity: 0.4;">›</span>
      <span style="color: var(--paper);">Innovation</span>
    </nav>
    <div class="innov-hero__grid" data-reveal>
      <div>
        <span class="innov-hero__eyebrow">Research &amp; Innovation</span>
        <h1 class="innov-hero__title" id="innov-title">Where Tradition Meets Technology</h1>
        <p class="innov-hero__lead">
          Gaurikrit&rsquo;s research direction explores how a natural material
          understood by tradition can be developed with contemporary methods &mdash;
          into coatings, fuels, composites and building materials.
        </p>
        <div class="innov-hero__ctas">
          <a class="btn btn--haldi" href="#focus-areas">The Five Focus Areas</a>
          <a class="btn btn--secondary" href="/sustainability/">Sustainability</a>
        </div>
      </div>
      <figure class="innov-hero__composition">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('innovation-research', [960, 1280, 1920, 2560]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('innovation-research', [960, 1280, 1920, 2560]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/innovation-research-1280.jpg') ?>"
               alt="Illustrative material study — exploring the relationship between raw materials, processing concepts and finished applications. Not a photograph of a Gaurikrit facility or verified production line."
               width="1280" height="800"
               loading="eager" fetchpriority="high" decoding="async">
        </picture>
      </figure>
    </div>
    <p class="innov-hero__caption">
      Illustrative material study &mdash; exploring the relationship between raw materials, processing concepts and finished applications. Not a photograph of a Gaurikrit facility or verified production line.
    </p>
  </div>
</section>

<!-- ============================================================
     02. FOCUS AREAS — five research directions (numbered index)
     ============================================================ -->
<section class="section section--paper innov-focus" id="focus-areas" aria-labelledby="focus-title">
  <div class="container">
    <div class="innov-focus__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Focus Areas</span>
      <h2 class="section-heading__title" id="focus-title">Five directions under exploration</h2>
      <p class="section-heading__desc">
        These are research directions &mdash; not proven accomplishments, patents or facilities.
        Each explores how a natural material could serve a contemporary application.
      </p>
    </div>
    <div class="innov-focus__grid" data-reveal-stagger>
      <?php foreach ($INNOVATION_AREAS as $focus): ?>
        <div class="innov-focus__item">
          <span class="innov-focus__num" aria-hidden="true"><?= e($focus['num']) ?></span>
          <h3 class="innov-focus__name"><?= e($focus['name']) ?></h3>
          <p class="innov-focus__desc"><?= e($focus['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="innov-focus__disclaimer" data-reveal>
      These focus areas represent research directions only. They are not presented as
      proven accomplishments, completed research, operational capabilities or
      commercially available products unless separately documented.
    </p>
  </div>
</section>

<!-- ============================================================
     03. METHODOLOGY — four principles (connected composition)
     ============================================================ -->
<section class="innov-method" id="method" aria-labelledby="method-title">
  <div class="container">
    <div class="innov-method__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">How we explore</span>
      <h2 class="section-heading__title" id="method-title">Material-first, application-led</h2>
      <p class="section-heading__desc">
        Four principles guide how Gaurikrit approaches each research direction.
      </p>
    </div>
    <div class="innov-method__grid" data-reveal-stagger>
      <?php foreach ($methodItems as $item): ?>
        <div class="innov-method__item">
          <span class="innov-method__num" aria-hidden="true"><?= e($item['num']) ?></span>
          <h3 class="innov-method__name"><?= e($item['name']) ?></h3>
          <p class="innov-method__desc"><?= e($item['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     04. DOCUMENTED OUTCOME — Eco-Paints (the proven family)
     ============================================================ -->
<section class="section section--paper innov-documented" id="documented" aria-labelledby="doc-title">
  <div class="container">
    <div class="innov-documented__grid" data-reveal>
      <div>
        <span class="innov-documented__label">Documented product family</span>
        <h2 class="innov-documented__title" id="doc-title">Eco-Paints &mdash; where the direction became products</h2>
        <p class="innov-documented__body">
          The natural-coatings focus is the most developed: Prakritik Distemper
          and Prakritik Emulsion are documented, specified products with real
          client photography &mdash; the reference point for how a research
          direction becomes a Gaurikrit family.
        </p>
        <div class="innov-documented__links">
          <a class="btn btn--primary" href="/products/prakritik-distemper/">Prakritik Distemper</a>
          <a class="btn btn--secondary" href="/products/prakritik-emulsion/">Prakritik Emulsion</a>
          <a class="btn btn--outline" href="/products/#eco-paints">Explore Eco-Paints</a>
        </div>
      </div>
      <figure class="innov-documented__image">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('eco-paints-pair', [640, 960, 1280, 1920]) ?>"
                  sizes="(min-width: 1024px) 55vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('eco-paints-pair', [640, 960, 1280, 1920]) ?>"
                  sizes="(min-width: 1024px) 55vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/eco-paints-pair-1280.jpg') ?>"
               alt="Prakritik Distemper and Emulsion paint packs — the documented Eco-Paints product family"
               width="1280" height="800"
               loading="lazy" decoding="async">
        </picture>
        <figcaption style="padding: 0.75rem 1.25rem; font-size: 0.75rem; color: var(--fg-muted); border-top: 1px solid var(--border); font-style: italic;">
          Prakritik Distemper and Emulsion &mdash; the documented Eco-Paints family.
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     05. EXPLORATORY DIRECTIONS — Futureline products
     ============================================================ -->
<section class="innov-exploratory" id="exploratory" aria-labelledby="expl-title">
  <div class="container">
    <div class="innov-exploratory__grid" data-reveal>
      <div>
        <span class="innov-exploratory__label">Exploratory product directions</span>
        <h2 class="innov-exploratory__title" id="expl-title">Futureline directions &mdash; not yet in production</h2>
        <p class="innov-exploratory__body">
          Beyond the documented Eco-Paints family, Gaurikrit explores additional
          product directions from the same natural resource base. These are
          Futureline directions &mdash; client-supplied artwork shows the intended
          product concepts, but they are not yet in production.
        </p>
        <div class="innov-exploratory__statuses">
          <span class="innov-exploratory__status">Bio-Briquettes: Futureline &middot; Not yet in production</span>
          <span class="innov-exploratory__status">Eco Utility Products: Futureline &middot; Not yet in production</span>
        </div>
        <div class="innov-documented__links">
          <a class="btn btn--outline" href="/products/#bio-briquettes">Bio-Briquettes direction</a>
          <a class="btn btn--outline" href="/products/#utility-products">Eco Utility Products direction</a>
        </div>
      </div>
      <figure class="innov-exploratory__image">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('showcase-innovation', [640, 960, 1254]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('showcase-innovation', [640, 960, 1254]) ?>"
                  sizes="(min-width: 1024px) 40vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/showcase-innovation-960.jpg') ?>"
               alt="Client-supplied material showcase — Prakritik Paint and dhoop cups shown together as an exploratory product direction. Bio-Briquettes and Eco Utility Products remain Futureline products, not yet in production."
               width="1254" height="1254"
               loading="lazy" decoding="async">
        </picture>
        <figcaption class="innov-exploratory__caption">
          Client-supplied material showcase &mdash; an exploratory product direction.
          Bio-Briquettes and Eco Utility Products remain Futureline products and
          are not yet in production.
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     06. CTA — Discuss a Collaboration
     ============================================================ -->
<section class="innov-cta" aria-labelledby="collab-title">
  <div class="container">
    <div data-reveal>
      <span class="innov-cta__eyebrow">Collaboration</span>
      <h2 class="innov-cta__title" id="collab-title">Discuss a Collaboration</h2>
      <p class="innov-cta__sub">
        Research programmes, institutions and sustainability partners &mdash;
        talk to Gaurikrit about material directions and collaboration.
      </p>
      <div class="innov-cta__actions">
        <a class="btn btn--haldi" href="/for-business/">Become a Partner</a>
        <a class="btn btn--secondary" href="/contact/">Contact Gaurikrit</a>
      </div>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
