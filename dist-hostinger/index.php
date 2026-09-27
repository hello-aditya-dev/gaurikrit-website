<?php
/**
 * Gaurikrit Bio Products — Homepage (V16 story restructure).
 *
 * THE STORY: one natural resource → multiple useful material solutions →
 * one circular-economy mission. A visitor understands the company from
 * this page alone (§74 story test).
 *
 * Section order (§12) — exact:
 *   01 HERO                    limewash      material-led field, NOT a
 *                                           paint advert (real pair photo
 *                                           + branching category markers)
 *   02 FROM WASTE TO RESOURCE  paper         RAW MATERIAL → MATERIAL
 *                                           DEVELOPMENT → USEFUL APPLICATIONS
 *   03 ONE RESOURCE, FOUR      haldi-wash    2×2 editorial chapters,
 *      SOLUTIONS                             Eco-Paints = real imagery;
 *                                           others = type/material plates
 *                                           (never fake product photos)
 *   04 NOTHING GOES TO WASTE   paper         7-stage continuous circular
 *                                           loop, progressive highlight
 *   05 SOLUTIONS FOR MODERN    limewash     application matrix —
 *      INDIA                                APPLICATION DIRECTIONS labels
 *   06 WHY GAURIKRIT           haldi-wash   four ruled principles
 *   07 IMPACT AREAS            paper        five QUALITATIVE areas —
 *                                           no numbers, no fake counters
 *   08 RESEARCH & INNOVATION   limewash     5 focus areas → /innovation/
 *   09 VISION + MISSION        forest       two columns
 *   10 PARTNERSHIP CTA         paper        audience strip + 2 CTAs
 *   11 FOOTER                  forest       (shared include)
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

global $COMPANY, $FAMILIES, $CIRCULAR_STAGES, $APPLICATION_GROUPS,
       $WHY_PRINCIPLES, $IMPACT_AREAS, $INNOVATION_AREAS, $PARTNER_AUDIENCES;

$pairImage = '/assets/products/prakritik-pair.jpg';
?>
<style>
  /* ===== 01. HERO — story lockup 5 / material field 7 ===== */
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

  /* ===== 02. RESOURCE STEPS — page-local rhythm only (structure §42.2) ===== */
  .resource-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 03. FOUR SOLUTIONS — page-local rhythm (structure §42.3) ===== */
  .families-section__head { max-width: 48rem; margin-bottom: 2.75rem; }

  /* ===== 04. CIRCULAR MODEL — page-local rhythm (structure §42.4) ===== */
  .circular-section__head { max-width: 48rem; margin-bottom: 2.75rem; }

  /* ===== 05. APPLICATIONS MATRIX (structure §42.5) ===== */
  .applications-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 08. INNOVATION TEASER — material research composition + rows ===== */
  .innov-teaser__grid {
    display: grid; grid-template-columns: 1fr; gap: 2.5rem; align-items: center;
  }
  @media (min-width: 1024px) { .innov-teaser__grid { grid-template-columns: 5fr 7fr; gap: 3.5rem; } }
  .innov-composition { position: relative; min-height: 18rem; }
  .innov-composition__plate {
    position: absolute; overflow: hidden;
    border: 1px solid var(--border); border-radius: var(--r-card);
    background: var(--paper);
  }
  .innov-composition__plate img {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }
  .innov-composition__plate--a { left: 0; top: 0; width: 62%; aspect-ratio: 4 / 3; }
  .innov-composition__plate--b { right: 0; bottom: 0; width: 52%; aspect-ratio: 4 / 3; }
  .innov-composition__plate--b::after {
    content: ""; position: absolute; left: 0; top: 0; width: 2.5rem; height: 0.25rem;
    background: var(--haldi);
  }
  .innov-composition__tag {
    position: absolute; left: 0; bottom: -0.5rem; transform: translateY(100%);
    font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted); padding-top: 1rem;
  }

  /* ===== 10. PARTNERSHIP — page-local rhythm ===== */
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

      <!-- Material-led field: real Prakritik Paint photography + texture +
           branching category markers + restrained haldi/forest chips.
           NOT a paint advertisement — one resource → many applications. -->
      <div class="hero__visual" data-reveal>
        <figure class="story-field" aria-label="Gaurikrit material field — Prakritik Paint products and the four ecosystem directions">
          <div class="story-field__texture" aria-hidden="true">
            <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>" alt="" width="1344" height="768" loading="eager" decoding="async">
          </div>
          <div class="story-field__chips" aria-hidden="true">
            <span class="story-field__chip story-field__chip--haldi"></span>
            <span class="story-field__chip story-field__chip--forest"></span>
          </div>
          <div class="story-field__inner">
            <img class="story-field__photo"
                 src="<?= asset_url($pairImage) ?>"
                 alt="Prakritik Distemper and Prakritik Emulsion paint packs — the documented Eco-Paints family"
                 width="1420" height="618"
                 loading="eager" fetchpriority="high" decoding="async">
            <figcaption class="story-field__markers">
              <span class="story-field__marker story-field__marker--lead">
                <span class="story-field__marker-dot" aria-hidden="true"></span>
                <span class="story-field__marker-name">Eco-Paints</span>
                <span class="story-field__marker-tag">Documented</span>
              </span>
              <span class="story-field__marker">
                <span class="story-field__marker-dot" aria-hidden="true"></span>
                <span class="story-field__marker-name">GoCast Logs</span>
                <span class="story-field__marker-tag">Direction</span>
              </span>
              <span class="story-field__marker">
                <span class="story-field__marker-dot" aria-hidden="true"></span>
                <span class="story-field__marker-name">Bio-Coal Logs</span>
                <span class="story-field__marker-tag">Direction</span>
              </span>
              <span class="story-field__marker">
                <span class="story-field__marker-dot" aria-hidden="true"></span>
                <span class="story-field__marker-name">Utility Products</span>
                <span class="story-field__marker-tag">Direction</span>
              </span>
            </figcaption>
          </div>
        </figure>
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
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/raw-material-study.webp') ?>">
            <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
                 alt="Raw natural material — a lime-plastered surface study"
                 width="1344" height="768" loading="lazy" decoding="async">
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
            <source type="image/webp" srcset="<?= asset_url('/assets/products/prakritik-distemper-from-pair.webp') ?>">
            <img src="<?= asset_url('/assets/products/prakritik-distemper-from-pair.png') ?>"
                 alt="Prakritik Distemper paint pack — developed natural material"
                 width="649" height="612" loading="lazy" decoding="async">
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
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/finished-surface-study.webp') ?>">
            <img src="<?= asset_url('/assets/editorial/finished-surface-study.jpg') ?>"
                 alt="Finished matte wall surface — a useful application"
                 width="1344" height="768" loading="lazy" decoding="async">
          </picture>
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 03</span>
          <h3 class="resource-step__title">Useful Applications</h3>
          <p class="resource-step__desc">
            Products for walls, energy and everyday use — nothing goes to waste.
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
      $familyMedia = [
          'eco-paints'        => 'photo',
          'gocast-logs'       => 'plate',
          'bio-coal-logs'     => 'plate',
          'utility-products'  => 'plate',
      ];
      $plateTexture = [
          'gocast-logs'       => '/assets/editorial/raw-material-study.jpg',
          'bio-coal-logs'     => '/assets/editorial/exterior-finish-study.jpg',
          'utility-products'  => '/assets/editorial/courtyard-study.jpg',
      ];
      $plateTextureWebp = [
          'gocast-logs'       => '/assets/editorial/raw-material-study.webp',
          'bio-coal-logs'     => '/assets/editorial/exterior-finish-study.webp',
          'utility-products'  => '/assets/editorial/courtyard-study.webp',
      ];
      foreach ($FAMILIES as $family): ?>
        <article class="family" id="family-<?= e($family['id']) ?>">
          <?php if ($familyMedia[$family['id']] === 'photo'): ?>
            <figure class="family__media family__media--photo">
              <img src="<?= asset_url($pairImage) ?>"
                   alt="Prakritik Distemper and Emulsion paint packs — the Eco-Paints family"
                   width="1420" height="618" loading="lazy" decoding="async">
            </figure>
          <?php else: ?>
            <figure class="family__media family__media--plate" aria-label="<?= e($family['name']) ?> — material direction">
              <span class="family__media-plate-texture" aria-hidden="true">
                <picture>
                  <source type="image/webp" srcset="<?= asset_url($plateTextureWebp[$family['id']]) ?>">
                  <img src="<?= asset_url($plateTexture[$family['id']]) ?>" alt="" width="1344" height="768" loading="lazy" decoding="async">
                </picture>
              </span>
              <span class="family__media-plate-word"><?= e($family['name']) ?></span>
              <span class="family__media-plate-tag">Material direction</span>
            </figure>
          <?php endif; ?>

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
     04. NOTHING GOES TO WASTE — the circular model (§19–20)
     One continuous loop. Progressive highlight via story.js
     (progressive enhancement — everything readable without JS).
     ============================================================ -->
