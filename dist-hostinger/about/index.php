<?php
/**
 * Gaurikrit Bio Products — About (V7 rebuild — product plate hero + 35/65 ledger).
 * Task V5-FINISH.
 *
 * Refines the V4 composition: hero is typographic (small 96px logo mark +
 * गौरीकृत + GAURIKRIT BIO PRODUCTS) with a subtle interior-wall-study
 * background at 0.08 opacity (NO giant logo panel); Who-we-are body
 * constrained to 65ch with line-height 1.7 and more breathing room;
 * product photos larger within their containers; company-plate rows
 * get a border-top + bumped label letter-spacing for a premium feel;
 * mission strip rural-landscape opacity reduced to 0.10. Factual data
 * unchanged from data.php.
 *
 *   1. Hero — V5: typographic, small logo mark + faded wall bg.
 *   2. WHO WE ARE (legal identity) — V5: 65ch body, line-height 1.7.
 *   3. WHAT WE CURRENTLY PRESENT — V5: larger product photo CSS footprint.
 *   4. MATERIAL DIRECTION — zebu-study.webp beside wall.
 *   5. MISSION — V5: rural-landscape at 0.10 opacity (was 0.15).
 *   6. COMPANY INFORMATION — V5: border-top per row, bumped label
 *      letter-spacing, aligned values.
 */
declare(strict_types=1);

$pageTitle       = 'About Gaurikrit Bio Products — Nature. Culture. Useful materials.';
$pageDescription = 'Gaurikrit Bio Products (OPC) Private Limited — Khurja, District Bulandshahr, Uttar Pradesh. Makers of Prakritik Distemper and Emulsion Paint. GSTIN 09AAMCG8400F1ZK.';
$pageCanonical   = '/about/';
$pageClass        = 'about';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');

