<?php
/**
 * Gaurikrit Bio Products — contact form API.
 * POST only. Returns JSON. Validates server-side, sends via SMTP.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

// POST only.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Method not allowed'], 405);
}

// Rate limit.
if (!rate_limit('contact_' . client_ip(), 5, 60)) {
    json_response(['success' => false, 'error' => 'Too many requests. Please wait a minute.'], 429);
}

// CSRF.
$csrf = $_POST['csrf_token'] ?? '';
if (!csrf_verify($csrf)) {
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh the page.'], 403);
}

// Honeypot.
if (!empty($_POST['company'])) {
    json_response(['success' => true, 'message' => 'Thanks! We will reach out within 24 hours.'], 200);
}

// Validate.
$name    = clean_text($_POST['name'] ?? '', 80);
$email   = clean_text($_POST['email'] ?? '', 254);
$phone   = clean_text($_POST['phone'] ?? '', 20);
$interest = clean_text($_POST['interest'] ?? 'General', 30);
$message = clean_text($_POST['message'] ?? '', 2000);

$errors = [];
if (mb_strlen($name) < 2) $errors['name'] = 'Please enter your name';
if (!is_valid_email($email)) $errors['email'] = 'Please enter a valid email';
if (!preg_match('/^[+0-9\s-]*$/', $phone) && $phone !== '') $errors['phone'] = 'Phone can only contain digits, spaces, + and -';
if (mb_strlen($message) < 10) $errors['message'] = 'Please tell us a bit more (min 10 characters)';

// Validate interest is one of the allowed values.
$allowedInterests = ['Distemper', 'Emulsion', 'Partnership', 'General'];
if (!in_array($interest, $allowedInterests, true)) $interest = 'General';

if (!empty($errors)) {
    json_response(['success' => false, 'error' => 'Validation failed', 'fields' => $errors], 400);
}

// Send email.
$htmlBody = "<html><body style='font-family: sans-serif; color: #1a1a1a;'>
<h2>New contact enquiry</h2>
<table cellpadding='8'>
<tr><td><strong>Name:</strong></td><td>" . htmlspecialchars($name) . "</td></tr>
<tr><td><strong>Email:</strong></td><td>" . htmlspecialchars($email) . "</td></tr>
<tr><td><strong>Phone:</strong></td><td>" . htmlspecialchars($phone) . "</td></tr>
<tr><td><strong>Interest:</strong></td><td>" . htmlspecialchars($interest) . "</td></tr>
<tr><td><strong>Message:</strong></td><td>" . nl2br(htmlspecialchars($message)) . "</td></tr>
<tr><td><strong>IP:</strong></td><td>" . htmlspecialchars(client_ip()) . "</td></tr>
<tr><td><strong>Time:</strong></td><td>" . date('Y-m-d H:i:s') . "</td></tr>
</table>
</body></html>";

$textBody = "New contact enquiry\n\nName: $name\nEmail: $email\nPhone: $phone\nInterest: $interest\nMessage: $message\nIP: " . client_ip() . "\nTime: " . date('Y-m-d H:i:s');

$mailSent = send_smtp_email(
    $config['mail_to'] ?? 'seva@gaurikrit.com',
    'Contact enquiry: ' . $name,
    $htmlBody,
    $textBody,
    $config
);

// Optional DB storage.
if (!empty($config['db_host'])) {
    try {
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $stmt = $pdo->prepare("INSERT INTO contact_enquiries (name, email, phone, interest, message, ip, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $phone, $interest, $message, client_ip()]);
    } catch (Throwable $e) {
        error_log("[gaurikrit] DB error: " . $e->getMessage());
    }
}

json_response([
    'success' => true,
    'message' => 'Thanks! Our team will reach out within 24 hours.',
], 201);
