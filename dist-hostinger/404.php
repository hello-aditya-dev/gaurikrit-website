<?php
/**
 * Gaurikrit Bio Products — 404 page (V4 asset replacement pass).
 * Task V4-ASSETS.
 *
 * Branded: "This wall hasn't been painted yet."
 * render_illustration('field-botanicals') accent (small, decorative —
 * kept as SVG per spec). Brand mark uses the official PNG (gaurikrit-logo-
 * mark.png) with the gaurikrit-cow-mark SVG as fallback. Link to /.
 */
declare(strict_types=1);

http_response_code(404);

$pageTitle       = '404 — This wall hasn\'t been painted yet | Gaurikrit';
$pageDescription = 'The page you were looking for has not been painted yet. Return to the Gaurikrit homepage.';
$pageCanonical   = '/';
$pageClass        = 'error-404';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY;
?>
<style>
  .error-page {
    min-height: 80vh; display: flex; align-items: center; justify-content: flex-start;
    text-align: left; padding-block: clamp(3rem, 8vw, 6rem);
    padding-top: calc(var(--header-h) + 3rem);
    position: relative; overflow: hidden;
  }
  /* V4: field-botanicals SVG kept as small decorative accent at low opacity. */
  .error-page__bg {
    position: absolute; right: -2rem; top: 50%; transform: translateY(-50%);
    width: 22rem; height: 22rem; opacity: 0.08; z-index: 0;
    pointer-events: none; color: var(--forest);
  }
  @media (max-width: 768px) {
    .error-page__bg { width: 14rem; height: 14rem; right: -3rem; opacity: 0.06; }
  }
  .error-page__inner {
    position: relative; z-index: 1; max-width: 40rem;
  }
  /* V4: use the real official logo mark (696×700) for the brand seal.
     Falls back to the gaurikrit-cow-mark SVG if the PNG is missing. */
  .error-page__seal {
    position: relative;
    width: 4rem; height: 4rem; margin: 0 0 1.5rem;
    display: flex; align-items: center; justify-content: center;
    background: radial-gradient(circle at 50% 45%, #f9f5eb, #e7ebdf);
    border-radius: var(--r-card);
    overflow: hidden;
  }
  .error-page__seal .error-page__seal-img {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 0.375rem;
    z-index: 2;
  }
  .error-page__seal .error-page__seal-fallback {
    position: absolute; inset: 0; z-index: 1;
    display: flex; align-items: center; justify-content: center;
    color: var(--forest);
  }
  .error-page__seal .error-page__seal-fallback svg { width: 70%; height: 70%; }
  .error-page__code {
    font-family: var(--font-display); font-size: clamp(3rem, 10vw, 5.5rem);
    font-weight: 700; color: var(--primary); line-height: 1;
    letter-spacing: -0.02em;
  }
  .error-page__deva {
    font-family: var(--font-deva); font-size: clamp(1.25rem, 2.5vw, 1.625rem);
    color: var(--haldi-deep); margin-top: 0.75rem;
  }
  .error-page__msg {
    font-family: var(--font-display); font-size: clamp(1.5rem, 4vw, 2.25rem);
    margin-top: 1.25rem; color: var(--fg); line-height: 1.2;
    text-wrap: balance;
  }
  .error-page__sub {
    margin-top: 1.25rem; font-size: 1rem; color: var(--fg-muted);
    line-height: 1.7; max-width: 50ch;
  }
  .error-page__actions {
    margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem;
  }
  @media (min-width: 480px) {
    .error-page__actions { flex-direction: row; align-items: center; }
  }
</style>

<section class="error-page bg-limewash" aria-labelledby="error-title">
  <div class="error-page__bg" aria-hidden="true">
    <?php render_illustration('field-botanicals'); ?>
  </div>
  <div class="container">
    <div class="error-page__inner" data-reveal>
      <div class="error-page__seal" aria-hidden="true">
        <img class="error-page__seal-img"
             src="<?= asset_url('/assets/brand/gaurikrit-logo-mark.png') ?>"
             alt=""
             width="696" height="700"
             loading="eager" decoding="async"
             onerror="this.style.visibility='hidden';">
        <span class="error-page__seal-fallback">
          <?php render_illustration('gaurikrit-cow-mark'); ?>
        </span>
      </div>
      <p class="error-page__code">404</p>
      <p class="error-page__deva"><?= e($COMPANY['devanagari']) ?></p>
      <h1 class="error-page__msg" id="error-title">
        This wall hasn't been painted yet.
      </h1>
      <p class="error-page__sub">
        The page you were looking for is not here. The wall it would have
        painted hasn't been finished — or the URL has moved. Head back to the
        Gaurikrit homepage, or explore Prakritik Paint directly.
      </p>
      <div class="error-page__actions">
        <a class="btn btn--primary btn--lg" href="/">Back to Home</a>
        <a class="btn btn--outline" href="/products/">Explore Products</a>
      </div>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