$address = $COMPANY['address'] ?? [];
$addressLine = implode("\n", $address);
?>
<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO (V7: 5/7 — brand identity left, real product plate right) ===== */
  .about-hero {
    padding-top: calc(var(--header-h) + clamp(1.25rem, 3vw, 2rem));
    padding-bottom: clamp(1.25rem, 3vw, 2rem);
  }
  .about-hero__container {
    display: grid; gap: clamp(1.5rem, 4vw, 3rem); align-items: center;
  }
  @media (min-width: 1024px) {
    .about-hero__container { grid-template-columns: 5fr 7fr; }
  }
  .about-hero__lockup { display: flex; flex-direction: column; gap: 0.75rem; }
  .about-hero__deva {
    font-family: var(--font-deva); font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700; color: var(--haldi-deep);
  }
  .about-hero__brand-sub {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .about-hero__title {
    font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4rem);
    line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance;
    margin-top: 0.5rem;
  }
  .about-hero__body {
    margin-top: 1rem; font-size: clamp(1rem, 2vw, 1.125rem);
    color: var(--fg-muted); line-height: 1.65; max-width: 60ch;
  }
  /* V7: the hero shows WHO the brand is + WHAT it actually makes — the real
     product group photo as a catalogue plate with the official mark. */
  .about-hero__plate {
    background: var(--paper);
    border: 1px solid var(--border);
    border-top: 3px solid var(--haldi);
    border-radius: var(--r-panel);
    padding: clamp(1rem, 2vw, 1.5rem);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .about-hero__plate-head {
    display: flex; align-items: center; gap: 0.625rem;
    padding-bottom: 0.75rem; margin-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
  }
  .about-hero__plate-mark {
    width: 40px; height: 40px; flex: none; object-fit: contain;
  }
  .about-hero__plate-brand {
    font-family: var(--font-deva); font-size: 0.9375rem; color: var(--haldi-deep);
    line-height: 1.2;
  }
  .about-hero__plate-brand small {
    display: block; font-family: var(--font-sans); font-size: 0.5625rem;
    font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--fg-muted); margin-top: 0.125rem;
  }
  .about-hero__plate-photo {
    display: block; width: 100%; height: auto;
    object-fit: contain; aspect-ratio: 1280 / 621;
  }

  /* ===== WHO WE ARE (V7: 35/65 ledger-left, body right) ===== */
  .about-wrap { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .about-section .about-section__body { max-width: 65ch; }

  /* ===== WHAT WE PRESENT (V5: larger product image CSS footprint) ===== */
  .about-products-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .about-products { margin-top: 2rem; }
  .about-product-card__media {
    position: relative; aspect-ratio: 4/3; background: var(--limewash);
    border-radius: var(--r-panel); overflow: hidden;
    margin-bottom: 1rem;
    display: flex; align-items: center; justify-content: center;
  }
  .about-product-card__media .about-product-photo {
    display: block;
    max-height: 88%;  /* V5: increased from 80% → 88% */
    max-width: 80%;   /* V5: default larger cap */
    width: auto; height: auto;
    object-fit: contain;
    filter: drop-shadow(0 14px 20px rgba(34, 36, 27, 0.16));
  }
  /* V5: increased caps — closer to natural image sizes. */
  .about-product-card__media--distemper .about-product-photo {
    max-width: min(85%, 500px);  /* was min(70%, 420px) */
  }
  .about-product-card__media--emulsion .about-product-photo {
    max-width: min(80%, 350px);  /* was min(60%, 320px) */
  }

  /* ===== MATERIAL DIRECTION (V7: zebu printed onto the page — no box) ===== */
  .about-direction-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .about-direction__visual {
    /* No panel chrome: the artwork's cream ground matches the paper
       background so the cow reads as printed onto the page. */
    background: transparent;
    border-radius: 0;
    overflow: hidden;
    position: relative;
    aspect-ratio: 1536 / 1126;  /* V7: cow ~10% larger — crop bottom margin */
  }
  .about-direction__visual .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; object-position: 50% 35%;
  }

  /* ===== MISSION BAND (V5: rural-landscape at 0.10 opacity — was 0.15) ===== */
  .about-mission {
    position: relative; padding-block: clamp(4rem, 8vw, 6.5rem);
    background: var(--forest-deep); color: var(--primary-fg);
    overflow: hidden;
  }
  .about-mission__bg {
    position: absolute; inset: 0; opacity: 0.10; pointer-events: none;
    overflow: hidden;
  }
  .about-mission__bg .editorial-image { width: 100%; height: 100%; object-fit: cover; }
  .about-mission__inner {
    position: relative; z-index: 1; max-width: 48rem;
  }
  .about-mission__eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--haldi);
  }
  .about-mission__title {
    margin-top: 0.875rem; font-family: var(--font-display); font-style: italic;
    font-size: clamp(1.75rem, 4vw, 3.25rem); line-height: 1.15;
    color: var(--paper); text-wrap: balance;
  }
  .about-mission__sub {
    margin-top: 1.5rem; color: rgba(250, 248, 241, 0.78);
    line-height: 1.7; max-width: 60ch;
  }
  .about-mission__cta { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* ===== COMPANY PLATE (V5: premium feel — border-top per row, bumped label
     letter-spacing, aligned values column) ===== */
  .company-plate-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  /* V7: a formal ledger reads at 56rem, not stretched across 1400px. */
  .company-plate { max-width: 56rem; }
  .company-plate__head { margin-bottom: 2rem; }
  /* V5: remove the parent's border-top so each row's border-top reads as a
     clean separator (no double line on the first row). */
  .company-plate { border-top: 0; margin-top: 0; }
  .company-plate__row {
    padding: 1.25rem 0;  /* V5: more breathing room (was 1rem 0) */
    border-top: 1px solid var(--border);  /* V5: border-top (was border-bottom) */
    border-bottom: 0;
    align-items: baseline;
  }
  .company-plate__row:last-child {
    border-bottom: 1px solid var(--border);  /* V5: closing line */
  }
  .company-plate dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;  /* V5: 0.14em → 0.18em */
    text-transform: uppercase; color: var(--fg-muted);
  }
  .company-plate dd { color: var(--fg); }
  .company-plate__address { white-space: pre-line; }
</style>

