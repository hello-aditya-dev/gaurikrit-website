<?php
/**
 * Shared <head> + opening body + site header.
 * Pages define $pageTitle, $pageDescription, $pageCanonical, $pageClass before including this.
 */
global $COMPANY, $NAV, $config;
$pageTitle       = $pageTitle       ?? 'Gaurikrit Bio Products — Prakritik Paint';
$pageDescription = $pageDescription ?? 'Cow dung-based Prakritik Paint. Walls that breathe sustainability.';
$pageCanonical   = $pageCanonical   ?? '/';
$pageClass       = $pageClass       ?? 'home';
$pageOgType      = $pageOgType      ?? 'website';
$pageOgImage     = $pageOgImage     ?? null;
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/brand/gaurikrit-logo-mark.png" type="image/png">
    <?php render_meta([
        'title'       => $pageTitle,
        'description' => $pageDescription,
        'canonical'   => $pageCanonical,
        'ogType'      => $pageOgType,
        'ogImage'     => $pageOgImage,
    ], $COMPANY); ?>

    <!-- Fonts: Manrope (sans), Newsreader (display), Noto Serif Devanagari -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Newsreader:opsz,wght@6..72,400;6..72,600;6..72,700&family=Noto+Serif+Devanagari:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= asset_url('/assets/css/app.css') ?>">
</head>
<body class="page-<?= e($pageClass) ?>">
    <a href="#main" class="skip-link">Skip to content</a>

    <!-- ===== Site header ===== -->
    <header class="site-header" id="site-header" data-scrolled="false">
        <div class="container site-header__inner">
            <a href="/" class="brand" aria-label="Gaurikrit home">
                <span class="brand__mark">
                    <?php render_illustration('gaurikrit-cow-mark', ['class' => 'brand__mark-svg']); ?>
                </span>
                <span class="brand__text">
                    <span class="brand__name">Gaurikrit</span>
                    <span class="brand__sub">Bio Products</span>
                </span>
            </a>

            <nav class="site-nav" aria-label="Primary" data-spy>
                <?php foreach ($NAV as $link): ?>
                    <a href="<?= e($link['href']) ?>" class="site-nav__link" data-nav-link="<?= e($link['href']) ?>"><?= e($link['label']) ?></a>
                <?php endforeach; ?>
            </nav>

            <div class="site-header__actions">
                <button class="theme-toggle" aria-label="Toggle theme" data-theme-toggle>
                    <svg class="theme-toggle__icon theme-toggle__icon--sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                    <svg class="theme-toggle__icon theme-toggle__icon--moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
                <a href="/contact/" class="btn btn--primary btn--sm site-header__cta">Get a Quote</a>
                <button class="menu-toggle" aria-label="Open menu" data-menu-toggle aria-expanded="false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile menu sheet -->
    <div class="mobile-menu" data-mobile-menu hidden>
        <div class="mobile-menu__panel">
            <div class="mobile-menu__head">
                <span class="mobile-menu__title">Menu</span>
                <button class="mobile-menu__close" aria-label="Close menu" data-menu-close>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="mobile-menu__nav" aria-label="Mobile">
                <?php foreach ($NAV as $link): ?>
                    <a href="<?= e($link['href']) ?>" class="mobile-menu__link" data-nav-link="<?= e($link['href']) ?>"><?= e($link['label']) ?><span class="mobile-menu__arrow">→</span></a>
                <?php endforeach; ?>
            </nav>
            <div class="mobile-menu__foot">
                <a href="/contact/" class="btn btn--primary btn--block">Get a Quote</a>
                <p class="mobile-menu__tagline">Naturally crafted · Since 2019</p>
            </div>
        </div>
    </div>

    <main id="main" class="site-main">
