<?php
/**
 * Gaurikrit Bio Products — About page.
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

$pageTitle       = 'About Gaurikrit Bio Products — Bio Paint from Bharat';
$pageDescription = 'Gaurikrit Bio Products — cow dung-based Prakritik Paint, made in Bharat since ' . ($COMPANY['foundedYear'] ?? 2019) . '. Gaushala-sourced, naturally breathable, heritage limewash recipe.';
$pageCanonical   = '/about/';
$pageClass       = 'about';
$pageOgType      = 'website';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';
?>
<style>
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; padding-top:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }

  .split-grid { display:grid; gap:2rem; grid-template-columns:1fr; align-items:start; }
  @media (min-width: 768px) { .split-grid { grid-template-columns:1fr 1fr; } }

  .prose p { color:var(--fg-muted); font-size:1.0625rem; line-height:1.75; margin-bottom:1.25rem; }
  .prose p:last-child { margin-bottom:0; }

  .about-quote { padding:1.75rem; border-left:3px solid var(--haldi); background:var(--bg-card); border-radius:var(--radius); box-shadow:var(--shadow-soft); margin-top:2rem; }
  .about-quote blockquote { font-family:var(--font-display); font-style:italic; font-size:clamp(1.125rem,2.2vw,1.375rem); line-height:1.5; }
  .about-quote figcaption { margin-top:0.75rem; font-size:0.875rem; color:var(--fg-muted); }

  .about-courtyard-art { padding:1.5rem; background:var(--secondary-bg); border:1px solid var(--border); border-radius:var(--radius-lg); aspect-ratio:4/3; display:flex; align-items:center; justify-content:center; }

  .timeline { display:grid; gap:1rem; max-width:48rem; margin-inline:auto; }
  .timeline-item { display:grid; grid-template-columns:auto 1fr; gap:1.25rem; align-items:start; padding:1rem 0; border-bottom:1px dashed var(--border); }
  .timeline-item:last-child { border-bottom:none; }
  .timeline-item__year { font-family:var(--font-display); font-size:1.5rem; font-weight:700; color:var(--primary); min-width:5rem; }
  .timeline-item__title { font-weight:700; margin-bottom:0.25rem; }
  .timeline-item__desc { color:var(--fg-muted); font-size:0.9375rem; line-height:1.55; }
</style>

<section class="page-hero section section--paper section--grain" style="padding-top:calc(var(--header-h) + 2rem)">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <span>About</span>
        </nav>
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">About Us</span>
            <h1 class="section-heading__title">From a gaushala to your wall.</h1>
            <p class="section-heading__desc"><?= e($COMPANY['story']['lead']) ?></p>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div class="split-grid" data-reveal>
            <div>
                <article class="prose">
                    <?php foreach (explode("\n\n", $COMPANY['story']['body']) as $para): ?>
                        <p><?= e($para) ?></p>
                    <?php endforeach; ?>
                </article>
                <figure class="about-quote" data-reveal>
                    <blockquote><?= e($COMPANY['story']['founderQuote']) ?></blockquote>
                    <figcaption>— <?= e($COMPANY['story']['founderName']) ?>, <?= e($COMPANY['story']['founderRole']) ?></figcaption>
                </figure>
            </div>
            <div class="about-courtyard-art" data-reveal>
                <?php render_illustration('indian-courtyard'); ?>
            </div>
        </div>
    </div>
</section>

<section class="section section--paper section--grain">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Three Anchors</span>
            <h2 class="section-heading__title">What we stand on.</h2>
        </div>
        <div class="features-grid" data-reveal-stagger>
            <?php foreach ($COMPANY['aboutCards'] as $card): ?>
                <article class="feature-card">
                    <h3 class="feature-card__title"><?= e($card['title']) ?></h3>
                    <p class="feature-card__desc"><?= e($card['desc']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--forest">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">In Numbers</span>
            <h2 class="section-heading__title">Quiet facts.</h2>
            <p class="section-heading__desc">No marketing inflation. Just numbers we can defend with a test or a log.</p>
        </div>
        <div class="why-stat-row" style="display:grid; gap:1rem; grid-template-columns:repeat(2,1fr)" data-reveal-stagger>
            <?php foreach ($COMPANY['stats'] as $stat): ?>
                <div class="why-stat" style="background:oklch(1 0 0 / 0.04); border:1px solid oklch(1 0 0 / 0.1)">
                    <div class="why-stat__num" style="color:var(--haldi)" data-count-up="<?= e((string)(int)$stat['numericValue']) ?>" data-suffix="<?= e($stat['suffix']) ?>"><?= e($stat['value']) ?></div>
                    <div class="why-stat__label" style="color:oklch(0.85 0.01 75)"><?= e($stat['label']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">The Path</span>
            <h2 class="section-heading__title">From <?= e((string)$COMPANY['foundedYear']) ?> to today.</h2>
        </div>
        <ol class="timeline" data-reveal>
            <li class="timeline-item">
                <div class="timeline-item__year"><?= e((string)$COMPANY['foundedYear']) ?></div>
                <div>
                    <div class="timeline-item__title">The first gaushala conversation</div>
                    <div class="timeline-item__desc">Gaurikrit begins as an attempt to turn unused cow dung into something useful, with the patience of a craft workshop and the discipline of a paint factory.</div>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-item__year">2020</div>
                <div>
                    <div class="timeline-item__title">First Prakritik Distemper batch</div>
                    <div class="timeline-item__desc">A cow dung-based natural distemper, finished with lime and plant pigments. Soft, matte, breathable — an interior paint that breathes with the wall.</div>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-item__year">2022</div>
                <div>
                    <div class="timeline-item__title">Prakritik Emulsion</div>
                    <div class="timeline-item__desc">A finer, more washable emulsion joins the line — same breathable soul, improved scrub resistance, suitable for both interior and sheltered exterior walls.</div>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-item__year">Today</div>
                <div>
                    <div class="timeline-item__title">Pan-India, gaushala by gaushala</div>
                    <div class="timeline-item__desc">Partner gaushalas, documented batches, and shipping across the country — to families, contractors, architects, and project owners.</div>
                </div>
            </li>
        </ol>
    </div>
</section>

<section class="section section--paper section--grain">
    <div class="container">
        <div style="text-align:center" data-reveal>
            <a href="/products/" class="btn btn--primary btn--lg">Explore the products</a>
            <a href="/why-prakritik/" class="btn btn--outline btn--lg" style="margin-left:0.5rem">Why Prakritik?</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
