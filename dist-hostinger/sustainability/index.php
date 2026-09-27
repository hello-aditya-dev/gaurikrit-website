<?php
/**
 * Gaurikrit Bio Products — Sustainability (V16 NEW route /sustainability/).
 *
 * The broader circular-economy framework (§38), in order:
 *   HERO       One Resource. A Wider Material Cycle.
 *   S1         Circular Economy           — the seven-stage loop
 *   S2         Resource Utilisation       — one resource, many applications
 *   S3         Impact Areas               — five qualitative areas, NO
 *                                           numbers, no fake counters
 *   S4         Applications that Replace Less Sustainable Alternatives
 *   S5         Rural Value Creation
 *   S6         Measurement Framework      — numbers only when verified
 *
 * Visual language (§39): materials, flows, product categories — NO green-leaf
 * clichés, no planet icons, no fake graphs, no tonnes-saved charts.
 * A MATERIAL SYSTEM, not a marketing dashboard.
 */
declare(strict_types=1);

$pageTitle       = 'Sustainability & Circular Economy — Gaurikrit';
$pageDescription = 'Gaurikrit\'s sustainability framework: circular economy, resource utilisation, qualitative impact areas, applications that replace less sustainable alternatives, rural value creation and the measurement framework.';
$pageCanonical   = '/sustainability/';
$pageClass       = 'sustainability';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $CIRCULAR_STAGES, $IMPACT_AREAS, $APPLICATION_GROUPS;

