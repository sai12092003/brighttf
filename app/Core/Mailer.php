<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Minimal mail sender. On cPanel, PHP's built-in mail() works out of the box
 * via the server's local MTA. Locally (or whenever mail() is unavailable),
 * notifications are appended to storage/logs/mail.log instead of failing.
 */
final class Mailer
{
    public static function send(string $to, string $subject, string $body): bool
    {
        $fromAddress = config('mail.from_address');
        $fromName = config('mail.from_name');

        if (config('app.env') !== 'production') {
            self::logToFile($to, $subject, $body);
            return true;
        }

        $headers = "From: {$fromName} <{$fromAddress}>\r\n";
        $headers .= "Reply-To: {$fromAddress}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $sent = @mail($to, $subject, $body, $headers);

        if (!$sent) {
            self::logToFile($to, $subject, $body);
        }

        return $sent;
    }

    private static function logToFile(string $to, string $subject, string $body): void
    {
        $logDir = config('paths.storage') . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $entry = sprintf(
            "[%s] To: %s | Subject: %s\n%s\n%s\n\n",
            date('Y-m-d H:i:s'),
            $to,
            $subject,
            str_repeat('-', 40),
            $body
        );
        file_put_contents($logDir . '/mail.log', $entry, FILE_APPEND);
    }
}
