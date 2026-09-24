<?php
/**
 * Gaurikrit Bio Products — Why Prakritik? (brand story).
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS, $CLAIMS;

$pageTitle       = 'Why Prakritik? — Cow Dung, Lime, and Walls that Breathe | Gaurikrit';
$pageDescription = 'Why we make Prakritik Paint from cow dung and lime. The breathable philosophy, the gaushala sourcing, the limewash heritage — and why it matters for your walls.';
$pageCanonical   = '/why-prakritik/';
$pageClass       = 'why-prakritik';
$pageOgType      = 'website';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

$limewashHeritage = get_claim('clm-limewash-heritage');
$breathable       = get_claim('clm-breathable');
$gaushalaSourced  = get_claim('clm-gaushala-sourced');
?>
<style>
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; padding-top:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }
  .prose { max-width:48rem; margin-inline:auto; }
  .prose p { color:var(--fg-muted); font-size:1.0625rem; line-height:1.75; margin-bottom:1.25rem; }
  .prose p:last-child { margin-bottom:0; }
  .prose h2 { font-size:1.5rem; margin:2.5rem 0 1rem; }
  .prose h2:first-child { margin-top:0; }
  .prose ul { list-style:disc; padding-left:1.5rem; margin-bottom:1.25rem; }
  .prose li { color:var(--fg-muted); margin-bottom:0.5rem; line-height:1.6; }

  .split-grid { display:grid; gap:2rem; grid-template-columns:1fr; align-items:start; }
  @media (min-width: 768px) { .split-grid { grid-template-columns:1fr 1fr; } }

  .why-block { padding:2rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .why-block__eyebrow { font-size:0.75rem; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:var(--primary); }
  .why-block__title { font-size:1.375rem; margin-top:0.5rem; margin-bottom:0.75rem; }
  .why-block__body { color:var(--fg-muted); font-size:0.9375rem; line-height:1.65; }

  .why-art { display:flex; align-items:center; justify-content:center; min-height:14rem; padding:1.5rem; background:var(--secondary-bg); border-radius:var(--radius-lg); border:1px solid var(--border); }

  .claim-pull { padding:1.5rem; border-left:3px solid var(--haldi); background:var(--secondary-bg); border-radius:var(--radius); margin:2rem 0; }
  .claim-pull__text { font-family:var(--font-display); font-style:italic; font-size:1.125rem; line-height:1.55; }
  .claim-pull__ref { margin-top:0.5rem; font-family:monospace; font-size:0.75rem; color:var(--fg-muted); }

  .why-stat-row { display:grid; gap:1rem; grid-template-columns:repeat(2,1fr); margin-top:1.5rem; }
  @media (min-width: 768px) { .why-stat-row { grid-template-columns:repeat(4,1fr); } }
  .why-stat { padding:1rem; background:var(--secondary-bg); border-radius:var(--radius); text-align:center; }
  .why-stat__num { font-family:var(--font-display); font-size:1.5rem; font-weight:700; color:var(--primary); }
  .why-stat__label { font-size:0.75rem; color:var(--fg-muted); margin-top:0.25rem; }
</style>

<section class="page-hero section section--paper section--grain" style="padding-top:calc(var(--header-h) + 2rem)">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <span>Why Prakritik</span>
        </nav>
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Why Prakritik</span>
            <h1 class="section-heading__title">Walls that breathe, paint that remembers.</h1>
            <p class="section-heading__desc">Cow dung, lime, and pigment — each doing what it has always done, on Indian walls.</p>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <article class="prose" data-reveal>
            <h2>The gaushala beginning</h2>
            <p><?= e($COMPANY['story']['lead']) ?></p>
            <p><?= e($COMPANY['story']['body']) ?></p>

            <div class="claim-pull" data-reveal>
                <blockquote class="claim-pull__text">"<?= e($COMPANY['story']['founderQuote']) ?>"</blockquote>
                <div class="claim-pull__ref">— <?= e($COMPANY['story']['founderName']) ?>, <?= e($COMPANY['story']['founderRole']) ?></div>
            </div>

            <h2>Why cow dung, why lime</h2>
            <p>For centuries, Indian homes finished their walls with cow dung and lime — materials that were abundant, breathable, and gentle on the people who lived with them. Modern paints replaced these with synthetic binders and solvent-heavy driers. The walls stopped breathing. Moisture got trapped. Paint started blistering.</p>
            <p>We set out to do the opposite. To go back to cow dung and lime — but to do it consistently, in small batches, with the discipline of a paint factory and the patience of a craft workshop. The result is Prakritik Paint: a paint that does not trap moisture, does not carry lead or solvent-heavy VOC binders, and wears the soft matte face of an Indian limewash wall.</p>

            <ul>
                <li><strong>Cow dung</strong> — refined into a fine natural binder. Sourced from partner gaushalas with documented material logs.</li>
                <li><strong>Lime</strong> — the breathability engine. Lets water vapour pass through the wall, reducing trapped moisture and blistering.</li>
                <li><strong>Plant &amp; mineral pigments</strong> — colour without heavy metals, without lead, without VOC-heavy solvents.</li>
            </ul>

            <?php if ($limewashHeritage): ?>
            <div class="claim-pull" data-reveal>
                <blockquote class="claim-pull__text"><?= e($limewashHeritage['claim']) ?></blockquote>
                <div class="claim-pull__ref"><?= e($limewashHeritage['reference']) ?> · <?= e($limewashHeritage['source']) ?> · verified <?= e(date('j M Y', strtotime($limewashHeritage['verifiedOn']))) ?></div>
            </div>
            <?php endif; ?>
        </article>
    </div>
</section>

<section class="section section--paper section--grain">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">From Gaushala to Wall</span>
            <h2 class="section-heading__title">Material journey.</h2>
            <p class="section-heading__desc">Four honest stages. No mystery, no marketing — only the path the material takes.</p>
        </div>
        <div class="why-art" data-reveal style="min-height:8rem; aspect-ratio:5/1; max-width:48rem; margin-inline:auto">
            <?php render_illustration('material-journey'); ?>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div class="split-grid" data-reveal>
            <div class="why-art" style="aspect-ratio:2/1">
                <?php render_illustration('gaushala-scene'); ?>
            </div>
            <div class="why-block">
                <span class="why-block__eyebrow">Gaushala Sourced</span>
                <h2 class="why-block__title">Material with a purpose.</h2>
                <p class="why-block__body">Cow dung is collected from partner gaushalas — places where the cow is cared for and the dung is abundant. Every batch is reconciled and logged. The material leaves a gaushala, arrives at our workshop, and becomes paint. No middlemen, no anonymous sourcing.</p>
                <?php if ($gaushalaSourced): ?>
                <p class="claim-pull__ref" style="margin-top:1rem"><?= e($gaushalaSourced['reference']) ?> · <?= e($gaushalaSourced['source']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="section section--forest" id="breathable-promise">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">The Breathable Promise</span>
            <h2 class="section-heading__title">Walls that breathe.</h2>
            <p class="section-heading__desc">Trapped moisture is what makes paint blister. Breathability is what makes paint last.</p>
        </div>
        <div class="why-stat-row" data-reveal-stagger>
            <?php foreach ($COMPANY['stats'] as $stat): ?>
                <div class="why-stat" style="background:oklch(1 0 0 / 0.04); border:1px solid oklch(1 0 0 / 0.1)">
                    <div class="why-stat__num" style="color:var(--haldi)" data-count-up="<?= e((string)(int)$stat['numericValue']) ?>" data-suffix="<?= e($stat['suffix']) ?>"><?= e($stat['value']) ?></div>
                    <div class="why-stat__label" style="color:oklch(0.85 0.01 75)"><?= e($stat['label']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($breathable): ?>
        <div class="claim-pull" data-reveal style="background:oklch(1 0 0 / 0.04); border-color:var(--haldi); margin-top:2.5rem; max-width:48rem; margin-inline:auto">
            <blockquote class="claim-pull__text" style="color:var(--primary-fg)"><?= e($breathable['claim']) ?></blockquote>
            <div class="claim-pull__ref" style="color:oklch(0.75 0.01 75)"><?= e($breathable['reference']) ?> · <?= e($breathable['source']) ?> · verified <?= e(date('j M Y', strtotime($breathable['verifiedOn']))) ?></div>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div style="text-align:center" data-reveal>
            <a href="/products/" class="btn btn--primary btn--lg">Explore Prakritik Paint</a>
            <a href="/about/" class="btn btn--outline btn--lg" style="margin-left:0.5rem">About Gaurikrit</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