<section class="section section--paper circular-section" aria-labelledby="circular-title">
  <div class="container">
    <div class="circular-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Circular Model</span>
      <h2 class="section-heading__title" id="circular-title">Nothing Goes to Waste.</h2>
      <p class="section-heading__desc">
        One continuous cycle: the resource enters, is developed, becomes useful
        products — and creates a new value cycle.
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
      <!-- The return path — resource regeneration closes the loop. -->
      <svg class="circular__loop-path" viewBox="0 0 1000 28" preserveAspectRatio="none" aria-hidden="true">
        <path d="M8,2 L8,20 C8,26 16,26 26,26 L974,26 C984,26 992,26 992,20 L992,10" />
      </svg>
      <span class="circular__loop-label" aria-hidden="true">Resource regeneration</span>
    </div>
  </div>
</section>

<!-- ============================================================
     05. SOLUTIONS FOR MODERN INDIA — application matrix (§21–22)
     Organised by APPLICATION. Undocumented subcategories are
     labelled APPLICATION DIRECTIONS, never products for sale.
     ============================================================ -->
<section class="section section--limewash applications-section" aria-labelledby="applications-title">
  <div class="container">
    <div class="applications-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Application Areas</span>
      <h2 class="section-heading__title" id="applications-title">Sustainable Solutions for Modern India.</h2>
      <p class="section-heading__desc">
        Where the ecosystem works — buildings, energy, traditional applications
        and everyday living.
      </p>
    </div>

    <div class="app-matrix" data-reveal-stagger>
      <?php foreach ($APPLICATION_GROUPS as $group): ?>
        <div class="app-group">
          <h3 class="app-group__title"><?= e($group['title']) ?></h3>
          <ul class="app-group__list">
            <?php foreach ($group['items'] as $item): ?>
              <li class="app-group__item<?= $item['live'] ? ' app-group__item--live' : ' app-group__item--direction' ?>">
                <?php if ($item['href']): ?>
                  <a href="<?= e($item['href']) ?>"><?= e($item['name']) ?></a>
                <?php else: ?>
                  <span><?= e($item['name']) ?></span>
                <?php endif; ?>
                <span class="app-group__item-tag"><?= $item['live'] ? 'Family' : 'Direction' ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="app-matrix-note" data-reveal>
      Entries marked <strong>Direction</strong> are application areas under exploration —
      not products currently for sale. Eco-Paints is the documented family.
    </p>
  </div>
