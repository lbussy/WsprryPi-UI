<?php

/**
 * -----------------------------------------------------------------------------
 * @file        wsprrypi_config.php
 * @brief       WsprryPi INI Configuration API
 * 
 * @details     This PHP script provides an API for reading and updating the 
 *              WsprryPi INI configuration file. It handles GET requests to 
 *              read the configuration as JSON and PUT/POST requests to update
 *              specific values while preserving the file format, comments, 
 *              and structure.
 * 
 *              The script ensures thread-safe writing, proper error handling,
 *              and logging to Apache's error log for troubleshooting.
 *
 * @usage       - GET:  Retrieve current INI settings as JSON
 *              - POST: Update INI values with a JSON payload
 *              - PUT:  Same as POST but often preferred for RESTful APIs
 *
 * @example     curl -X GET http://localhost/wsprrypi/wsprrypi_config.php
 *              curl -X PUT http://localhost/wsprrypi/wsprrypi_config.php \
 *                   -H "Content-Type: application/json" \
 *                   -d '{"Control": {"Transmit": false}}'
 *
 * @author      Lee C. Bussy (@LBussy)
 * @copyright   Copyright (C) 2023-2025 Lee C. Bussy
 * @license     MIT License
 * -----------------------------------------------------------------------------
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/apache2/error.log');  // Default Apache error log


// Set custom exception handler
set_exception_handler('myException');

$file = realpath(__DIR__ . '/wsprrypi.ini');

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $post = file_get_contents('php://input');

    $data = json_decode($post, true);
    if ($data === null) {
        error_log("JSON Decode Failed: " . json_last_error_msg());
        throw new Exception('Invalid JSON input.');
    }

    if (write_ini_file($file, $data)) {
        header("Cache-Control: no-cache, must-revalidate");
        header("HTTP/1.0 200 OK");
    } else {
        throw new Exception("Failed to write INI file.");
    }
} else {
    read_ini_file($file);
}

/**
 * Reads an INI file and outputs it as JSON.
 *
 * @param string $file The path to the INI file.
 * @throws Exception If the INI file cannot be read or parsed.
 */
function read_ini_file($file)
{
    if (!file_exists($file)) {
        throw new Exception("INI file '$file' not found.");
    }

    $ini_array = parse_ini_file($file, true, INI_SCANNER_TYPED);
    if (!$ini_array) {
        throw new Exception('Unable to read configuration.');
    }

    $json_output = json_encode($ini_array);
    if ($json_output === false) {
        throw new Exception('JSON encoding failed: ' . json_last_error_msg());
    }

    try {
        header("Cache-Control: no-cache, must-revalidate");
        header("HTTP/1.0 200 OK");
        echo $json_output;
    } catch (Exception $e) {
        throw new Exception('Unable to process configuration: ' . $e->getMessage());
    }
}

/**
 * Writes an array to an INI file while preserving comments and formatting.
 *
 * @param string $file The file path.
 * @param array $array The data array.
 * @return bool Returns true on success.
 * @throws Exception If file access or writing fails.
 */
function write_ini_file($file, $array = [])
{
    if (!file_exists($file)) {
        throw new Exception("INI file '$file' not found.");
    }

    $lines = file($file);
    if ($lines === false) {
        throw new Exception('Unable to read the INI file.');
    }

    $output = [];
    $current_section = '';

    foreach ($lines as $line) {
        $trimmed_line = trim($line);

        if (empty($trimmed_line) || $trimmed_line[0] === ';' || $trimmed_line[0] === '#') {
            $output[] = $line;
            continue;
        }

        if ($trimmed_line[0] === '[' && substr($trimmed_line, -1) === ']') {
            $current_section = substr($trimmed_line, 1, -1);
            $output[] = $line;
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            list($key, $value) = array_map('trim', $parts);

            // Update existing values
            if ($current_section && isset($array[$current_section][$key])) {
                $value = $array[$current_section][$key];
                unset($array[$current_section][$key]);
            } elseif (!$current_section && isset($array[$key])) {
                $value = $array[$key];
                unset($array[$key]);
            }

            $output[] = "$key = " . (is_bool($value) ? ($value ? 'true' : 'false') : $value) . PHP_EOL;
        } else {
            $output[] = $line;
        }
    }

    // Append only remaining new keys (not empty sections)
    foreach ($array as $section => $values) {
        if (!empty($values) && is_array($values)) {
            $output[] = "[$section]" . PHP_EOL;
            foreach ($values as $key => $value) {
                $output[] = "$key = " . (is_bool($value) ? ($value ? 'true' : 'false') : $value) . PHP_EOL;
            }
        }
    }

    $fp = fopen($file, 'w');
    if (!$fp) {
        throw new Exception('Unable to open file for writing.');
    }

    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        throw new Exception('Unable to lock file for writing.');
    }

    if (fwrite($fp, implode('', $output)) === false) {
        throw new Exception('Failed to write to INI file.');
    }

    flock($fp, LOCK_UN);
    fclose($fp);

    return true;
}

/**
 * Custom exception handler for returning JSON error responses.
 *
 * @param Exception $exception The exception object.
 */
function myException($exception)
{
    error_log("Exception: " . $exception->getMessage());
    header("Cache-Control: no-cache, must-revalidate");
    header("HTTP/1.0 500 System Error");
    echo json_encode(["error" => $exception->getMessage()]);
}
