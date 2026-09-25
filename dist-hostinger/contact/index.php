<?php
/**
 * Gaurikrit Bio Products — Contact (V5 finish pass).
 * Task V5-FINISH.
 *
 * Refines the V4 composition: hero drops the giant logo-mark panel for a
 * calm typographic hero with email / phones / address immediately visible
 * below the heading, plus a very subtle interior-wall-study at 0.06
 * opacity as background; the form gets a subtle border + soft shadow;
 * the supporting CTAs (For Business, Estimate Your Project) move to
 * small text links below the form, no longer competing with the form's
 * submit button. Factual data unchanged.
 *
 *   H1 "Talk to Gaurikrit." Short copy. Immediately surface:
 *     email, phones, address, GSTIN.
 *
 *   Layout: .contact-section 5 col company/contact info (left) /
 *           7 col enquiry form (right). NO giant card.
 *
 *   Form: name, phone, email, interest (select 6 values from
 *   $INTEREST_OPTIONS), message. Posts to /api/contact.php.
 *   csrf_field() + honeypot. Button "Send Enquiry".
 */
declare(strict_types=1);

$pageTitle       = 'Talk to Gaurikrit — Contact | Gaurikrit Bio Products';
$pageDescription = 'Email, phones, address and GSTIN for Gaurikrit Bio Products (OPC) Private Limited. Send an enquiry about Prakritik Distemper, Emulsion, bulk projects, partnerships or Gaushala collaboration.';
$pageCanonical   = '/contact/';
$pageClass        = 'contact';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $INTEREST_OPTIONS;

$phones = $COMPANY['phones'] ?? [];
$address = $COMPANY['address'] ?? [];
$addressLine = implode("\n", $address);

