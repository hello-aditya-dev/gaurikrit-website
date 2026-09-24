<?php
/**
 * Gaurikrit Bio Products — 404 page.
 * Task PAGES-LOCK. Branded "This wall hasn't been painted yet."
 * Link back to /. render_illustration('field-botanicals') accent.
 * Warm and on-brand.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

global $COMPANY;

http_response_code(404);

$pageTitle       = 'Page not found — ' . e($COMPANY['name']) . ' Bio Products';
$pageDescription = 'This wall hasn\'t been painted yet. Return to the Gaurikrit homepage.';
$pageCanonical   = '/404';
$pageClass        = 'error-404';

require ROOT_PATH . '/includes/header.php';
?>
<style>
  .error-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding-block: clamp(3rem, 8vw, 6rem); padding-top: calc(var(--header-h) + 3rem); position: relative; overflow: hidden; }
  .error-page__bg { position: absolute; right: -2rem; top: 50%; transform: translateY(-50%); width: 18rem; height: 18rem; opacity: 0.12; pointer-events: none; color: var(--primary); }
  .error-page__inner { position: relative; z-index: 1; max-width: 40rem; }
  .error-page__seal { width: 4rem; height: 4rem; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; }
  .error-page__code { font-family: var(--font-display); font-size: clamp(3rem, 10vw, 5.5rem); font-weight: 700; color: var(--primary); line-height: 1; letter-spacing: -0.02em; }
  .error-page__msg { font-family: var(--font-display); font-size: clamp(1.25rem, 3vw, 1.875rem); margin-top: 1rem; color: var(--fg); line-height: 1.3; text-wrap: balance; }
  .error-page__sub { margin-top: 1rem; font-size: 0.9375rem; color: var(--fg-muted); line-height: 1.6; }
  .error-page__actions { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; justify-content: center; }
  @media (min-width: 480px) { .error-page__actions { flex-direction: row; align-items: center; justify-content: center; } }
  .error-page__stroke { margin: 2rem auto 0; max-width: 16rem; }
  .error-page__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.25rem, 3vw, 1.75rem); color: var(--haldi-deep); margin-top: 1.5rem; }
</style>

<section class="error-page" id="error-404">
    <div class="error-page__bg" aria-hidden="true"><?php render_illustration('field-botanicals'); ?></div>
    <div class="container error-page__inner" data-reveal>
        <div class="error-page__seal" aria-hidden="true"><?php render_illustration('gaurikrit-cow-mark'); ?></div>
        <div class="error-page__code">404</div>
        <h1 class="error-page__msg">This wall hasn't been painted yet.</h1>
        <p class="error-page__sub">The page you were looking for doesn't exist — or hasn't been built yet. Let's get you back to a painted wall.</p>
        <div class="error-page__actions">
            <a href="/" class="btn btn--primary btn--lg">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to home
            </a>
            <a href="/products/" class="btn btn--outline btn--lg">Explore Prakritik Paint</a>
        </div>
        <div class="error-page__deva" lang="hi"><?= e($COMPANY['devanagari']) ?></div>
        <div class="error-page__stroke" aria-hidden="true"><?php render_illustration('paint-brush-stroke'); ?></div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
