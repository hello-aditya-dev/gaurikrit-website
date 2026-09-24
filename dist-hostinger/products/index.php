<?php
/**
 * Gaurikrit Bio Products — Products Overview.
 * Task PAGES-LOCK. Architectural material catalogue.
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Paint — Distemper & Emulsion — Gaurikrit Bio Products';
$pageDescription = 'Prakritik Paint from Gaurikrit — cow dung-based paint in Distemper and Emulsion formats for interior and exterior walls. Specifications, packaging and coverage.';
$pageCanonical   = '/products/';
$pageClass       = 'products-overview';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $COVERAGE_DISCLAIMER;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
?>
<style>
  /* HERO */
  .products-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: 2rem; }
  .products-hero__inner { max-width: 56rem; }
  .products-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .products-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .products-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .products-hero__sub { margin-top: 1rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .products-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }

  /* CATALOGUE — large presentation blocks (not cards) */
  .catalogue { padding-block: clamp(3rem, 6vw, 5rem); }
  .catalogue-block { display: grid; gap: 2rem; align-items: center; padding-block: clamp(2rem, 4vw, 3.5rem); border-bottom: 1px solid var(--border); }
  .catalogue-block:last-of-type { border-bottom: 0; }
  @media (min-width: 1024px) { .catalogue-block { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .catalogue-block--reverse > :first-child { order: 2; }
  @media (min-width: 1024px) { .catalogue-block--reverse > :first-child { order: 0; } }
  .catalogue-media { position: relative; aspect-ratio: 1; background: var(--secondary-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); }
  .catalogue-media .product-media { width: 100%; height: 100%; }
  .catalogue-media .product-media__official { object-fit: contain; padding: 2.5rem; }
  .catalogue-media .product-media__fallback { padding: 2rem; }
  .catalogue-media__chip { position: absolute; top: 1rem; left: 1rem; padding: 0.3125rem 0.75rem; border-radius: var(--radius-full); font-size: 0.625rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; background: var(--bg-card); color: var(--primary); border: 1px solid var(--border); z-index: 3; }
  .catalogue-text__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .catalogue-text__name { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.75rem); line-height: 1.1; margin-top: 0.75rem; letter-spacing: -0.02em; }
  .catalogue-text__desc { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .catalogue-text__spec-row { display: flex; flex-wrap: wrap; gap: 0.375rem; margin-top: 1.25rem; }
  .catalogue-text__spec { padding: 0.3125rem 0.75rem; border-radius: var(--radius-full); background: var(--secondary-bg); font-size: 0.75rem; font-weight: 500; border: 1px solid var(--border); }
  .catalogue-text__cta { margin-top: 1.5rem; }
  .catalogue-block--distemper .catalogue-media { border-top: 4px solid var(--indigo); }
  .catalogue-block--emulsion .catalogue-media { border-top: 4px solid var(--haldi-deep); }

  /* SPEC COMPARISON TABLE */
  .spec-table-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .spec-table-section__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .spec-table-section__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); letter-spacing: -0.02em; }
  .spec-table { width: 100%; border-collapse: collapse; background: var(--bg-card); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); border: 1px solid var(--border); }
  .spec-table thead th { background: var(--forest); color: var(--primary-fg); padding: 1rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; }
  .spec-table thead th:first-child { width: 9rem; }
  .spec-table tbody td { padding: 0.875rem 1.25rem; border-top: 1px solid var(--border); font-size: 0.9375rem; vertical-align: top; }
  .spec-table tbody th { padding: 0.875rem 1.25rem; border-top: 1px solid var(--border); font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--fg-muted); text-align: left; }
  @media (max-width: 640px) {
    .spec-table thead { display: none; }
    .spec-table, .spec-table tbody, .spec-table tr, .spec-table td, .spec-table th { display: block; width: 100%; }
    .spec-table tr { border-bottom: 1px solid var(--border); padding: 0.5rem 0; }
    .spec-table tbody td, .spec-table tbody th { border: 0; padding: 0.375rem 1rem; }
    .spec-table tbody th { background: var(--secondary-bg); }
    .spec-table tbody td[data-col]::before { content: attr(data-col) ' — '; font-weight: 700; color: var(--fg-muted); text-transform: uppercase; font-size: 0.6875rem; letter-spacing: 0.1em; }
  }
  .disclaimer-note { margin-top: 1.5rem; padding: 1rem 1.25rem; background: var(--bg-card); border-left: 3px solid var(--haldi); border-radius: var(--radius); font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.65; }

  /* ASHTA LAABH compact */
  .ashta-compact { padding-block: clamp(3rem, 6vw, 5rem); }
  .ashta-compact__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .ashta-compact__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 3vw, 2rem); color: var(--haldi-deep); }
  .ashta-compact__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; }
  .ashta-compact__grid { display: grid; gap: 0.75rem; }
  @media (min-width: 640px) { .ashta-compact__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .ashta-compact__grid { grid-template-columns: repeat(4, 1fr); } }
  .ashta-compact__item { padding: 1rem 1.25rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); display: flex; flex-direction: column; gap: 0.25rem; }
  .ashta-compact__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .ashta-compact__name { font-weight: 600; font-size: 0.9375rem; }
  .ashta-compact__deva-item { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* CTA STRIP */
  .help-cta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--forest); color: var(--primary-fg); text-align: center; }
  .help-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); }
  .help-cta__sub { margin-top: 0.5rem; color: oklch(0.85 0.01 75); }
  .help-cta__btn { margin-top: 1.5rem; }
