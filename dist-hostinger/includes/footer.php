<?php
/**
 * Shared footer + closing body/html.
 * No newsletter. No fake socials. Real contact details. No fake Privacy/Terms links.
 */
global $COMPANY, $NAV;
$phones = $COMPANY['phones'] ?? [];
$addr = $COMPANY['address'] ?? [];
?>
    </main>

    <!-- ===== Site footer ===== -->
    <footer class="site-footer" id="footer">
        <div class="container site-footer__main">
            <div class="site-footer__brand">
                <a href="/" class="brand brand--footer">
                    <span class="brand__mark" data-official-image="/assets/brand/gaurikrit-logo-mark.png">
                        <img class="brand__official" src="/assets/brand/gaurikrit-logo-mark.png" alt="Gaurikrit" width="36" height="36">
                        <span class="brand__fallback"><?php render_illustration('gaurikrit-cow-mark', ['class' => 'brand__mark-svg']); ?></span>
                    </span>
                    <span class="brand__name">Gaurikrit</span>
                </a>
                <p class="site-footer__brandline"><?= e($COMPANY['brandLine']) ?></p>
                <p class="site-footer__legal-name"><?= e($COMPANY['legalName']) ?></p>
            </div>
            <nav class="site-footer__col" aria-label="Navigate">
                <h4 class="site-footer__heading">Navigate</h4>
                <?php foreach ($NAV as $link): ?>
                    <a href="<?= e($link['href']) ?>"><?= e($link['label']) ?></a>
                <?php endforeach; ?>
            </nav>
            <nav class="site-footer__col" aria-label="Products">
                <h4 class="site-footer__heading">Products</h4>
                <a href="/products/prakritik-distemper/">Prakritik Distemper</a>
                <a href="/products/prakritik-emulsion/">Prakritik Emulsion</a>
                <a href="/downloads/">Brochure</a>
                <a href="/for-business/">For Business</a>
            </nav>
            <div class="site-footer__col">
                <h4 class="site-footer__heading">Contact</h4>
                <p class="site-footer__contact-line">
                    <a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a>
                </p>
                <?php foreach ($phones as $phone): ?>
                    <p class="site-footer__contact-line">
                        <a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="site-footer__bottom">
            <div class="container site-footer__bottom-inner">
                <p>© <?= date('Y') ?> <?= e($COMPANY['legalName']) ?>. GSTIN: <?= e($COMPANY['gstin']) ?>.</p>
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
    <script src="<?= asset_url('/assets/js/ashta-laabh.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/colour-study.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/forms.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/calculator.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/app.js') ?>"></script>
</body>
</html>
