<?php
/**
 * Gaurikrit Bio Products — For Business (V5 finish pass).
 * Task V5-FINISH.
 *
 * Refines the V4 composition: hero replaces architectural-elevation with
 * business-context-study (more Indian, contemporary); audiences section
 * drops the shared illustration in favour of a CSS-only 4-ruled-columns
 * visual that connects to the four audience types; enquiry copy is
 * rewritten in calm, direct language; form gets more padding, looser
 * field spacing, and clearer focus states. Factual data unchanged.
 *
 * Composition:
 *   1. Hero — V5: business-context-study right (was architectural-elevation).
 *   2. Audiences — V5: NO shared image; CSS 4-ruled-columns visual instead.
 *   3. Practical section — V5: rewritten enquiry copy.
 *   4. Business Form — V5: more padding, looser field spacing, clearer focus.
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

  /* ===== HERO (V5: text left / business-context-study right — NO floating blob) ===== */
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

  /* ===== AUDIENCES (V5: NO shared image; CSS 4-ruled-columns visual
     instead — connects directly to the four audience types) ===== */
  .biz-audiences-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  /* V5: 4-column rule pattern above the cards — each column has a number
     + a thin haldi underline, mirroring the four audience types below. */
  .biz-audiences-rule {
    display: grid; grid-template-columns: 1fr; gap: 0;
    margin-bottom: 3rem;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
  }
  @media (min-width: 768px) {
    .biz-audiences-rule { grid-template-columns: repeat(4, 1fr); }
  }
  .biz-audiences-rule__col {
    padding: 1.25rem 1rem; border-top: 2px solid var(--haldi);
    display: flex; align-items: baseline; gap: 0.625rem;
  }
  .biz-audiences-rule__col + .biz-audiences-rule__col {
    border-left: 1px solid var(--border);
  }
  @media (max-width: 767px) {
    .biz-audiences-rule__col + .biz-audiences-rule__col {
      border-left: 0; border-top: 1px solid var(--border);
    }
  }
  .biz-audiences-rule__num {
    font-family: var(--font-display); font-weight: 700; font-size: 0.875rem;
    color: var(--haldi-deep); letter-spacing: 0.04em;
  }
  .biz-audiences-rule__label {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
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

  /* ===== FORM (V5: more padding, looser field spacing, clearer focus states) ===== */
  .biz-form-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-form-layout__aside { display: flex; flex-direction: column; gap: 1.5rem; }
  .biz-form-layout__aside .help-cta { padding: 1.5rem; }
  /* V5: more padding + soft shadow for premium feel. */
  .biz-form-card {
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); padding: 2rem;  /* V5: was 1.5rem */
    box-shadow: 0 8px 24px -8px rgba(34, 36, 27, 0.12);
  }
  @media (min-width: 768px) { .biz-form-card { padding: 2.5rem; } }  /* V5: was 2rem */
  .biz-form-card__intro { font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 2rem; }  /* V5: more spacing */
  .biz-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.5rem; }  /* V5: was 1.25rem */
  /* V5: clearer focus states on inputs / selects / textareas. */
  .biz-form-card .form-input,
  .biz-form-card .form-select,
  .biz-form-card .form-textarea {
    transition: border-color var(--dur), box-shadow var(--dur);
  }
  .biz-form-card .form-input:focus,
  .biz-form-card .form-select:focus,
  .biz-form-card .form-textarea:focus {
    outline: 0;
    border-color: var(--forest);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--haldi) 25%, transparent);
  }
  .biz-aside-card {
    border-top: 1px solid var(--border); padding: 0; background: transparent;
  }
  .biz-aside-card__row { padding-block: 1rem; border-bottom: 1px solid var(--border); }
  .biz-aside-card dt { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
</style>

<!-- ===== HERO (V5: business-context-study right) ===== -->
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
        <!-- V5: business-context-study replaces architectural-elevation
             (more Indian, more contemporary). -->
        <picture>
          <source type="image/webp" srcset="<?= asset_url('/assets/editorial/business-context-study.webp') ?>">
          <img class="editorial-image"
               src="<?= asset_url('/assets/editorial/business-context-study.jpg') ?>"
               alt=""
               width="1344" height="768"
               loading="eager" decoding="async">
        </picture>
      </div>
    </div>
  </div>
</section>

<!-- ===== AUDIENCES — V5: CSS 4-ruled-columns visual (no shared image) ===== -->
<section class="section section--paper biz-audiences-section" aria-labelledby="audiences-title">
  <div class="container">
    <div class="biz-audiences__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Who this is for</span>
      <h2 class="section-heading__title" id="audiences-title">Audiences.</h2>
    </div>

    <!-- V5: simple CSS visual — 4 ruled columns, one per audience type.
         No shared image (avoids repeating business-context-study from hero). -->
    <div class="biz-audiences-rule" aria-hidden="true" data-reveal>
      <div class="biz-audiences-rule__col">
        <span class="biz-audiences-rule__num">01</span>
        <span class="biz-audiences-rule__label">Architects</span>
      </div>
      <div class="biz-audiences-rule__col">
        <span class="biz-audiences-rule__num">02</span>
        <span class="biz-audiences-rule__label">Institutions</span>
      </div>
      <div class="biz-audiences-rule__col">
        <span class="biz-audiences-rule__num">03</span>
        <span class="biz-audiences-rule__label">CSR / NGOs</span>
      </div>
      <div class="biz-audiences-rule__col">
        <span class="biz-audiences-rule__num">04</span>
        <span class="biz-audiences-rule__label">Gaushalas</span>
      </div>
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

<!-- ===== PRACTICAL SECTION — V5: rewritten enquiry copy ===== -->
<section class="section section--limewash biz-practical" aria-labelledby="include-title">
  <div class="container">
    <div class="biz-practical__grid" data-reveal>
      <div class="biz-practical__head">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>Practical</span>
        <h2 class="biz-practical__title" id="include-title">Include these details for a faster response.</h2>
        <p class="biz-practical__body">
          A few practical details up front let us respond with what we can
          supply — pack sizes, format, and how Prakritik Paint fits your project.
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
