<?php
/**
 * Gaurikrit Bio Products — Why Prakritik (V12 finishing pass).
 *
 * Illustrated editorial essay, one visual system:
 *   - Section rhythm per the global five families: limewash hero → paper
 *     material → warm-wash tradition → paper material-to-wall → warm-wash
 *     benefits → paper formats → limewash context → forest footer.
 *   - Chapter 02 imagery is large and deliberate (copy ~45 / courtyard
 *     elevation ~55 on desktop; copy then image on mobile).
 *   - Chapter 04 is the shared typographic eight-benefit grid (no radial
 *     seal, no cow diagram) — identical to Home / Products / detail pages.
 *   - Chapter 06 is a framed editorial context band (rural-landscape) —
 *     regional context only, never presented as company premises.
 * Factual data unchanged from data.php.
 */
declare(strict_types=1);

$pageTitle       = 'Why Prakritik Paint — An Old Material, Reconsidered | Gaurikrit';
$pageDescription = 'Cow dung has been used on Indian walls for generations. Prakritik Paint carries that material into a contemporary paint format. The material, the tradition, the wall.';
$pageCanonical   = '/why-prakritik/';
$pageClass        = 'why-prakritik';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
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

  /* ===== HERO (V10: single quiet finished-wall study — where the
     material lands; the zebu crop layering is retired) ===== */
  .why-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .why-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .why-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .why-hero__lockup { max-width: 42rem; }
  .why-hero__art {
    position: relative; aspect-ratio: 1344/768;
    background: var(--paper); border-radius: var(--r-panel);
    overflow: hidden;
    border: 1px solid var(--border);
  }
  .why-hero__art .why-hero__img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; display: block;
  }
  /* Legacy single-picture .editorial-image positioner (kept for
     why-material-sample / why-tradition-art / etc.) */
  .why-material-sample .editorial-image,
  .why-tradition-art .editorial-image { display: block; }
  .why-hero__title { font-size: clamp(2.2rem, 5vw, 4rem); }

  /* ===== NUMBERED CHAPTERS ===== */
  .why-chapter {
    display: grid; gap: 2rem; padding-block: clamp(3.5rem, 6vw, 5rem);
  }
  @media (min-width: 1024px) {
    .why-chapter { grid-template-columns: 4fr 8fr; gap: 3rem; align-items: start; }
  }
  /* V12: Section 02 TRADITION — the courtyard elevation is the chapter's
     dominant visual: copy ~45 / image ~55 on desktop (image large enough
     to matter); copy first, image second at every breakpoint. */
  @media (min-width: 1024px) {
    .why-chapter--wide-art { grid-template-columns: 45fr 55fr; gap: 3rem; align-items: center; }
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

  /* === Chapter 01 — MATERIAL: raw-material-study (plaster surface) === */
  .why-material-sample {
    position: relative; aspect-ratio: 1344/768;
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

  /* === Chapter 03 — MATERIAL TO WALL: 3 step cards (structure in
     app.css §17 .material-step — same cards as the homepage journey) === */
  .why-flow-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-flow-section .material-steps { margin-top: 2rem; }

  /* === Chapter 04 — ASHTA: the shared typographic benefits grid
     (structure in app.css §18 — identical to every other page). === */
  .why-ashta-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* === Chapter 05 — FORMATS: two real product visuals on quiet
     format-wash grounds (hairline border, no gradient, no accent
     stripe; soft grounded product shadow only). === */
  .why-formats-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-formats {
    display: grid; gap: 2rem; margin-top: 2rem;
  }
  @media (min-width: 768px) { .why-formats { grid-template-columns: 1fr 1fr; } }
  .why-format-card {
    position: relative;
    background: color-mix(in srgb, var(--paper-cool) 25%, var(--paper));
    border: 1px solid var(--border);
    border-radius: var(--r-panel); overflow: hidden;
    display: flex; align-items: center; justify-content: center; padding: 1.5rem;
    min-height: 22rem;
  }
  .why-format-card--emulsion {
    background: color-mix(in srgb, var(--paper-leaf) 25%, var(--paper));
  }
  .why-format-card .format-product {
    display: block;
    max-height: 26rem; max-width: 100%;
    width: auto; height: auto;
    object-fit: contain;
    filter: drop-shadow(0 10px 16px rgba(34, 36, 27, 0.12));
  }
  .why-format-card__caption {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.9); padding: 0.5rem 0.875rem;
    border-radius: var(--r-pill); font-size: 0.8125rem; font-weight: 600;
  }
  .why-format-card--distemper .why-format-card__caption { color: var(--indigo); }
  .why-format-card--emulsion  .why-format-card__caption { color: var(--leaf); }

  /* === Chapter 06 — CONTEXT: framed editorial band (rural-landscape
     = regional context only, never company premises). V12 fixes the
     legacy band/bg class drift: the framed band now matches the markup. === */
  .why-context-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-context-bg {
    position: relative; width: 100%; aspect-ratio: 1344/768;
    background: var(--limewash); border-radius: var(--r-panel);
    border: 1px solid var(--border);
    overflow: hidden; align-self: center;
  }
</style>

<!-- ===== HERO — single quiet finished-wall study ===== -->
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
          Traditional Indian homes have long used cow-dung-based coatings on
          walls and floors. Prakritik Paint brings that material idea into a
          contemporary paint format.
        </p>
      </div>
      <div class="why-hero__art">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-finish-study.webp') ?>">
          <img class="why-hero__img"
               src="<?= asset_url('/assets/editorial/interior-finish-study.jpg') ?>"
               alt="Quiet interior wall with a matte mineral finish"
               width="1344" height="768"
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
      <div class="why-material-sample">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/raw-material-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
               alt="Raw lime-plastered wall surface — natural material"
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ===== 02 TRADITION — courtyard elevation: copy ~45 / image ~55 ===== -->
<section class="section section--haldi-wash" aria-labelledby="chapter-02-title">
  <div class="container">
    <div class="why-chapter why-chapter--wide-art" data-reveal>
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
    <div class="material-steps" data-reveal>
      <article class="material-step">
        <figure class="material-step__figure">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/raw-material-study.webp') ?>">
            <img class="editorial-image"
                 src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
                 alt="Raw lime-plastered wall surface — natural material"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">01</span>
          <h3 class="material-step__title">Natural material</h3>
          <p class="material-step__desc">Cow dung is the material inspiration.</p>
        </div>
      </article>
      <article class="material-step material-step--product">
        <figure class="material-step__figure">
          <picture>
            <source type="image/webp" srcset="<?= asset_url($distemper['officialImageWebp']) ?>">
            <img class="material-step__product"
                 src="<?= asset_url($distemper['officialImage']) ?>"
                 alt="Prakritik Distemper paint pack"
                 width="<?= $distemper['officialImageW'] ?>" height="<?= $distemper['officialImageH'] ?>"
                 loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">02</span>
          <h3 class="material-step__title">Prakritik Paint</h3>
          <p class="material-step__desc">Available as Distemper and Emulsion.</p>
        </div>
      </article>
      <article class="material-step">
        <figure class="material-step__figure">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/finished-surface-study.webp') ?>">
            <img class="editorial-image"
                 src="<?= asset_url('/assets/editorial/finished-surface-study.jpg') ?>"
                 alt="Finished matte limewash wall surface"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">03</span>
          <h3 class="material-step__title">Finished wall</h3>
          <p class="material-step__desc">Both are listed for interior and exterior use.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ===== 04 ASHTA — the shared typographic eight-benefit grid ===== -->
<section class="section section--haldi-wash why-ashta-section" aria-labelledby="chapter-04-title">
  <div class="container">
    <div class="why-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="chapter-04-title">Eight benefits of Prakritik Paint.</h2>
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
        <picture>
          <source type="image/webp" srcset="<?= asset_url($distemper['officialImageWebp']) ?>">
          <img class="format-product"
               src="<?= asset_url($distemper['officialImage']) ?>"
               alt="<?= e($distemper['name']) ?>"
               width="<?= $distemper['officialImageW'] ?>" height="<?= $distemper['officialImageH'] ?>"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-format-card__caption"><?= e($distemper['packagingShort']) ?> packs</span>
      </div>
      <div class="why-format-card why-format-card--emulsion">
        <picture>
          <source type="image/webp" srcset="<?= asset_url($emulsion['officialImageWebp']) ?>">
          <img class="format-product"
               src="<?= asset_url($emulsion['officialImage']) ?>"
               alt="<?= e($emulsion['name']) ?>"
               width="<?= $emulsion['officialImageW'] ?>" height="<?= $emulsion['officialImageH'] ?>"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-format-card__caption"><?= e($emulsion['packagingShort']) ?> packs</span>
      </div>
    </div>
  </div>
</section>

<!-- ===== 06 CONTEXT — framed editorial context band (regional context,
     never company premises): copy ~4 / band ~8 on desktop ===== -->
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
      <div class="why-context-bg" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/rural-landscape.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/rural-landscape.jpg') ?>"
               alt=""
               width="1344" height="768"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
