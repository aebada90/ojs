<?php

declare(strict_types=1);

/**
 * Keyed deploy helper for Hostinger when FTP data channels are flaky.
 * Lives in public_html; writes into public_html/laravel.
 *
 * Set OKTOBER_DEPLOY_KEY in the server environment when possible.
 */

$key = $_GET['key'] ?? $_POST['key'] ?? '';
$expected = getenv('OKTOBER_DEPLOY_KEY') ?: '';
if ($expected === '' || ! hash_equals($expected, (string) $key)) {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

$rel = (string) ($_GET['path'] ?? $_POST['path'] ?? '');
$url = (string) ($_GET['url'] ?? $_POST['url'] ?? '');

if ($rel === '' || $url === '' || str_contains($rel, '..') || str_contains($rel, "\0")) {
    http_response_code(400);
    echo 'path+url required';
    exit;
}

if (! preg_match('#^https://raw\.githubusercontent\.com/aebada90/ojs/#', $url)) {
    http_response_code(400);
    echo 'url host not allowed';
    exit;
}

$root = is_dir(__DIR__.'/laravel') ? (__DIR__.'/laravel') : __DIR__;
$target = rtrim($root, '/').'/'.ltrim($rel, '/');
$dir = dirname($target);
if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
    http_response_code(500);
    echo 'mkdir failed';
    exit;
}

$ctx = stream_context_create([
    'http' => [
        'timeout' => 60,
        'header' => "User-Agent: oktoberhub-deploy-pull\r\n",
    ],
]);
$data = @file_get_contents($url, false, $ctx);
if ($data === false) {
    http_response_code(502);
    echo 'fetch failed';
    exit;
}

if (file_put_contents($target, $data) === false) {
    http_response_code(500);
    echo 'write failed';
    exit;
}

echo 'OK '.$rel.' '.strlen($data)."\n";
