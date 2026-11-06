<?php
/**
 * Receives the "Request a quotation" form.
 *
 * Saves each enquiry to data/enquiries.csv, then emails it. The saved copy is
 * what counts as success, so an enquiry survives a mail server problem.
 *
 * Answers with JSON for the page's JavaScript. Without JavaScript it stores the
 * result in the session and redirects back to the form.
 */

require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/mailer.php';

start_session();

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

/** Send the result to the visitor and stop. */
function respond(bool $ok, string $message, array $errors = [], array $old = [], int $status = 200): never
{
    global $wantsJson;

    if ($wantsJson) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message, 'errors' => (object) $errors]);
        exit;
    }

    $_SESSION['enquiry_result'] = ['ok' => $ok, 'message' => $message, 'errors' => $errors, 'old' => $old];
    header('Location: index.php#contact', true, 303);
    exit;
}

/** Read a posted text field. Line breaks are kept only when $multiline is true. */
function field(string $name, bool $multiline = false): string
{
    $value = $_POST[$name] ?? '';
    if (!is_string($value)) {
        return '';
    }
    $pattern = $multiline ? '/[^\P{Cc}\n]/u' : '/\p{Cc}/u';
    $value   = str_replace("\r\n", "\n", $value);

    return trim((string) preg_replace($pattern, ' ', $value));
}

/** Stop spreadsheet programs treating a saved value as a formula. */
function csv_safe(string $value): string
{
    return preg_match('/^[=+\-@]/', $value) ? "'" . $value : $value;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php#contact', true, 303);
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (!is_string($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    respond(false, 'Your session has expired. Please reload the page and send your enquiry again.', status: 403);
}

// Hidden field that people never see but spam bots fill in. Report success so
// the bot moves on, and save nothing.
if (field('website') !== '') {
    respond(true, 'Thank you. Our team will get back to you shortly.');
}

$enquiry = [
    'name'         => field('name'),
    'organisation' => field('organisation'),
    'phone'        => field('phone'),
    'service'      => field('service'),
    'requirement'  => field('requirement', true),
];

$errors = [];

$nameLength = mb_strlen($enquiry['name'], 'UTF-8');
if ($nameLength < 2 || $nameLength > 100) {
    $errors['name'] = 'Please enter your full name.';
}
if (mb_strlen($enquiry['organisation'], 'UTF-8') > 150) {
    $errors['organisation'] = 'Please keep this under 150 characters.';
}
if (!preg_match('/^\+?[0-9][0-9 ()\-]{5,20}$/', $enquiry['phone'])
    || strlen((string) preg_replace('/\D/', '', $enquiry['phone'])) < 7) {
    $errors['phone'] = 'Please enter a valid phone number.';
}
if (!in_array($enquiry['service'], array_column($services, 'title'), true)) {
    $errors['service'] = 'Please choose a service.';
}
if (mb_strlen($enquiry['requirement'], 'UTF-8') > 2000) {
    $errors['requirement'] = 'Please keep this under 2000 characters.';
}

if ($errors) {
    respond(false, 'Please check the highlighted fields.', $errors, $enquiry, 422);
}

$submittedAt = date('Y-m-d H:i:s');

// Save the enquiry.
$file = @fopen(ENQUIRY_FILE, 'c+b');
if ($file === false || !flock($file, LOCK_EX)) {
    error_log('Enquiry form: cannot open ' . ENQUIRY_FILE);
    respond(false, 'Sorry, we could not send your enquiry. Please call us on ' . PHONE_DISPLAY . '.', old: $enquiry, status: 500);
}

fseek($file, 0, SEEK_END);
if (ftell($file) === 0) {
    fwrite($file, "\xEF\xBB\xBF"); // Lets Excel read the file as UTF-8.
    fputcsv($file, ['Date', 'Name', 'Organisation', 'Phone', 'Service', 'Requirement'], ',', '"', '');
}
$row = array_map('csv_safe', [$enquiry['name'], $enquiry['organisation'], $enquiry['phone'], $enquiry['service'], $enquiry['requirement']]);
fputcsv($file, [$submittedAt, ...$row], ',', '"', '');
flock($file, LOCK_UN);
fclose($file);

// Email it. A failure here is logged, because the enquiry is already saved.
$body = "New enquiry from the website\n\n"
    . "Date: {$submittedAt}\n"
    . "Name: {$enquiry['name']}\n"
    . 'Organisation: ' . ($enquiry['organisation'] ?: '-') . "\n"
    . "Phone: {$enquiry['phone']}\n"
    . "Service: {$enquiry['service']}\n\n"
    . "Requirement:\n" . ($enquiry['requirement'] ?: '-') . "\n";

try {
    send_mail(ENQUIRY_EMAIL, 'New website enquiry: ' . $enquiry['service'], $body);
} catch (Throwable $error) {
    error_log('Enquiry form: email could not be sent (' . $error->getMessage() . '). The enquiry was saved to ' . ENQUIRY_FILE);
}

respond(true, 'Thank you, ' . $enquiry['name'] . '. Our team will get back to you with a deployment plan.');
