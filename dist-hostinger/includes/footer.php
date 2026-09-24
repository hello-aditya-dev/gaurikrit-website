<?php
/**
 * Shared footer + closing body/html.
 */
global $COMPANY, $NAV, $config;
?>
    </main>

    <!-- ===== Site footer ===== -->
    <footer class="site-footer" id="footer">
        <!-- Newsletter strip -->
        <div class="site-footer__strip">
            <div class="container site-footer__strip-inner">
                <div>
                    <h3 class="site-footer__strip-title">Golden updates, once a month.</h3>
                    <p class="site-footer__strip-sub">New batches, shade launches, and craft stories. No spam — unsubscribe anytime.</p>
                </div>
                <form class="newsletter-form" data-newsletter-form novalidate>
                    <?= csrf_field() ?>
                    <div class="form-honeypot" aria-hidden="true"><label>Leave empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label></div>
                    <input type="email" name="email" required placeholder="you@example.com" aria-label="Email for newsletter" class="newsletter-form__input">
                    <button type="submit" class="btn btn--primary newsletter-form__btn">Subscribe</button>
                </form>
            </div>
        </div>

        <!-- Main footer -->
        <div class="container site-footer__main">
            <div class="site-footer__brand">
                <a href="/" class="brand brand--footer">
                    <span class="brand__mark"><?php render_illustration('gaurikrit-cow-mark', ['class' => 'brand__mark-svg']); ?></span>
                    <span class="brand__name">Gaurikrit</span>
                </a>
                <p class="site-footer__blurb">
                    <?= e($COMPANY['tagline']) ?> Cow dung-based Prakritik Paint — naturally crafted, naturally breathable.
                </p>
                <div class="site-footer__socials">
                    <?php foreach ($COMPANY['socials'] as $s): ?>
                        <a href="<?= e($s['href']) ?>" class="site-footer__social" aria-label="<?= e($s['name']) ?>"><?= e($s['name'][0]) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <nav class="site-footer__col" aria-label="Company">
                <h4 class="site-footer__heading">Company</h4>
                <a href="/about/">About Us</a>
                <a href="/why-prakritik/">Why Prakritik?</a>
                <a href="/products/">Products</a>
                <a href="/contact/">Contact</a>
            </nav>
            <nav class="site-footer__col" aria-label="Products">
                <h4 class="site-footer__heading">Products</h4>
                <a href="/products/prakritik-distemper/">Prakritik Distemper</a>
                <a href="/products/prakritik-emulsion/">Prakritik Emulsion</a>
                <a href="/downloads/">Brochure</a>
                <a href="/for-business/">Bulk & Projects</a>
            </nav>
            <div class="site-footer__col">
                <h4 class="site-footer__heading">Get in touch</h4>
                <p class="site-footer__contact">
                    <a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a><br>
                    <a href="tel:<?= e(preg_replace('/\s+/', '', $COMPANY['phone'])) ?>"><?= e($COMPANY['phone']) ?></a>
                </p>
            </div>
        </div>

        <div class="site-footer__bottom">
            <div class="container site-footer__bottom-inner">
                <p>© <?= date('Y') ?> Gaurikrit Bio Products. All rights reserved.</p>
                <div class="site-footer__legal">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
                <p class="site-footer__made">Crafted in Bharat.</p>
            </div>
        </div>
    </footer>

    <!-- Back-to-top -->
    <button class="back-to-top" data-back-to-top aria-label="Back to top" hidden>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>

    <!-- Toast region (populated by JS) -->
    <div class="toast-region" data-toast-region aria-live="polite" aria-atomic="true"></div>

    <!-- JS modules — load order matters: utils before features before entry -->
    <script src="<?= asset_url('/assets/js/navigation.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/animations.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/ashta-laabh.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/colour-study.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/forms.js') ?>"></script>
    <script src="<?= asset_url('/assets/js/app.js') ?>"></script>
</body>
</html>
