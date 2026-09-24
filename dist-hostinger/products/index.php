<?php
/**
 * Gaurikrit Bio Products — Products overview.
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

$pageTitle       = 'Prakritik Paint Products — Distemper & Emulsion | Gaurikrit';
$pageDescription = 'Two Prakritik Paint products — a cow dung-based distemper for interiors, and a finer emulsion for interiors and sheltered exteriors. Naturally breathable, zero lead, gaushala-sourced.';
$pageCanonical   = '/products/';
$pageClass       = 'products';
$pageOgType      = 'website';

require_once __DIR__ . '/../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';
?>
<style>
  .page-hero { padding-top: calc(var(--header-h) + 3rem); padding-bottom: 1rem; }
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }
  .products-split { display:grid; gap:1.5rem; }
  @media (min-width: 768px) { .products-split { grid-template-columns:repeat(2,1fr); } }
  .product-card__link svg { width:0.875rem; height:0.875rem; }
</style>

<section class="page-hero section section--paper section--grain">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <span>Products</span>
        </nav>
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Our Products</span>
            <h1 class="section-heading__title">Two crafts. One discipline.</h1>
            <p class="section-heading__desc">Prakritik Distemper for interiors. Prakritik Emulsion for interiors and sheltered exteriors. Both cow dung-based, both breathable, both zero lead.</p>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="container">
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
                        <h2 class="product-card__name"><?= e($p['name']) ?></h2>
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

        <div class="section--forest" style="margin-top:3rem; padding:2rem; border-radius:var(--radius-lg); text-align:center" data-reveal>
            <h2 style="font-size:1.5rem; color:var(--haldi);">Bulk or project enquiry?</h2>
            <p style="color:oklch(0.85 0.01 75); margin-top:0.5rem; margin-bottom:1.5rem;">We supply gaushalas, contractors, architects, and project owners in batch volumes.</p>
            <a href="/for-business/" class="btn btn--haldi btn--lg">Talk to us</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
