<?php
/**
 * Gaurikrit Bio Products — Downloads (V3 rebuild).
 * Task V3-PAGES.
 *
 * NO card grid for a single brochure. .downloads-split — large brochure
 * cover left / title+details+actions right.
 *
 * Brochure PDF: PHP `is_file()` check for
 * `/assets/documents/prakritik-paint-brochure.pdf`. If present:
 * "View Brochure" + "Download PDF". If absent:
 * "Contact Gaurikrit for the current product brochure."
 */
declare(strict_types=1);

$pageTitle       = 'Downloads — Prakritik Paint Brochure | Gaurikrit';
$pageDescription = 'View or download the Prakritik Paint product brochure. If the current PDF is not yet published, contact Gaurikrit directly for the latest brochure.';
$pageCanonical   = '/downloads/';
$pageClass        = 'downloads';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY;

$coverImage = '/assets/documents/prakritik-paint-brochure-cover.png';
$brochureUrl = '/assets/documents/prakritik-paint-brochure.pdf';
$brochurePath = ROOT_PATH . $brochureUrl;
$hasBrochure = is_file($brochurePath);
?>
<style>
  /* ===== HERO ===== */
  .dl-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .dl-hero__inner { display: grid; gap: 1rem; max-width: 60rem; }
  .dl-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .dl-hero__eyebrow-dot {
    display: inline-block; width: 0.375rem; height: 0.375rem;
    border-radius: 50%; background: var(--haldi);
  }
  .dl-hero__title {
    margin-top: 0.5rem; font-family: var(--font-display);
    font-size: clamp(2.2rem, 5vw, 4rem); letter-spacing: -0.02em;
    text-wrap: balance; line-height: 1.05;
  }
  .dl-hero__sub {
    margin-top: 1rem; color: var(--fg-muted);
    font-size: clamp(1rem, 2vw, 1.125rem); max-width: 60ch;
  }

  /* ===== DOWNLOADS SPLIT (cover left / details+actions right) ===== */
  .downloads-split {
    padding-block: clamp(2.5rem, 5vw, 4rem);
  }
  .dl-cover {
    position: relative; min-height: 26rem;
    background: linear-gradient(135deg, var(--haldi-soft), var(--haldi));
    border: 1px solid var(--border-strong);
    border-radius: var(--r-panel);
    overflow: hidden;
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 2.5rem;
  }
  @media (min-width: 1024px) { .dl-cover { min-height: 34rem; } }
  .dl-cover__media {
    position: absolute; inset: 0; z-index: 0;
    display: flex; align-items: center; justify-content: center;
  }
  .dl-cover__media .product-media { width: 100%; height: 100%; }
  .dl-cover__media .product-media__official { object-fit: cover; }
  .dl-cover__inner { position: relative; z-index: 2; color: var(--charcoal); }
  .dl-cover__seal { width: 4rem; height: 4rem; margin: 0 0 1.25rem; }
  .dl-cover__seal svg { width: 100%; height: 100%; }
  .dl-cover__deva {
    font-family: var(--font-deva); font-weight: 700;
    font-size: clamp(1.5rem, 3vw, 2rem); color: var(--forest-deep);
  }
  .dl-cover__wordmark {
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(1.5rem, 3vw, 2rem); color: var(--charcoal);
    margin-top: 0.25rem;
  }
  .dl-cover__title {
    font-family: var(--font-display); font-style: italic;
    font-size: clamp(1.125rem, 2vw, 1.375rem); margin-top: 0.75rem;
    color: var(--forest-deep); max-width: 28ch;
  }
  .dl-cover__foot {
    margin-top: 1rem; font-size: 0.8125rem;
    color: rgba(32, 30, 25, 0.7); letter-spacing: 0.04em;
  }

  /* Right column — details + actions */
  .dl-card { gap: 1.25rem; }
  .brochure__detail-eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--primary);
  }
  .brochure__detail-title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem);
    margin-top: 0.5rem; line-height: 1.15; letter-spacing: -0.01em;
    text-wrap: balance;
  }
  .brochure__detail-desc { color: var(--fg-muted); line-height: 1.7; max-width: 60ch; }
  .brochure__detail-meta {
    display: flex; justify-content: space-between; gap: 1rem;
    padding-block: 0.75rem; border-bottom: 1px solid var(--border);
    font-size: 0.9375rem;
  }
  .brochure__detail-meta:last-of-type { border-bottom: 0; }
  .brochure__detail-meta dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .brochure__detail-meta dd { color: var(--fg); }
  .brochure__detail-actions {
    display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.5rem;
  }
  .brochure__detail-note {
    margin-top: 1.25rem; font-size: 0.8125rem; color: var(--fg-muted);
    line-height: 1.6;
  }

  /* Missing brochure note */
  .dl-missing {
    padding: 1.5rem; background: var(--limewash);
    border: 1px dashed var(--border-strong); border-radius: var(--r-panel);
    font-size: 0.9375rem; color: var(--fg-muted); line-height: 1.6;
  }
  .dl-missing strong { color: var(--fg); }
