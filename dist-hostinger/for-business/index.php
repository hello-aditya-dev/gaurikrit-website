<?php
/**
 * Gaurikrit Bio Products — For Business (V4 asset replacement pass).
 * Task V4-ASSETS.
 *
 * Composition unchanged from V3. This pass replaces coded SVG
 * illustrations with real editorial artwork. NO floating blob.
 *
 * Composition:
 *   1. Hero — text left / architectural-elevation right (NO floating blob).
 *   2. Audiences — shared rural-landscape + 4 ruled columns (NO cards).
 *   3. Practical section — "When you enquire, it helps to include" + list.
 *   4. Business Form — 12-col layout (left 4 help/contact, right 8 fields).
 *      CTA "Discuss a Project". Posts to /api/business-enquiry.php.
 *      csrf_field() + honeypot.
 */
declare(strict_types=1);

$pageTitle       = 'For Business — Architects, Builders, CSR, NGOs, Gaushalas | Gaurikrit';
$pageDescription = 'Discuss Prakritik Paint for residential, commercial, institutional, CSR / NGO and Gaushala collaboration projects with Gaurikrit Bio Products.';
$pageCanonical   = '/for-business/';
$pageClass        = 'for-business';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PROJECT_TYPES;

$phones = $COMPANY['phones'] ?? [];

$audiences = [
    ['num' => '01', 'title' => 'Architects & Builders',
     'desc' => 'Discuss product and project requirements for residential, commercial, or institutional work.'],
    ['num' => '02', 'title' => 'Institutions / CSR',
     'desc' => 'Talk to Gaurikrit about institutional or sustainability-led projects.'],
    ['num' => '03', 'title' => 'CSR / NGOs',
     'desc' => 'Discuss sustainability-led projects and community paint programmes.'],
    ['num' => '04', 'title' => 'Gaushalas / Partners',
     'desc' => 'Explore collaboration around cow-dung-based bio-products.'],
];

