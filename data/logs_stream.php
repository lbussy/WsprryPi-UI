<?php
// logs_stream.php

// Tell the browser this is an SSE stream
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// If the connection ever drops, retry after 10 000 ms (10 s)
echo "retry: 10000\n\n";
@ob_flush();
@flush();

// Which files to follow
$files = [
    'info'  => '/var/log/wsprrypi/wsprrypi_log',
    'error' => '/var/log/wsprrypi/wsprrypi_error',
];

// Start tail-ing both, sending the last 10 lines on connect
$cmd  = 'tail -n 500 -F '
    . implode(' ', array_map('escapeshellarg', $files));
$proc = popen($cmd, 'r');
if (!$proc) {
    http_response_code(500);
    echo "data: {\"error\":\"Cannot start tail process\"}\n\n";
    exit;
}

$current  = null;
$lastPing = time();

while (!feof($proc)) {
    // Every 30 s send a no-op comment to prevent idle timeouts
    if (time() - $lastPing >= 30) {
        echo ": keep-alive\n\n";
        @ob_flush();
        @flush();
        $lastPing = time();
    }

    $line = fgets($proc);
    if ($line === false) {
        // No data right now → wait a bit
        usleep(100000);
        continue;
    }

    // tail -F prints headings “==> /path/to/file <==” when switching
    if (preg_match('/^==> (.+) <==$/', trim($line), $m)) {
        $current = array_search($m[1], $files, true) ?: null;
        continue;
    }

    if ($current) {
        // Wrap it up as JSON with a stream tag
        $data = json_encode([
            'stream'    => $current,
            'timestamp' => microtime(true),
            'line'      => rtrim($line),
        ]);
        echo "data: {$data}\n\n";
        @ob_flush();
        @flush();
    }
}

pclose($proc);
