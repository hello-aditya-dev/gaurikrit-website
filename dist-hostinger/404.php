<?php
/**
 * Gaurikrit Bio Products — 404.
 */
declare(strict_types=1);

global $COMPANY, $PRODUCTS;

$pageTitle       = "404 — This wall hasn't been painted yet | Gaurikrit";
$pageDescription = "The page you are looking for is not here. Let's get you back to a freshly painted one.";
$pageCanonical   = '/404';
$pageClass       = 'error';
$pageOgType      = 'website';
$httpStatus      = 404;

require_once __DIR__ . '/includes/bootstrap.php';

if (!headers_sent()) {
    http_response_code(404);
}

require ROOT_PATH . '/includes/header.php';
?>
<style>
  .error-illustration { margin-top:2rem; display:flex; align-items:center; justify-content:center; opacity:0.85; }
  .error-illustration svg { max-width:20rem; }
  .error-actions { margin-top:2rem; display:flex; flex-wrap:wrap; gap:0.75rem; justify-content:center; }
  .error-actions a, .error-actions button { min-width:11rem; }
</style>

<section class="error-page" id="error">
    <div class="container">
        <h1 class="error-page__title">404</h1>
        <p class="error-page__msg">This wall hasn't been painted yet.</p>
        <p style="margin-top:1rem; color:var(--fg-muted); max-width:32rem; margin-inline:auto">The page you are looking for might have been moved, renamed, or never existed. Let's get you back to a freshly painted one.</p>
        <div class="error-illustration" aria-hidden="true"><?php render_illustration('paint-brush-stroke'); ?></div>
        <div class="error-actions">
            <a href="/" class="btn btn--primary btn--lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                Back to home
            </a>
            <a href="/products/" class="btn btn--outline btn--lg">Explore products</a>
            <a href="/contact/" class="btn btn--ghost btn--lg">Contact us</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
