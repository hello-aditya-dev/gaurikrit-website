<?php
/**
 * Gaurikrit Bio Products — minimal SMTP mailer.
 *
 * Zero-Composer, zero-dependency. Uses PHP's built-in stream_socket_client +
 * stream_socket_enable_crypto to speak SMTP directly. Works on Hostinger
 * shared hosting without any PECL/Composer packages.
 *
 * Supports: STARTTLS, AUTH LOGIN, plain TLS.
 */

declare(strict_types=1);

class SmtpMailer
{
    private $host;
    private int $port;
    private string $username;
    private string $password;
    private string $encryption;
    private $socket;
    private string $log = '';

    public function __construct(array $config)
    {
        $this->host = $config['smtp_host'] ?? '';
        $this->port = (int)($config['smtp_port'] ?? 587);
        $this->username = $config['smtp_username'] ?? '';
        $this->password = $config['smtp_password'] ?? '';
        $this->encryption = $config['smtp_encryption'] ?? 'tls';
    }

    /**
     * Send an email. Returns true on success, throws on failure.
     */
    public function send(string $to, string $subject, string $htmlBody, string $textBody, string $from, string $fromName): bool
    {
        if ($this->host === '') {
            throw new RuntimeException('SMTP host not configured');
        }

        $this->connect();
        $this->ehlo();
        $this->starttls();
        $this->auth();
        $this->mailFrom($from);
        $this->rcptTo($to);
        $this->data($to, $subject, $htmlBody, $textBody, $from, $fromName);
        $this->quit();
        $this->disconnect();

        return true;
    }

    private function connect(): void
    {
        $remote = ($this->encryption === 'ssl' ? 'ssl://' : '') . $this->host . ':' . $this->port;
        $this->socket = @stream_socket_client(
            $remote,
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT
        );
        if (!$this->socket) {
            throw new RuntimeException("SMTP connect failed: $errstr ($errno)");
        }
        stream_set_timeout($this->socket, 30);
        $this->expect(220);
    }

    private function ehlo(): void
    {
        $this->send("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        $this->expect(250);
    }

    private function starttls(): void
    {
        if ($this->encryption === 'tls') {
            $this->send("STARTTLS");
            $this->expect(220);
            if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException("TLS enable failed");
            }
            // Re-EHLO after TLS.
            $this->send("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
            $this->expect(250);
        }
    }

    private function auth(): void
    {
        if ($this->username === '') return;
        $this->send("AUTH LOGIN");
        $this->expect(334);
        $this->send(base64_encode($this->username));
        $this->expect(334);
        $this->send(base64_encode($this->password));
        $this->expect(235);
    }

    private function mailFrom(string $from): void
    {
        $this->send("MAIL FROM:<$from>");
        $this->expect(250);
    }

    private function rcptTo(string $to): void
    {
        $this->send("RCPT TO:<$to>");
        $this->expect(250);
    }

    private function data(string $to, string $subject, string $htmlBody, string $textBody, string $from, string $fromName): void
    {
        $this->send("DATA");
        $this->expect(354);

        $boundary = uniqid('gk_boundary_', true);
        $headers = [
            "From: {$fromName} <{$from}>",
            "To: <{$to}>",
            "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=",
            "MIME-Version: 1.0",
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
            "Date: " . date(DATE_RFC2822),
            "Message-ID: <" . uniqid('gk_', true) . "@" . ($_SERVER['SERVER_NAME'] ?? 'localhost') . ">",
        ];

        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($textBody)) . "\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($htmlBody)) . "\r\n";
        $body .= "--{$boundary}--\r\n";

        $this->send(implode("\r\n", $headers) . "\r\n\r\n" . $body . ".");
        $this->expect(250);
    }

    private function quit(): void
    {
        $this->send("QUIT");
    }

    private function disconnect(): void
    {
        if ($this->socket) {
            fclose($this->socket);
            $this->socket = null;
        }
    }

    private function send(string $cmd): void
    {
        $this->log .= "→ $cmd\r\n";
        fwrite($this->socket, $cmd . "\r\n");
    }

    private function expect(int $code): string
    {
        $response = '';
        while (substr($response, 3, 1) !== ' ') {
            $response = fgets($this->socket, 4096);
            if ($response === false) break;
            $this->log .= "← $response";
        }
        $got = (int) substr($response, 0, 3);
        if ($got !== $code) {
            throw new RuntimeException("SMTP expected $code, got $got: $response");
        }
        return $response;
    }

    public function getLog(): string
    {
        return $this->log;
    }
}

/**
 * Send an email using the configured SMTP credentials.
 * Falls back gracefully if SMTP is not configured (logs but doesn't throw).
 */
function send_smtp_email(string $to, string $subject, string $htmlBody, string $textBody, array $config): bool
{
    if (empty($config['smtp_host'])) {
        // SMTP not configured — log and return false (form still shows success to avoid enumeration).
        error_log("[gaurikrit] SMTP not configured — email not sent to $to");
        return false;
    }

    try {
        $mailer = new SmtpMailer($config);
        $from = $config['mail_from'] ?? '';
        $fromName = $config['mail_from_name'] ?? 'Gaurikrit';
        $mailer->send($to, $subject, $htmlBody, $textBody, $from, $fromName);
        return true;
    } catch (Throwable $e) {
        error_log("[gaurikrit] SMTP error: " . $e->getMessage());
        return false;
    }
}
