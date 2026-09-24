<?php
/**
 * Gaurikrit Bio Products — Homepage.
 * Full single-page experience: hero, marquee, trust bar, about, why-prakritik,
 * products, features, process, coverage calculator, claims register,
 * testimonials, FAQ, contact.
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS, $CLAIMS, $NAV, $config;

$pageTitle       = 'Gaurikrit Bio Products — Prakritik Paint. Walls that breathe sustainability.';
$pageDescription = 'Cow dung-based Prakritik Paint in distemper and emulsion formats. Naturally breathable, zero lead, low-VOC, gaushala-sourced. Made in Bharat.';
$pageCanonical   = '/';
$pageClass       = 'home';
$pageOgType      = 'website';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

// Page-local data.
$features = [
    ['title' => 'Naturally Crafted', 'desc' => 'Cow dung binder, lime, plant pigments. No solvents, no shortcuts — only what walls have asked for, for centuries.'],
    ['title' => 'Lab-Tested Purity', 'desc' => 'Every batch screened for lead, heavy metals, and VOC solvents. Numbers on paper, not just words on a label.'],
    ['title' => '100% Coverage', 'desc' => 'Distemper ~130 sq ft/kg/coat. Emulsion ~150 sq ft/L/coat. Tested on standard substrate, batch after batch.'],
    ['title' => 'Low-VOC', 'desc' => 'No solvent-heavy binders. The smell of fresh paint becomes the smell of limewash and earth.'],
    ['title' => 'Heritage Recipe', 'desc' => 'The Indian limewash tradition — lime, pigment, water — updated with a refined cow-dung binder. Grandmother-tested.'],
    ['title' => 'Pan-India Delivery', 'desc' => 'Packed in small batches and shipped across the country. Bulk enquiries welcome for gaushalas, contractors, and projects.'],
];

$processSteps = [
    ['num' => '01', 'title' => 'Source',    'desc' => 'Cow dung collected from partner gaushalas with documented material logs.'],
    ['num' => '02', 'title' => 'Craft',     'desc' => 'Cleaned, sun-dried, refined into a fine binder. Blended with lime and pigments in small batches.'],
    ['num' => '03', 'title' => 'Test',      'desc' => 'Lead, heavy-metal, VOC, breathability, and coverage tested. Reference number on every claim.'],
    ['num' => '04', 'title' => 'Deliver',   'desc' => 'Packed and dispatched pan-India. Bulk and project enquiries welcome.'],
];

$testimonials = [
    ['quote' => 'The walls breathe. After two monsoons, no blistering, no flaking — exactly what they promised.', 'name' => 'Anita Rao', 'role' => 'Homeowner, Bengaluru'],
    ['quote' => 'I used Prakritik Emulsion on a sheltered exterior wall. The finish is soft, the colour is honest.', 'name' => 'Mahesh K.', 'role' => 'Contractor, Pune'],
    ['quote' => 'Knowing the cow dung comes from a documented gaushala makes the purchase feel purposeful.', 'name' => 'Sunita Devi', 'role' => 'Architect, Jaipur'],
];

$faqs = [
    ['q' => 'Is the paint really made from cow dung?', 'a' => 'Yes. Refined cow dung is the primary natural binder in both Prakritik Distemper and Prakritik Emulsion. It is cleaned, sun-dried, and refined into a fine binder before being blended with lime and pigments.'],
    ['q' => 'Does it smell like cow dung after painting?', 'a' => 'No. Once dried, the paint has the soft, earthy smell of limewash — not raw dung. The refining process removes the odour-bearing compounds.'],
    ['q' => 'Is Prakritik Paint safe for interiors and children\'s rooms?', 'a' => 'Yes. It contains no lead and no solvent-heavy VOC binders. The pigment comes from plant and mineral sources. Always allow fresh coats to dry fully before reoccupying a room.'],
    ['q' => 'Can I use it on exterior walls?', 'a' => 'Prakritik Emulsion is suitable for sheltered exterior walls. Prakritik Distemper is recommended for interiors only. For exposed exteriors, please consult us for a project-specific recommendation.'],
    ['q' => 'What coverage should I expect?', 'a' => 'Distemper covers approximately 130 sq ft per kg per coat. Emulsion covers approximately 150 sq ft per litre per coat. Both are typically applied in two coats over a limewash primer. Use the coverage calculator on this page for an estimate.'],
    ['q' => 'How is the cow dung sourced?', 'a' => 'From partner gaushalas with documented material logs. The sourcing is reconciled and recorded — every batch is traceable to a gaushala partner.'],
    ['q' => 'Do you offer bulk pricing for projects?', 'a' => 'Yes. We supply gaushalas, contractors, architects, and project owners. Please use the For Business page to submit a bulk enquiry with your project type and approximate requirement.'],
    ['q' => 'Where do you ship?', 'a' => 'Pan-India. Smaller packs ship via courier; bulk orders ship via transport. Please allow additional time for remote pin codes.'],
];

$paintSpecs = [
    'prakritik-distemper' => ['name' => 'Prakritik Distemper', 'unit' => 'kg', 'coverage' => 130, 'pricePerUnit' => 180, 'packs' => [5, 10, 20]],
    'prakritik-emulsion'  => ['name' => 'Prakritik Emulsion',  'unit' => 'L',  'coverage' => 150, 'pricePerUnit' => 320, 'packs' => [1, 4, 10, 20]],
    'primer'              => ['name' => 'Prakritik Limewash Primer', 'unit' => 'kg', 'coverage' => 100, 'pricePerUnit' => 120, 'packs' => [5, 10, 20]],
];

$claimCategories = [
    'all'         => 'All categories',
    'material'    => 'Material',
    'performance' => 'Performance',
    'safety'      => 'Safety',
];
?>
<!-- ===== Page-local supplementary styles (no build step) ===== -->
<style>
  /* Two-column grids not in app.css */
  .split-grid { display:grid; gap:2rem; grid-template-columns:1fr; }
  @media (min-width: 768px) { .split-grid { grid-template-columns:1fr 1fr; align-items:start; } }

  /* About story body */
  .about-body p { color: var(--fg-muted); line-height:1.7; margin-bottom:1rem; font-size:1.0625rem; }
  .about-body p:last-child { margin-bottom:0; }
  .about-quote { margin-top:2rem; padding:1.5rem; border-left:3px solid var(--haldi); background:var(--bg-card); border-radius:var(--radius); box-shadow:var(--shadow-soft); }
  .about-quote blockquote { font-family:var(--font-display); font-style:italic; font-size:clamp(1.125rem,2.2vw,1.375rem); line-height:1.5; color:var(--fg); }
  .about-quote figcaption { margin-top:0.75rem; font-size:0.8125rem; color:var(--fg-muted); }

  /* Why-prakritik split cards */
  .why-split { display:grid; gap:1.5rem; grid-template-columns:1fr; max-width:64rem; margin-inline:auto; }
  @media (min-width: 768px) { .why-split { grid-template-columns:1fr 0.6fr 1fr; align-items:stretch; } }
  .why-card { padding:1.75rem; border-radius:var(--radius-lg); background: oklch(1 0 0 / 0.04); border:1px solid oklch(1 0 0 / 0.1); backdrop-filter: blur(8px); }
  .why-card__eyebrow { font-size:0.75rem; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:var(--haldi); }
  .why-card__title { font-size:1.375rem; margin-top:0.5rem; }
  .why-card__desc { margin-top:0.75rem; font-size:0.9375rem; color:oklch(0.85 0.01 75); line-height:1.6; }
  .why-bridge { display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:1.5rem; }
  .why-bridge__text { font-family:var(--font-display); font-style:italic; font-size:1.0625rem; color:var(--haldi); }

  /* Testimonials */
  .testimonials-grid { display:grid; gap:1.5rem; }
  @media (min-width: 768px) { .testimonials-grid { grid-template-columns:repeat(3,1fr); } }
  .testimonial { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); display:flex; flex-direction:column; gap:1rem; }
  .testimonial__quote { font-family:var(--font-display); font-size:1.0625rem; line-height:1.6; }
  .testimonial__quote::before { content:'"'; color:var(--haldi); font-size:1.5em; line-height:0.1; vertical-align:-0.25em; margin-right:0.125em; }
  .testimonial__cite { font-size:0.875rem; }
  .testimonial__name { font-weight:700; }
  .testimonial__role { color:var(--fg-muted); font-size:0.8125rem; }

  /* Calculator */
  .calculator { display:grid; gap:2rem; }
  @media (min-width: 768px) { .calculator { grid-template-columns:1fr 1fr; align-items:start; } }
  .calculator-form { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .calculator-result { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--secondary-bg); min-height: 12rem; }
  .calculator-result[hidden] { display:none; }
  .calculator-result__title { font-size:1rem; font-weight:700; margin-bottom:0.75rem; }
  .calculator-result__row { display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px dashed var(--border); font-size:0.9375rem; }
  .calculator-result__row:last-child { border-bottom:none; }
  .calculator-result__total { font-weight:700; color:var(--primary); }
  .calculator-empty { color:var(--fg-muted); font-size:0.9375rem; }

  /* Contact grid + newsletter cards */
  .contact-info { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .contact-info__item { display:flex; gap:0.75rem; margin-bottom:1rem; font-size:0.9375rem; }
  .contact-info__item:last-child { margin-bottom:0; }
  .contact-info__label { font-weight:700; min-width:5rem; color:var(--fg-muted); font-size:0.8125rem; text-transform:uppercase; letter-spacing:0.1em; }
  .newsletter-card { padding:1.75rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); box-shadow:var(--shadow-soft); }
  .newsletter-card h3 { font-size:1.25rem; margin-bottom:0.5rem; }
  .newsletter-card p { color:var(--fg-muted); font-size:0.875rem; margin-bottom:1rem; }

  /* Cert badge cursor */
  .trust-bar__cert { cursor:pointer; }

  /* Section eyebrow chip variant for hero lockup */
  .hero__eyebrow { display:inline-flex; align-items:center; gap:0.5rem; padding:0.3125rem 0.75rem; border:1px solid var(--border); border-radius:var(--radius-full); font-size:0.6875rem; font-weight:700; letter-spacing:0.2em; text-transform:uppercase; color:var(--primary); background:var(--bg-card); width:fit-content; margin-bottom:1rem; }
  .hero__eyebrow-dot { width:0.375rem; height:0.375rem; border-radius:50%; background:var(--haldi); }

  /* Calculator + claims + faq + contact card headings on this page sit above body */
  .calculator-wrap .section-heading { text-align:left; margin-inline:0; max-width:none; }

  /* CTA links for product cards with arrow */
  .product-card__link svg { width:0.875rem; height:0.875rem; }
