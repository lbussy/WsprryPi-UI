<?php
// Tell the browser to keep the HTTP connection open
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Paths to your two logs
$files = [
    'info'  => '/var/log/wsprrypi/wsprrypi_log',
    'error' => '/var/log/wsprrypi/wsprrypi_error',
];

// Build a tail command that follows both files and prints headers
$cmd = 'tail -n 10 -F '
    . implode(' ', array_map('escapeshellarg', $files));
$proc = popen($cmd, 'r');
if (!$proc) {
    http_response_code(500);
    echo "data: {\"error\":\"Cannot open tail process\"}\n\n";
    exit;
}

$current = null;
while (!feof($proc)) {
    $line = fgets($proc);
    if ($line === false) {
        usleep(100000);
        continue;
    }

    // Detect “==> filename <==” headings from tail -F
    if (preg_match('/^==> (.+) <==$/', trim($line), $m)) {
        // figure out which key it is (info or error)
        $path = $m[1];
        $current = array_search($path, $files, true) ?: null;
        continue;
    }

    if ($current) {
        // build a small JSON payload
        $payload = json_encode([
            'stream' => $current,
            'line'   => rtrim($line),
        ]);
        echo "data: {$payload}\n\n";
        @ob_flush();
        @flush();
    }
}

pclose($proc);
