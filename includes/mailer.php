<?php
/**
 * Sends plain-text email through the SMTP server set in config.php.
 */

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

/**
 * Send an email from SMTP_USER. Throws an exception explaining what went wrong
 * if the password file is missing or the server refuses the message.
 */
function send_mail(string $to, string $subject, string $body): void
{
    $password = is_file(SMTP_PASSWORD_FILE) ? require SMTP_PASSWORD_FILE : '';
    if (!is_string($password) || $password === '') {
        throw new RuntimeException('SMTP password not set. Create ' . SMTP_PASSWORD_FILE . ' from smtp-password.example.php.');
    }

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->Port       = SMTP_PORT;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = $password;
    $mail->Timeout    = 15;
    $mail->CharSet    = PHPMailer::CHARSET_UTF8;

    $mail->setFrom(SMTP_USER, SITE_NAME);
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
}
