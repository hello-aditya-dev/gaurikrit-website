<?php
/**
 * Gaurikrit Bio Products — For Business.
 * Task PAGES-LOCK. Architectural / project-oriented.
 * Sections: ARCHITECTS & BUILDERS / INSTITUTIONS / CSR / NGOs / GAUSHALAS
 * (invite language, NO existing client claims). Business form.
 */
declare(strict_types=1);

$pageTitle       = 'For Business — Gaurikrit Bio Products';
$pageDescription = 'Talk to Gaurikrit about project, bulk and collaboration requirements for Prakritik Paint. Architects, builders, institutions, CSR, NGOs and gaushalas.';
$pageCanonical   = '/for-business/';
$pageClass        = 'for-business';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PROJECT_TYPES, $PRODUCTS;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
?>
<style>
  /* HERO */
  .biz-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2.5rem, 5vw, 4rem); background: linear-gradient(180deg, var(--bg) 0%, var(--secondary-bg) 100%); }
  .biz-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .biz-hero__container { grid-template-columns: 1.1fr 0.9fr; gap: 4rem; } }
  .biz-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); width: fit-content; }
  .biz-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .biz-hero__title { margin-top: 1.25rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .biz-hero__sub { margin-top: 1.25rem; max-width: 36rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .biz-hero__ctas { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .biz-hero__art { position: relative; aspect-ratio: 4/3; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); padding: 1.5rem; display: flex; align-items: flex-end; justify-content: center; }
  .biz-hero__art .biz-hero__bucket { position: absolute; right: 1.5rem; bottom: 1.5rem; width: 30%; height: 60%; }
  .biz-hero__art .biz-hero__brush { position: absolute; left: 1rem; top: 1rem; width: 60%; height: 50%; opacity: 0.7; }
  .biz-hero__art .biz-hero__grid-overlay { position: absolute; inset: 0; background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px); background-size: 3rem 3rem; opacity: 0.4; pointer-events: none; }

  /* SECTIONS — architectural columns */
  .biz-sections { padding-block: clamp(3rem, 6vw, 5rem); }
  .biz-sections__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .biz-sections__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); letter-spacing: -0.02em; }
  .biz-sections__grid { display: grid; gap: 0; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; background: var(--bg-card); box-shadow: var(--shadow-soft); }
  @media (min-width: 640px) { .biz-sections__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .biz-sections__grid { grid-template-columns: repeat(4, 1fr); } }
  .biz-section { padding: 1.75rem; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); display: flex; flex-direction: column; gap: 0.625rem; min-height: 14rem; }
  @media (min-width: 1024px) { .biz-section:nth-child(2n) { border-right: 1px solid var(--border); } .biz-section:nth-child(4n) { border-right: 0; } .biz-section:nth-last-child(-n+4) { border-bottom: 0; } }
  .biz-section__num { font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: var(--haldi-deep); }
  .biz-section__title { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; line-height: 1.2; }
  .biz-section__desc { font-size: 0.875rem; color: var(--fg-muted); line-height: 1.6; }
  .biz-section__chip { margin-top: auto; padding: 0.3125rem 0.625rem; border-radius: var(--radius-full); background: var(--secondary-bg); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--primary); width: fit-content; }

  /* FORM */
  .biz-form-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .biz-form-card { padding: clamp(1.5rem, 4vw, 2.5rem); background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  @media (min-width: 768px) { .biz-form-card { padding: 2.5rem; } }
  .biz-form-card__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .biz-form-card__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); line-height: 1.15; margin-top: 0.5rem; letter-spacing: -0.02em; }
  .biz-form-card__intro { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; font-size: 0.9375rem; }
  .biz-form-grid { display: grid; gap: 1rem; grid-template-columns: 1fr; margin-top: 1.5rem; }
  @media (min-width: 640px) { .biz-form-grid { grid-template-columns: 1fr 1fr; } }
  .biz-form-field--full { grid-column: 1 / -1; }
  .biz-form-card .btn { width: 100%; }
  .biz-form-card__note { margin-top: 1rem; font-size: 0.75rem; color: var(--fg-muted); text-align: center; }
</style>

<!-- HERO -->
<section class="biz-hero" id="biz-hero" data-reveal>
    <div class="container biz-hero__container">
        <div>
            <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>For Business</span>
            <h1 class="biz-hero__title">Building with a different kind of material?</h1>
            <p class="biz-hero__sub">Talk to Gaurikrit about project, bulk and collaboration requirements for Prakritik Paint.</p>
            <div class="biz-hero__ctas">
                <a href="#enquiry" class="btn btn--primary btn--lg">Discuss a Project</a>
                <a href="/products/" class="btn btn--outline btn--lg">Explore Prakritik Paint</a>
            </div>
        </div>
        <div class="biz-hero__art" aria-hidden="true">
            <div class="biz-hero__grid-overlay"></div>
            <div class="biz-hero__brush"><?php render_illustration('paint-brush-stroke'); ?></div>
            <div class="biz-hero__bucket"><?php render_illustration('prakritik-emulsion-bucket'); ?></div>
        </div>
    </div>
</section>

