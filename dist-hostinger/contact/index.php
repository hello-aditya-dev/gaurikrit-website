<?php
/**
 * Gaurikrit Bio Products — Contact page.
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

$pageTitle       = 'Contact Gaurikrit Bio Products';
$pageDescription = 'Get in touch with Gaurikrit Bio Products — bulk, project, retail, or general enquiry. Email, phone, or send us a message and we will reply within two business days.';
$pageCanonical   = '/contact/';
$pageClass       = 'contact';
$pageOgType      = 'website';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

// Pre-fill interest select from query string (when arriving from product detail CTA).
$interest = isset($_GET['interest']) ? clean_text((string)$_GET['interest'], 60) : '';
?>
<style>
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; padding-top:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }

  .contact-info { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .contact-info__item { display:flex; gap:0.75rem; margin-bottom:1rem; font-size:0.9375rem; }
  .contact-info__item:last-child { margin-bottom:0; }
  .contact-info__label { font-weight:700; min-width:5rem; color:var(--fg-muted); font-size:0.8125rem; text-transform:uppercase; letter-spacing:0.1em; }
  .newsletter-card { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .newsletter-card h3 { font-size:1.25rem; margin-bottom:0.5rem; }
  .newsletter-card p { color:var(--fg-muted); font-size:0.875rem; margin-bottom:1rem; }
</style>

<section class="page-hero section section--paper section--grain" style="padding-top:calc(var(--header-h) + 2rem)">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <span>Contact</span>
        </nav>
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Get in Touch</span>
            <h1 class="section-heading__title">Let's paint something natural together.</h1>
            <p class="section-heading__desc">Bulk, project, retail, or just curious — we read every message and reply within two business days.</p>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div class="contact-grid" data-reveal>
            <form class="contact-form" data-contact-form novalidate>
                <?= csrf_field() ?>
                <div class="form-honeypot" aria-hidden="true">
                    <label>Leave this field empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-name">Name <span class="req">*</span></label>
                    <input class="form-input" type="text" id="cf-name" name="name" required autocomplete="name" maxlength="120">
                    <div class="form-error" data-error-for="name"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-email">Email <span class="req">*</span></label>
                    <input class="form-input" type="email" id="cf-email" name="email" required autocomplete="email" maxlength="254">
                    <div class="form-error" data-error-for="email"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-phone">Phone</label>
                    <input class="form-input" type="tel" id="cf-phone" name="phone" autocomplete="tel" maxlength="20">
                    <div class="form-error" data-error-for="phone"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-interest">Interest <span class="req">*</span></label>
                    <select class="form-select" id="cf-interest" name="interest" required>
                        <option value="">Select an option…</option>
                        <option value="prakritik-distemper"<?= $interest === 'prakritik-distemper' ? ' selected' : '' ?>>Prakritik Distemper</option>
                        <option value="prakritik-emulsion"<?= $interest === 'prakritik-emulsion' ? ' selected' : '' ?>>Prakritik Emulsion</option>
                        <option value="bulk">Bulk / Project enquiry</option>
                        <option value="partnership">Partnership / Retail</option>
                        <option value="general">General question</option>
                    </select>
                    <div class="form-error" data-error-for="interest"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-message">Message <span class="req">*</span></label>
                    <textarea class="form-textarea" id="cf-message" name="message" required minlength="10" maxlength="2000"></textarea>
                    <div class="form-error" data-error-for="message"></div>
                </div>
                <button type="submit" class="btn btn--primary btn--block">
                    <span data-submit-label>Send Message</span>
                    <span data-submit-spinner hidden aria-hidden="true">…</span>
                </button>
            </form>

            <aside>
                <div class="contact-info" aria-label="Contact details">
                    <div class="contact-info__item">
                        <span class="contact-info__label">Email</span>
                        <span><a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a></span>
                    </div>
                    <div class="contact-info__item">
                        <span class="contact-info__label">Phone</span>
                        <span><a href="tel:<?= e(preg_replace('/\s+/', '', $COMPANY['phone'])) ?>"><?= e($COMPANY['phone']) ?></a></span>
                    </div>
                    <div class="contact-info__item">
                        <span class="contact-info__label">Hours</span>
                        <span>Mon–Sat, 10 am – 6 pm IST</span>
                    </div>
                    <div class="contact-info__item">
                        <span class="contact-info__label">Based in</span>
                        <span>Bharat · Pan-India shipping</span>
                    </div>
                    <div class="contact-info__item">
                        <span class="contact-info__label">Founded</span>
                        <span><?= e((string)$COMPANY['foundedYear']) ?></span>
                    </div>
                </div>

                <div class="newsletter-card" style="margin-top:1.5rem">
                    <h3>Golden updates, once a month.</h3>
                    <p>New batches, shade launches, and craft stories. No spam.</p>
                    <form data-newsletter-form novalidate>
                        <?= csrf_field() ?>
                        <div class="form-honeypot" aria-hidden="true"><label>Leave empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label></div>
                        <div class="form-field">
                            <label class="form-label sr-only" for="nl-email">Email</label>
                            <input class="form-input" type="email" id="nl-email" name="email" required placeholder="you@example.com" autocomplete="email">
                            <div class="form-error" data-error-for="email"></div>
                        </div>
                        <button type="submit" class="btn btn--primary btn--block">Subscribe</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
