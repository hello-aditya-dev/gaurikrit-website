<?php
/**
 * Gaurikrit Bio Products — contact form API.
 *
 * POST only. Returns JSON. Server-side validated. Sends via SMTP.
 *
 * Truthful success/failure:
 *   - If SMTP delivery succeeds -> 200/201 success.
 *   - If SMTP fails but the DB save succeeds -> 200 success-with-caveat.
 *   - If both fail -> 500 with an actionable error message.
 *
 * NO response-time promises ("within 24 hours", "one business day").
 * NO logs ever include SMTP passwords or base64-encoded credentials.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

global $INTEREST_OPTIONS;

// POST only.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Method not allowed'], 405);
}

// Rate limit: 5 submissions per minute per client IP.
if (!rate_limit('contact_' . client_ip(), 5, 60)) {
    json_response(['success' => false, 'error' => 'Too many requests. Please wait a minute and try again.'], 429);
}

// CSRF.
$csrf = $_POST['csrf_token'] ?? '';
if (!csrf_verify($csrf)) {
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh the page and try again.'], 403);
}

// Honeypot — if the hidden `company` field is filled, this is a bot.
// Return a generic success toast so the bot operator can't tell the
// submission was discarded.
if (!empty($_POST['company'])) {
    json_response([
        'success' => true,
        'message' => 'Thank you. Your enquiry has been sent.',
    ], 200);
}

// Validate.
$name    = clean_text($_POST['name'] ?? '', 80);
$email   = clean_text($_POST['email'] ?? '', 254);
$phone   = clean_text($_POST['phone'] ?? '', 20);
$interest = clean_text($_POST['interest'] ?? '', 30);
$message = clean_text($_POST['message'] ?? '', 2000);

$errors = [];
if (mb_strlen($name) < 2) {
    $errors['name'] = 'Please enter your name (at least 2 characters).';
}
if (!is_valid_email($email)) {
    $errors['email'] = 'Please enter a valid email address.';
}
if ($phone !== '' && !preg_match('/^[+0-9\s-]+$/', $phone)) {
    $errors['phone'] = 'Phone can only contain digits, spaces, + and -.';
}

// Interest must be one of the 6 canonical values from $INTEREST_OPTIONS.
// If it's empty or invalid, that's a validation error (the form offers a
// dropdown; sending an unknown value indicates tampering).
if ($interest === '') {
    $errors['interest'] = 'Please choose what your enquiry is about.';
} elseif (!array_key_exists($interest, $INTEREST_OPTIONS)) {
    $errors['interest'] = 'Please choose a valid interest option.';
}

if (mb_strlen($message) < 10) {
    $errors['message'] = 'Please tell us a bit more (at least 10 characters).';
}

if (!empty($errors)) {
    json_response([
        'success' => false,
        'error'   => 'Please review the form and try again.',
        'fields'  => $errors,
    ], 400);
}

// Map the canonical interest value to its human-readable label for the
// email body. Falls back to the raw value if the lookup misses (defensive;
// shouldn't happen because of the validation above).
$interestLabel = $INTEREST_OPTIONS[$interest] ?? $interest;

// Compose email bodies.
$htmlBody = "<html><body style='font-family: sans-serif; color: #1a1a1a;'>\n"
    . "<h2>New contact enquiry</h2>\n"
    . "<table cellpadding='8' cellspacing='0' border='0'>\n"
    . "<tr><td><strong>Name:</strong></td><td>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Email:</strong></td><td>" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Phone:</strong></td><td>" . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Interest:</strong></td><td>" . htmlspecialchars($interestLabel, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Message:</strong></td><td>" . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . "</td></tr>\n"
    . "<tr><td><strong>IP:</strong></td><td>" . htmlspecialchars(client_ip(), ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Time:</strong></td><td>" . date('Y-m-d H:i:s') . "</td></tr>\n"
    . "</table>\n"
    . "</body></html>";

$textBody = "New contact enquiry\n\n"
    . "Name: $name\n"
    . "Email: $email\n"
    . "Phone: $phone\n"
    . "Interest: $interestLabel\n"
    . "Message: $message\n"
    . "IP: " . client_ip() . "\n"
    . "Time: " . date('Y-m-d H:i:s');

// Attempt SMTP delivery. Capture the boolean result.
// NOTE: send_smtp_email() NEVER logs the SMTP password or base64-encoded
// credentials — only the exception message (which contains the SMTP
// server's response code/text, not our auth payload).
$mailSent = send_smtp_email(
    $config['mail_to'] ?? 'seva@gaurikrit.com',
    'Contact enquiry: ' . $name,
    $htmlBody,
    $textBody,
    $config
);

// Optional DB storage. Capture the boolean result.
$dbSaved = false;
if (!empty($config['db_host'])) {
    try {
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $stmt = $pdo->prepare(
            "INSERT INTO contact_enquiries
                (name, email, phone, interest, message, ip, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->execute([$name, $email, $phone, $interestLabel, $message, client_ip()]);
        $dbSaved = true;
    } catch (Throwable $e) {
        // Log the message only — never the password or DSN with credentials.
        $safeMsg = $e->getMessage();
        // Strip anything that looks like a connection string with a password.
        $safeMsg = preg_replace('/\/\/[^@]*@/', '//***:***@', $safeMsg) ?? $safeMsg;
        error_log("[gaurikrit] contact DB error: " . $safeMsg);
        $dbSaved = false;
    }
}

// ---- Truthful response ----
if ($mailSent) {
    json_response([
        'success' => true,
        'message' => 'Thank you. Your enquiry has been sent.',
    ], 201);
}

if ($dbSaved) {
    json_response([
        'success' => true,
        'message' => 'Your enquiry was saved. If your request is urgent, please contact Gaurikrit directly by phone or email.',
    ], 200);
}

// Both paths failed — be honest with the user and point them at direct contact.
json_response([
    'success' => false,
    'error'   => 'We could not submit your enquiry right now. Please contact Gaurikrit directly by phone or email.',
], 500);