</style>

<!-- ===== HERO ===== -->
<section class="products-hero" id="products-hero" data-reveal>
    <div class="container products-hero__inner">
        <span class="products-hero__eyebrow"><span class="products-hero__eyebrow-dot" aria-hidden="true"></span>Prakritik Paint</span>
        <h1 class="products-hero__title">Cow dung-based paint in Distemper and Emulsion formats.</h1>
        <p class="products-hero__sub">Two Prakritik Paint formats — both matt, both suitable for interior and exterior walls, both carrying the same material lineage.</p>
        <hr class="products-hero__rule">
    </div>
</section>

<!-- ===== CATALOGUE ===== -->
<section class="catalogue" id="catalogue" data-reveal>
    <div class="container">

        <!-- Distemper -->
        <article class="catalogue-block catalogue-block--distemper" id="prakritik-distemper">
            <div class="catalogue-media">
                <span class="catalogue-media__chip">01 · Distemper</span>
                <div class="product-media" data-official-image="<?= e($distemper['officialImage']) ?>">
                    <img class="product-media__official" src="<?= e($distemper['officialImage']) ?>" alt="<?= e($distemper['name']) ?>" width="640" height="640">
                    <div class="product-media__fallback"><?php render_illustration('prakritik-distemper-bucket'); ?></div>
                </div>
            </div>
            <div class="catalogue-text">
                <span class="catalogue-text__eyebrow"><?= e($distemper['descriptor']) ?></span>
                <h2 class="catalogue-text__name"><?= e($distemper['name']) ?></h2>
                <p class="catalogue-text__desc">A powdered cow dung-based paint format. Packaged in kilograms, suitable for interior and exterior walls, with a matt finish.</p>
                <div class="catalogue-text__spec-row">
                    <span class="catalogue-text__spec"><?= e($distemper['packagingShort']) ?></span>
                    <span class="catalogue-text__spec">Finish: <?= e($distemper['finish']) ?></span>
                    <span class="catalogue-text__spec"><?= e($distemper['usage']) ?></span>
                    <span class="catalogue-text__spec">Coverage: <?= e($distemper['coverage']) ?></span>
                </div>
                <div class="catalogue-text__cta">
                    <a href="<?= e($distemper['route']) ?>" class="btn btn--primary btn--lg">Explore Distemper
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Emulsion (reversed) -->
        <article class="catalogue-block catalogue-block--emulsion catalogue-block--reverse" id="prakritik-emulsion">
            <div class="catalogue-media">
                <span class="catalogue-media__chip">02 · Emulsion</span>
                <div class="product-media" data-official-image="<?= e($emulsion['officialImage']) ?>">
                    <img class="product-media__official" src="<?= e($emulsion['officialImage']) ?>" alt="<?= e($emulsion['name']) ?>" width="640" height="640">
                    <div class="product-media__fallback"><?php render_illustration('prakritik-emulsion-bucket'); ?></div>
                </div>
            </div>
            <div class="catalogue-text">
                <span class="catalogue-text__eyebrow"><?= e($emulsion['descriptor']) ?></span>
                <h2 class="catalogue-text__name"><?= e($emulsion['name']) ?></h2>
                <p class="catalogue-text__desc">A liquid cow dung-based paint format. Packaged in litres, suitable for interior and exterior walls, with a matt finish.</p>
                <div class="catalogue-text__spec-row">
                    <span class="catalogue-text__spec"><?= e($emulsion['packagingShort']) ?></span>
                    <span class="catalogue-text__spec">Finish: <?= e($emulsion['finish']) ?></span>
                    <span class="catalogue-text__spec"><?= e($emulsion['usage']) ?></span>
                    <span class="catalogue-text__spec">Coverage: <?= e($emulsion['coverage']) ?></span>
                </div>
                <div class="catalogue-text__cta">
                    <a href="<?= e($emulsion['route']) ?>" class="btn btn--primary btn--lg">Explore Emulsion
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>
    </div>
