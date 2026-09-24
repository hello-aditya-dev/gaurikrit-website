<?php
/**
 * Gaurikrit Bio Products — business enquiry API.
 * POST only. Returns JSON. 9 fields, server-side validated.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Method not allowed'], 405);
}

if (!rate_limit('business_' . client_ip(), 5, 60)) {
    json_response(['success' => false, 'error' => 'Too many requests. Please wait a minute.'], 429);
}

$csrf = $_POST['csrf_token'] ?? '';
if (!csrf_verify($csrf)) {
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh the page.'], 403);
}

if (!empty($_POST['company'])) {
    json_response(['success' => true, 'message' => 'Thanks! Our partnerships team will respond within one business day.'], 200);
}

$name           = clean_text($_POST['name'] ?? '', 80);
$organisation   = clean_text($_POST['organisation'] ?? '', 120);
$role           = clean_text($_POST['role'] ?? '', 80);
$phone          = clean_text($_POST['phone'] ?? '', 20);
$email          = clean_text($_POST['email'] ?? '', 254);
$city           = clean_text($_POST['city'] ?? '', 80);
$projectType    = clean_text($_POST['project_type'] ?? '', 50);
$approxReq      = clean_text($_POST['approximate_requirement'] ?? '', 100);
$message        = clean_text($_POST['message'] ?? '', 2000);

$errors = [];
if (mb_strlen($name) < 2) $errors['name'] = 'Please enter your name';
if (!is_valid_email($email)) $errors['email'] = 'Please enter a valid email';
if (mb_strlen($organisation) < 2) $errors['organisation'] = 'Please enter your organisation name';

if (!empty($errors)) {
    json_response(['success' => false, 'error' => 'Validation failed', 'fields' => $errors], 400);
}

$htmlBody = "<html><body style='font-family: sans-serif; color: #1a1a1a;'>
<h2>New business enquiry</h2>
<table cellpadding='8'>
<tr><td><strong>Name:</strong></td><td>" . htmlspecialchars($name) . "</td></tr>
<tr><td><strong>Organisation:</strong></td><td>" . htmlspecialchars($organisation) . "</td></tr>
<tr><td><strong>Role:</strong></td><td>" . htmlspecialchars($role) . "</td></tr>
<tr><td><strong>Phone:</strong></td><td>" . htmlspecialchars($phone) . "</td></tr>
<tr><td><strong>Email:</strong></td><td>" . htmlspecialchars($email) . "</td></tr>
<tr><td><strong>City:</strong></td><td>" . htmlspecialchars($city) . "</td></tr>
<tr><td><strong>Project type:</strong></td><td>" . htmlspecialchars($projectType) . "</td></tr>
<tr><td><strong>Approximate requirement:</strong></td><td>" . htmlspecialchars($approxReq) . "</td></tr>
<tr><td><strong>Message:</strong></td><td>" . nl2br(htmlspecialchars($message)) . "</td></tr>
<tr><td><strong>IP:</strong></td><td>" . htmlspecialchars(client_ip()) . "</td></tr>
<tr><td><strong>Time:</strong></td><td>" . date('Y-m-d H:i:s') . "</td></tr>
</table>
</body></html>";

$textBody = "New business enquiry\n\nName: $name\nOrganisation: $organisation\nRole: $role\nPhone: $phone\nEmail: $email\nCity: $city\nProject type: $projectType\nApproximate requirement: $approxReq\nMessage: $message\nIP: " . client_ip() . "\nTime: " . date('Y-m-d H:i:s');

send_smtp_email(
    $config['mail_to'] ?? 'seva@gaurikrit.com',
    'Business enquiry: ' . $organisation,
    $htmlBody,
    $textBody,
    $config
);

if (!empty($config['db_host'])) {
    try {
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $stmt = $pdo->prepare("INSERT INTO business_enquiries (name, organisation, role, phone, email, city, project_type, approximate_requirement, message, ip, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $organisation, $role, $phone, $email, $city, $projectType, $approxReq, $message, client_ip()]);
    } catch (Throwable $e) {
        error_log("[gaurikrit] DB error: " . $e->getMessage());
    }
}

json_response([
    'success' => true,
    'message' => 'Thanks! Our partnerships team will respond within one business day.',
], 201);
