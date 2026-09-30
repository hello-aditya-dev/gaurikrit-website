<?php
/**
 * Gaurikrit Bio Products — business enquiry API.
 *
 * POST only. Returns JSON. Server-side validated. Sends via SMTP.
 *
 * Truthful success/failure:
 *   - If SMTP delivery succeeds -> 201 success.
 *   - If SMTP fails but the DB save succeeds -> 200 success-with-caveat.
 *   - If both fail -> 500 with an actionable error message.
 *
 * NO response-time promises ("within one business day", etc.).
 * NO logs ever include SMTP passwords or base64-encoded credentials.
 *
 * Fields: name, organisation, role, phone, email, city,
 *         interest (must be one of $INTEREST_OPTIONS — V20 §59),
 *         wall_area + paint_format (optional, Eco-Paints interest only),
 *         approximate_requirement, message.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

global $PROJECT_TYPES, $INTEREST_OPTIONS;

// POST only.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Method not allowed'], 405);
}

// Rate limit: 5 submissions per minute per client IP.
if (!rate_limit('business_' . client_ip(), 5, 60)) {
    json_response(['success' => false, 'error' => 'Too many requests. Please wait a minute and try again.'], 429);
}

// CSRF.
$csrf = $_POST['csrf_token'] ?? '';
if (!csrf_verify($csrf)) {
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh the page and try again.'], 403);
}

// Honeypot — if the hidden `company` field is filled, this is a bot.
if (!empty($_POST['company'])) {
    json_response([
        'success' => true,
        'message' => 'Thank you. Your enquiry has been sent.',
    ], 200);
}

// Validate.
$name          = clean_text($_POST['name'] ?? '', 80);
$organisation  = clean_text($_POST['organisation'] ?? '', 120);
$role          = clean_text($_POST['role'] ?? '', 80);
$phone         = clean_text($_POST['phone'] ?? '', 20);
$email         = clean_text($_POST['email'] ?? '', 254);
$city          = clean_text($_POST['city'] ?? '', 80);
// V20 §59: the canonical field is `interest` (slugs from
// $INTEREST_OPTIONS). Legacy `project_type` values are still accepted
// and mapped where possible so no older submission breaks.
$interest      = clean_text($_POST['interest'] ?? '', 50);
$wallArea      = clean_text($_POST['wall_area'] ?? '', 60);
$paintFormat   = clean_text($_POST['paint_format'] ?? '', 30);
$approxReq     = clean_text($_POST['approximate_requirement'] ?? '', 100);
$message       = clean_text($_POST['message'] ?? '', 2000);

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
if ($phone === '') {
    $errors['phone'] = 'Please enter a phone number so Gaurikrit can reach you.';
}
if (mb_strlen($message) < 10) {
    $errors['message'] = 'Please tell us a bit more about the project (at least 10 characters).';
}

// Interest must be one of the canonical $INTEREST_OPTIONS keys (V20 §59).
$interestLabels = $INTEREST_OPTIONS;
if ($interest === '') {
    $interest = clean_text($_POST['project_type'] ?? '', 50); // legacy
}
if ($interest === '') {
    $errors['interest'] = 'Please choose an interest.';
} elseif (isset($interestLabels[$interest])) {
    $interestLabel = $interestLabels[$interest];
} elseif (in_array($interest, $interestLabels, true)) {
    $interestLabel = $interest;                    // legacy label value
} else {
    $errors['interest'] = 'Please choose a valid interest.';
}

// Paint-specific optional fields — only meaningful for paint interests.
$paintInterests = ['eco-paints', 'prakritik-distemper', 'prakritik-emulsion',
                   'bulk-project'];
$isPaintInterest = isset($interestLabels[$interest])
    && in_array($interest, $paintInterests, true);
if (!$isPaintInterest) {
    $wallArea = '';
    $paintFormat = '';
} elseif ($paintFormat !== '' && !in_array($paintFormat, ['distemper', 'emulsion'], true)) {
    $errors['paint_format'] = 'Please choose a valid paint format.';
}

if (!empty($errors)) {
    json_response([
        'success' => false,
        'error'   => 'Please review the form and try again.',
        'fields'  => $errors,
    ], 400);
}

// Compose email bodies.
$htmlBody = "<html><body style='font-family: sans-serif; color: #1a1a1a;'>\n"
    . "<h2>New business enquiry</h2>\n"
    . "<table cellpadding='8' cellspacing='0' border='0'>\n"
    . "<tr><td><strong>Name:</strong></td><td>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Organisation:</strong></td><td>" . htmlspecialchars($organisation, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Role:</strong></td><td>" . htmlspecialchars($role, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Phone:</strong></td><td>" . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Email:</strong></td><td>" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>City:</strong></td><td>" . htmlspecialchars($city, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Interest:</strong></td><td>" . htmlspecialchars(($interestLabel ?? $interest), ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . (($wallArea !== '') ? "<tr><td><strong>Wall area:</strong></td><td>" . htmlspecialchars($wallArea, ENT_QUOTES, 'UTF-8') . "</td></tr>\n" : '')
    . (($paintFormat !== '') ? "<tr><td><strong>Paint format:</strong></td><td>" . htmlspecialchars(ucfirst($paintFormat), ENT_QUOTES, 'UTF-8') . "</td></tr>\n" : '')
    . "<tr><td><strong>Approximate requirement:</strong></td><td>" . htmlspecialchars($approxReq, ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Message:</strong></td><td>" . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . "</td></tr>\n"
    . "<tr><td><strong>IP:</strong></td><td>" . htmlspecialchars(client_ip(), ENT_QUOTES, 'UTF-8') . "</td></tr>\n"
    . "<tr><td><strong>Time:</strong></td><td>" . date('Y-m-d H:i:s') . "</td></tr>\n"
    . "</table>\n"
    . "</body></html>";

$textBody = "New business enquiry\n\n"
    . "Name: $name\n"
    . "Organisation: $organisation\n"
    . "Role: $role\n"
    . "Phone: $phone\n"
    . "Email: $email\n"
    . "City: $city\n"
    . "Interest: " . ($interestLabel ?? $interest) . "\n"
    . (($wallArea !== '') ? "Wall area: $wallArea\n" : '')
    . (($paintFormat !== '') ? "Paint format: " . ucfirst($paintFormat) . "\n" : '')
    . "Approximate requirement: $approxReq\n"
    . "Message: $message\n"
    . "IP: " . client_ip() . "\n"
    . "Time: " . date('Y-m-d H:i:s');

// Attempt SMTP delivery. Capture the boolean result.
$mailSent = send_smtp_email(
    $config['mail_to'] ?? 'seva@gaurikrit.com',
    'Business enquiry: ' . ($organisation !== '' ? $organisation : $name),
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
            "INSERT INTO business_enquiries
                (name, organisation, role, phone, email, city,
                 project_type, approximate_requirement, message, ip, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->execute([
            $name, $organisation, $role, $phone, $email, $city,
            ($interestLabel ?? $interest), $approxReq, $message, client_ip(),
        ]);
        $dbSaved = true;
    } catch (Throwable $e) {
        $safeMsg = $e->getMessage();
        $safeMsg = preg_replace('/\/\/[^@]*@/', '//***:***@', $safeMsg) ?? $safeMsg;
        error_log("[gaurikrit] business DB error: " . $safeMsg);
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

json_response([
    'success' => false,
    'error'   => 'We could not submit your enquiry right now. Please contact Gaurikrit directly by phone or email.',
], 500);