// Pre-fill interest from ?interest= query (server-side; forms.js also does
// this client-side as a backup).
$selectedInterest = '';
$interestParam = $_GET['interest'] ?? '';
if ($interestParam !== '' && array_key_exists($interestParam, $INTEREST_OPTIONS)) {
    $selectedInterest = $interestParam;
}
?>
<style>
  /* ===== HERO (V5: calm typographic — no giant logo panel; subtle wall bg) ===== */
  .contact-hero {
    padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem;
    position: relative; overflow: hidden;
  }
  /* V5: subtle interior-wall-study at 0.06 opacity as background. */
  .contact-hero__bg {
    position: absolute; inset: 0; opacity: 0.06;
    pointer-events: none; overflow: hidden;
  }
  .contact-hero__bg .editorial-image { width: 100%; height: 100%; object-fit: cover; }
  /* V5: single-column inner (no 7fr/5fr split — the hero is typographic
     with company details immediately visible below the heading). */
  .contact-hero__inner { position: relative; z-index: 1; max-width: 60rem; }
  .contact-hero__lockup { display: flex; flex-direction: column; gap: 0.625rem; max-width: 70ch; }
  .contact-hero__eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .contact-hero__title {
    font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4rem);
    line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance;
    margin-top: 0.5rem;
  }
  .contact-hero__sub {
    margin-top: 1rem; font-size: clamp(1rem, 2vw, 1.125rem);
    color: var(--fg-muted); line-height: 1.65; max-width: 60ch;
  }
  /* V5: company details immediately visible below the heading + body. */
  .contact-hero__quick {
    margin-top: 2rem; border-top: 1px solid var(--border);
  }
  .contact-hero__quick-row {
    padding: 1rem 0; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr; gap: 0.25rem;
    align-items: baseline;
  }
  @media (min-width: 640px) {
    .contact-hero__quick-row { grid-template-columns: 9rem 1fr; gap: 1rem; }
  }
  .contact-hero__quick-row dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;  /* V5 */
    text-transform: uppercase; color: var(--fg-muted);
  }
  .contact-hero__quick-row dd { font-size: 1rem; color: var(--fg); }
  .contact-hero__quick-row dd a { color: var(--primary); text-decoration: none; }
  .contact-hero__quick-row dd a:hover { text-decoration: underline; }
  .contact-hero__quick-address { white-space: pre-line; }

  /* ===== CONTACT SECTION (5 / 7 — info left, form right) ===== */
  .contact-section { padding-top: clamp(1.5rem, 3vw, 2.5rem); }

  /* Contact info as a modern plate / ledger (ruled rows, no card chrome). */
  .contact-info {
    padding: 0; background: transparent; border: 0;
    border-top: 1px solid var(--border); border-radius: 0; box-shadow: none;
  }
  .contact-info__row {
    padding-block: 1.125rem; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr; gap: 0.25rem;
    align-items: baseline;
  }
  @media (min-width: 640px) {
    .contact-info__row { grid-template-columns: 11rem 1fr; gap: 1rem; }
  }
  /* V5: bolder labels + bumped letter-spacing for premium scannability. */
  .contact-info__row dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;  /* V5 */
    text-transform: uppercase; color: var(--fg-muted);
  }
  .contact-info__row dd { font-size: 1rem; color: var(--fg); }  /* V5: was 0.9375rem */
  .contact-info__row dd a { color: var(--primary); text-decoration: none; }
  .contact-info__row dd a:hover { text-decoration: underline; }
  .contact-info__address { white-space: pre-line; }

  /* Form (right). V5: subtle border + soft shadow to distinguish from
     the left plate; clearer focus states on inputs. */
  .contact-form {
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); padding: 2rem;  /* V5: was 1.5rem */
    box-shadow: 0 8px 24px -8px rgba(34, 36, 27, 0.12);  /* V5 */
  }
  @media (min-width: 768px) { .contact-form { padding: 2.5rem; } }  /* V5: was 2rem */
  .contact-form-card__intro {
    font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 1.5rem;
  }
  .contact-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.5rem; }  /* V5: was 1.25rem */
  /* V5: clearer focus states on form fields. */
  .contact-form .form-input,
  .contact-form .form-select,
  .contact-form .form-textarea {
    transition: border-color var(--dur), box-shadow var(--dur);
  }
  .contact-form .form-input:focus,
  .contact-form .form-select:focus,
  .contact-form .form-textarea:focus {
    outline: 0;
    border-color: var(--forest);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--haldi) 25%, transparent);
  }
  /* V5: supporting CTAs as small text links below the form (not buttons). */
  .contact-form__foot-links {
    margin-top: 1.5rem; padding-top: 1.25rem;
    border-top: 1px solid var(--border);
    display: flex; flex-wrap: wrap; gap: 0.625rem; align-items: center;
    font-size: 0.875rem; color: var(--fg-muted);
  }
  .contact-form__foot-links a {
    color: var(--primary); text-decoration: none; font-weight: 600;
  }
  .contact-form__foot-links a:hover { text-decoration: underline; }
  .contact-form__foot-links span { color: var(--border-strong); }
</style>

<!-- ===== HERO (V5: calm typographic — no giant logo panel; subtle wall bg) ===== -->
<section class="contact-hero bg-limewash" aria-labelledby="contact-title">
  <!-- V5: subtle interior-wall-study at 0.06 opacity as background. -->
  <div class="contact-hero__bg" aria-hidden="true">
    <picture>
      <source type="image/webp" srcset="<?= asset_url('/assets/editorial/interior-wall-study.webp') ?>">
      <img class="editorial-image"
           src="<?= asset_url('/assets/editorial/interior-wall-study.jpg') ?>"
           alt=""
           width="1344" height="768"
           loading="eager" decoding="async">
    </picture>
  </div>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Contact</span>
    </nav>
    <div class="contact-hero__inner" data-reveal>
      <div class="contact-hero__lockup">
        <span class="contact-hero__eyebrow">
          <span class="contact-hero__eyebrow-dot" aria-hidden="true"></span>
          Get in touch
        </span>
        <hr class="contact-hero__rule">
        <h1 class="contact-hero__title" id="contact-title">Talk to Gaurikrit.</h1>
        <p class="contact-hero__sub">
          A short message and a phone number are usually enough. Tell us what
          you are painting — home, site, Gaushala collaboration — and we will
          respond.
        </p>
      </div>
      <!-- V5: company details immediately visible below the heading + body. -->
      <dl class="contact-hero__quick">
        <div class="contact-hero__quick-row">
          <dt>Email</dt>
          <dd><a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a></dd>
        </div>
        <?php foreach ($phones as $phone): ?>
          <div class="contact-hero__quick-row">
            <dt>Phone</dt>
            <dd><a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a></dd>
          </div>
        <?php endforeach; ?>
        <div class="contact-hero__quick-row">
          <dt>Address</dt>
          <dd class="contact-hero__quick-address"><?= e($addressLine) ?></dd>
        </div>
      </dl>
    </div>
  </div>