</section>

<!-- ===== SPEC COMPARISON TABLE ===== -->
<section class="spec-table-section" id="spec-comparison" data-reveal>
    <div class="container">
        <div class="spec-table-section__head">
            <span class="section-heading__eyebrow">Specifications side by side</span>
            <h2 class="spec-table-section__title">Compare the two formats.</h2>
        </div>
        <div style="overflow-x:auto;">
            <table class="spec-table">
                <thead>
                    <tr>
                        <th scope="col">Specification</th>
                        <th scope="col"><?= e($distemper['name']) ?></th>
                        <th scope="col"><?= e($emulsion['name']) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Packaging</th>
                        <td data-col="Distemper"><?= e($distemper['packagingShort']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['packagingShort']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Colour</th>
                        <td data-col="Distemper"><?= e($distemper['colour']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['colour']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Finish</th>
                        <td data-col="Distemper"><?= e($distemper['finish']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['finish']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Drying time</th>
                        <td data-col="Distemper"><?= e($distemper['dryingTime']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['dryingTime']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Coverage</th>
                        <td data-col="Distemper"><?= e($distemper['coverage']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['coverage']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">V.O.C.</th>
                        <td data-col="Distemper"><?= e($distemper['voc']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['voc']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Usage</th>
                        <td data-col="Distemper"><?= e($distemper['usage']) ?></td>
                        <td data-col="Emulsion"><?= e($emulsion['usage']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="disclaimer-note"><strong>Coverage note —</strong> <?= e($COVERAGE_DISCLAIMER) ?></p>
    </div>
</section>

<!-- ===== ASHTA LAABH (compact) ===== -->
<section class="ashta-compact" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="ashta-compact__head">
            <div class="ashta-compact__deva" lang="hi"><?= e('अष्ट लाभ') ?></div>
            <h2 class="ashta-compact__title">Eight benefits presented in Prakritik Paint.</h2>
        </div>
        <ol class="ashta-compact__grid" data-reveal-stagger>
            <?php foreach ($ASHTA_LAABH as $i => $benefit): ?>
            <li class="ashta-compact__item">
                <span class="ashta-compact__num"><?= sprintf('%02d', $i + 1) ?></span>
                <span class="ashta-compact__name"><?= e($benefit['name']) ?></span>
                <span class="ashta-compact__deva-item" lang="hi"><?= e($benefit['hindi']) ?></span>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<!-- ===== HELP CTA ===== -->
<section class="help-cta" id="help-cta" data-reveal>
    <div class="container">
        <h2 class="help-cta__title">Need help choosing?</h2>
        <p class="help-cta__sub">Talk to Gaurikrit about your project and we'll help you compare formats.</p>
        <div class="help-cta__btn">
            <a href="/contact/" class="btn btn--haldi btn--lg">Talk to Gaurikrit</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
