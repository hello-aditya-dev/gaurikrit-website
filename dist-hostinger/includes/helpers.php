<?php
/**
 * Gaurikrit Bio Products — helpers.
 * Pure functions, no side effects beyond asset emission.
 */

declare(strict_types=1);

/**
 * Emit a versioned asset URL using filemtime for cache-busting.
 *   asset_url('/assets/css/app.css')
 *   => '/assets/css/app.css?v=1719123456'
 */
function asset_url(string $path): string
{
    $full = ROOT_PATH . $path;
    if (is_file($full)) {
        return $path . '?v=' . (string) filemtime($full);
    }
    return $path;
}

/**
 * HTML-escape a string for output.
 */
function e(string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/**
 * Generate a CSRF token, storing it in the session.
 * Returns the token. Use csrf_field() to emit the hidden input.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Emit a hidden CSRF input field.
 */
function csrf_field(): string
{
    $token = csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
}

/**
 * Verify a submitted CSRF token against the session.
 */
function csrf_verify(string $submitted): bool
{
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $submitted);
}

/**
 * Render a coded SVG illustration partial.
 *   render_illustration('indian-cow', ['class' => 'hero-cow'])
 */
function render_illustration(string $name, array $attrs = []): void
{
    $file = INCLUDES_PATH . '/illustrations/' . $name . '.php';
    if (!is_file($file)) {
        return;
    }
    // Pass attributes as variables to the partial.
    $__attrs = $attrs;
    unset($attrs);
    extract($__attrs, EXTR_SKIP);
    include $file;
}

/**
 * JSON response helper for API endpoints.
 */
function json_response(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Validate an email address strictly.
 */
function is_valid_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false
        && strlen($email) <= 254;
}

/**
 * Sanitize a text input (trim + strip tags + length cap).
 */
function clean_text(string $value, int $max = 2000): string
{
    $value = trim($value);
    $value = strip_tags($value);
    return mb_substr($value, 0, $max);
}

/**
 * Get client IP (for rate limiting / logging).
 */
function client_ip(): string
{
    $fwd = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    if ($fwd) {
        $parts = explode(',', $fwd);
        return trim($parts[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

/**
 * Simple in-memory rate limiter using a temp file.
 * Returns true if allowed, false if rate-limited.
 */
function rate_limit(string $key, int $max = 5, int $windowSec = 60): bool
{
    $file = sys_get_temp_dir() . '/gk_rl_' . md5($key);
    $now = time();
    $data = ['count' => 0, 'reset' => $now + $windowSec];
    if (is_file($file)) {
        $raw = file_get_contents($file);
        if ($raw !== false) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }
    }
    if ($now > ($data['reset'] ?? 0)) {
        $data = ['count' => 0, 'reset' => $now + $windowSec];
    }
    $data['count']++;
    file_put_contents($file, json_encode($data), LOCK_EX);
    return $data['count'] <= $max;
}
