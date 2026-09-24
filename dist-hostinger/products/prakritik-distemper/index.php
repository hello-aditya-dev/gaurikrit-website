<?php
/**
 * Gaurikrit Bio Products — Prakritik Distemper product detail.
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

require_once __DIR__ . '/../../includes/bootstrap.php';

$slug = 'prakritik-distemper';
$product = get_product($slug);
if (!$product) {
    http_response_code(404);
    require ROOT_PATH . '/404.php';
    exit;
}

$pageTitle       = e($product['name']) . ' — Cow Dung-Based Natural Distemper | Gaurikrit';
$pageDescription = e($product['tagline']) . ' ' . e($product['description']);
$pageCanonical   = '/products/' . $slug . '/';
$pageClass       = 'product-detail';
$pageOgType      = 'product';
$pageOgImage     = $COMPANY['siteUrl'] . $product['officialImage'];

require ROOT_PATH . '/includes/header.php';

// Shade palette for the colour-study visualizer.
$shades = [
    ['name' => 'Limewash White',  'hex' => '#f4efe2'],
    ['name' => 'Mitti',            'hex' => '#b89272'],
    ['name' => 'Geru',             'hex' => '#a05a3a'],
    ['name' => 'Haldi',            'hex' => '#d4a04a'],
    ['name' => 'Forest',           'hex' => '#5a7a5a'],
    ['name' => 'Indigo',           'hex' => '#3a4a7a'],
];
?>
<style>
  .breadcrumb { font-size:0.8125rem; color:var(--fg-muted); margin-bottom:1rem; padding-top:1rem; }
  .breadcrumb a { color:var(--primary); }
  .breadcrumb a:hover { text-decoration:underline; }
  .product-detail__section--sizes { display:flex; flex-wrap:wrap; gap:0.375rem; }
  .product-detail__size { padding:0.25rem 0.625rem; border-radius:var(--radius-full); background:var(--secondary-bg); font-size:0.75rem; font-weight:500; }
  .product-detail__claim { display:flex; align-items:flex-start; gap:0.625rem; padding:0.75rem; border:1px solid var(--border); border-radius:var(--radius); margin-bottom:0.5rem; }
  .product-detail__claim-icon { color:var(--primary); flex-shrink:0; }
  .product-detail__claim-text { font-size:0.8125rem; }
  .product-detail__claim-ref { font-family:monospace; font-size:0.6875rem; color:var(--fg-muted); margin-top:0.25rem; }
  .product-detail__cta-row { display:flex; flex-wrap:wrap; gap:0.75rem; margin-top:1.5rem; }

  /* Colour study visualizer */
  .colour-study { margin-top:1.5rem; padding:1.5rem; border:1px solid var(--border); border-radius:var(--radius-lg); background:var(--bg-card); }
  .colour-study__title { font-size:0.75rem; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:var(--primary); margin-bottom:0.75rem; }
  .colour-study__wall { position:relative; aspect-ratio:16/9; border-radius:var(--radius); border:1px solid var(--border); background:#f4efe2; overflow:hidden; transition:background 0.6s var(--ease); }
  .colour-study__wall-overlay { position:absolute; inset:0; background-image:radial-gradient(circle at 1px 1px, oklch(0.42 0.05 150 / 0.06) 0.5px, transparent 0); background-size:14px 14px; pointer-events:none; }
  .colour-study__wall-label { position:absolute; bottom:0.75rem; left:0.75rem; font-size:0.75rem; font-weight:600; color:var(--charcoal); background:oklch(1 0 0 / 0.7); padding:0.25rem 0.625rem; border-radius:var(--radius-full); }
  .colour-study__swatches { display:flex; flex-wrap:wrap; gap:0.5rem; margin-top:1rem; }
  .colour-study__swatch { width:2.5rem; height:2.5rem; border-radius:var(--radius-full); border:2px solid var(--border); cursor:pointer; transition:transform var(--dur), border-color var(--dur); }
  .colour-study__swatch:hover { transform:scale(1.08); }
  .colour-study__swatch[data-active="true"] { border-color:var(--primary); transform:scale(1.1); }
</style>

<section class="product-detail" id="product-detail">
    <div class="container" style="grid-column: 1 / -1">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a> <span aria-hidden="true">/</span> <a href="/products/">Products</a> <span aria-hidden="true">/</span> <span><?= e($product['name']) ?></span>
        </nav>
    </div>
    <div class="container" style="display:grid; gap:2rem; grid-template-columns:1fr">
        <div class="split-grid" style="display:grid; gap:2rem; grid-template-columns:1fr; align-items:start">
            <div class="product-detail__media">
                <div class="product-media" data-official-image="<?= e($product['officialImage']) ?>">
                    <img class="product-media__official" src="<?= e($product['officialImage']) ?>" alt="<?= e($product['name']) ?>" decoding="async" onerror="this.parentElement.dataset.loadedError='1'" onload="this.parentElement.dataset.loaded='true'">
                    <div class="product-media__fallback"><?php render_illustration($product['image']); ?></div>
                </div>
            </div>
            <div>
                <span class="product-card__highlight" style="display:inline-block; margin-bottom:0.75rem"><?= e($product['categoryLabel']) ?></span>
                <h1 class="product-detail__name"><?= e($product['name']) ?></h1>
                <p class="product-detail__tagline"><?= e($product['tagline']) ?></p>

                <div class="product-detail__section">
                    <h2 class="product-detail__section-title">Description</h2>
                    <p style="font-size:0.9375rem; color:var(--fg-muted); line-height:1.65"><?= e($product['description']) ?></p>
                </div>

                <div class="product-detail__section">
                    <h2 class="product-detail__section-title">How to use</h2>
                    <p style="font-size:0.9375rem; color:var(--fg-muted); line-height:1.65"><?= e($product['usage']) ?></p>
                </div>

                <div class="product-detail__section">
                    <h2 class="product-detail__section-title">Available sizes</h2>
                    <div class="product-detail__section--sizes">
                        <?php foreach ($product['sizes'] as $size): ?>
                            <span class="product-detail__size"><?= e($size) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="product-detail__section">
                    <h2 class="product-detail__section-title">Price range</h2>
                    <p style="font-size:1.25rem; font-weight:700; color:var(--primary)"><?= e($product['priceRange']) ?></p>
                </div>

                <div class="product-detail__cta-row">
                    <a href="/contact/?interest=<?= e($product['slug']) ?>" class="btn btn--primary btn--lg">Enquire about <?= e($product['name']) ?></a>
                    <a href="/downloads/" class="btn btn--outline btn--lg">Download brochure</a>
                </div>
            </div>
        </div>

        <div class="split-grid" style="display:grid; gap:2rem; grid-template-columns:1fr; align-items:start">
            <div class="colour-study" data-colour-study>
                <div class="colour-study__title">Try a shade</div>
                <div class="colour-study__wall" data-colour-wall style="background:#f4efe2">
                    <div class="colour-study__wall-overlay" aria-hidden="true"></div>
                    <span class="colour-study__wall-label" data-colour-label>Limewash White</span>
                </div>
                <div class="colour-study__swatches" role="radiogroup" aria-label="Choose a shade">
                    <?php foreach ($shades as $i => $s): ?>
                        <button type="button" class="colour-study__swatch" data-shade-name="<?= e($s['name']) ?>" data-shade-hex="<?= e($s['hex']) ?>" style="background:<?= e($s['hex']) ?>" aria-label="<?= e($s['name']) ?>" role="radio" aria-checked="<?= $i === 0 ? 'true' : 'false' ?>"<?= $i === 0 ? ' data-active="true"' : '' ?>></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h2 class="product-detail__section-title">Verified claims</h2>
                <div class="product-detail__claims">
                    <?php foreach ($product['claims'] as $cid): ?>
                        <?php $c = get_claim($cid); if (!$c) continue; ?>
                        <article class="product-detail__claim">
                            <svg class="product-detail__claim-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                            <div>
                                <div class="product-detail__claim-text"><?= e($c['claim']) ?></div>
                                <div class="product-detail__claim-ref"><?= e($c['reference']) ?> · <?= e($c['categoryLabel']) ?> · verified <?= e(date('j M Y', strtotime($c['verifiedOn']))) ?></div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section--paper section--grain">
    <div class="container">
        <div class="section-heading" data-reveal>
            <span class="section-heading__eyebrow">Coverage</span>
            <h2 class="section-heading__title">How much will you need?</h2>
            <p class="section-heading__desc">Use the calculator on the homepage to estimate based on your wall area.</p>
        </div>
        <div style="text-align:center" data-reveal>
            <a href="/#calculator" class="btn btn--primary btn--lg">Open coverage calculator</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
