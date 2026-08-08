<?php
// Dev-only router for `php -S`, mimicking the production .htaccess rewrite:
// serve real files/assets as-is, otherwise hand off to the front controller.
// Not used in production (Apache uses public_html/.htaccess instead).

$docRoot = __DIR__ . '/public_html';
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = $docRoot . $path;

if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // let the built-in server serve it directly
}

require $docRoot . '/index.php';
