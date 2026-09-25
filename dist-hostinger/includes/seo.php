<?php
/**
 * Gaurikrit Bio Products — SEO metadata helper.
 * Accurate Organization JSON-LD using only supplied factual data.
 */

declare(strict_types=1);

function render_meta(array $meta, array $company = []): void
{
    $siteUrl   = $company['siteUrl'] ?? 'https://gaurikrit.com';
    $title     = $meta['title'] ?? 'Gaurikrit — Prakritik Paint & Bio Products';
    $desc      = $meta['description'] ?? 'Gaurikrit Bio Products offers cow dung-based Prakritik Distemper and Emulsion Paint for interior and exterior walls from Bulandshahr, Uttar Pradesh.';
    $canonical = $meta['canonical'] ?? '/';
    $ogNames = [
        '/' => 'home', '/products/' => 'products',
        '/products/prakritik-distemper/' => 'distemper',
        '/products/prakritik-emulsion/' => 'emulsion',
        '/why-prakritik/' => 'why-prakritik', '/about/' => 'about',
        '/for-business/' => 'for-business', '/paint-calculator/' => 'calculator',
        '/downloads/' => 'downloads', '/contact/' => 'contact',
    ];
    $slug = $ogNames[$canonical] ?? 'home';
    $ogImage = $meta['ogImage'] ?: rtrim($siteUrl, '/') . '/assets/social/og-' . $slug . '.jpg';
    $ogAlt = 'Gaurikrit — ' . $title;

    $fullCanonical = rtrim($siteUrl, '/') . $canonical;

    echo '<title>' . e($title) . '</title>' . "\n";
    echo '<meta name="description" content="' . e($desc) . '">' . "\n";
    echo '<link rel="canonical" href="' . e($fullCanonical) . '">' . "\n";
    echo '<meta name="robots" content="index, follow">' . "\n";
    echo '<meta property="og:title" content="' . e($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . e($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . e($fullCanonical) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:site_name" content="Gaurikrit Bio Products">' . "\n";
    echo '<meta property="og:image" content="' . e($ogImage) . '">' . "\n";
    echo '<meta property="og:image:width" content="1200">' . "\n";
    echo '<meta property="og:image:height" content="630">' . "\n";
    echo '<meta property="og:image:alt" content="' . e($ogAlt) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . e($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . e($desc) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . e($ogImage) . '">' . "\n";
    echo '<meta name="twitter:image:alt" content="' . e($ogAlt) . '">' . "\n";
    echo '<meta name="theme-color" content="#173F2B">' . "\n";

    // Accurate Organization JSON-LD — only supplied factual data.
    $addr = $company['address'] ?? [];
    $streetAddress = implode(', ', array_filter(array_slice($addr, 0, 3)));
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $company['name'] ?? 'Gaurikrit',
        'legalName' => $company['legalName'] ?? 'Gaurikrit Bio Products (OPC) Private Limited',
        'alternateName' => $company['devanagari'] ?? 'गौरीकृत',
        'url' => $siteUrl,
        'email' => $company['email'] ?? 'seva@gaurikrit.com',
        'telephone' => $company['phones'] ?? [],
        'vatID' => $company['gstin'] ?? '09AAMCG8400F1ZK',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $streetAddress,
            'addressLocality' => $addr[3] ?? 'Khurja',
            'addressRegion' => $addr[4] ?? 'Uttar Pradesh',
            'postalCode' => '203131',
            'addressCountry' => 'IN',
        ],
    ];
    echo '<script type="application/ld+json">' . json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";

    // ---- V14: BreadcrumbList JSON-LD (every page except home) ----
    // Mirrors the visible breadcrumb trail. Product detail pages get the
    // intermediate "Products" level, exactly like the on-page breadcrumb.
    $crumbNames = [
        '/products/'                   => 'Products',
        '/products/prakritik-distemper/' => 'Prakritik Distemper Paint',
        '/products/prakritik-emulsion/'  => 'Prakritik Emulsion Paint',
        '/why-prakritik/'              => 'Why Prakritik',
        '/about/'                      => 'About',
        '/for-business/'               => 'For Business',
        '/paint-calculator/'           => 'Paint Calculator',
        '/downloads/'                  => 'Downloads',
        '/contact/'                    => 'Contact',
    ];
    if ($canonical !== '/' && isset($crumbNames[$canonical])) {
        $items = [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => rtrim($siteUrl, '/') . '/'],
        ];
        if (strpos($canonical, '/products/prakritik-') === 0) {
            $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => rtrim($siteUrl, '/') . '/products/'];
            $items[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $crumbNames[$canonical], 'item' => $fullCanonical];
        } else {
            $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => $crumbNames[$canonical], 'item' => $fullCanonical];
        }
        $ldCrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
        echo '<script type="application/ld+json">' . json_encode($ldCrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }

    // ---- V14: Product JSON-LD on the two product detail pages ----
    // Factual fields only: name, description (the page meta description),
    // brand, category (the paint format), url and image (the OG card).
    // No offers/price/aggregateRating — those would be fabricated data.
    $productSlugs = [
        '/products/prakritik-distemper/' => 'prakritik-distemper',
        '/products/prakritik-emulsion/'  => 'prakritik-emulsion',
    ];
    if (isset($productSlugs[$canonical]) && function_exists('get_product')) {
        $p = get_product($productSlugs[$canonical]);
        if ($p) {
            $ldProduct = [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $p['name'],
                'description' => $desc,
                'brand' => ['@type' => 'Brand', 'name' => 'Gaurikrit'],
                'category' => $p['name'],
                'url' => $fullCanonical,
                'image' => rtrim($siteUrl, '/') . '/assets/social/og-' . $slug . '.jpg',
            ];
            echo '<script type="application/ld+json">' . json_encode($ldProduct, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
        }
    }
}