<!-- ===== HERO (V7: 5/7 — brand identity left, real product plate right) ===== -->
<section class="about-hero bg-limewash" aria-labelledby="about-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>About</span>
    </nav>
    <div class="about-hero__container" data-reveal>
      <div class="about-hero__lockup">
        <span class="about-hero__deva"><?= e($COMPANY['devanagari']) ?></span>
        <span class="about-hero__brand-sub">Gaurikrit Bio Products</span>
        <h1 class="about-hero__title" id="about-title">Nature. Culture. Useful materials.</h1>
        <p class="about-hero__body">
          <?= e($COMPANY['legalName']) ?> makes Prakritik Paint — a cow dung-based
          paint in two formats, Distemper and Emulsion, for interior and
          exterior walls. The company is based in <?= e($address[3] ?? '') ?>,
          <?= e($address[4] ?? '') ?>, Uttar Pradesh.
        </p>
      </div>
      <div class="about-hero__plate">
        <div class="about-hero__plate-head">
          <img class="about-hero__plate-mark"
               src="<?= asset_url('/assets/brand/gaurikrit-logo-mark.png') ?>"
               alt="Gaurikrit brand mark"
               width="40" height="40"
               loading="eager" decoding="async">
          <div class="about-hero__plate-brand">
            गौरीकृत
            <small>Prakritik Paint</small>
          </div>
        </div>
        <img class="about-hero__plate-photo"
             src="<?= asset_url('/assets/products/prakritik-group.jpg') ?>"
             alt="Prakritik Distemper and Emulsion paint packs"
             width="1280" height="621"
             loading="eager" fetchpriority="high" decoding="async">
      </div>
    </div>
  </div>
</section>

<!-- ===== WHO WE ARE (V7: 35/65 — identity left, body right) ===== -->
<section class="section section--paper about-wrap" aria-labelledby="who-title">
  <div class="container">
    <div class="about-section" data-reveal>
      <div>
        <span class="about-section__eyebrow">Who we are</span>
        <p class="about-section__lead">
          <?= e($COMPANY['legalName']) ?> — a One Person Company registered in
          <?= e($address[4] ?? '') ?>, <?= e($address[5] ?? '') ?>.
        </p>
      </div>
      <div class="about-section__body">
        <p>
          <?= e($COMPANY['name']) ?> makes Prakritik Paint, a cow dung-based
          paint in two formats: Prakritik Distemper and Prakritik
          Emulsion. Both are matt finish, listed for interior and
          exterior use.
        </p>
        <p>
          The company carries an old Indian material idea — cow dung on walls —
          into a contemporary paint format. A useful
          material, reconsidered for modern walls.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHAT WE CURRENTLY PRESENT — 2 real product photos ===== -->
<section class="section section--limewash about-products-section" aria-labelledby="present-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">What we currently present</span>
      <h2 class="section-heading__title" id="present-title">Two paint formats.</h2>
      <p class="section-heading__desc">
        Cow dung-based, matt finish, interior &amp; exterior usage.
      </p>
    </div>

    <div class="about-products" data-reveal-stagger>
      <article class="about-product-card">
        <div class="about-product-card__media about-product-card__media--distemper">
          <img class="about-product-photo"
               src="<?= asset_url($distemper['officialImage']) ?>"
               alt="<?= e($distemper['name']) ?>"
               width="510" height="538"
               loading="lazy" decoding="async">
        </div>
        <h3 class="about-product-card__name"><?= e($distemper['name']) ?></h3>
        <p class="about-product-card__desc">
          <?= e($distemper['packagingShort']) ?> packs · <?= e($distemper['coverage']) ?> coverage · <?= e($distemper['finish']) ?> finish.
        </p>
        <a class="about-product-card__link" href="<?= e($distemper['route']) ?>">View Distemper →</a>
      </article>
      <article class="about-product-card">
        <div class="about-product-card__media about-product-card__media--emulsion">
          <img class="about-product-photo"
               src="<?= asset_url($emulsion['officialImage']) ?>"
               alt="<?= e($emulsion['name']) ?>"
               width="355" height="486"
               loading="lazy" decoding="async">
        </div>
        <h3 class="about-product-card__name"><?= e($emulsion['name']) ?></h3>
        <p class="about-product-card__desc">
          <?= e($emulsion['packagingShort']) ?> packs · <?= e($emulsion['coverage']) ?> coverage · <?= e($emulsion['finish']) ?> finish.
        </p>
        <a class="about-product-card__link" href="<?= e($emulsion['route']) ?>">View Emulsion →</a>
      </article>
    </div>
  </div>
