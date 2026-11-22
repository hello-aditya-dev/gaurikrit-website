<?php
/**
 * Shared footer + closing body/html.
 * No newsletter. No fake socials. Real contact details. No fake Privacy/Terms links.
 * V16 §47: story-first column order — COMPANY / PRODUCTS / WORK WITH US /
 * contact. Family links use /products/#anchors (no nonexistent pages).
 */
global $COMPANY, $NAV, $NAV_UTILITIES, $FOOTER_PRODUCTS;
$phones = $COMPANY['phones'] ?? [];
$addr = $COMPANY['address'] ?? [];
?>
    </main>

    <!-- ===== Site footer ===== -->
    <footer class="site-footer" id="footer">
        <div class="container site-footer__main">
            <div class="site-footer__brand">
                <a href="/" class="brand brand--footer">
                    <span class="brand__mark" data-official-image="/assets/brand/gaurikrit-logo-mark-sm.png">
                        <img class="brand__official" src="/assets/brand/gaurikrit-logo-mark-sm.png" alt="Gaurikrit" width="36" height="36">
                        <span class="brand__fallback"><?php render_illustration('gaurikrit-cow-mark', ['class' => 'brand__mark-svg']); ?></span>
                    </span>
                    <span class="brand__name">Gaurikrit</span>
                </a>
                <p class="site-footer__brandline"><?= e($COMPANY['brandLine']) ?></p>
                <p class="site-footer__legal-name"><?= e(implode(', ', array_slice($COMPANY['address'], 3, 3))) ?></p>
            </div>
            <nav class="site-footer__col site-footer__col--company" aria-label="Company">
                <h4 class="site-footer__heading">Company</h4>
                <a href="/">Home</a>
                <a href="/about/">Our Story</a>
                <a href="/colours/">Colours</a>
                <a href="/sustainability/">Sustainability</a>
                <a href="/sustainability/">Innovation</a>
            </nav>
            <nav class="site-footer__col" aria-label="Products">
                <h4 class="site-footer__heading">Products</h4>
                <?php foreach ($FOOTER_PRODUCTS as $item): ?>
                    <a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
                <?php endforeach; ?>
            </nav>
            <nav class="site-footer__col site-footer__col--work" aria-label="Work with us">
                <h4 class="site-footer__heading">Work With Us</h4>
                <a href="/contact/">Partners</a>
                <a href="/paint-calculator/">Painting Calculator</a>
                <a href="/downloads/">Downloads</a>
                <a href="/contact/">Contact</a>
            </nav>
            <div class="site-footer__col site-footer__col--contact">
                <h4 class="site-footer__heading">Contact</h4>
                <p class="site-footer__contact-line">
                    <a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a>
                </p>
                <?php foreach ($phones as $phone): ?>
                    <p class="site-footer__contact-line">
                        <a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a>
                    </p>
                <?php endforeach; ?>
                <div class="site-footer__social" aria-label="Connect with Gaurikrit">
                    <a class="site-footer__social-link" href="mailto:<?= e($COMPANY['email']) ?>" aria-label="Email Gaurikrit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </a>
                    <?php foreach ($phones as $i => $phone): ?>
                        <a class="site-footer__social-link" href="tel:<?= e(str_replace(' ', '', $phone)) ?>" aria-label="Call <?= e($phone) ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <div class="container site-footer__bottom-inner">
                <p>© <?= date('Y') ?> <?= e($COMPANY['legalName']) ?>. GSTIN: <?= e($COMPANY['gstin']) ?>.</p>
                <p class="site-footer__bottom-deva" lang="hi" aria-label="Prakriti se, deewaron tak"><?= e($COMPANY['hindiTagline']) ?></p>
            </div>
        </div>
    </footer>

    <!-- Back-to-top -->
    <button class="back-to-top" data-back-to-top aria-label="Back to top" hidden>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>

    <!-- Toast region -->
    <div class="toast-region" data-toast-region aria-live="polite" aria-atomic="true"></div>

    <!--
      Module scripts. Order matters: each module registers
      window.GaurikritApp.<Name> = { init: fn, ... } and app.js
      (loaded last) calls .init() on each. calculator.js is included
      after forms.js so it can reuse the toast helper if needed, and
      before app.js so app.js can include 'Calculator' in its boot
      sequence.
    -->
    <script src="<?= asset_url('/assets/js/navigation.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/animations.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/hero-carousel.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/colour-study.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/forms.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/calculator.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/story.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/app.js') ?>"></script>
</body>
</html>
