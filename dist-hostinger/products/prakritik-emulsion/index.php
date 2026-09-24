<?php
/**
 * Gaurikrit Bio Products — Prakritik Emulsion detail.
 * Task PAGES-LOCK. Warmer. Haldi / Leaf secondary accent.
 * REVERSED main composition — image right, text left (opposite of Distemper).
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Emulsion Paint — Gaurikrit Bio Products';
$pageDescription = 'Prakritik Emulsion Paint — eco-friendly cow dung paint. White, matt finish, 4 hrs drying time, 300 sq.ft. coverage, interior and exterior use. 1, 4, 10 and 20 litre packaging.';
$pageCanonical   = '/products/prakritik-emulsion/';
$pageClass       = 'product-emulsion';

require_once __DIR__ . '/../../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $COVERAGE_DISCLAIMER;

$product   = get_product('prakritik-emulsion');
$distemper = get_product('prakritik-distemper');
?>
<style>
  .emulsion-detail { padding-top: calc(var(--header-h) + 2rem); background: linear-gradient(180deg, var(--bg) 0%, var(--haldi-light) 100%); }
  .breadcrumb { font-size: 0.8125rem; color: var(--fg-muted); margin-bottom: 1.5rem; padding-top: 0.5rem; }
  .breadcrumb a { color: var(--primary); }
  .breadcrumb a:hover { text-decoration: underline; }
  .breadcrumb span { color: var(--fg-muted); margin: 0 0.375rem; }

  /* HERO — REVERSED: image RIGHT, text LEFT (opposite of Distemper) */
  .emulsion-hero { display: grid; gap: 2rem; align-items: center; padding-bottom: clamp(2rem, 4vw, 3rem); border-bottom: 1px solid var(--haldi-deep); }
  @media (min-width: 1024px) { .emulsion-hero { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .emulsion-hero__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi-deep); }
  .emulsion-hero__name { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.05; letter-spacing: -0.02em; margin-top: 0.75rem; }
  .emulsion-hero__descriptor { margin-top: 0.5rem; font-size: clamp(1rem, 2vw, 1.25rem); color: var(--geru); font-weight: 600; }
  .emulsion-hero__body { margin-top: 1rem; color: var(--fg-muted); line-height: 1.65; max-width: 36rem; }
  .emulsion-hero__chips { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; }
  .emulsion-hero__chip { padding: 0.3125rem 0.875rem; border-radius: var(--radius-full); background: var(--bg-card); border: 1px solid var(--haldi-deep); font-size: 0.75rem; font-weight: 600; color: var(--haldi-deep); }
  .emulsion-hero__cta-row { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* MEDIA on the RIGHT — reverse grid order */
  .emulsion-hero > :first-child { order: 2; }
  @media (min-width: 1024px) { .emulsion-hero > :first-child { order: 0; } }
  .emulsion-hero__media { position: relative; aspect-ratio: 1; background: var(--bg-card); border: 1px solid var(--haldi-deep); border-top: 4px solid var(--haldi); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-haldi); }
  .emulsion-hero__media .product-media { width: 100%; height: 100%; }
  .emulsion-hero__media .product-media__official { object-fit: contain; padding: 3rem; }
  .emulsion-hero__media .product-media__fallback { padding: 2.5rem; }
  .emulsion-hero__media__num { position: absolute; top: 1rem; right: 1.25rem; font-family: var(--font-display); font-size: 4rem; font-weight: 700; color: var(--haldi-deep); opacity: 0.22; line-height: 1; }
  .emulsion-hero__media__leaf { position: absolute; left: -0.5rem; bottom: -0.5rem; width: 4rem; height: 4rem; opacity: 0.65; pointer-events: none; }

  /* SPEC SHEET — horizontal row cards (different from Distemper's numbered list) */
  .spec-sheet { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 2.5rem; max-width: 48rem; }
  .spec-sheet__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi-deep); }
  .spec-sheet__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .spec-sheet__grid { display: grid; gap: 1rem; }
  @media (min-width: 640px) { .spec-sheet__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .spec-sheet__grid { grid-template-columns: repeat(4, 1fr); } }
  .spec-card { padding: 1.5rem; background: var(--bg-card); border: 1px solid var(--border); border-bottom: 3px solid var(--haldi); border-radius: var(--radius); display: flex; flex-direction: column; gap: 0.375rem; }
  .spec-card__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .spec-card__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .spec-card__value { font-family: var(--font-display); font-size: 1.375rem; font-weight: 700; color: var(--fg); line-height: 1.15; }
  .spec-card__note { font-size: 0.75rem; color: var(--fg-muted); line-height: 1.5; margin-top: 0.25rem; }

  .disclaimer-card { padding: 1.25rem 1.5rem; background: var(--bg-card); border-left: 3px solid var(--haldi-deep); border-radius: var(--radius); font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.65; margin-top: 2rem; }

  /* ASHTA LAABH — radial + side list (different from Distemper's 4-col grid) */
  .emulsion-ashta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--bg-card); }
  .emulsion-ashta__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .emulsion-ashta__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.75rem, 4vw, 2.5rem); color: var(--haldi-deep); }
  .emulsion-ashta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; }
  .emulsion-ashta__grid { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .emulsion-ashta__grid { grid-template-columns: 1fr 1fr; } }
  .emulsion-ashta__diagram { max-width: 28rem; margin-inline: auto; width: 100%; aspect-ratio: 1; }
  .emulsion-ashta__diagram svg { width: 100%; height: 100%; }
  .emulsion-ashta__list { display: grid; gap: 0.625rem; }
  .emulsion-ashta__item { padding: 0.875rem 1.125rem; background: var(--bg); border-left: 3px solid var(--haldi); border-radius: var(--radius); display: grid; grid-template-columns: 2rem 1fr auto; gap: 0.75rem; align-items: center; cursor: pointer; transition: background var(--dur), border-color var(--dur), transform var(--dur); }
  .emulsion-ashta__item:hover, .emulsion-ashta__item:focus-visible, .emulsion-ashta__item[data-active="true"] { background: oklch(0.82 0.14 82 / 0.12); border-left-color: var(--forest); transform: translateX(2px); outline: none; }
  .emulsion-ashta__item:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
  .emulsion-ashta__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .emulsion-ashta__name { font-weight: 600; font-size: 0.9375rem; }
  .emulsion-ashta__deva { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* CTA + CROSS-LINK */
  .emulsion-cta { padding-block: clamp(3rem, 6vw, 5rem); }
  .emulsion-cta__inner { display: grid; gap: 1.5rem; padding: clamp(1.75rem, 4vw, 3rem); background: linear-gradient(135deg, var(--haldi-light), var(--haldi)); border-radius: var(--radius-lg); box-shadow: var(--shadow-haldi); color: var(--charcoal); }
  @media (min-width: 768px) { .emulsion-cta__inner { grid-template-columns: 1.4fr 1fr; gap: 2.5rem; align-items: center; } }
  .emulsion-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); letter-spacing: -0.02em; }
  .emulsion-cta__body { margin-top: 0.75rem; color: oklch(0.30 0.02 50); line-height: 1.65; }
  .emulsion-cta__actions { display: flex; flex-direction: column; gap: 0.75rem; }
  .emulsion-cta__actions .btn--primary { background: var(--forest); color: var(--primary-fg); }
  .emulsion-cta__actions .btn--outline { background: transparent; border-color: var(--forest-deep); color: var(--forest-deep); }
  .emulsion-cta__cross { padding: 1.25rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); }
  .emulsion-cta__cross-title { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .emulsion-cta__cross-name { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; margin-top: 0.375rem; }
  .emulsion-cta__cross-link { margin-top: 0.5rem; display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.8125rem; font-weight: 600; color: var(--primary); }
  .emulsion-cta__cross-link:hover { gap: 0.5rem; }
</style>

<section class="emulsion-detail" id="emulsion-detail">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a><span>›</span>
            <a href="/products/">Products</a><span>›</span>
            Prakritik Emulsion
        </nav>

        <!-- HERO (REVERSED: image right, text left) -->
        <div class="emulsion-hero" data-reveal>
            <div class="emulsion-hero__lockup">
                <span class="emulsion-hero__eyebrow">Prakritik Paint</span>
                <h1 class="emulsion-hero__name"><?= e($product['name']) ?></h1>
                <div class="emulsion-hero__descriptor"><?= e($product['descriptor']) ?></div>
                <p class="emulsion-hero__body">A liquid cow dung-based paint format. White, matt, and suitable for interior and exterior walls — the warmer half of the Prakritik range.</p>
                <div class="emulsion-hero__chips">
                    <span class="emulsion-hero__chip"><?= e($product['packagingShort']) ?></span>
                    <span class="emulsion-hero__chip"><?= e($product['finish']) ?> finish</span>
                    <span class="emulsion-hero__chip"><?= e($product['usage']) ?></span>
                </div>
                <div class="emulsion-hero__cta-row">
                    <a href="/contact/?interest=prakritik-emulsion" class="btn btn--primary btn--lg">Enquire About Emulsion</a>
                    <a href="/paint-calculator/" class="btn btn--outline btn--lg">Estimate Your Project</a>
                </div>
            </div>
            <div class="emulsion-hero__media">
                <span class="emulsion-hero__media__num" aria-hidden="true">02</span>
                <div class="product-media" data-official-image="<?= e($product['officialImage']) ?>">
                    <img class="product-media__official" src="<?= e($product['officialImage']) ?>" alt="<?= e($product['name']) ?>" width="640" height="640">
                    <div class="product-media__fallback"><?php render_illustration('prakritik-emulsion-bucket'); ?></div>
                </div>
                <div class="emulsion-hero__media__leaf" aria-hidden="true"><?php render_illustration('field-botanicals'); ?></div>
            </div>
        </div>
    </div>
</section>

<!-- SPEC SHEET — 4-col row cards (different from Distemper's 2-col list) -->
<section class="spec-sheet section--paper" id="spec-sheet" data-reveal>
    <div class="container">
        <div class="spec-sheet__head">
            <span class="spec-sheet__eyebrow">Specification sheet</span>
            <h2 class="spec-sheet__title">Material specifications.</h2>
        </div>
        <div class="spec-sheet__grid" data-reveal-stagger>
            <div class="spec-card">
                <span class="spec-card__num">01</span>
                <span class="spec-card__label">Packaging</span>
                <span class="spec-card__value"><?= e($product['packagingShort']) ?></span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">02</span>
                <span class="spec-card__label">Colour</span>
                <span class="spec-card__value"><?= e($product['colour']) ?></span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">03</span>
                <span class="spec-card__label">Finish</span>
                <span class="spec-card__value"><?= e($product['finish']) ?></span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">04</span>
                <span class="spec-card__label">Drying time</span>
                <span class="spec-card__value"><?= e($product['dryingTime']) ?></span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">05</span>
                <span class="spec-card__label">Coverage</span>
                <span class="spec-card__value"><?= e($product['coverage']) ?></span>
                <span class="spec-card__note"><?= e($COVERAGE_DISCLAIMER) ?></span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">06</span>
                <span class="spec-card__label">V.O.C.</span>
                <span class="spec-card__value"><?= e($product['voc']) ?></span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">07</span>
                <span class="spec-card__label">Usage</span>
                <span class="spec-card__value"><?= e($product['usage']) ?></span>
            </div>
            <div class="spec-card" style="background: var(--secondary-bg);">
                <span class="spec-card__num">∞</span>
                <span class="spec-card__label">Also see</span>
                <a href="/products/" class="spec-card__value" style="color: var(--primary); font-size: 1.125rem; text-decoration: underline;">Compare both formats</a>
            </div>
        </div>
        <div class="disclaimer-card">
            <strong>Coverage note —</strong> <?= e($COVERAGE_DISCLAIMER) ?>
        </div>
    </div>
</section>

<!-- ASHTA LAABH — radial + list -->
<section class="emulsion-ashta" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="emulsion-ashta__head">
            <div class="emulsion-ashta__deva" lang="hi"><?= e('अष्ट लाभ') ?></div>
            <h2 class="emulsion-ashta__title">Eight benefits presented in Prakritik Paint.</h2>
        </div>
        <div class="emulsion-ashta__grid" data-ashta-laabh>
            <div class="emulsion-ashta__diagram" aria-hidden="true"><?php render_illustration('ashta-laabh-diagram'); ?></div>
            <ol class="emulsion-ashta__list" data-reveal-stagger>
                <?php foreach ($ASHTA_LAABH as $i => $benefit): $bid = 'em-al-' . ($i + 1); ?>
                <li class="emulsion-ashta__item" data-ashta-node="<?= e($bid) ?>">
                    <span class="emulsion-ashta__num"><?= sprintf('%02d', $i + 1) ?></span>
                    <span class="emulsion-ashta__name"><?= e($benefit['name']) ?></span>
                    <span class="emulsion-ashta__deva" lang="hi"><?= e($benefit['hindi']) ?></span>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- CTA + CROSS-LINK -->
<section class="emulsion-cta section--paper" id="enquire" data-reveal>
    <div class="container">
        <div class="emulsion-cta__inner">
            <div>
                <h2 class="emulsion-cta__title">Want to know more about Prakritik Emulsion?</h2>
                <p class="emulsion-cta__body">Send an enquiry about packaging, project sizes, or collaboration. We'll respond with what's currently available.</p>
                <div class="emulsion-cta__actions">
                    <a href="/contact/?interest=prakritik-emulsion" class="btn btn--primary btn--lg btn--block">Enquire About Emulsion</a>
                    <a href="/for-business/" class="btn btn--outline btn--lg btn--block">Discuss a Project</a>
                </div>
            </div>
            <div class="emulsion-cta__cross">
                <span class="emulsion-cta__cross-title">Also in the Prakritik range</span>
                <h3 class="emulsion-cta__cross-name"><?= e($distemper['name']) ?></h3>
                <a href="<?= e($distemper['route']) ?>" class="emulsion-cta__cross-link">Explore Distemper
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