</section>

<!-- ===== MATERIAL DIRECTION — zebu-study beside wall ===== -->
<section class="section section--paper about-direction-section" aria-labelledby="direction-title">
  <div class="container">
    <div class="about-section" data-reveal>
      <div>
        <span class="about-section__eyebrow">Material direction</span>
        <p class="about-section__lead">
          An old Indian material idea, carried into a contemporary paint format.
        </p>
        <div class="about-section__body">
          <p>
            Cow dung has been used on Indian walls and floors for generations.
            Gaurikrit offers cow dung-based Prakritik Paint in two formats.
          </p>
          <p>
            The cow is in the material. The wall is where it goes.
          </p>
        </div>
        <div class="about-mission__cta" style="margin-top: 1.5rem;">
          <a class="btn btn--primary" href="/why-prakritik/">Why Prakritik</a>
        </div>
      </div>
      <div class="about-direction__visual" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/zebu-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/zebu-study.jpg') ?>"
               alt="Editorial study of an Indian zebu cow"
               width="1536" height="1024"
               loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ===== MISSION BAND — rural-landscape engraving ===== -->
<section class="about-mission" aria-labelledby="about-mission-title">
  <div class="about-mission__bg" aria-hidden="true">
    <picture>
      <source type="image/webp" srcset="<?= asset_url('/assets/editorial/rural-landscape.webp') ?>">
      <img class="editorial-image"
           src="<?= asset_url('/assets/editorial/rural-landscape.jpg') ?>"
           alt=""
           width="1344" height="768"
           loading="lazy" decoding="async">
    </picture>
  </div>
  <div class="container">
    <div class="about-mission__inner" data-reveal>
      <span class="about-mission__eyebrow">Our direction</span>
      <h2 class="about-mission__title" id="about-mission-title">
        <?= e($COMPANY['mission']) ?>
      </h2>
      <p class="about-mission__sub">
        <?= e($COMPANY['brandLine']) ?>
      </p>
      <div class="about-mission__cta">
        <a class="btn btn--haldi" href="/products/">Explore Prakritik Paint</a>
        <a class="btn btn--secondary" href="/contact/">Talk to Us</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== COMPANY INFORMATION — modern ledger plate ===== -->
<section class="section section--paper company-plate-section" aria-labelledby="company-info-title">
  <div class="container">
    <div class="company-plate__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Company information</span>
      <h2 class="section-heading__title" id="company-info-title">A registered Indian company.</h2>
    </div>

    <dl class="company-plate" data-reveal>
      <div class="company-plate__row">
        <dt>Legal name</dt>
        <dd><?= e($COMPANY['legalName']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>Brand name</dt>
        <dd><?= e($COMPANY['name']) ?> · <?= e($COMPANY['devanagari']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>GSTIN</dt>
        <dd><?= e($COMPANY['gstin']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>Email</dt>
        <dd>
          <a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a>
        </dd>
      </div>
      <?php foreach ($COMPANY['phones'] as $phone): ?>
        <div class="company-plate__row">
          <dt>Phone</dt>
          <dd>
            <a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a>
          </dd>
        </div>
      <?php endforeach; ?>
      <div class="company-plate__row">
        <dt>Registered address</dt>
        <dd class="company-plate__address"><?= e($addressLine) ?></dd>
      </div>
    </dl>

    <div class="company-info__actions" style="margin-top: 2.5rem;">
      <a class="btn btn--primary" href="/contact/">Talk to Us</a>
      <a class="btn btn--outline" href="/for-business/">For Business</a>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
