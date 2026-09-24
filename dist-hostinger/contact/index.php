<?php
/**
 * Gaurikrit Bio Products — Contact.
 * Task PAGES-LOCK.
 *
 * Display: legal name, full address, GSTIN, email (mailto:), both phones (tel:).
 * Contact form posts to /api/contact.php. Pre-fill interest from ?interest=.
 * NO newsletter. NO office hours. NO Pan-India.
 */
declare(strict_types=1);

$pageTitle       = 'Contact — Gaurikrit Bio Products';
$pageDescription = 'Talk to Gaurikrit. Send an enquiry about Prakritik Paint products, projects or partnerships. Based in Khurja, District Bulandshahr, Uttar Pradesh.';
$pageCanonical   = '/contact/';
$pageClass        = 'contact';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $INTEREST_OPTIONS, $FAQ;

$address = $COMPANY['address'] ?? [];
$phones  = $COMPANY['phones'] ?? [];

// Pre-fill interest from ?interest= if it's a known option.
$selectedInterest = '';
if (!empty($_GET['interest'])) {
    $candidate = (string) $_GET['interest'];
    if (array_key_exists($candidate, $INTEREST_OPTIONS)) {
        $selectedInterest = $candidate;
    } else {
        foreach ($INTEREST_OPTIONS as $key => $label) {
            if (stripos($key, $candidate) !== false || stripos($label, $candidate) !== false) {
                $selectedInterest = $key;
                break;
            }
        }
    }
}

// Carry through any project detail hints from the calculator (?paint=, ?area=).
$calcHint = '';
$paintHint = !empty($_GET['paint']) ? (string) $_GET['paint'] : '';
$paintingHint = !empty($_GET['painting_type']) ? (string) $_GET['painting_type'] : '';
$locationHint = !empty($_GET['location']) ? (string) $_GET['location'] : '';
$areaHint = !empty($_GET['wall_area']) ? (string) $_GET['wall_area'] : '';
$hints = array_filter([
    $paintingHint ? 'Painting type: ' . $paintingHint : '',
    $locationHint ? 'Location: ' . $locationHint : '',
    $paintHint ? ('paint' === $paintHint ? 'Paint: Prakritik ' . ucfirst($paintHint) : 'Paint: ' . $paintHint) : '',
    $areaHint ? 'Wall area: ' . $areaHint . ' sq.ft.' : '',
]);
if (!empty($hints)) {
    $calcHint = "Project details from the calculator:\n" . implode("\n", $hints) . "\n\nPlease share an accurate estimate.";
}
?>
<style>
  /* HERO */
  .contact-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2rem, 4vw, 3rem); }
  .contact-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .contact-hero__container { grid-template-columns: 1.1fr 0.9fr; } }
  .contact-hero__lockup { display: flex; flex-direction: column; gap: 0.625rem; }
  .contact-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); width: fit-content; }
  .contact-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .contact-hero__title { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .contact-hero__sub { max-width: 36rem; font-size: clamp(1rem, 2vw, 1.125rem); color: var(--fg-muted); line-height: 1.65; }
  .contact-hero__art { aspect-ratio: 4/3; border-radius: var(--radius-lg); background: var(--bg-card); border: 1px solid var(--border); box-shadow: var(--shadow-soft); overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 2rem; }

  /* CONTACT INFO CARD */
  .contact-info-card { padding: clamp(1.5rem, 4vw, 2.5rem); border: 1px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); box-shadow: var(--shadow-soft); }
  .contact-info-card h2 { font-size: 1.5rem; margin-bottom: 1rem; }
  .contact-info-card dl { display: grid; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
  .contact-info-card__row { display: grid; grid-template-columns: 8rem 1fr; background: var(--bg-card); }
  @media (max-width: 480px) { .contact-info-card__row { grid-template-columns: 1fr; } .contact-info-card__row dt { background: var(--secondary-bg); } }
  .contact-info-card__row dt, .contact-info-card__row dd { padding: 0.75rem 1rem; }
  .contact-info-card__row dt { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .contact-info-card__row dd { font-size: 0.9375rem; }
  .contact-info-card__row dd a { color: var(--primary); font-weight: 600; }
  .contact-info-card__address { white-space: pre-line; }

  /* FORM */
  .contact-form-card { padding: clamp(1.5rem, 4vw, 2.5rem); border: 1px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); box-shadow: var(--shadow-soft); }
  .contact-form-card h2 { font-size: 1.5rem; margin-bottom: 0.5rem; }
  .contact-form-card__intro { font-size: 0.9375rem; color: var(--fg-muted); margin-bottom: 1.5rem; }
  .contact-form-card .form-grid { display: grid; gap: 1rem; grid-template-columns: 1fr; }
  @media (min-width: 640px) { .contact-form-card .form-grid { grid-template-columns: 1fr 1fr; } }
  .contact-form-card .form-field--full { grid-column: 1 / -1; }

  /* FAQ */
  .contact-faq { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .contact-faq__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .contact-faq__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); letter-spacing: -0.02em; }
  .contact-faq__list { max-width: 48rem; margin-inline: auto; }
</style>