</section>

<!-- ============================================================
     06. WHY GAURIKRIT — four principles (§23)
     ============================================================ -->
<section class="section section--haldi-wash principles-section" aria-labelledby="principles-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Why Gaurikrit</span>
      <h2 class="section-heading__title" id="principles-title">What Makes Us Different.</h2>
    </div>
    <div class="principles-grid" data-reveal-stagger>
      <?php foreach ($WHY_PRINCIPLES as $principle): ?>
        <div class="principle">
          <span class="principle__num" aria-hidden="true"><?= e($principle['num']) ?></span>
          <h3 class="principle__name"><?= e($principle['name']) ?></h3>
          <p class="principle__desc"><?= e($principle['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     07. IMPACT AREAS — qualitative, NO counters (§24 / §3)
     ============================================================ -->
<section class="section section--paper impact-section" aria-labelledby="impact-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">How Impact Is Created</span>
      <h2 class="section-heading__title" id="impact-title">Every Product Creates Change.</h2>
      <p class="section-heading__desc">
        Five impact areas — described qualitatively. Verified figures will be
        published as project data becomes available.
      </p>
    </div>
    <div class="impact-list" data-reveal-stagger>
      <?php foreach ($IMPACT_AREAS as $area): ?>
        <div class="impact-row">
          <span class="impact-row__label"><?= e($area['label']) ?></span>
          <span class="impact-row__area"><?= e($area['area']) ?></span>
          <p class="impact-row__desc"><?= e($area['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="impact-note" data-reveal>
      Impact measurement will be added as verified project data becomes available.
      <a href="/sustainability/">Read the sustainability framework →</a>
    </p>
  </div>
</section>

<!-- ============================================================
     08. RESEARCH & INNOVATION — focus areas teaser (§25)
     ============================================================ -->
<section class="section section--limewash innov-teaser" aria-labelledby="innov-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Research &amp; Innovation</span>
      <h2 class="section-heading__title" id="innov-title">Where Tradition Meets Technology.</h2>
    </div>
    <div class="innov-teaser__grid" data-reveal>
      <div class="innov-composition" aria-hidden="true">
        <span class="innov-composition__plate innov-composition__plate--a">
          <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>" alt="" width="1344" height="768" loading="lazy" decoding="async">
        </span>
        <span class="innov-composition__plate innov-composition__plate--b">
          <img src="<?= asset_url('/assets/editorial/finished-surface-study.jpg') ?>" alt="" width="1344" height="768" loading="lazy" decoding="async">
        </span>
        <span class="innov-composition__tag">Material research directions</span>
      </div>
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
     09. VISION + MISSION — strong Forest section (§26)
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
          To replace less sustainable alternatives with practical, accessible and
          environmentally responsible product solutions.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     10. PARTNERSHIP CTA (§27)
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
