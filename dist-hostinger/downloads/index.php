<?php
/**
 * Gaurikrit Bio Products — Downloads.
 * Task PAGES-LOCK. Branded brochure page with image handoff + brochure PDF
 * detection via JS ([data-brochure-detect]).
 *
 * Brochure cover: image handoff for
 *   /assets/documents/prakritik-paint-brochure-cover.png
 * Brochure PDF:   /assets/documents/prakritik-paint-brochure.pdf
 * If the PDF is missing server-side, show the "Contact Gaurikrit for the
 * current product brochure." message. JS detection is a bonus layer.
 */
declare(strict_types=1);

$pageTitle       = 'Product Documents — Gaurikrit Bio Products';
$pageDescription = 'Prakritik Paint Brochure — product information for Prakritik Distemper and Prakritik Emulsion. Download or contact Gaurikrit for the current brochure.';
$pageCanonical   = '/downloads/';
$pageClass        = 'downloads';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');

// Server-side detection: is the brochure PDF present?
$brochurePdf = '/assets/documents/prakritik-paint-brochure.pdf';
$brochureCover = '/assets/documents/prakritik-paint-brochure-cover.png';
$pdfPresent = is_file(ROOT_PATH . $brochurePdf);
?>
<style>
  /* HERO */
  .dl-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2rem, 4vw, 3rem); }
  .dl-hero__inner { max-width: 56rem; }
  .dl-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .dl-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .dl-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .dl-hero__sub { margin-top: 1rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .dl-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }

  /* BROCHURE BLOCK */
  .brochure { padding-block: clamp(3rem, 6vw, 5rem); }
  .brochure__inner { display: grid; gap: 2.5rem; align-items: center; }
  @media (min-width: 1024px) { .brochure__inner { grid-template-columns: 1fr 1.2fr; gap: 4rem; } }
  .brochure__cover { position: relative; aspect-ratio: 3/4; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-forest); display: flex; align-items: center; justify-content: center; padding: 2rem; }
  @media (max-width: 1023px) { .brochure__cover { max-width: 24rem; margin-inline: auto; } }
  .brochure__cover .product-media { width: 100%; height: 100%; }
  .brochure__cover .product-media__official { object-fit: contain; }
  .brochure__cover .product-media__fallback { padding: 0; width: 100%; height: 100%; }
  /* Coded fallback cover — uses illustration + brand typography */
  .brochure__cover-fallback { position: relative; width: 100%; height: 100%; background: linear-gradient(160deg, var(--forest), var(--forest-deep)); color: var(--primary-fg); border-radius: var(--radius); overflow: hidden; display: flex; flex-direction: column; padding: 2rem; }
  .brochure__cover-fallback .cover-mark { width: 4rem; height: 4rem; }
  .brochure__cover-fallback .cover-deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 4vw, 2.25rem); color: var(--haldi); margin-top: auto; }
  .brochure__cover-fallback .cover-name { font-family: var(--font-display); font-size: clamp(1.5rem, 4vw, 2.5rem); font-weight: 700; line-height: 1.1; margin-top: 0.25rem; }
  .brochure__cover-fallback .cover-phrase { font-style: italic; font-family: var(--font-display); color: oklch(0.88 0.11 85); margin-top: 0.75rem; }
  .brochure__cover-fallback .cover-stamp { position: absolute; top: 1rem; right: 1rem; padding: 0.3125rem 0.625rem; border: 1px solid var(--haldi); border-radius: var(--radius-full); font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--haldi); }
  .brochure__cover-fallback .cover-art { position: absolute; right: 0; bottom: 0; width: 60%; height: 60%; opacity: 0.18; pointer-events: none; }

  /* Brochure detail */
  .brochure__detail-eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .brochure__detail-title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); line-height: 1.1; margin-top: 0.5rem; letter-spacing: -0.02em; }
  .brochure__detail-desc { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .brochure__detail-meta { margin-top: 1.5rem; padding: 1rem 1.25rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); display: grid; gap: 0.625rem; }
  .brochure__detail-meta dt { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .brochure__detail-meta dd { font-size: 0.9375rem; margin-top: 0.125rem; }
  .brochure__detail-actions { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .brochure__detail-note { margin-top: 1rem; padding: 1rem 1.25rem; border-left: 3px solid var(--mitti); background: var(--secondary-bg); border-radius: var(--radius); font-size: 0.875rem; color: var(--fg-muted); line-height: 1.65; }
  .brochure__detail-note a { color: var(--primary); font-weight: 600; }

  /* WHAT'S INSIDE list */
  .inside { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .inside__head { margin-bottom: 2rem; max-width: 48rem; }
  .inside__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .inside__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .inside__list { display: grid; gap: 1rem; }
  @media (min-width: 640px) { .inside__list { grid-template-columns: 1fr 1fr; } }
  .inside__item { padding: 1.25rem 1.5rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); display: flex; gap: 1rem; align-items: start; }
  .inside__item-num { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; color: var(--haldi-deep); flex-shrink: 0; line-height: 1; }
  .inside__item-title { font-weight: 600; font-size: 0.9375rem; }
  .inside__item-desc { font-size: 0.8125rem; color: var(--fg-muted); margin-top: 0.25rem; line-height: 1.5; }

  /* CTA */
  .dl-cta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--forest); color: var(--primary-fg); }
  .dl-cta__inner { text-align: center; max-width: 48rem; margin-inline: auto; }
  .dl-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); }
  .dl-cta__body { margin-top: 0.75rem; color: oklch(0.85 0.01 75); line-height: 1.65; }
  .dl-cta__actions { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
</style>

<!-- HERO -->
<section class="dl-hero" id="dl-hero" data-reveal>
    <div class="container dl-hero__inner">
        <span class="dl-hero__eyebrow"><span class="dl-hero__eyebrow-dot" aria-hidden="true"></span>Product Documents</span>
        <h1 class="dl-hero__title">Prakritik Paint Brochure.</h1>
        <p class="dl-hero__sub">Product information for Prakritik Distemper and Prakritik Emulsion.</p>
        <hr class="dl-hero__rule">
    </div>
</section>

<!-- BROCHURE -->
<section class="brochure section--paper" id="brochure" data-reveal>
    <div class="container">
        <div class="brochure__inner">

            <!-- COVER with image handoff -->
            <div class="brochure__cover">
                <div class="product-media" data-official-image="<?= e($brochureCover) ?>">
                    <img class="product-media__official" src="<?= e($brochureCover) ?>" alt="Prakritik Paint brochure cover" width="480" height="640">
                    <div class="product-media__fallback">
                        <div class="brochure__cover-fallback">
                            <span class="cover-stamp">Brochure</span>
                            <div class="cover-mark" aria-hidden="true"><?php render_illustration('gaurikrit-cow-mark'); ?></div>
                            <div class="cover-deva" lang="hi"><?= e($COMPANY['devanagari']) ?></div>
                            <div class="cover-name">Prakritik Paint</div>
                            <div class="cover-phrase"><?= e($COMPANY['brandLine']) ?></div>
                            <div class="cover-art" aria-hidden="true"><?php render_illustration('paint-brush-stroke'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL + ACTIONS -->
            <div class="brochure__detail">
                <span class="brochure__detail-eyebrow">Brochure</span>
                <h2 class="brochure__detail-title">Prakritik Paint Brochure.</h2>
                <p class="brochure__detail-desc">A short document with product information for Prakritik Distemper and Prakritik Emulsion.</p>
                <dl class="brochure__detail-meta">
                    <div>
                        <dt>Products covered</dt>
                        <dd><?= e($distemper['name']) ?> &amp; <?= e($emulsion['name']) ?></dd>
                    </div>
                    <div>
                        <dt>Document type</dt>
                        <dd>Product brochure</dd>
                    </div>
                </dl>

                <?php if ($pdfPresent): ?>
                    <!-- Server-side: PDF is present — show view/download buttons.
                         Also wire JS brochure detection as a bonus layer. -->
                    <div data-brochure-detect="<?= e($brochurePdf) ?>" data-brochure-state="available">
                        <div class="brochure__detail-actions" data-brochure-if-available>
                            <a href="<?= e($brochurePdf) ?>" class="btn btn--primary btn--lg" target="_blank" rel="noopener">View Brochure</a>
                            <a href="<?= e($brochurePdf) ?>" class="btn btn--outline btn--lg" download>Download PDF</a>
                        </div>
                        <p class="brochure__detail-note" data-brochure-if-missing hidden>
                            Contact Gaurikrit for the current product brochure — <a href="/contact/?interest=general">send an enquiry</a>.
                        </p>
                    </div>
                <?php else: ?>
                    <!-- Server-side: PDF is NOT present — show the message. -->
                    <div data-brochure-detect="<?= e($brochurePdf) ?>" data-brochure-state="missing">
                        <div class="brochure__detail-actions" data-brochure-if-available hidden>
                            <a href="<?= e($brochurePdf) ?>" class="btn btn--primary btn--lg" target="_blank" rel="noopener">View Brochure</a>
                            <a href="<?= e($brochurePdf) ?>" class="btn btn--outline btn--lg" download>Download PDF</a>
                        </div>
                        <p class="brochure__detail-note" data-brochure-if-missing>
                            <strong>Contact Gaurikrit for the current product brochure.</strong>
                            The brochure PDF will be available here once published. Until then, send an enquiry and we'll share what's currently available — <a href="/contact/?interest=general">send an enquiry</a>.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- WHAT'S INSIDE -->
<section class="inside" id="inside" data-reveal>
    <div class="container">
        <div class="inside__head">
            <span class="inside__eyebrow">What's inside</span>
            <h2 class="inside__title">What the brochure covers.</h2>
        </div>
        <ol class="inside__list" data-reveal-stagger>
            <li class="inside__item">
                <span class="inside__item-num">01</span>
                <div>
                    <div class="inside__item-title">Both Prakritik formats</div>
                    <div class="inside__item-desc">A short presentation of Distemper and Emulsion — packaging, finish, drying time, coverage and usage.</div>
                </div>
            </li>
            <li class="inside__item">
                <span class="inside__item-num">02</span>
                <div>
                    <div class="inside__item-title">Specifications side by side</div>
                    <div class="inside__item-desc">The supplied product specifications, presented as a comparison.</div>
                </div>
            </li>
            <li class="inside__item">
                <span class="inside__item-num">03</span>
                <div>
                    <div class="inside__item-title">Material direction</div>
                    <div class="inside__item-desc">A short note on the cow-dung-based material lineage Prakritik Paint carries.</div>
                </div>
            </li>
            <li class="inside__item">
                <span class="inside__item-num">04</span>
                <div>
                    <div class="inside__item-title">Coverage disclaimer</div>
                    <div class="inside__item-desc">The supplied coverage note, carried into the brochure as written.</div>
                </div>
            </li>
        </ol>
    </div>
</section>

<!-- CTA -->
<section class="dl-cta" id="dl-cta" data-reveal>
    <div class="container">
        <div class="dl-cta__inner">
            <h2 class="dl-cta__title">Have a project in mind?</h2>
            <p class="dl-cta__body">Talk to Gaurikrit about project, bulk and collaboration requirements for Prakritik Paint.</p>
            <div class="dl-cta__actions">
                <a href="/contact/" class="btn btn--haldi btn--lg">Talk to Us</a>
                <a href="/for-business/" class="btn btn--outline btn--lg" style="border-color: var(--haldi); color: var(--haldi);">Discuss a Project</a>
            </div>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
