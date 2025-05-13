<?php

declare(strict_types=1);

// Enable error reporting for debugging
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Always return JSON
header('Content-Type: application/json; charset=UTF-8');

// ─── Validate required parameters ───────────────────────────
$txSign = $_GET['tx_sign'] ?? '';
$start  = $_GET['start']   ?? '';
$end    = $_GET['end']     ?? '';

if (trim($txSign) === '' || trim($start) === '' || trim($end) === '') {
    // Missing required parameter(s): return empty JSON array
    echo json_encode([]);
    exit;
}

// Sanitize and normalize tx_sign
$txSign = strtoupper($txSign);
$txSign = preg_replace('/[^A-Z0-9*%]/', '', $txSign);

// Validate start/end format "YYYY-MM-DD HH:MM:SS"
$tsRegex = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
if (!preg_match($tsRegex, $start) || !preg_match($tsRegex, $end)) {
    echo json_encode([]);
    exit;
}

// ─── Read optional parameters with defaults ────────────────
$ttl        = isset($_GET['ttl'])          ? (int) $_GET['ttl']         : 120;
$windowHrs  = isset($_GET['window_hours'])  ? (int) $_GET['window_hours'] : 2;
$rxSign     = isset($_GET['rx_sign'])      ? strtoupper($_GET['rx_sign']) : '%';
$rxSign     = preg_replace('/[^A-Z0-9*%]/', '', $rxSign);
$format     = isset($_GET['format'])       ? $_GET['format']           : 'JSON Rows';

// ─── Prepare cache paths ───────────────────────────────────
$cacheDir   = __DIR__ . '/cache';
$cacheFile  = sprintf(
    '%s/wspr_spots_%s_%s.json',
    $cacheDir,
    $txSign,
    md5($start . '|' . $end)
);
$now        = time();

// Ensure cache directory exists
if (!is_dir($cacheDir) && !mkdir($cacheDir, 0755, true)) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot create cache directory']);
    exit;
}

// Serve from cache if still fresh
if (file_exists($cacheFile) && ($now - filemtime($cacheFile) < $ttl)) {
    readfile($cacheFile);
    exit;
}

// ─── Build remote URL ──────────────────────────────────────
$query = http_build_query([
    'start'   => $start,
    'end'     => $end,
    'tx_sign' => $txSign,
    'rx_sign' => $rxSign,
    'format'  => $format,
]);
$url = 'https://wspr.live/wspr_downloader.php?' . $query;

// ─── Fetch from remote with timeout ────────────────────────
$ctxOpts = [
    'http' => [
        'method'  => 'GET',
        'timeout' => 20,
    ]
];
$ctx      = stream_context_create($ctxOpts);
$response = @file_get_contents($url, false, $ctx);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'Fetch failed']);
    exit;
}

// ─── Check HTTP status from headers ───────────────────────
$status = 0;
if (
    isset($http_response_header[0]) &&
    preg_match('#HTTP/\S+\s+(\d+)#', $http_response_header[0], $m)
) {
    $status = (int)$m[1];
}
if ($status !== 200) {
    http_response_code(502);
    echo json_encode(['error' => "Remote HTTP status $status"]);
    exit;
}

// ─── Cache & output the fresh result ──────────────────────
@file_put_contents($cacheFile, $response);
echo $response;
