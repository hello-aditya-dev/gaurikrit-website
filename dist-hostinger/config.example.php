<?php
/**
 * Gaurikrit Bio Products — configuration template.
 *
 * Copy this file to config.php and fill in real values.
 * config.php is gitignored — never commit real credentials.
 */

return [
    // SMTP for PHPMailer-style sending (we use a built-in minimal SMTP).
    'smtp_host'     => '',
    'smtp_port'     => 587,
    'smtp_username' => '',
    'smtp_password' => '',
    'smtp_encryption' => 'tls', // 'tls' or 'ssl' or '' for none

    // From / To addresses.
    'mail_from'      => '',
    'mail_from_name' => 'Gaurikrit Bio Products',
    'mail_to'        => 'seva@gaurikrit.com',

    // Optional MySQL storage (leave blank to disable DB; forms still email).
    'db_host'    => '',
    'db_name'    => '',
    'db_user'    => '',
    'db_pass'    => '',

    // Production domain for canonical/sitemap/OG URLs.
    'site_url'   => 'https://gaurikrit.com',

    // Enable debug logging (set false in production).
    'debug'      => false,
];