</section>

<!-- ===== CONTACT SECTION — 5 / 7 (info left / form right) ===== -->
<section class="section section--paper" style="padding-top: clamp(2rem, 4vw, 3rem);">
  <div class="container">
    <div class="contact-section" data-reveal>
      <!-- LEFT — company info / contact plate -->
      <aside>
        <span class="contact-hero__eyebrow">Direct lines</span>
        <h2 class="spec-sheet__title" style="margin-top: 0.5rem;">Company &amp; contact.</h2>

        <dl class="contact-info">
          <div class="contact-info__row">
            <dt>Legal name</dt>
            <dd><?= e($COMPANY['legalName']) ?></dd>
          </div>
          <div class="contact-info__row">
            <dt>GSTIN</dt>
            <dd><?= e($COMPANY['gstin']) ?></dd>
          </div>
          <div class="contact-info__row">
            <dt>Email</dt>
            <dd>
              <a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a>
            </dd>
          </div>
          <?php foreach ($phones as $phone): ?>
            <div class="contact-info__row">
              <dt>Phone</dt>
              <dd>
                <a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a>
              </dd>
            </div>
          <?php endforeach; ?>
          <div class="contact-info__row">
            <dt>Address</dt>
            <dd class="contact-info__address"><?= e($addressLine) ?></dd>
          </div>
        </dl>
      </aside>

      <!-- RIGHT — enquiry form -->
      <form class="contact-form" action="/api/contact.php" method="post"
            data-contact-form novalidate>
        <p class="contact-form-card__intro">
          Fields marked <span class="req">*</span> are required.
        </p>
        <?= csrf_field() ?>
        <div class="form-honeypot" aria-hidden="true">
          <label for="contact-company-hp">Company (leave this blank)</label>
          <input type="text" id="contact-company-hp" name="company" tabindex="-1"
                 autocomplete="off">
        </div>

        <div class="form-grid">
          <div class="form-field">
            <label class="form-label" for="contact-name">Name <span class="req">*</span></label>
            <input class="form-input" type="text" id="contact-name" name="name"
                   required maxlength="80" autocomplete="name">
            <div class="form-error" data-error-for="name" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="contact-phone">Phone</label>
            <input class="form-input" type="tel" id="contact-phone" name="phone"
                   maxlength="20" autocomplete="tel" placeholder="+91 ...">
            <div class="form-error" data-error-for="phone" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="contact-email">Email <span class="req">*</span></label>
            <input class="form-input" type="email" id="contact-email" name="email"
                   required maxlength="254" autocomplete="email">
            <div class="form-error" data-error-for="email" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="contact-interest">Enquiry is about <span class="req">*</span></label>
            <select class="form-select" id="contact-interest" name="interest" required>
              <option value="" disabled <?= $selectedInterest === '' ? 'selected' : '' ?>>Choose…</option>
              <?php foreach ($INTEREST_OPTIONS as $value => $label): ?>
                <option value="<?= e($value) ?>" <?= $value === $selectedInterest ? 'selected' : '' ?>>
                  <?= e($label) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-error" data-error-for="interest" role="alert"></div>
          </div>
          <div class="form-field form-field--full">
            <label class="form-label" for="contact-message">Message <span class="req">*</span></label>
            <textarea class="form-textarea" id="contact-message" name="message" required
                      maxlength="2000" rows="6"
                      placeholder="Tell us a bit about what you are painting."></textarea>
            <div class="form-error" data-error-for="message" role="alert"></div>
          </div>
        </div>

        <div class="calc-actions">
          <button type="submit" class="btn btn--primary btn--lg">
            <span data-submit-label>Send Enquiry</span>
          </button>
        </div>

        <!-- V5: supporting CTAs as small text links below the form — no
             longer competing as buttons with the form's submit. -->
        <p class="contact-form__foot-links">
          <a href="/for-business/">For Business</a>
          <span aria-hidden="true">·</span>
          <a href="/paint-calculator/">Estimate Your Project</a>
        </p>
      </form>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
