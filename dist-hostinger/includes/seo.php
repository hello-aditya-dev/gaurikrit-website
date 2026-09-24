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
    $ogImage   = $meta['ogImage'] ?? ($siteUrl . '/assets/brand/gaurikrit-logo-mark.png');

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
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . e($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . e($desc) . '">' . "\n";

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
}
