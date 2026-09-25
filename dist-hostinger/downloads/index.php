<?php
/**
 * Gaurikrit Bio Products — Downloads (V4 asset replacement pass).
 * Task V4-ASSETS.
 *
 * Composition unchanged from V3. This pass uses the real brochure cover
 * (848×1200) large on the left. NO SVG seal stack — the brochure cover
 * itself carries the brand identity.
 *
 *   NO card grid for a single brochure. .downloads-split — large brochure
 *   cover left / title+details+actions right.
 *
 *   Brochure PDF: PHP `is_file()` check for
 *   `/assets/documents/prakritik-paint-brochure.pdf`. If present:
 *   "View Brochure" + "Download PDF". If absent:
 *   "Contact Gaurikrit for the current product brochure."
 */
declare(strict_types=1);

$pageTitle       = 'Downloads — Prakritik Paint Brochure | Gaurikrit';
$pageDescription = 'View or download the Prakritik Paint brochure for Distemper and Emulsion.';
$pageCanonical   = '/downloads/';
$pageClass        = 'downloads';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY;

$coverImage = '/assets/documents/prakritik-paint-brochure-cover.jpg';
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

  /* ===== DOWNLOADS SPLIT — real brochure cover left, details right ===== */
  .downloads-split {
    padding-block: clamp(2.5rem, 5vw, 4rem);
  }
  /* Real brochure cover — display at its true aspect ratio (848×1200). */
  .dl-cover {
    position: relative;
    aspect-ratio: 848/1200;
    background: var(--paper-warm);
    border: 1px solid var(--border-strong);
    border-radius: var(--r-panel);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
  }
  .dl-cover .dl-cover__image {
    display: block;
    width: 100%; height: 100%;
    object-fit: contain;
  }
  /* When the official cover loads, hide the fallback wordmark. */
  .dl-cover:has(.dl-cover__image) .dl-cover__fallback { display: none; }
  .dl-cover__fallback {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    text-align: center; padding: 2rem;
    color: rgba(32, 30, 25, 0.4);
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(1.5rem, 4vw, 3rem);
    line-height: 1.15; letter-spacing: 0.02em;
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
        Browse the supplied Prakritik Paint brochure or download a copy.
      </p>
    </div>
  </div>
</section>

<!-- ===== DOWNLOADS SPLIT ===== -->
<section class="section section--paper">
  <div class="container">
    <div class="downloads-split" data-reveal>
      <!-- LEFT — real brochure cover (848×1200) -->
      <div class="dl-cover">
        <img class="dl-cover__image"
             src="<?= asset_url($coverImage) ?>"
             alt="Prakritik Paint brochure cover"
             width="848" height="1200"
             loading="eager" fetchpriority="high" decoding="async">
        <div class="dl-cover__fallback" aria-hidden="true">
          PRAKRITIK<br>PAINT<br>BROCHURE
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
              Please contact Gaurikrit for a copy of the product brochure.
            </p>
            <div class="brochure__detail-actions">
              <a class="btn btn--primary btn--lg" href="/contact/?interest=general">Contact Gaurikrit for the current product brochure</a>
            </div>
            <p class="brochure__detail-note">
              In the meantime, product specifications for both formats are listed
              on the Distemper and Emulsion detail pages.
            </p>

          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
