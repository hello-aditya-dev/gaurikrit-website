<?php
/**
 * Gaurikrit Bio Products — SEO metadata helper.
 * Call render_meta($pageMeta) inside <head>.
 */

declare(strict_types=1);

function render_meta(array $meta, array $company = []): void
{
    $siteUrl   = $company['siteUrl'] ?? 'https://gaurikrit.com';
    $title     = $meta['title'] ?? 'Gaurikrit Bio Products — Prakritik Paint';
    $desc      = $meta['description'] ?? 'Cow dung-based Prakritik Paint. Walls that breathe sustainability.';
    $canonical = $meta['canonical'] ?? '/';
    $pageClass = $meta['pageClass'] ?? '';
    $ogType    = $meta['ogType'] ?? 'website';
    $ogImage   = $meta['ogImage'] ?? ($siteUrl . '/assets/brand/gaurikrit-og.png');

    $fullCanonical = rtrim($siteUrl, '/') . $canonical;
    $fullOgImage   = $meta['ogImageAbsolute'] ?? $ogImage;

    echo '<title>' . e($title) . '</title>' . "\n";
    echo '<meta name="description" content="' . e($desc) . '">' . "\n";
    echo '<link rel="canonical" href="' . e($fullCanonical) . '">' . "\n";
    echo '<meta name="robots" content="index, follow">' . "\n";
    echo '<meta property="og:title" content="' . e($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . e($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . e($fullCanonical) . '">' . "\n";
    echo '<meta property="og:type" content="' . e($ogType) . '">' . "\n";
    echo '<meta property="og:site_name" content="Gaurikrit Bio Products">' . "\n";
    echo '<meta property="og:image" content="' . e($fullOgImage) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . e($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . e($desc) . '">' . "\n";

    // JSON-LD Organization schema.
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Gaurikrit Bio Products',
        'alternateName' => 'गौरीकृत',
        'description' => 'Maker of Prakritik Paint — cow dung-based natural paint in distemper and emulsion formats.',
        'url' => $siteUrl,
        'knowsAbout' => ['cow dung paint', 'prakritik paint', 'natural distemper', 'natural emulsion', 'limewash', 'gaushala'],
        'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'IN'],
    ];
    echo '<script type="application/ld+json">' . json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
}
