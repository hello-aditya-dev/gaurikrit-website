<?php
/**
 * Gaurikrit Bio Products — Partners (V20 source-truth pass).
 *
 * V20 changes (§55-61):
 *   1. Hero — ONE two-material composition (partners-hero master: REAL
 *      Prakritik pair + REAL client-supplied cow-dung log plate on one
 *      studio sweep). The old 4-tile cover-crop grid is removed — no
 *      generated Bio-Coal / Utility in the hero.
 *   2. Audiences — the duplicated 7-audience strip removed; the four
 *      audience cards carry the information.
 *   3. Practical section — universal details (Interest / City / market /
 *      Use case / Approximate quantity); paint fields are conditional.
 *   4. Form — Interest select (canonical $INTEREST_OPTIONS slugs) with
 *      conditional wall-area/paint-format fields for Eco-Paints
 *      interests (progressive enhancement, no-JS safe).
 *      CTA "Discuss a Project". Posts to /api/business-enquiry.php.
 *      csrf_field() + honeypot.
 */
declare(strict_types=1);

$pageTitle       = 'Partners & Business Enquiries — Gaurikrit';
$pageDescription = 'Build with Gaurikrit: distribution, dealership, architecture, contracting, institutional, industrial and sustainability partnerships around the Gaurikrit material ecosystem — Eco-Paints, GoCast, Bio-Coal and utility directions.';
$pageCanonical   = '/for-business/';
$pageClass        = 'for-business';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $INTEREST_OPTIONS;

$phones = $COMPANY['phones'] ?? [];

$audiences = [
    ['num' => '01', 'title' => 'Distributors & Dealers',
     'desc' => 'Bring Prakritik Paint — and future Gaurikrit families — to your market.'],
    ['num' => '02', 'title' => 'Architects & Contractors',
     'desc' => 'Discuss product and project requirements for residential, commercial, or institutional work.'],
    ['num' => '03', 'title' => 'Institutions, CSR & NGOs',
     'desc' => 'Talk to Gaurikrit about institutional or sustainability-led projects.'],
    ['num' => '04', 'title' => 'Industries & Sustainability Partners',
     'desc' => 'Explore collaboration around cow-dung-based bio-products and material directions.'],
];

// V20 §58: universal practical details — wall area / paint format are
// NOT universal (they made no sense for GoCast / Bio-Coal / Utility /
// distribution / collaboration enquiries); they remain in the FORM as
// conditional fields shown only for Eco-Paints interest.
$helpfulInclude = [
    ['label' => 'Interest',   'hint' => 'Eco-Paints, GoCast, Bio-Coal, Utility Products, distribution or collaboration'],
    ['label' => 'City / market', 'hint' => 'Where the requirement is located'],
    ['label' => 'Use case / requirement', 'hint' => 'What your organisation needs'],
    ['label' => 'Approximate quantity', 'hint' => 'If known'],
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

  /* ===== HERO (V20: text left / partners-hero two-material plate right) ===== */
  .biz-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) { .biz-hero { padding-bottom: 2.5rem; } }
  .biz-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .biz-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .biz-hero__lockup { max-width: 42rem; }
  .biz-hero__art { padding: 0; background: none; border: 0; }
  /* V20 §56: ONE two-material composition — the REAL Prakritik pair and
     the REAL client-supplied cow-dung log plate share one studio sweep
     (partners-hero master). No generated Bio-Coal / Utility in the hero:
     the hero is about working with Gaurikrit, not proving all four
     categories. Hairline plate, objects uncropped. */
  .biz-hero__plate { margin: 0; overflow: hidden;
    border-radius: var(--r-panel); border: 1px solid var(--border);
    background: var(--paper); }
  .biz-hero__plate img {
    display: block; width: 100%; height: auto; aspect-ratio: 16 / 10;
    object-fit: cover; object-position: center 56%;
  }
  .biz-hero__plate figcaption {
    padding: 0.625rem 1rem; border-top: 1px solid var(--border);
    display: flex; justify-content: space-between; gap: 1rem;
    font-size: 0.6875rem; letter-spacing: 0.04em; text-transform: uppercase;
    color: var(--fg-muted);
  }
  .biz-hero__plate figcaption em {
    font-style: normal; opacity: 0.75; text-transform: none;
  }

  /* ===== AUDIENCES (V16: the seven partner audiences as a flexible
     partner-strip + four audience cards; the 4-ruled-column visual is
     retired) ===== */
  .biz-audiences-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-audiences__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== PRACTICAL SECTION ===== */
  .biz-practical { padding-block: clamp(2.75rem, 5vw, 4.25rem); }
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
  /* V20 §61: tightened transition from the practical section (was clamp(3.5rem, 6vw, 5rem)) */
  .biz-form-section { padding-block: clamp(2.5rem, 4vw, 3.5rem) 5rem; }
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

