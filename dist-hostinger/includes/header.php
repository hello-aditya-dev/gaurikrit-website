<?php
/**
 * Shared <head> + opening body + site header.
 * Pages define $pageTitle, $pageDescription, $pageCanonical, $pageClass before including this.
 *
 * Logo handoff: attempts /assets/brand/gaurikrit-logo-full.png.
 * If present, shows official logo. If absent, shows coded cow-mark + Gaurikrit text.
 * No broken image — the <img> has onerror handling in app.js.
 */
global $COMPANY, $NAV, $config;
$pageTitle       = $pageTitle       ?? 'Gaurikrit — Prakritik Paint & Bio Products';
$pageDescription = $pageDescription ?? 'Gaurikrit Bio Products offers cow dung-based Prakritik Distemper and Emulsion Paint for interior and exterior walls from Bulandshahr, Uttar Pradesh.';
$pageCanonical   = $pageCanonical   ?? '/';
$pageClass       = $pageClass       ?? 'home';
$pageOgImage     = $pageOgImage     ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
    <link rel="icon" href="/favicon-16x16.png" type="image/png" sizes="16x16">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <?php render_meta([
        'title'       => $pageTitle,
        'description' => $pageDescription,
        'canonical'   => $pageCanonical,
        'ogImage'     => $pageOgImage,
    ], $COMPANY); ?>

    <!-- Fonts are served locally from assets/fonts for reliable Hindi rendering. -->
    <link rel="stylesheet" href="<?= asset_url('/assets/css/app.css') ?>">
</head>
<body class="page-<?= e($pageClass) ?>">
    <a href="#main" class="skip-link">Skip to content</a>

    <!-- ===== Site header ===== -->
    <header class="site-header" id="site-header" data-scrolled="false">
        <div class="container site-header__inner">
            <a href="/" class="brand" aria-label="Gaurikrit home">
                <span class="brand__mark" data-official-image="/assets/brand/gaurikrit-logo-mark.png">
                    <img class="brand__official" src="/assets/brand/gaurikrit-logo-mark.png" alt="Gaurikrit" width="36" height="36">
                    <span class="brand__fallback"><?php render_illustration('gaurikrit-cow-mark', ['class' => 'brand__mark-svg']); ?></span>
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
                <a href="/contact/" class="btn btn--primary btn--sm site-header__cta">Talk to Us</a>
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
                <a href="/contact/" class="btn btn--primary btn--block">Talk to Us</a>
            </div>
        </div>
    </div>

    <main id="main" class="site-main">