$measurementItems = [
    ['name' => 'Trees / Resource conservation', 'desc' => 'Trees saved through GoCast and material directions — measured when verified project data is available.'],
    ['name' => 'Waste / Material reuse',        'desc' => 'Natural and agricultural material streams carried into products.'],
    ['name' => 'Energy / Fossil fuel replaced', 'desc' => 'Biomass fuel applications replacing conventional fuel use.'],
    ['name' => 'Carbon / Reduction',            'desc' => 'Emissions reduction from verified lifecycle analysis.'],
    ['name' => 'Rural livelihoods',             'desc' => 'Additional value created around agricultural ecosystems.'],
];
?>
<style>
  /* ===== PAGE HERO — story-hero (shared §42.11) + material plate ===== */
  .sustain-hero__grid {
    display: grid; gap: clamp(2rem, 4vw, 4rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) { .sustain-hero__grid { grid-template-columns: 7fr 5fr; } }
  .sustain-hero__plate {
    position: relative; aspect-ratio: 4 / 3;
    border: 1px solid var(--border); border-radius: var(--r-panel);
    overflow: hidden; background: var(--paper);
  }
  .sustain-hero__plate img {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  .sustain-hero__plate::after {
    content: ""; position: absolute; left: 0; top: 0; width: 2.5rem; height: 0.25rem;
    background: var(--haldi);
  }

  /* ===== Section rhythm (page-local wrappers only — grounds come from
     the five families; structures are shared §42 blocks). ===== */
  .sustain-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
</style>

<!-- ============================================================
     HERO — One Resource. A Wider Material Cycle.
     ============================================================ -->
<section class="story-hero bg-limewash" aria-labelledby="sustain-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Sustainability</span>
    </nav>
    <div class="sustain-hero__grid" data-reveal>
      <div>
        <span class="eyebrow">Sustainability &amp; Circular Economy</span>
        <h1 class="story-hero__title" id="sustain-title">One Resource. A Wider Material Cycle.</h1>
        <p class="story-hero__lead">
          Gaurikrit's sustainability approach is a material system, not a
          marketing dashboard: one natural resource, developed into useful
          products, in a cycle designed so nothing goes to waste.
        </p>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--primary" href="#impact-areas">How Impact Is Created</a>
          <a class="btn btn--secondary" href="/about/">Our Story</a>
        </div>
      </div>
      <figure class="sustain-hero__plate">
        <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
             alt="Natural lime-plastered material surface — the resource beginning of the material cycle"
             width="1344" height="768"
             loading="eager" fetchpriority="high" decoding="async">
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     S1. CIRCULAR ECONOMY — the seven-stage loop (§38)
     ============================================================ -->
<section class="section section--paper" id="circular-economy" aria-labelledby="circ-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 01 — Circular Economy</span>
      <h2 class="section-heading__title" id="circ-title">The cycle is the product system.</h2>
      <p class="section-heading__desc">
        Gaurikrit's circular model describes how the resource enters, is
        developed, becomes useful products — and renews the cycle.
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
      <svg class="circular__loop-path" viewBox="0 0 1000 28" preserveAspectRatio="none" aria-hidden="true">
        <path d="M8,2 L8,20 C8,26 16,26 26,26 L974,26 C984,26 992,26 992,20 L992,10" />
      </svg>
      <span class="circular__loop-label" aria-hidden="true">Resource regeneration</span>
    </div>
  </div>
</section>

<!-- ============================================================
     S2. RESOURCE UTILISATION
     ============================================================ -->
<section class="section section--haldi-wash" id="resource-utilisation" aria-labelledby="util-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 02 — Resource Utilisation</span>
      <h2 class="section-heading__title" id="util-title">One resource, used many ways.</h2>
      <p class="section-heading__desc">
        The same natural material base is developed into wall coatings, fuel
        directions and utility directions — value multiplied by application,
        not extraction.
      </p>
    </div>
    <div class="resource-steps" data-reveal-stagger>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
               alt="Raw natural material study"
               width="1344" height="768" loading="lazy" decoding="async">
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Input</span>
          <h3 class="resource-step__title">Natural &amp; agricultural streams</h3>
          <p class="resource-step__desc">Material that already exists in rural ecosystems.</p>
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
          <span class="resource-step__kicker">Development</span>
          <h3 class="resource-step__title">Working materials</h3>
          <p class="resource-step__desc">Processed and developed into useful material families.</p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          <img src="<?= asset_url('/assets/editorial/finished-surface-study.jpg') ?>"
               alt="Finished matte wall surface — useful application"
               width="1344" height="768" loading="lazy" decoding="async">
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Output</span>
          <h3 class="resource-step__title">Everyday applications</h3>
          <p class="resource-step__desc">Walls, energy and daily-use directions from one base.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     S3. IMPACT AREAS — qualitative, NO counters (§38 S3 / §24)
     ============================================================ -->
<section class="section section--paper" id="impact-areas" aria-labelledby="imp-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 03 — Impact Areas</span>
      <h2 class="section-heading__title" id="imp-title">How impact is created.</h2>
      <p class="section-heading__desc">
        Five areas, described qualitatively — no numbers until verified data
        exists.
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
      Verified figures will be published as project data becomes available —
      see the measurement framework below.
    </p>
  </div>
</section>

<!-- ============================================================
     S4. APPLICATIONS THAT REPLACE LESS SUSTAINABLE ALTERNATIVES
     ============================================================ -->
<section class="section section--limewash" id="replacing" aria-labelledby="rep-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 04 — Replacement</span>
      <h2 class="section-heading__title" id="rep-title">Applications that replace less sustainable alternatives.</h2>
      <p class="section-heading__desc">
        Every ecosystem direction exists to substitute a conventional,
        resource-intensive alternative.
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
  </div>
</section>

<!-- ============================================================
     S5. RURAL VALUE CREATION
     ============================================================ -->
<section class="section section--haldi-wash" id="rural-value" aria-labelledby="rural-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">05</span>
        <span class="story-chapter__kicker">Rural Value Creation</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="rural-title">Value created where the resource already is.</h2>
        <div class="story-chapter__body">
          <p>
            Cow dung is gathered in rural and agricultural ecosystems. Developing
            it into products creates additional value around those ecosystems —
            for households, gaushalas and agricultural communities.
          </p>
          <p class="muted">
            Gaurikrit works with Gaushalas and institutions exploring
            cow-dung-based bio-products — see <a href="/for-business/">Partners</a>.
          </p>
        </div>
        <figure class="story-chapter__visual">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/rural-landscape.webp') ?>">
            <img src="<?= asset_url('/assets/editorial/rural-landscape.jpg') ?>"
                 alt="Rural agricultural landscape — where the material cycle begins"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
          <figcaption>Rural landscape study — the resource context of the material cycle.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     S6. MEASUREMENT FRAMEWORK — numbers only when verified (§38)
     ============================================================ -->
<section class="section section--paper" id="measurement" aria-labelledby="meas-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 06 — Measurement Framework</span>
      <h2 class="section-heading__title" id="meas-title">What we will measure — and how it appears.</h2>
      <p class="section-heading__desc">
        Quantified impact is published only when verified project data exists.
        Nothing on this page is a projected, estimated or aspirational number.
      </p>
    </div>
    <div class="measure-list" data-reveal-stagger>
      <?php foreach ($measurementItems as $item): ?>
        <div class="measure-item">
          <span class="measure-item__name"><?= e($item['name']) ?></span>
          <p class="measure-item__desc"><?= e($item['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <div style="margin-top: 2.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem;" data-reveal>
      <a class="btn btn--primary" href="/innovation/">Research &amp; Innovation</a>
      <a class="btn btn--outline" href="/contact/">Discuss a Collaboration</a>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
