<?php
$logDir = "/var/log/wsprrypi"; // Prepend this path (no trailing slash)

$shortName = $_GET['logFile']; // Log file to get = ?logFile={foo}
$logPath = $logDir . "/" . $shortName;
$thisDirName = dirname(realpath($logPath));

if ($thisDirName == $logDir) {
    if (is_file($logPath)) {
        $logData = file_get_contents($logPath);
        $logArray = explode("\n", $logData); // Split on newline
        $data = array();
        foreach ($logArray as $logLine) {
            $entries = explode("\t", $logLine);
            $data[] = array(
                'timestamp' => trim($entries[0]),
                'logentry' => trim($entries[1])
            );
        }
        $json = json_encode($data);
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo $json;
    } else {
        http_response_code(406);
    }
} else {
    http_response_code(403);
}
?>