</style>
<?php /* JSON paint-specs payload for the coverage calculator JS */ ?>
<script id="paint-specs" type="application/json"><?= json_encode($paintSpecs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<!-- ===== HERO ===== -->
<section class="hero" id="home">
    <div class="container hero__container">
        <div class="hero__lockup">
            <span class="hero__eyebrow"><span class="hero__eyebrow-dot" aria-hidden="true"></span><?= e($COMPANY['hero']['eyebrow']) ?></span>
            <span class="hero__devanagari"><?= e($COMPANY['devanagari']) ?></span>
            <span class="hero__brand-sub"><?= e($COMPANY['fullName']) ?></span>
            <h1 class="hero__title"><?php foreach ($COMPANY['hero']['headlineLines'] as $i => $line): ?><?= $i > 0 ? '<br>' : '' ?><?= e($line) ?><?php endforeach; ?></h1>
            <p class="hero__sub"><?= e($COMPANY['hero']['subheadline']) ?></p>
            <div class="hero__ctas">
                <a href="<?= e($COMPANY['hero']['primaryCta']['href']) ?>" class="btn btn--primary btn--lg">
                    <?= e($COMPANY['hero']['primaryCta']['label']) ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="<?= e($COMPANY['hero']['secondaryCta']['href']) ?>" class="btn btn--outline btn--lg"><?= e($COMPANY['hero']['secondaryCta']['label']) ?></a>
            </div>
        </div>
        <div class="hero__art" aria-hidden="true">
            <div class="hero__stroke"><?php render_illustration('paint-brush-stroke', ['class' => 'hero__stroke-inner']); ?></div>
            <div class="hero__bucket"><?php render_illustration('prakritik-emulsion-bucket'); ?></div>
            <div class="hero__cow"><?php render_illustration('indian-cow'); ?></div>
        </div>
    </div>
    <div class="container">
        <div class="hero__landscape" aria-hidden="true"><?php render_illustration('rural-landscape'); ?></div>
    </div>
    <a href="#about" class="hero__scroll" aria-label="Scroll to about">
        <span class="hero__scroll-text">Scroll</span>
        <svg class="hero__scroll-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
    </a>
</section>

<!-- ===== MARQUEE ===== -->
<div class="marquee" role="marquee" aria-label="Brand phrases">
    <div class="marquee__track" data-marquee-track>
        <?php foreach ($COMPANY['marquee'] as $phrase): ?>
            <span class="marquee__item"><span class="marquee__item-text"><?= e($phrase) ?></span><span class="marquee__dot" aria-hidden="true">·</span></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== TRUST BAR ===== -->
<section class="trust-bar" id="trust" aria-label="Trust bar">
    <div class="container">
        <div class="trust-bar__stats" data-reveal-stagger>
            <?php foreach ($COMPANY['stats'] as $stat): ?>
                <div class="trust-bar__stat">
                    <div class="trust-bar__stat-value" data-count-up="<?= e((string)(int)$stat['numericValue']) ?>" data-suffix="<?= e($stat['suffix']) ?>"><?= e($stat['value']) ?></div>
                    <div class="trust-bar__stat-label"><?= e($stat['label']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="trust-bar__certs">
            <span class="trust-bar__certs-label">Certifications</span>
            <?php foreach ($COMPANY['certifications'] as $cert): ?>
                <button type="button" class="trust-bar__cert" data-cert-name="<?= e($cert['name']) ?>" data-cert-desc="<?= e($cert['desc']) ?>" aria-label="<?= e($cert['name']) ?> — <?= e($cert['desc']) ?>">
                    <span class="trust-bar__cert-name"><?= e($cert['name']) ?></span>
                    <span class="trust-bar__cert-desc"><?= e($cert['desc']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="section section--paper" id="about">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Our Story</span>
            <h2 class="section-heading__title">Walls that breathe, paint that remembers.</h2>
            <p class="section-heading__desc"><?= e($COMPANY['story']['lead']) ?></p>
        </div>
        <div class="split-grid" data-reveal>
            <div class="about-body">
                <?php foreach (explode("\n\n", $COMPANY['story']['body']) as $para): ?>
                    <p><?= e($para) ?></p>
                <?php endforeach; ?>
            </div>
            <figure class="about-quote">
                <blockquote><?= e($COMPANY['story']['founderQuote']) ?></blockquote>
                <figcaption>— <?= e($COMPANY['story']['founderName']) ?>, <?= e($COMPANY['story']['founderRole']) ?></figcaption>
            </figure>
        </div>
        <div class="features-grid" data-reveal-stagger style="margin-top:2.5rem">
            <?php foreach ($COMPANY['aboutCards'] as $card): ?>
                <article class="feature-card">
                    <h3 class="feature-card__title"><?= e($card['title']) ?></h3>
                    <p class="feature-card__desc"><?= e($card['desc']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== WHY PRAKRITIK ===== -->
<section class="section section--forest" id="why-prakritik">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Why Prakritik</span>
            <h2 class="section-heading__title">One material, three honest promises.</h2>
            <p class="section-heading__desc">Cow dung, lime, and pigment — each doing what it has always done, on Indian walls.</p>
        </div>
        <div class="why-split" data-reveal-stagger>
            <article class="why-card">
                <span class="why-card__eyebrow">Haldi finish</span>
                <h3 class="why-card__title">Soft, matte, breathable.</h3>
                <p class="why-card__desc">A limewash-style finish that lets water vapour pass through the wall. No trapped moisture, no blistering — just the soft glow of an Indian courtyard.</p>
            </article>
            <div class="why-bridge">
                <span class="why-bridge__text">One promise —<br>walls that breathe.</span>
            </div>
            <article class="why-card">
                <span class="why-card__eyebrow">Forest sourcing</span>
                <h3 class="why-card__title">From gaushala to wall.</h3>
                <p class="why-card__desc">Cow dung is sourced from partner gaushalas with documented material logs. Every batch is traceable — purpose, not waste.</p>
            </article>
        </div>
        <div style="text-align:center; margin-top:2.5rem" data-reveal>
            <a href="/why-prakritik/" class="btn btn--haldi btn--lg">Read the full story</a>
        </div>
    </div>
</section>

<!-- ===== PRODUCTS ===== -->
<section class="section section--paper section--grain" id="products">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Our Products</span>
            <h2 class="section-heading__title">Two crafts. One discipline.</h2>
            <p class="section-heading__desc">Prakritik Distemper for interiors, Prakritik Emulsion for interiors and sheltered exteriors — both cow dung-based, both breathable.</p>
        </div>
        <div class="products-grid" data-reveal-stagger>
            <?php foreach ($PRODUCTS as $p): ?>
                <article class="product-card<?= !empty($p['featured']) ? ' product-card--featured' : '' ?>">
                    <div class="product-card__media">
                        <span class="product-card__chip"><?= e($p['categoryLabel']) ?></span>
                        <?php if (!empty($p['featured'])): ?>
                            <span class="product-card__featured-badge">Featured</span>
                        <?php endif; ?>
                        <div class="product-media" data-official-image="<?= e($p['officialImage']) ?>">
                            <img class="product-media__official" src="<?= e($p['officialImage']) ?>" alt="" loading="lazy" decoding="async" onerror="this.parentElement.dataset.loadedError='1'" onload="this.parentElement.dataset.loaded='true'">
                            <div class="product-media__fallback"><?php render_illustration($p['image']); ?></div>
                        </div>
                    </div>
                    <div class="product-card__body">
                        <h3 class="product-card__name"><?= e($p['name']) ?></h3>
                        <p class="product-card__tagline"><?= e($p['tagline']) ?></p>
                        <div class="product-card__highlights">
                            <?php foreach ($p['highlights'] as $h): ?>
                                <span class="product-card__highlight"><?= e($h) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="product-card__foot">
                            <span class="product-card__price"><?= e($p['priceRange']) ?></span>
                            <a class="product-card__link" href="/products/<?= e($p['slug']) ?>/">
                                View details
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== FEATURES ===== -->
<section class="section section--paper" id="features">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Why Gaurikrit</span>
            <h2 class="section-heading__title">Six reasons homes and contractors trust us.</h2>
            <p class="section-heading__desc">From gaushala to wall, every step is built to earn trust.</p>
        </div>
        <div class="features-grid" data-reveal-stagger>
            <?php foreach ($features as $f): ?>
                <article class="feature-card">
                    <div class="feature-card__icon" aria-hidden="true">
                        <?php
                        $iconMap = ['Naturally Crafted' => 'leaf', 'Lab-Tested Purity' => 'flask', '100% Coverage' => 'ruler', 'Low-VOC' => 'wind', 'Heritage Recipe' => 'book', 'Pan-India Delivery' => 'truck'];
                        $iconKey = $iconMap[$f['title']] ?? 'leaf';
                        $icons = [
                            'leaf'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-3.5 10-8 10z"/><path d="M2 21c0-3 1.85-6.78 7-10"/></svg>',
                            'flask'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3h6M10 3v6L4 20a2 2 0 0 0 2 3h12a2 2 0 0 0 2-3l-6-11V3"/></svg>',
                            'ruler'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21.3 8.7 8.7 21.3a1 1 0 0 1-1.4 0l-4.6-4.6a1 1 0 0 1 0-1.4L15.3 2.7a1 1 0 0 1 1.4 0l4.6 4.6a1 1 0 0 1 0 1.4z"/><path d="M14 7l-3 3M9 12l-3 3M19 12l-3 3"/></svg>',
                            'wind'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M9.6 4.6A2 2 0 1 1 11 8H2M12.6 19.4A2 2 0 1 0 14 16H2M17.4 7.4A3 3 0 1 1 19.8 12H2"/></svg>',
                            'book'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5V5a2 2 0 0 1 2-2h14v17H6.5a2.5 2.5 0 0 0-2.5 2.5z"/></svg>',
                            'truck'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18a2 2 0 1 0 4 0 2 2 0 0 0-4 0zM15 18a2 2 0 1 0 4 0 2 2 0 0 0-4 0zM3 6h11v10H3zM14 9h4l3 3v4h-7"/></svg>',
                        ];
                        echo $icons[$iconKey] ?? $icons['leaf'];
                        ?>
                    </div>
                    <h3 class="feature-card__title"><?= e($f['title']) ?></h3>
                    <p class="feature-card__desc"><?= e($f['desc']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== PROCESS ===== -->
<section class="section section--forest" id="process">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">The Craft</span>
            <h2 class="section-heading__title">From gaushala to your wall, in four steps.</h2>
            <p class="section-heading__desc">Every Prakritik Paint batch follows the same disciplined path.</p>
        </div>
        <div class="process-steps" data-reveal-stagger>
            <?php foreach ($processSteps as $step): ?>
                <article class="process-step">
                    <span class="process-step__num" aria-hidden="true"><?= e($step['num']) ?></span>
                    <div class="process-step__icon" aria-hidden="true">
                        <?php
                        $iconMap = ['Source' => 'sprout', 'Craft' => 'hammer', 'Test' => 'flask', 'Deliver' => 'truck'];
                        $iconKey = $iconMap[$step['title']] ?? 'sprout';
                        $icons = [
                            'sprout' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10M10 20v-6M14 20v-6M5 12c0-3 3-5 7-5s7 2 7 5c0 1.5-1.5 3-3.5 3H8.5C6.5 15 5 13.5 5 12z"/></svg>',
                            'hammer' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 12l-8.5 8.5a2 2 0 0 1-2.8-2.8L12 9.2M17.5 4.5l3 3-7 7-3-3z"/></svg>',
                            'flask'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3h6M10 3v6L4 20a2 2 0 0 0 2 3h12a2 2 0 0 0 2-3l-6-11V3"/></svg>',
                            'truck'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18a2 2 0 1 0 4 0 2 2 0 0 0-4 0zM15 18a2 2 0 1 0 4 0 2 2 0 0 0-4 0zM3 6h11v10H3zM14 9h4l3 3v4h-7"/></svg>',
                        ];
                        echo $icons[$iconKey] ?? $icons['sprout'];
                        ?>
                    </div>
                    <h3 class="process-step__title"><?= e($step['title']) ?></h3>
                    <p class="process-step__desc"><?= e($step['desc']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== COVERAGE CALCULATOR ===== -->
<section class="section section--paper" id="calculator">
    <div class="container calculator-wrap">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Coverage Calculator</span>
            <h2 class="section-heading__title">Estimate your paint requirement.</h2>
            <p class="section-heading__desc">Enter your wall area and product. The estimate is based on standard two-coat application over a limewash primer.</p>
        </div>
        <div class="calculator" data-reveal>
            <form class="calculator-form" data-coverage-form novalidate>
                <div class="form-field">
                    <label class="form-label" for="calc-area">Wall area (sq ft) <span class="req">*</span></label>
                    <input class="form-input" type="number" id="calc-area" name="area" min="1" step="1" value="200" required inputmode="numeric">
                    <div class="form-error" data-error-for="area"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="calc-product">Product <span class="req">*</span></label>
                    <select class="form-select" id="calc-product" name="product">
                        <option value="prakritik-distemper">Prakritik Distemper (130 sq ft / kg / coat)</option>
                        <option value="prakritik-emulsion">Prakritik Emulsion (150 sq ft / L / coat)</option>
                    </select>
                </div>
                <div class="form-field">
                    <label class="form-label"><input type="checkbox" name="primer" checked style="margin-right:0.5rem; vertical-align:middle"> Include Prakritik Limewash Primer</label>
                </div>
                <button type="submit" class="btn btn--primary btn--block">Calculate</button>
            </form>
            <div class="calculator-result" data-coverage-result hidden>
                <h3 class="calculator-result__title">Estimated requirement</h3>
                <div data-coverage-rows></div>
                <p class="form-error" data-coverage-note style="margin-top:0.75rem; min-height:0"></p>
            </div>
            <div class="calculator-empty" data-coverage-empty hidden></div>
        </div>
    </div>
</section>

<!-- ===== CLAIMS REGISTER ===== -->
<section class="section section--paper section--grain" id="claims">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Claims Register</span>
            <h2 class="section-heading__title">Every claim, sourced. No exceptions.</h2>
            <p class="section-heading__desc">Nine documented claims — material, performance, safety — each with a test source and reference number.</p>
        </div>
        <div class="claims-toolbar" data-reveal>
            <div class="claims-search">
                <span class="claims-search__icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </span>
                <input class="claims-search__input" type="search" placeholder="Search claims…" aria-label="Search claims" data-claims-search>
            </div>
            <select class="form-select" style="height:2.75rem; width:auto; min-width:12rem" aria-label="Filter by category" data-claims-filter>
                <?php foreach ($claimCategories as $key => $label): ?>
                    <option value="<?= e($key) ?>"><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="overflow-x:auto">
            <table class="claims-table" data-claims-table>
                <thead>
                    <tr>
                        <th>Claim</th>
                        <th>Category</th>
                        <th>Source</th>
                        <th>Reference</th>
                        <th>Verified</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($CLAIMS as $c): ?>
                        <tr data-claim-id="<?= e($c['id']) ?>" data-claim-category="<?= e($c['category']) ?>" data-claim-text="<?= e(strtolower($c['claim'] . ' ' . $c['source'] . ' ' . $c['reference'])) ?>">
                            <td><?= e($c['claim']) ?></td>
                            <td><span class="product-card__highlight"><?= e($c['categoryLabel']) ?></span></td>
                            <td><?= e($c['source']) ?></td>
                            <td><code class="claims-table__ref" title="Copy reference" data-copy-ref="<?= e($c['reference']) ?>"><?= e($c['reference']) ?></code></td>
                            <td><?= e(date('j M Y', strtotime($c['verifiedOn']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="claims-empty" data-claims-empty hidden>No claims match your search.</p>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="section section--paper" id="testimonials">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Loved by Homes & Pros</span>
            <h2 class="section-heading__title">What families, contractors, and architects say.</h2>
        </div>
        <div class="testimonials-grid" data-reveal-stagger>
            <?php foreach ($testimonials as $t): ?>
                <figure class="testimonial">
                    <blockquote class="testimonial__quote"><?= e($t['quote']) ?></blockquote>
                    <figcaption class="testimonial__cite">
                        <div class="testimonial__name"><?= e($t['name']) ?></div>
                        <div class="testimonial__role"><?= e($t['role']) ?></div>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section section--paper section--grain" id="faq">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Questions</span>
            <h2 class="section-heading__title">Before you ask.</h2>
            <p class="section-heading__desc">The questions we hear most often, answered plainly.</p>
        </div>
        <div class="faq-list" data-reveal>
            <?php foreach ($faqs as $faq): ?>
                <article class="faq-item" data-faq-item>
                    <button class="faq-item__q" type="button" aria-expanded="false">
                        <span><?= e($faq['q']) ?></span>
                        <svg class="faq-item__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div class="faq-item__a"><div class="faq-item__a-inner"><?= e($faq['a']) ?></div></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== CONTACT ===== -->
<section class="section section--paper" id="contact">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Get in Touch</span>
            <h2 class="section-heading__title">Let's paint something natural together.</h2>
            <p class="section-heading__desc">Bulk, project, retail, or just curious — we read every message.</p>
        </div>
        <div class="contact-grid" data-reveal>
            <form class="contact-form" data-contact-form novalidate>
                <?= csrf_field() ?>
                <div class="form-honeypot" aria-hidden="true">
                    <label>Leave this field empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-name">Name <span class="req">*</span></label>
                    <input class="form-input" type="text" id="cf-name" name="name" required autocomplete="name" maxlength="120">
                    <div class="form-error" data-error-for="name"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-email">Email <span class="req">*</span></label>
                    <input class="form-input" type="email" id="cf-email" name="email" required autocomplete="email" maxlength="254">
                    <div class="form-error" data-error-for="email"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-phone">Phone</label>
                    <input class="form-input" type="tel" id="cf-phone" name="phone" autocomplete="tel" maxlength="20">
                    <div class="form-error" data-error-for="phone"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-interest">Interest <span class="req">*</span></label>
                    <select class="form-select" id="cf-interest" name="interest" required>
                        <option value="">Select an option…</option>
                        <option value="prakritik-distemper">Prakritik Distemper</option>
                        <option value="prakritik-emulsion">Prakritik Emulsion</option>
                        <option value="bulk">Bulk / Project enquiry</option>
                        <option value="partnership">Partnership / Retail</option>
                        <option value="general">General question</option>
                    </select>
                    <div class="form-error" data-error-for="interest"></div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="cf-message">Message <span class="req">*</span></label>
                    <textarea class="form-textarea" id="cf-message" name="message" required minlength="10" maxlength="2000"></textarea>
                    <div class="form-error" data-error-for="message"></div>
                </div>
                <button type="submit" class="btn btn--primary btn--block">
                    <span data-submit-label>Send Message</span>
                    <span data-submit-spinner hidden aria-hidden="true">…</span>
                </button>
            </form>
            <aside class="contact-info" aria-label="Contact details">
                <div class="contact-info__item">
                    <span class="contact-info__label">Email</span>
                    <span><a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a></span>
                </div>
                <div class="contact-info__item">
                    <span class="contact-info__label">Phone</span>
                    <span><a href="tel:<?= e(preg_replace('/\s+/', '', $COMPANY['phone'])) ?>"><?= e($COMPANY['phone']) ?></a></span>
                </div>
                <div class="contact-info__item">
                    <span class="contact-info__label">Hours</span>
                    <span>Mon–Sat, 10 am – 6 pm IST</span>
                </div>
                <div class="contact-info__item">
                    <span class="contact-info__label">Based in</span>
                    <span>Bharat · Pan-India shipping</span>
                </div>
                <div class="contact-info__item">
                    <span class="contact-info__label">Founded</span>
                    <span><?= e((string)$COMPANY['foundedYear']) ?></span>
                </div>
                <div class="newsletter-card" style="margin-top:1.5rem">
                    <h3>Golden updates, once a month.</h3>
                    <p>New batches, shade launches, and craft stories. No spam.</p>
                    <form data-newsletter-form novalidate>
                        <?= csrf_field() ?>
                        <div class="form-honeypot" aria-hidden="true"><label>Leave empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label></div>
                        <div class="form-field">
                            <label class="form-label sr-only" for="nl-email">Email</label>
                            <input class="form-input" type="email" id="nl-email" name="email" required placeholder="you@example.com" autocomplete="email">
                            <div class="form-error" data-error-for="email"></div>
                        </div>
                        <button type="submit" class="btn btn--primary btn--block">Subscribe</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
