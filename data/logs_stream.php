<?php
// logs_stream.php

// Tell the browser this is an SSE stream
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// If the connection ever drops, retry after 10 000 ms (10 s)
echo "retry: 10000\n\n";

// What the browser last got (if any)
$lastId = isset($_SERVER['HTTP_LAST_EVENT_ID'])
    ? (int) $_SERVER['HTTP_LAST_EVENT_ID']
    : -1;

// Which files to follow
$files = [
    'info'  => '/var/log/wsprrypi/wsprrypi_log',
    'error' => '/var/log/wsprrypi/wsprrypi_error',
];

// Start tail - we’ll still ask for 500 lines on a fresh connect…
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
$id        = 0;    // our own incremental event counter

while (!feof($proc)) {
    // keep‐alive every 30 s
    if (time() - $lastPing >= 30) {
        echo ": keep-alive\n\n";
        @ob_flush();
        @flush();
        $lastPing = time();
    }

    $line = fgets($proc);
    if ($line === false) {
        usleep(100000);
        continue;
    }

    // Detect “==> filename <==” headings from tail -F
    if (preg_match('/^==> (.+) <==$/', trim($line), $m)) {
        $current = array_search($m[1], $files, true) ?: null;
        continue;
    }

    // skip the error file entirely if you want
    if ($current === 'error') {
        continue;
    }

    // we’re about to send one real event, so bump our counter
    $id++;

    // if this ID was already sent last time, drop it
    if ($id <= $lastId) {
        continue;
    }

    // package up the event
    $payload = [
        'stream'    => $current,
        'timestamp' => microtime(true),
        'line'      => rtrim($line),
    ];
    $data = json_encode($payload);

    // here’s the SSE ID plus the data
    echo "id: {$id}\n";
    echo "data: {$data}\n\n";

    @ob_flush();
    @flush();
}

pclose($proc);