<!-- HERO -->
<section class="contact-hero" id="contact-hero" data-reveal>
    <div class="container contact-hero__container">
        <div class="contact-hero__lockup">
            <span class="contact-hero__eyebrow"><span class="contact-hero__eyebrow-dot" aria-hidden="true"></span>Contact</span>
            <h1 class="contact-hero__title">Talk to Gaurikrit.</h1>
            <p class="contact-hero__sub">Product questions, project requirements or partnership conversations — send an enquiry or contact Gaurikrit directly.</p>
        </div>
        <div class="contact-hero__art" aria-hidden="true">
            <?php render_illustration('indian-courtyard'); ?>
        </div>
    </div>
</section>

<!-- CONTACT INFO + FORM -->
<section class="section section--paper" id="reach" data-reveal>
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info-card">
                <h2>Company information</h2>
                <dl>
                    <div class="contact-info-card__row">
                        <dt>Legal name</dt>
                        <dd><?= e($COMPANY['legalName']) ?></dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>Address</dt>
                        <dd class="contact-info-card__address"><?php foreach ($address as $line) { echo e($line) . "\n"; } ?></dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>GSTIN</dt>
                        <dd><?= e($COMPANY['gstin']) ?></dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>Email</dt>
                        <dd><a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a></dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>Phone</dt>
                        <dd>
                            <?php foreach ($phones as $phone): ?>
                                <a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a><br>
                            <?php endforeach; ?>
                        </dd>
                    </div>
                </dl>
                <div style="margin-top:1.25rem; display:flex; flex-direction:column; gap:0.75rem;">
                    <a href="mailto:<?= e($COMPANY['email']) ?>" class="btn btn--outline btn--block">Email Gaurikrit</a>
                    <?php if (!empty($phones[0])): ?>
                        <a href="tel:<?= e(str_replace(' ', '', $phones[0])) ?>" class="btn btn--primary btn--block">Call Gaurikrit</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="contact-form-card">
                <h2>Send an enquiry</h2>
                <p class="contact-form-card__intro">Fields marked <span class="req" style="color: var(--mitti);">*</span> are required.</p>
                <form data-contact-form method="post" action="/api/contact.php" novalidate>
                    <?= csrf_field() ?>
                    <div class="form-honeypot" aria-hidden="true">
                        <label for="ct-company">Company (leave empty)</label>
                        <input type="text" id="ct-company" name="company" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="form-grid">
                        <div class="form-field">
                            <label class="form-label" for="ct-name">Name <span class="req">*</span></label>
                            <input class="form-input" type="text" id="ct-name" name="name" required maxlength="80" autocomplete="name">
                            <div class="form-error" data-error-for="name"></div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="ct-email">Email <span class="req">*</span></label>
                            <input class="form-input" type="email" id="ct-email" name="email" required maxlength="254" autocomplete="email">
                            <div class="form-error" data-error-for="email"></div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="ct-phone">Phone</label>
                            <input class="form-input" type="tel" id="ct-phone" name="phone" maxlength="20" autocomplete="tel">
                            <div class="form-error" data-error-for="phone"></div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="ct-interest">Interest</label>
                            <select class="form-select" id="ct-interest" name="interest">
                                <option value="">Select…</option>
                                <?php foreach ($INTEREST_OPTIONS as $key => $label): ?>
                                    <option value="<?= e($key) ?>" <?= $selectedInterest === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-error" data-error-for="interest"></div>
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-label" for="ct-message">Message <span class="req">*</span></label>
                            <textarea class="form-textarea" id="ct-message" name="message" required minlength="10" maxlength="2000" rows="6" placeholder="Tell us a little about your question or project." <?php if ($calcHint): ?>data-prefill="<?= e($calcHint) ?>"<?php endif; ?>><?php if ($calcHint) echo e($calcHint); ?></textarea>
                            <div class="form-error" data-error-for="message"></div>
                        </div>
                    </div>
                    <div style="margin-top:1rem; display:flex; flex-direction:column; gap:0.75rem;">
                        <button type="submit" class="btn btn--primary btn--lg btn--block">
                            <span data-submit-label>Send Enquiry</span>
                            <svg data-submit-spinner hidden width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56" style="animation: spin 1s linear infinite"/></svg>
                        </button>
                        <p style="font-size:0.75rem; color:var(--fg-muted); text-align:center;">By submitting, you agree to be contacted about your enquiry.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="contact-faq" id="faq" data-reveal>
    <div class="container">
        <div class="contact-faq__head">
            <span class="section-heading__eyebrow">Quick answers</span>
            <h2 class="contact-faq__title">Frequently asked questions.</h2>
            <p class="section-heading__desc">A short list of questions the supplied product information can answer.</p>
        </div>
        <div class="faq-list contact-faq__list" data-reveal-stagger>
            <?php foreach ($FAQ as $i => $item): $fid = 'faq-' . ($i + 1); ?>
                <div class="faq-item" data-faq-item>
                    <button type="button" class="faq-item__q" aria-expanded="false" aria-controls="<?= e($fid) ?>-a" id="<?= e($fid) ?>-q">
                        <span><?= e($item['q']) ?></span>
                        <svg class="faq-item__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-item__a" id="<?= e($fid) ?>-a" role="region" aria-labelledby="<?= e($fid) ?>-q">
                        <div class="faq-item__a-inner"><?= $item['a'] /* pre-escaped in data.php where needed */ ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center; margin-top:2rem;" data-reveal>
            <a href="/downloads/" class="btn btn--outline btn--lg">See the brochure</a>
        </div>
    </div>
</section>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>

<?php require ROOT_PATH . '/includes/footer.php';
