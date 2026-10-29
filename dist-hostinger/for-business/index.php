<?php
/**
 * Gaurikrit Bio Products — Partners (V20 source-truth pass).
 *
 * V20 changes (§55-61), V23 hero revision:
 *   1. Hero — 2x2 grid of the four client-supplied product artworks
 *      (carousel-* ecosystem stems); the retired two-material hero
 *      composite is no longer referenced.
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
$pageDescription = 'Build with Gaurikrit: distribution, dealership, architecture, contracting, institutional, industrial and sustainability partnerships around the Gaurikrit material ecosystem — Eco-Paints, Cow-Dung Logs, Bio-Briquettes and utility directions.';
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
    ['label' => 'Interest',   'hint' => 'Eco-Paints, Cow-Dung Logs, Bio-Briquettes, Eco Utility Products, distribution or collaboration'],
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

  /* ===== HERO (V23: text left / 2x2 client-artwork tile grid right) ===== */
  .biz-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) { .biz-hero { padding-bottom: 2.5rem; } }
  .biz-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .biz-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .biz-hero__lockup { max-width: 42rem; }
  .biz-hero__art { padding: 0; background: none; border: 0; }
  /* V23: four client-supplied product artworks in a 2x2 mat grid —
     same reading as the homepage portfolio; nothing cropped (16:9 tiles
     + object-fit:contain keep every label/claim fully visible). */
  .biz-hero__ecosystem {
    display: grid; grid-template-columns: 1fr 1fr; gap: 4px;
  }
  .biz-hero__tile {
    margin: 0; overflow: hidden;
    background: var(--paper-warm);
    border: 1px solid var(--border); border-radius: 0.25rem;
    aspect-ratio: 16 / 9;
  }
  .biz-hero__tile picture { display: block; width: 100%; height: 100%; margin: 0; }
  .biz-hero__tile img {
    display: block; width: 100%; height: 100%;
    object-fit: contain; object-position: center;
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
          Eco-Paints today — and the Cow-Dung Logs, Bio-Briquettes and Eco Utility Products
          directions as they develop. Bio-Briquettes and Eco Utility Products
          are Futureline product directions, not yet in production.
        </p>
        <div class="biz-hero__ctas">
          <a class="btn btn--primary btn--lg" href="#enquire">Discuss a Project</a>
          <a class="btn btn--outline" href="/products/">Explore the Ecosystem</a>
        </div>
      </div>
      <div class="biz-hero__art" aria-hidden="true">
        <div class="biz-hero__ecosystem" role="img" aria-label="The Gaurikrit material ecosystem — Eco-Paints, Cow-Dung Logs, Bio-Briquettes and Eco Utility Products client artwork">
          <figure class="biz-hero__tile">
            <picture>
              <source type="image/avif" srcset="<?= eco_srcset('carousel-eco-paints', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <source type="image/webp" srcset="<?= eco_srcset_webp('carousel-eco-paints', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <img src="<?= asset_url('/assets/images/ecosystem/carousel-eco-paints-1280.jpg') ?>" alt="" width="1280" height="720" loading="lazy" decoding="async">
            </picture>
          </figure>
          <figure class="biz-hero__tile">
            <picture>
              <source type="image/avif" srcset="<?= eco_srcset('carousel-cow-dung-logs', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <source type="image/webp" srcset="<?= eco_srcset_webp('carousel-cow-dung-logs', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <img src="<?= asset_url('/assets/images/ecosystem/carousel-cow-dung-logs-1280.jpg') ?>" alt="" width="1280" height="720" loading="lazy" decoding="async">
            </picture>
          </figure>
          <figure class="biz-hero__tile">
            <picture>
              <source type="image/avif" srcset="<?= eco_srcset('carousel-bio-briquettes', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <source type="image/webp" srcset="<?= eco_srcset_webp('carousel-bio-briquettes', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <img src="<?= asset_url('/assets/images/ecosystem/carousel-bio-briquettes-1280.jpg') ?>" alt="" width="1280" height="720" loading="lazy" decoding="async">
            </picture>
          </figure>
          <figure class="biz-hero__tile">
            <picture>
              <source type="image/avif" srcset="<?= eco_srcset('carousel-eco-utility-products', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <source type="image/webp" srcset="<?= eco_srcset_webp('carousel-eco-utility-products', [640, 960, 1280]) ?>" sizes="(min-width: 1024px) 34vw, calc(100vw - 2.5rem)">
              <img src="<?= asset_url('/assets/images/ecosystem/carousel-eco-utility-products-1280.jpg') ?>" alt="" width="1280" height="720" loading="lazy" decoding="async">
            </picture>
          </figure>
        </div>
      </div>
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
