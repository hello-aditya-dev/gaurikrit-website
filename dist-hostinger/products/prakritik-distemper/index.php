<?php
/**
 * Gaurikrit Bio Products — Prakritik Distemper detail.
 * Task PAGES-LOCK. Cooler, quieter material sheet. Indigo secondary accent.
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Distemper Paint — Gaurikrit Bio Products';
$pageDescription = 'Prakritik Distemper Paint — eco-friendly cow dung paint. White, matt finish, 4 hrs drying time, 200 sq.ft. coverage, interior and exterior use. 1, 5, 10 and 20 kg packaging.';
$pageCanonical   = '/products/prakritik-distemper/';
$pageClass       = 'product-distemper';

require_once __DIR__ . '/../../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $COVERAGE_DISCLAIMER;

$product = get_product('prakritik-distemper');
$emulsion = get_product('prakritik-emulsion');
?>
<style>
  .distemper-detail { padding-top: calc(var(--header-h) + 2rem); }
  .breadcrumb { font-size: 0.8125rem; color: var(--fg-muted); margin-bottom: 1.5rem; padding-top: 0.5rem; }
  .breadcrumb a { color: var(--primary); }
  .breadcrumb a:hover { text-decoration: underline; }
  .breadcrumb span { color: var(--fg-muted); margin: 0 0.375rem; }

  .distemper-hero { display: grid; gap: 2rem; align-items: center; padding-bottom: clamp(2rem, 4vw, 3rem); border-bottom: 1px solid var(--border); }
  @media (min-width: 1024px) { .distemper-hero { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .distemper-hero__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .distemper-hero__name { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.05; letter-spacing: -0.02em; margin-top: 0.75rem; }
  .distemper-hero__descriptor { margin-top: 0.5rem; font-size: clamp(1rem, 2vw, 1.25rem); color: var(--indigo); font-weight: 600; }
  .distemper-hero__body { margin-top: 1rem; color: var(--fg-muted); line-height: 1.65; max-width: 36rem; }
  .distemper-hero__chips { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; }
  .distemper-hero__chip { padding: 0.3125rem 0.875rem; border-radius: var(--radius-full); background: var(--bg-card); border: 1px solid var(--border); font-size: 0.75rem; font-weight: 600; color: var(--indigo); }
  .distemper-hero__cta-row { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  .distemper-media { position: relative; aspect-ratio: 1; background: linear-gradient(160deg, var(--bg-card), var(--secondary-bg)); border: 1px solid var(--border); border-top: 4px solid var(--indigo); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); }
  .distemper-media .product-media { width: 100%; height: 100%; }
  .distemper-media .product-media__official { object-fit: contain; padding: 3rem; }
  .distemper-media .product-media__fallback { padding: 2.5rem; }
  .distemper-media__num { position: absolute; top: 1rem; right: 1.25rem; font-family: var(--font-display); font-size: 4rem; font-weight: 700; color: var(--indigo); opacity: 0.18; line-height: 1; }

  /* SPEC SHEET */
  .spec-sheet { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 2.5rem; }
  .spec-sheet__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--indigo); }
  .spec-sheet__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .spec-sheet__list { display: grid; gap: 0; border-top: 1px solid var(--border); }
  @media (min-width: 640px) { .spec-sheet__list { grid-template-columns: repeat(2, 1fr); } }
  .spec-sheet__row { padding: 1.25rem 0; border-bottom: 1px solid var(--border); display: grid; grid-template-columns: 2.5rem 1fr; gap: 1rem; align-items: start; }
  @media (min-width: 640px) { .spec-sheet__row { padding: 1.25rem 1.5rem; } .spec-sheet__row:nth-child(odd) { border-right: 1px solid var(--border); } }
  .spec-sheet__num { font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: var(--haldi-deep); }
  .spec-sheet__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .spec-sheet__value { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; margin-top: 0.25rem; color: var(--fg); }
  .spec-sheet__value small { font-family: var(--font-sans); font-size: 0.75rem; font-weight: 500; color: var(--fg-muted); display: block; margin-top: 0.25rem; }

  .disclaimer-card { padding: 1.25rem 1.5rem; background: var(--bg-card); border-left: 3px solid var(--indigo); border-radius: var(--radius); font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.65; margin-top: 2rem; }

  /* ASHTA LAABH */
  .distemper-ashta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .distemper-ashta__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .distemper-ashta__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.75rem, 4vw, 2.5rem); color: var(--indigo); }
  .distemper-ashta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; }
  .distemper-ashta__grid { display: grid; gap: 0.75rem; }
  @media (min-width: 640px) { .distemper-ashta__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .distemper-ashta__grid { grid-template-columns: repeat(4, 1fr); } }
  .distemper-ashta__item { padding: 1rem 1.25rem; background: var(--bg-card); border-left: 2px solid var(--indigo); border-radius: var(--radius); display: flex; flex-direction: column; gap: 0.25rem; }
  .distemper-ashta__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .distemper-ashta__name { font-weight: 600; font-size: 0.9375rem; }
  .distemper-ashta__deva { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* CTA + CROSS-LINK */
  .distemper-cta { padding-block: clamp(3rem, 6vw, 5rem); }
  .distemper-cta__inner { display: grid; gap: 1.5rem; padding: clamp(1.75rem, 4vw, 3rem); background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  @media (min-width: 768px) { .distemper-cta__inner { grid-template-columns: 1.4fr 1fr; gap: 2.5rem; align-items: center; } }
  .distemper-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); letter-spacing: -0.02em; }
  .distemper-cta__body { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .distemper-cta__actions { display: flex; flex-direction: column; gap: 0.75rem; }
  .distemper-cta__cross { padding: 1.25rem; border: 1px dashed var(--border); border-radius: var(--radius); }
  .distemper-cta__cross-title { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .distemper-cta__cross-name { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; margin-top: 0.375rem; }
  .distemper-cta__cross-link { margin-top: 0.5rem; display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.8125rem; font-weight: 600; color: var(--primary); }
  .distemper-cta__cross-link:hover { gap: 0.5rem; }
</style>

<section class="distemper-detail" id="distemper-detail">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a><span>›</span>
            <a href="/products/">Products</a><span>›</span>
            Prakritik Distemper
        </nav>

        <!-- HERO -->
        <div class="distemper-hero" data-reveal>
            <div class="distemper-hero__lockup">
                <span class="distemper-hero__eyebrow">Prakritik Paint</span>
                <h1 class="distemper-hero__name"><?= e($product['name']) ?></h1>
                <div class="distemper-hero__descriptor"><?= e($product['descriptor']) ?></div>
                <p class="distemper-hero__body">A powdered cow dung-based paint format. White, matt, and suitable for interior and exterior walls — a quieter material sheet in the Prakritik range.</p>
                <div class="distemper-hero__chips">
                    <span class="distemper-hero__chip"><?= e($product['packagingShort']) ?></span>
                    <span class="distemper-hero__chip"><?= e($product['finish']) ?> finish</span>
                    <span class="distemper-hero__chip"><?= e($product['usage']) ?></span>
                </div>
                <div class="distemper-hero__cta-row">
                    <a href="/contact/?interest=prakritik-distemper" class="btn btn--primary btn--lg">Enquire About Distemper</a>
                    <a href="/paint-calculator/" class="btn btn--outline btn--lg">Estimate Your Project</a>
                </div>
            </div>
            <div class="distemper-media">
                <span class="distemper-media__num" aria-hidden="true">01</span>
                <div class="product-media" data-official-image="<?= e($product['officialImage']) ?>">
                    <img class="product-media__official" src="<?= e($product['officialImage']) ?>" alt="<?= e($product['name']) ?>" width="640" height="640">
                    <div class="product-media__fallback"><?php render_illustration('prakritik-distemper-bucket'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SPEC SHEET (numbered 01-07) -->
<section class="spec-sheet section--paper" id="spec-sheet" data-reveal>
    <div class="container">
        <div class="spec-sheet__head">
            <span class="spec-sheet__eyebrow">Specification sheet</span>
            <h2 class="spec-sheet__title">Material specifications.</h2>
        </div>
        <ol class="spec-sheet__list" data-reveal-stagger>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">01</span>
                <div>
                    <div class="spec-sheet__label">Packaging</div>
                    <div class="spec-sheet__value"><?= e($product['packagingShort']) ?></div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">02</span>
                <div>
                    <div class="spec-sheet__label">Colour</div>
                    <div class="spec-sheet__value"><?= e($product['colour']) ?></div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">03</span>
                <div>
                    <div class="spec-sheet__label">Finish</div>
                    <div class="spec-sheet__value"><?= e($product['finish']) ?></div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">04</span>
                <div>
                    <div class="spec-sheet__label">Drying time</div>
                    <div class="spec-sheet__value"><?= e($product['dryingTime']) ?></div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">05</span>
                <div>
                    <div class="spec-sheet__label">Coverage</div>
                    <div class="spec-sheet__value"><?= e($product['coverage']) ?>
                        <small><?= e($COVERAGE_DISCLAIMER) ?></small>
                    </div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">06</span>
                <div>
                    <div class="spec-sheet__label">V.O.C.</div>
                    <div class="spec-sheet__value"><?= e($product['voc']) ?></div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">07</span>
                <div>
                    <div class="spec-sheet__label">Usage</div>
                    <div class="spec-sheet__value"><?= e($product['usage']) ?></div>
                </div>
            </li>
        </ol>
        <div class="disclaimer-card">
            <strong>Coverage note —</strong> <?= e($COVERAGE_DISCLAIMER) ?>
        </div>
    </div>
</section>

<!-- ASHTA LAABH -->
<section class="distemper-ashta" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="distemper-ashta__head">
            <div class="distemper-ashta__deva" lang="hi"><?= e('अष्ट लाभ') ?></div>
            <h2 class="distemper-ashta__title">Eight benefits presented in Prakritik Paint.</h2>
        </div>
        <ol class="distemper-ashta__grid" data-reveal-stagger>
            <?php foreach ($ASHTA_LAABH as $i => $benefit): ?>
            <li class="distemper-ashta__item">
                <span class="distemper-ashta__num"><?= sprintf('%02d', $i + 1) ?></span>
                <span class="distemper-ashta__name"><?= e($benefit['name']) ?></span>
                <span class="distemper-ashta__deva" lang="hi"><?= e($benefit['hindi']) ?></span>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<!-- CTA + CROSS-LINK -->
<section class="distemper-cta section--paper" id="enquire" data-reveal>
    <div class="container">
        <div class="distemper-cta__inner">
            <div>
                <h2 class="distemper-cta__title">Want to know more about Prakritik Distemper?</h2>
                <p class="distemper-cta__body">Send an enquiry about packaging, project sizes, or collaboration. We'll respond with what's currently available.</p>
                <div class="distemper-cta__actions">
                    <a href="/contact/?interest=prakritik-distemper" class="btn btn--primary btn--lg btn--block">Enquire About Distemper</a>
                    <a href="/for-business/" class="btn btn--outline btn--lg btn--block">Discuss a Project</a>
                </div>
            </div>
            <div class="distemper-cta__cross">
                <span class="distemper-cta__cross-title">Also in the Prakritik range</span>
                <h3 class="distemper-cta__cross-name"><?= e($emulsion['name']) ?></h3>
                <a href="<?= e($emulsion['route']) ?>" class="distemper-cta__cross-link">Explore Emulsion
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
