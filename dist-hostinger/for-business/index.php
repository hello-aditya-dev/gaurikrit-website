<?php
/**
 * Gaurikrit Bio Products — For Business (bulk / project enquiry).
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

$pageTitle       = 'For Business — Bulk & Project Enquiry | Gaurikrit Bio Products';
$pageDescription = 'Bulk and project supply of Prakritik Paint. For gaushalas, contractors, architects, retailers, and project owners. Submit your requirement and we will revert within two business days.';
$pageCanonical   = '/for-business/';
$pageClass       = 'for-business';
$pageOgType      = 'website';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

$interest = isset($_GET['interest']) ? clean_text((string)$_GET['interest'], 60) : '';
?>
<style>
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; padding-top:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }

  .split-grid { display:grid; gap:2rem; grid-template-columns:1fr; align-items:start; }
  @media (min-width: 768px) { .split-grid { grid-template-columns:1.2fr 0.8fr; } }

  .biz-pitch { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .biz-pitch ul { list-style:none; padding:0; margin-top:1rem; }
  .biz-pitch li { display:flex; align-items:flex-start; gap:0.625rem; margin-bottom:0.75rem; font-size:0.9375rem; color:var(--fg-muted); }
  .biz-pitch li svg { color:var(--primary); flex-shrink:0; margin-top:0.125rem; }

  .biz-info { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--secondary-bg); }
  .biz-info__title { font-size:0.75rem; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:var(--primary); margin-bottom:0.75rem; }
  .biz-info__item { margin-bottom:0.75rem; font-size:0.9375rem; }
  .biz-info__item-label { font-weight:700; color:var(--fg); display:block; font-size:0.8125rem; text-transform:uppercase; letter-spacing:0.1em; }
  .biz-info__item-value { color:var(--fg-muted); }
</style>

<section class="page-hero section section--paper section--grain" style="padding-top:calc(var(--header-h) + 2rem)">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <span>For Business</span>
        </nav>
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">For Business</span>
            <h1 class="section-heading__title">Bulk &amp; project supply, with the same patience.</h1>
            <p class="section-heading__desc">For gaushalas, contractors, architects, retailers, and project owners. Tell us your requirement and we will revert within two business days.</p>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div class="split-grid" data-reveal>
            <div class="biz-pitch">
                <h2 style="font-size:1.25rem; margin-bottom:0.5rem">What we offer</h2>
                <ul>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        <span><strong>Batch volumes</strong> — small-batch consistency at scale, without losing the craft.</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        <span><strong>Documented sourcing</strong> — every batch traceable to a partner gaushala.</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        <span><strong>Test reports on file</strong> — lead, heavy-metal, VOC, breathability, coverage.</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        <span><strong>Pan-India dispatch</strong> — courier for retail volumes, transport for project volumes.</span>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        <span><strong>Project pricing</strong> — transparent, batch-sized, no surprises.</span>
                    </li>
                </ul>
            </div>

            <aside class="biz-info" aria-label="Business contact details">
                <div class="biz-info__title">Talk to us directly</div>
                <div class="biz-info__item">
                    <span class="biz-info__item-label">Email</span>
                    <a class="biz-info__item-value" href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a>
                </div>
                <div class="biz-info__item">
                    <span class="biz-info__item-label">Phone</span>
                    <a class="biz-info__item-value" href="tel:<?= e(preg_replace('/\s+/', '', $COMPANY['phone'])) ?>"><?= e($COMPANY['phone']) ?></a>
                </div>
                <div class="biz-info__item">
                    <span class="biz-info__item-label">Response time</span>
                    <span class="biz-info__item-value">Within two business days</span>
                </div>
                <div class="biz-info__item">
                    <span class="biz-info__item-label">Catalogue</span>
                    <a class="biz-info__item-value" href="/downloads/">Download brochure</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="section section--paper section--grain" id="enquiry">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Enquiry Form</span>
            <h2 class="section-heading__title">Tell us about your project.</h2>
            <p class="section-heading__desc">The more detail you share, the more useful our first response will be.</p>
        </div>
        <form class="contact-form" data-business-form novalidate style="max-width:48rem; margin-inline:auto" data-reveal>
            <?= csrf_field() ?>
            <div class="form-honeypot" aria-hidden="true">
                <label>Leave this field empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label>
            </div>

            <div style="display:grid; gap:0; grid-template-columns:1fr; margin-bottom:0">
                <div class="form-field">
                    <label class="form-label" for="bf-name">Name <span class="req">*</span></label>
                    <input class="form-input" type="text" id="bf-name" name="name" required autocomplete="name" maxlength="120">
                    <div class="form-error" data-error-for="name"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="bf-organisation">Organisation <span class="req">*</span></label>
                    <input class="form-input" type="text" id="bf-organisation" name="organisation" required autocomplete="organization" maxlength="160">
                    <div class="form-error" data-error-for="organisation"></div>
                </div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-role">Role / designation</label>
                <input class="form-input" type="text" id="bf-role" name="role" autocomplete="organization-title" maxlength="120">
                <div class="form-error" data-error-for="role"></div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-phone">Phone <span class="req">*</span></label>
                <input class="form-input" type="tel" id="bf-phone" name="phone" required autocomplete="tel" maxlength="20">
                <div class="form-error" data-error-for="phone"></div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-email">Email <span class="req">*</span></label>
                <input class="form-input" type="email" id="bf-email" name="email" required autocomplete="email" maxlength="254">
                <div class="form-error" data-error-for="email"></div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-city">City</label>
                <input class="form-input" type="text" id="bf-city" name="city" autocomplete="address-level2" maxlength="120">
                <div class="form-error" data-error-for="city"></div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-project-type">Project type <span class="req">*</span></label>
                <select class="form-select" id="bf-project-type" name="project_type" required>
                    <option value="">Select a type…</option>
                    <option value="residential">Residential (single home)</option>
                    <option value="residential-bulk">Residential (multiple units / society)</option>
                    <option value="commercial">Commercial / Office</option>
                    <option value="institutional">Institutional / School / Hospital</option>
                    <option value="heritage">Heritage / Restoration</option>
                    <option value="retail">Retail / Reseller</option>
                    <option value="gaushala">Gaushala partnership</option>
                    <option value="other">Other</option>
                </select>
                <div class="form-error" data-error-for="project_type"></div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-requirement">Approximate requirement</label>
                <input class="form-input" type="text" id="bf-requirement" name="approximate_requirement" placeholder="e.g. 200 sq m interior, 2 coats" maxlength="200">
                <div class="form-error" data-error-for="approximate_requirement"></div>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-product-interest">Product interest</label>
                <select class="form-select" id="bf-product-interest" name="interest">
                    <option value="">Either / Not sure</option>
                    <option value="prakritik-distemper"<?= $interest === 'prakritik-distemper' ? ' selected' : '' ?>>Prakritik Distemper</option>
                    <option value="prakritik-emulsion"<?= $interest === 'prakritik-emulsion' ? ' selected' : '' ?>>Prakritik Emulsion</option>
                    <option value="both">Both</option>
                </select>
            </div>

            <div class="form-field">
                <label class="form-label" for="bf-message">Message <span class="req">*</span></label>
                <textarea class="form-textarea" id="bf-message" name="message" required minlength="10" maxlength="3000" placeholder="Tell us about your project timeline, site location, or any specific requirement."></textarea>
                <div class="form-error" data-error-for="message"></div>
            </div>

            <button type="submit" class="btn btn--primary btn--block btn--lg">
                <span data-submit-label>Submit Enquiry</span>
                <span data-submit-spinner hidden aria-hidden="true">…</span>
            </button>
        </form>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
