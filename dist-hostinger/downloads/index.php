<?php
/**
 * Gaurikrit Bio Products — Downloads (brochure).
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

$pageTitle       = 'Downloads — Prakritik Paint Brochure | Gaurikrit';
$pageDescription = 'Download the Gaurikrit Bio Products brochure — Prakritik Distemper and Prakritik Emulsion, claims, coverage, and how to use. PDF, ~1 MB.';
$pageCanonical   = '/downloads/';
$pageClass       = 'downloads';
$pageOgType      = 'website';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

$brochurePath = '/assets/documents/prakritik-paint-brochure.pdf';
$brochureAbs  = ROOT_PATH . $brochurePath;
$brochureExists = is_file($brochureAbs);
$brochureSize  = $brochureExists ? round(((int) filesize($brochureAbs)) / 1024 / 1024, 1) : null;

$coverPath    = '/assets/brand/brochure-cover.png';
$coverAbs     = ROOT_PATH . $coverPath;
$coverExists  = is_file($coverAbs);
?>
<style>
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; padding-top:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }

  .downloads-grid { display:grid; gap:2rem; grid-template-columns:1fr; align-items:start; max-width:48rem; margin-inline:auto; }
  @media (min-width: 768px) { .downloads-grid { grid-template-columns:0.8fr 1.2fr; } }

  .brochure-cover { aspect-ratio:3/4; border:1px solid var(--border); border-radius:var(--radius-lg); background:linear-gradient(135deg, var(--haldi-light), var(--haldi)); box-shadow:var(--shadow-haldi); display:flex; flex-direction:column; align-items:center; justify-content:center; padding:2rem; text-align:center; overflow:hidden; position:relative; }
  .brochure-cover__seal { width:6rem; height:6rem; border-radius:50%; background:var(--bg-card); display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; box-shadow:var(--shadow-soft); }
  .brochure-cover__title { font-family:var(--font-display); font-weight:700; font-size:1.5rem; color:var(--charcoal); line-height:1.15; }
  .brochure-cover__sub { font-size:0.75rem; font-weight:700; letter-spacing:0.2em; text-transform:uppercase; color:var(--forest); margin-top:0.5rem; }
  .brochure-cover__deva { font-family:var(--font-deva); font-weight:700; font-size:1.5rem; color:var(--forest); margin-bottom:0.5rem; }

  .download-card { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .download-card h2 { font-size:1.25rem; margin-bottom:0.5rem; }
  .download-card p { color:var(--fg-muted); font-size:0.9375rem; line-height:1.6; margin-bottom:1rem; }
  .download-meta { display:flex; gap:1.5rem; margin-bottom:1.5rem; font-size:0.8125rem; }
  .download-meta__label { color:var(--fg-muted); display:block; text-transform:uppercase; letter-spacing:0.1em; font-size:0.6875rem; }
  .download-meta__value { font-weight:700; }

  .download-actions { display:flex; flex-wrap:wrap; gap:0.75rem; }
</style>

<section class="page-hero section section--paper section--grain" style="padding-top:calc(var(--header-h) + 2rem)">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <span>Downloads</span>
        </nav>
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Downloads</span>
            <h1 class="section-heading__title">Take Prakritik Paint with you.</h1>
            <p class="section-heading__desc">The full brochure — products, claims, coverage, how-to. Print it, share it, or read it offline.</p>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div class="downloads-grid" data-reveal>
            <div class="brochure-cover" aria-hidden="true">
                <div class="brochure-cover__seal"><?php render_illustration('gaurikrit-cow-mark'); ?></div>
                <div class="brochure-cover__deva"><?= e($COMPANY['devanagari']) ?></div>
                <div class="brochure-cover__title">Prakritik Paint<br>Brochure</div>
                <div class="brochure-cover__sub"><?= e($COMPANY['fullName']) ?></div>
            </div>

            <article class="download-card">
                <h2>Prakritik Paint Brochure (PDF)</h2>
                <p>Two products, nine claims, coverage calculator notes, and the application guides — Distemper for interiors, Emulsion for interiors and sheltered exteriors.</p>
                <div class="download-meta">
                    <div>
                        <span class="download-meta__label">Format</span>
                        <span class="download-meta__value">PDF</span>
                    </div>
                    <div>
                        <span class="download-meta__label">Size</span>
                        <span class="download-meta__value"><?= $brochureExists ? e((string)$brochureSize) . ' MB' : 'TBD' ?></span>
                    </div>
                    <div>
                        <span class="download-meta__label">Updated</span>
                        <span class="download-meta__value"><?= e(date('M Y')) ?></span>
                    </div>
                </div>
                <div class="download-actions">
                    <?php if ($brochureExists): ?>
                        <a href="<?= e($brochurePath) ?>" class="btn btn--primary btn--lg" download>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                            Download brochure
                        </a>
                        <a href="<?= e($brochurePath) ?>" target="_blank" rel="noopener" class="btn btn--outline btn--lg">Open in new tab</a>
                    <?php else: ?>
                        <a href="<?= e($brochurePath) ?>" class="btn btn--primary btn--lg" download>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                            Download brochure
                        </a>
                        <p class="form-error" style="margin-top:0.75rem; min-height:0">Note: the PDF is being prepared. If the file is not yet available, please <a href="/contact/">contact us</a> and we will share it directly.</p>
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="section section--paper section--grain">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Don't want to download?</span>
            <h2 class="section-heading__title">Read everything on the site.</h2>
        </div>
        <div class="features-grid" data-reveal-stagger style="max-width:48rem; margin-inline:auto">
            <a href="/products/" class="feature-card" style="text-decoration:none">
                <h3 class="feature-card__title">Products →</h3>
                <p class="feature-card__desc">Prakritik Distemper and Prakritik Emulsion — full descriptions, sizes, prices, verified claims.</p>
            </a>
            <a href="/why-prakritik/" class="feature-card" style="text-decoration:none">
                <h3 class="feature-card__title">Why Prakritik? →</h3>
                <p class="feature-card__desc">Cow dung, lime, breathability, and the gaushala sourcing story.</p>
            </a>
            <a href="/#claims" class="feature-card" style="text-decoration:none">
                <h3 class="feature-card__title">Claims register →</h3>
                <p class="feature-card__desc">Nine documented claims, each with a source and a reference number.</p>
            </a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