<!-- ===== HERO (V16 §41: repositioned from paint-projects to the whole
     ecosystem — "Build with Gaurikrit.") ===== -->
<section class="biz-hero bg-limewash" aria-labelledby="biz-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Partners</span>
    </nav>
    <div class="biz-hero__container" data-reveal>
      <div class="biz-hero__lockup">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>Partners</span>
        <hr class="biz-hero__rule">
        <h1 class="biz-hero__title" id="biz-title">Build with Gaurikrit.</h1>
        <p class="biz-hero__sub">
          For distributors, dealers, architects, contractors, institutions,
          industries and sustainability partners. Talk to us about
          Eco-Paints today — and the GoCast, Bio-Coal and utility directions
          as they develop.
        </p>
        <div class="biz-hero__ctas">
          <a class="btn btn--primary btn--lg" href="#enquire">Discuss a Project</a>
          <a class="btn btn--outline" href="/products/">Explore the Ecosystem</a>
        </div>
      </div>
      <figure class="biz-hero__plate" data-reveal>
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('partners-hero', [640, 960, 1280, 1600, 1920]) ?>"
                  sizes="(min-width: 1024px) 55vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('partners-hero', [640, 960, 1280, 1600, 1920]) ?>"
                  sizes="(min-width: 1024px) 55vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/partners-hero-1280.jpg') ?>"
               alt="Prakritik Distemper and Prakritik Emulsion paint packs with client-supplied cow-dung logs on a terracotta plate — the two documented materials of the Gaurikrit ecosystem"
               width="1280" height="720" loading="eager" decoding="async">
        </picture>
        <figcaption>
          <span>Eco-Paints <em>Documented family</em></span>
          <span>Cow-Dung Logs <em>Client-supplied reference</em></span>
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ===== AUDIENCES — V16: the seven partner audiences (§41) as a
     flexible strip + four audience cards. ===== -->
<section class="section section--paper biz-audiences-section" aria-labelledby="audiences-title">
  <div class="container">
    <div class="biz-audiences__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Who this is for</span>
      <h2 class="section-heading__title" id="audiences-title">Partner with a material ecosystem.</h2>
    </div>

    <!-- V20 §57: the small horizontal audience strip is REMOVED — the
         four audience cards below already carry this information. -->
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
          supply — for paint projects, pack sizes and format; for the other
          directions, scale and requirement.
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
            Tell us about the project or the partnership. We will respond with
            what we can practically supply — for paint projects, pack sizes
            and format; for the other directions, scale and availability.
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
            <label class="form-label" for="biz-interest">Interest <span class="req">*</span></label>
            <select class="form-select" id="biz-interest" name="interest" required
                    data-interest-toggle>
              <option value="" disabled selected>Choose…</option>
              <?php foreach ($INTEREST_OPTIONS as $value => $label): ?>
                <option value="<?= e($value) ?>"><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="form-error" data-error-for="interest" role="alert"></div>
          </div>
          <!-- V20 §60: paint-specific fields shown ONLY for Eco-Paints
               interest (progressive enhancement — present in the no-JS
               default markup, hidden by JS for non-paint interests). -->
          <div class="form-field" data-paint-fields>
            <label class="form-label" for="biz-wall-area">Approximate wall area</label>
            <input class="form-input" type="text" id="biz-wall-area"
                   name="wall_area" maxlength="60" inputmode="numeric"
                   placeholder="sq.ft., if you have a number">
          </div>
          <div class="form-field" data-paint-fields>
            <label class="form-label" for="biz-paint-format">Paint format</label>
            <select class="form-select" id="biz-paint-format" name="paint_format">
              <option value="" selected>Not sure yet</option>
              <option value="distemper">Prakritik Distemper</option>
              <option value="emulsion">Prakritik Emulsion</option>
            </select>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-requirement">Approximate requirement</label>
            <input class="form-input" type="text" id="biz-requirement"
                   name="approximate_requirement" maxlength="100"
                   placeholder="Quantity or scale, if known.">
          </div>
          <div class="form-field form-field--full">
            <label class="form-label" for="biz-message">About the project <span class="req">*</span></label>
            <textarea class="form-textarea" id="biz-message" name="message" required
                      maxlength="2000" rows="6"
                      placeholder="Tell us what you need, where it is required, and what you would like to discuss."></textarea>
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