<!-- SECTIONS -->
<section class="biz-sections section--paper" id="audiences" data-reveal>
    <div class="container">
        <div class="biz-sections__head">
            <span class="section-heading__eyebrow">Who this is for</span>
            <h2 class="biz-sections__title">Four conversations, one form.</h2>
        </div>
        <div class="biz-sections__grid">
            <article class="biz-section">
                <div class="biz-section__num">01</div>
                <h3 class="biz-section__title">Architects & Builders</h3>
                <p class="biz-section__desc">Discuss product, packaging, and project requirements for residential and commercial builds.</p>
                <span class="biz-section__chip">Project</span>
            </article>
            <article class="biz-section">
                <div class="biz-section__num">02</div>
                <h3 class="biz-section__title">Institutions</h3>
                <p class="biz-section__desc">Talk to Gaurikrit about institutional projects that want a bio-based wall coating.</p>
                <span class="biz-section__chip">Institution</span>
            </article>
            <article class="biz-section">
                <div class="biz-section__num">03</div>
                <h3 class="biz-section__title">CSR / NGOs</h3>
                <p class="biz-section__desc">Sustainability-led CSR or NGO programmes exploring cow-dung-based bio-products.</p>
                <span class="biz-section__chip">CSR</span>
            </article>
            <article class="biz-section">
                <div class="biz-section__num">04</div>
                <h3 class="biz-section__title">Gaushalas</h3>
                <p class="biz-section__desc">Explore collaboration around cow-dung-based bio-products and Prakritik Paint.</p>
                <span class="biz-section__chip">Gaushala</span>
            </article>
        </div>
    </div>
</section>

<!-- BUSINESS FORM -->
<section class="biz-form-section" id="enquiry" data-reveal>
    <div class="container" style="max-width: 56rem;">
        <div class="biz-form-card">
            <span class="biz-form-card__eyebrow">Business enquiry</span>
            <h2 class="biz-form-card__title">Discuss a project with Gaurikrit.</h2>
            <p class="biz-form-card__intro">Fields marked <span class="req" style="color: var(--mitti);">*</span> are required. The more you share, the more useful the response.</p>

            <form data-business-form method="post" action="/api/business-enquiry.php" novalidate>
                <?= csrf_field() ?>
                <div class="form-honeypot" aria-hidden="true">
                    <label for="bz-company">Company (leave empty)</label>
                    <input type="text" id="bz-company" name="company" tabindex="-1" autocomplete="off">
                </div>
                <div class="biz-form-grid">
                    <div class="form-field">
                        <label class="form-label" for="bz-name">Name <span class="req">*</span></label>
                        <input class="form-input" type="text" id="bz-name" name="name" required maxlength="80" autocomplete="name">
                        <div class="form-error" data-error-for="name"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-organisation">Organisation <span class="req">*</span></label>
                        <input class="form-input" type="text" id="bz-organisation" name="organisation" required maxlength="120" autocomplete="organization">
                        <div class="form-error" data-error-for="organisation"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-role">Role</label>
                        <input class="form-input" type="text" id="bz-role" name="role" maxlength="80" placeholder="Architect, Procurement, Programme lead…" autocomplete="organization-title">
                        <div class="form-error" data-error-for="role"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-phone">Phone</label>
                        <input class="form-input" type="tel" id="bz-phone" name="phone" maxlength="20" autocomplete="tel">
                        <div class="form-error" data-error-for="phone"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-email">Email <span class="req">*</span></label>
                        <input class="form-input" type="email" id="bz-email" name="email" required maxlength="254" autocomplete="email">
                        <div class="form-error" data-error-for="email"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-city">City</label>
                        <input class="form-input" type="text" id="bz-city" name="city" maxlength="80" autocomplete="address-level2">
                        <div class="form-error" data-error-for="city"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-project-type">Project type</label>
                        <select class="form-select" id="bz-project-type" name="project_type">
                            <option value="">Select…</option>
                            <?php foreach ($PROJECT_TYPES as $type): ?>
                            <option value="<?= e($type) ?>"><?= e($type) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error" data-error-for="project_type"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-requirement">Approximate requirement</label>
                        <input class="form-input" type="text" id="bz-requirement" name="approximate_requirement" maxlength="100" placeholder="e.g. 20 litres of Emulsion, 50 kg of Distemper">
                        <div class="form-error" data-error-for="approximate_requirement"></div>
                    </div>
                    <div class="form-field biz-form-field--full">
                        <label class="form-label" for="bz-message">Message</label>
                        <textarea class="form-textarea" id="bz-message" name="message" maxlength="2000" rows="5" placeholder="A short note about your project, timeline and what you'd like to discuss."></textarea>
                        <div class="form-error" data-error-for="message"></div>
                    </div>
                    <div class="biz-form-field--full" style="margin-top: 0.5rem;">
                        <button type="submit" class="btn btn--primary btn--lg">
                            <span data-submit-label>Discuss a Project</span>
                            <svg data-submit-spinner hidden width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56" style="animation: spin 1s linear infinite"/></svg>
                        </button>
                    </div>
                </div>
            </form>
            <p class="biz-form-card__note">By submitting, you agree to be contacted about your enquiry.</p>
        </div>
    </div>
</section>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>

<?php require ROOT_PATH . '/includes/footer.php';