</style>

<!-- ===== HERO ===== -->
<section class="dl-hero bg-limewash" aria-labelledby="dl-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Downloads</span>
    </nav>
    <div class="dl-hero__inner" data-reveal>
      <span class="dl-hero__eyebrow">
        <span class="dl-hero__eyebrow-dot" aria-hidden="true"></span>
        Brochure
      </span>
      <hr class="dl-hero__rule">
      <h1 class="dl-hero__title" id="dl-title">Prakritik Paint brochure.</h1>
      <p class="dl-hero__sub">
        One brochure, when published. The current edition is checked at render
        time — if the PDF is present you can view or download it directly.
      </p>
    </div>
  </div>
</section>

<!-- ===== DOWNLOADS SPLIT ===== -->
<section class="section section--paper">
  <div class="container">
    <div class="downloads-split" data-reveal>
      <!-- LEFT — large brochure cover -->
      <div class="dl-cover">
        <div class="dl-cover__media" aria-hidden="true">
          <div class="product-media" data-official-image="<?= e($coverImage) ?>">
            <img class="product-media__official"
                 src="<?= e($coverImage) ?>"
                 alt="Prakritik Paint brochure cover"
                 width="800" height="1000" loading="lazy" decoding="async">
            <div class="product-media__fallback" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
              <span style="font-family: var(--font-display); font-weight: 700; font-size: clamp(1.5rem, 4vw, 3rem); color: rgba(32,30,25,0.35); text-align: center; padding: 2rem;">PRAKRITIK<br>PAINT<br>BROCHURE</span>
            </div>
          </div>
        </div>
        <div class="dl-cover__inner">
          <div class="dl-cover__seal" aria-hidden="true">
            <?php render_illustration('gaurikrit-cow-mark'); ?>
          </div>
          <p class="dl-cover__deva"><?= e($COMPANY['devanagari']) ?></p>
          <p class="dl-cover__wordmark">PRAKRITIK PAINT</p>
          <p class="dl-cover__title">Cow dung-based paint, for interior and exterior walls.</p>
          <p class="dl-cover__foot"><?= e($COMPANY['legalName']) ?></p>
        </div>
      </div>

      <!-- RIGHT — title + details + actions -->
      <div class="dl-card" data-brochure-detect="<?= e($brochureUrl) ?>">
        <?php if ($hasBrochure): ?>
          <div data-brochure-if-available>
            <span class="brochure__detail-eyebrow">Current edition</span>
            <h2 class="brochure__detail-title">Prakritik Paint — product brochure.</h2>
            <p class="brochure__detail-desc">
              The brochure covers both Prakritik Distemper and Prakritik Emulsion:
              pack sizes, listed specifications, finish, drying time, coverage,
              V.O.C. and usage. Suitable for architects, builders, institutions and
              homeowners.
            </p>

            <dl>
              <div class="brochure__detail-meta">
                <dt>Format</dt><dd>PDF</dd>
              </div>
              <div class="brochure__detail-meta">
                <dt>Source</dt><dd><?= e($COMPANY['name']) ?></dd>
              </div>
              <div class="brochure__detail-meta">
                <dt>Use</dt><dd>Read online or print</dd>
              </div>
            </dl>

            <div class="brochure__detail-actions">
              <a class="btn btn--primary btn--lg" href="<?= e($brochureUrl) ?>"
                 target="_blank" rel="noopener">View Brochure</a>
              <a class="btn btn--outline" href="<?= e($brochureUrl) ?>" download>Download PDF</a>
            </div>
            <p class="brochure__detail-note">
              If the file does not open, the PDF may not be reachable from your
              network. Contact Gaurikrit directly for a current copy.
            </p>
          </div>
        <?php else: ?>
          <div data-brochure-if-missing>
            <span class="brochure__detail-eyebrow">Brochure pending</span>
            <h2 class="brochure__detail-title">The current brochure is not yet published here.</h2>
            <p class="brochure__detail-desc">
              The brochure PDF was not detected on the server at render time.
              Gaurikrit will provide the current edition directly on request.
            </p>
            <div class="brochure__detail-actions">
              <a class="btn btn--primary btn--lg" href="/contact/?interest=general">Contact Gaurikrit for the current product brochure</a>
            </div>
            <p class="brochure__detail-note">
              In the meantime, product specifications for both formats are listed
              on the Distemper and Emulsion detail pages.
            </p>
            <div class="dl-missing" style="margin-top: 1.5rem;">
              <strong>Checked path:</strong>
              <code><?= e($brochureUrl) ?></code> — file not found at render time.
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
