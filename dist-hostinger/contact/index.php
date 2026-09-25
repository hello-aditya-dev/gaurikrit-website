<?php
/**
 * Gaurikrit Bio Products — Contact (V4 asset replacement pass).
 * Task V4-ASSETS.
 *
 * Simplified. NO large architectural hero. NO newsletter. NO FAQ.
 *
 *   H1 "Talk to Gaurikrit." Short copy. Immediately surface:
 *     email, phones, address, GSTIN.
 *
 *   Layout: .contact-section 5 col company/contact info (left) /
 *           7 col enquiry form (right). NO giant card.
 *
 *   The official logo mark (696×700) is used as a subtle secondary visual
 *   in the hero — no large artwork.
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
  /* ===== HERO ===== */
  .contact-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .contact-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .contact-hero__container { grid-template-columns: 7fr 5fr; gap: 3rem; }
  }
  .contact-hero__lockup { max-width: 42rem; }
  .contact-hero__title {
    font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4rem);
    line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance;
    margin-top: 0.5rem;
  }
  .contact-hero__sub {
    margin-top: 1rem; color: var(--fg-muted);
    font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; max-width: 60ch;
  }
  /* V4: subtle logo mark as secondary visual — no large artwork. */
  .contact-hero__mark {
    display: flex; align-items: center; justify-content: center;
    aspect-ratio: 696/700;
    background: radial-gradient(circle at 50% 45%, #f9f5eb, #e7ebdf);
    border-radius: var(--r-panel);
    overflow: hidden;
    padding: 1.5rem;
  }
  .contact-hero__mark .contact-hero__mark-img {
    display: block;
    width: min(75%, 220px); height: auto;
    object-fit: contain;
  }
  @media (max-width: 1023px) {
    .contact-hero__mark { display: none; }
  }

  /* ===== CONTACT SECTION (5 / 7 — info left, form right) ===== */
  .contact-section { padding-top: clamp(1.5rem, 3vw, 2.5rem); }

  /* Contact info as a modern plate / ledger (ruled rows, no card chrome). */
  .contact-info {
    padding: 0; background: transparent; border: 0;
    border-top: 1px solid var(--border); border-radius: 0; box-shadow: none;
  }
  .contact-info__row {
    padding-block: 1rem; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr; gap: 0.25rem;
    align-items: baseline;
  }
  @media (min-width: 640px) {
    .contact-info__row { grid-template-columns: 11rem 1fr; gap: 1rem; }
  }
  .contact-info__row dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .contact-info__row dd { font-size: 0.9375rem; color: var(--fg); }
  .contact-info__address { white-space: pre-line; }
  .contact-info__actions {
    display: flex; flex-wrap: wrap; gap: 0.625rem; margin-top: 1.5rem;
  }

  /* Form (right). */
  .contact-form {
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); padding: 1.5rem;
  }
  @media (min-width: 768px) { .contact-form { padding: 2rem; } }
  .contact-form-card__intro {
    font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 1.5rem;
  }
  .contact-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.25rem; }
</style>

<!-- ===== HERO ===== -->
<section class="contact-hero bg-limewash" aria-labelledby="contact-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Contact</span>
    </nav>
    <div class="contact-hero__container" data-reveal>
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
      <div class="contact-hero__mark" aria-hidden="true">
        <img class="contact-hero__mark-img"
             src="<?= asset_url('/assets/brand/gaurikrit-logo-mark.png') ?>"
             alt=""
             width="696" height="700"
             loading="eager" decoding="async">
      </div>
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

        <div class="contact-info__actions">
          <a class="btn btn--secondary" href="/for-business/">For Business</a>
          <a class="btn btn--outline" href="/paint-calculator/">Estimate Your Project</a>
        </div>
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
      </form>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