$helpfulInclude = [
    ['label' => 'Project type',      'hint' => 'Residential / Commercial / Institutional / CSR-NGO / Gaushala / Other'],
    ['label' => 'City',              'hint' => 'Where the site is located'],
    ['label' => 'Approximate wall area', 'hint' => 'In sq.ft. if you have a number'],
    ['label' => 'Paint format',      'hint' => 'Distemper, Emulsion, or not sure yet'],
    ['label' => 'Approximate requirement', 'hint' => 'Number of packs or litres you expect to need'],
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

  /* ===== HERO (text left / architectural-elevation right — NO floating blob) ===== */
  .biz-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) { .biz-hero { padding-bottom: 2.5rem; } }
  .biz-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .biz-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .biz-hero__lockup { max-width: 42rem; }
  .biz-hero__art {
    position: relative; aspect-ratio: 1344/768; background: var(--paper-cool);
    border-radius: var(--r-panel); overflow: hidden;
  }
  .biz-hero__art .editorial-image {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }

  /* ===== AUDIENCES (shared editorial image + 4 ruled columns) ===== */
  .biz-audiences-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-audiences-illustration {
    position: relative;
    margin-bottom: 3rem;
    aspect-ratio: 1344/768;
    width: 100%; overflow: hidden;
    border-radius: var(--r-panel);
  }
  .biz-audiences-illustration .editorial-image {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }
  .biz-audiences__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== PRACTICAL SECTION ===== */
  .biz-practical { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-practical__grid {
    display: grid; gap: 2rem; align-items: start;
  }
  @media (min-width: 768px) {
    .biz-practical__grid { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .biz-practical__head { max-width: 36rem; }
  .biz-practical__title {
    font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem);
    line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance;
  }
  .biz-practical__body {
    margin-top: 1rem; color: var(--fg-muted); line-height: 1.65;
  }
  .biz-practical__list {
    display: grid; gap: 0;
    border-top: 1px solid var(--border);
  }
  .biz-practical__item {
    display: grid; gap: 0.5rem; padding: 1rem 0;
    border-bottom: 1px solid var(--border);
    grid-template-columns: 1fr;
  }
  @media (min-width: 768px) {
    .biz-practical__item { grid-template-columns: 14rem 1fr; gap: 1rem; align-items: baseline; }
  }
  .biz-practical__item-label {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .biz-practical__item-hint { font-size: 0.9375rem; color: var(--fg); }

  /* ===== FORM (12-col: left 4 help/contact, right 8 fields) ===== */
  .biz-form-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-form-layout__aside { display: flex; flex-direction: column; gap: 1.5rem; }
  .biz-form-layout__aside .help-cta { padding: 1.5rem; }
  .biz-form-card {
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); padding: 1.5rem;
  }
  @media (min-width: 768px) { .biz-form-card { padding: 2rem; } }
  .biz-form-card__intro { font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 1.5rem; }
  .biz-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.25rem; }
  .biz-aside-card {
    border-top: 1px solid var(--border); padding: 0; background: transparent;
  }
  .biz-aside-card__row { padding-block: 1rem; border-bottom: 1px solid var(--border); }
  .biz-aside-card dt { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
</style>

<!-- ===== HERO ===== -->
<section class="biz-hero bg-limewash" aria-labelledby="biz-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>For Business</span>
    </nav>
    <div class="biz-hero__container" data-reveal>
      <div class="biz-hero__lockup">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>For Business</span>
        <hr class="biz-hero__rule">
        <h1 class="biz-hero__title" id="biz-title">Discuss a project with Gaurikrit.</h1>
        <p class="biz-hero__sub">
          For architects, builders, institutions, CSR programmes, NGOs and
          Gaushalas. Tell us about the project — site, scale, and what you are
          painting — and we will talk through Prakritik Distemper and Emulsion
          for your context.
        </p>
        <div class="biz-hero__ctas">
          <a class="btn btn--primary btn--lg" href="#enquire">Discuss a Project</a>
          <a class="btn btn--outline" href="/products/">Explore Products</a>
        </div>
      </div>
      <div class="biz-hero__art" aria-hidden="true">
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/architectural-elevation.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/architectural-elevation.jpg') ?>"
               alt="Architectural building elevation study"
               width="1344" height="768"
               loading="eager" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ===== AUDIENCES — shared editorial image + 4 ruled columns ===== -->
<section class="section section--paper biz-audiences-section" aria-labelledby="audiences-title">
  <div class="container">
    <div class="biz-audiences__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Who this is for</span>
      <h2 class="section-heading__title" id="audiences-title">Audiences.</h2>
    </div>

    <div class="biz-audiences-illustration" aria-hidden="true" data-reveal>
      <picture>
        <source type="image/webp" srcset="<?= asset_url('/assets/editorial/rural-landscape.webp') ?>">
        <img class="editorial-image"
             src="<?= asset_url('/assets/editorial/rural-landscape.jpg') ?>"
             alt=""
             width="1344" height="768"
             loading="lazy" decoding="async">
      </picture>
    </div>

    <div class="biz-audiences" data-reveal-stagger>
      <?php foreach ($audiences as $a): ?>
        <div class="audience-card">
          <span class="audience-card__num"><?= e($a['num']) ?></span>
          <h3 class="audience-card__title"><?= e($a['title']) ?></h3>
          <p class="audience-card__desc"><?= e($a['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== PRACTICAL SECTION — "When you enquire, it helps to include" ===== -->
<section class="section section--limewash biz-practical" aria-labelledby="include-title">
  <div class="container">
    <div class="biz-practical__grid" data-reveal>
      <div class="biz-practical__head">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>Practical</span>
        <h2 class="biz-practical__title" id="include-title">When you enquire, it helps to include.</h2>
        <p class="biz-practical__body">
          A few practical details up front let us give you a useful response —
          not a "we will get back to you" placeholder.
        </p>
      </div>
      <ul class="biz-practical__list">
        <?php foreach ($helpfulInclude as $item): ?>
          <li class="biz-practical__item">
            <span class="biz-practical__item-label"><?= e($item['label']) ?></span>
            <span class="biz-practical__item-hint"><?= e($item['hint']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ===== FORM (12-col) ===== -->
<section class="section section--paper biz-form-section" id="enquire" aria-labelledby="form-title">
  <div class="container">
    <div class="biz-form-layout" data-reveal>
      <!-- LEFT 4 col: heading/help/direct contact -->
      <aside class="biz-form-layout__aside">
        <div>
          <span class="biz-form-card__eyebrow">Project enquiry</span>
          <h2 class="biz-form-card__title" id="form-title">Discuss a Project.</h2>
          <p class="biz-form-card__note">
            Tell us about the site and the wall. We will respond with what we
            can practically supply — pack sizes, format, and how Prakritik Paint
            fits your project.
          </p>
        </div>

        <div class="help-cta">
          <h3 class="help-cta__title">Prefer to talk first?</h3>
          <p class="help-cta__sub">
            Call <?= e($phones[0] ?? '') ?> or email <?= e($COMPANY['email']) ?>.
          </p>
          <div class="help-cta__btn">
            <a class="btn btn--secondary btn--block" href="/contact/">Contact Gaurikrit</a>
          </div>
        </div>

        <dl class="biz-aside-card">
          <?php foreach ($phones as $phone): ?>
            <div class="biz-aside-card__row">
              <dt>Phone</dt>
              <dd><a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a></dd>
            </div>
          <?php endforeach; ?>
          <div class="biz-aside-card__row">
            <dt>Email</dt>
            <dd><a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a></dd>
          </div>
          <div class="biz-aside-card__row">
            <dt>Location</dt>
            <dd><?= e($COMPANY['address'][3] ?? '') ?>, <?= e($COMPANY['address'][4] ?? '') ?></dd>
          </div>
        </dl>
      </aside>

      <!-- RIGHT 8 col: form fields -->
      <form class="biz-form-card" action="/api/business-enquiry.php" method="post"
            data-business-form novalidate>
        <p class="biz-form-card__intro">
          Fields marked <span class="req">*</span> are required.
        </p>
        <?= csrf_field() ?>
        <div class="form-honeypot" aria-hidden="true">
          <label for="biz-company-hp">Company (leave this blank)</label>
          <input type="text" id="biz-company-hp" name="company" tabindex="-1"
                 autocomplete="off">
        </div>

        <div class="form-grid">
          <div class="form-field">
            <label class="form-label" for="biz-name">Name <span class="req">*</span></label>
            <input class="form-input" type="text" id="biz-name" name="name"
                   required maxlength="80" autocomplete="name">
            <div class="form-error" data-error-for="name" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-phone">Phone <span class="req">*</span></label>
            <input class="form-input" type="tel" id="biz-phone" name="phone"
                   required maxlength="20" autocomplete="tel"
                   placeholder="+91 ...">
            <div class="form-error" data-error-for="phone" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-email">Email <span class="req">*</span></label>
            <input class="form-input" type="email" id="biz-email" name="email"
                   required maxlength="254" autocomplete="email">
            <div class="form-error" data-error-for="email" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-organisation">Organisation</label>
            <input class="form-input" type="text" id="biz-organisation"
                   name="organisation" maxlength="120" autocomplete="organization">
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-role">Role</label>
            <input class="form-input" type="text" id="biz-role" name="role"
                   maxlength="80" autocomplete="organization-title">
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-city">City <span class="req">*</span></label>
            <input class="form-input" type="text" id="biz-city" name="city"
                   required maxlength="80" autocomplete="address-level2">
            <div class="form-error" data-error-for="city" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-project-type">Project type <span class="req">*</span></label>
            <select class="form-select" id="biz-project-type" name="project_type" required>
              <option value="" disabled selected>Choose…</option>
              <?php foreach ($PROJECT_TYPES as $type): ?>
                <option value="<?= e($type) ?>"><?= e($type) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="form-error" data-error-for="project_type" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-requirement">Approximate requirement</label>
            <input class="form-input" type="text" id="biz-requirement"
                   name="approximate_requirement" maxlength="100"
                   placeholder="e.g. 20 packs / 80 litres / not sure yet">
          </div>
          <div class="form-field form-field--full">
            <label class="form-label" for="biz-message">About the project <span class="req">*</span></label>
            <textarea class="form-textarea" id="biz-message" name="message" required
                      maxlength="2000" rows="6"
                      placeholder="Tell us about the site, the walls, and what you are painting."></textarea>
            <div class="form-error" data-error-for="message" role="alert"></div>
          </div>
        </div>

        <div class="calc-actions">
          <button type="submit" class="btn btn--primary btn--lg">
            <span data-submit-label>Discuss a Project</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
