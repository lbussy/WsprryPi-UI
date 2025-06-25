<?php
// Determine the current page (just the filename)
$current = basename($_SERVER['PHP_SELF']); // e.g. "index.php" or "view_logs.php"

// Decide what the page title should be
if ($current === 'index.php') {
    $pageTitle  = 'Wsprry Pi Configuration';
} elseif ($current === 'view_logs.php') {
    $pageTitle  = 'Wsprry Pi Logs';
} elseif ($current === 'view_spots.php') {
    $pageTitle  = 'Wsprry Pi Spots';
} else {
    $pageTitle  = 'Wsprry Pi Configuration'; // Fallback
}
?>

<script>
    window.currentPage = '<?= basename($_SERVER['SCRIPT_NAME']) ?>';
</script>

<meta charset="UTF-8" />

<title><?= htmlspecialchars($pageTitle) ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="site.webmanifest">
<link rel="icon" type="image/x-icon" href="favicon.ico">

<!-- Bootswatch Zephyr CSS -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.7/zephyr/bootstrap.min.css"
    integrity="sha512-Lz5ZvfQhGrjnM+ykkCSADHAVbHWx4wGy89UtJTpS70F5ZSbZuL5vzguanjB3rit3GvItlRqgya2E6KRoG5uorw=="
    crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD"
    crossorigin="anonymous">

<!-- Font Awesome Icons -->
<script
    src="https://kit.fontawesome.com/fdd3893553.js"
    integrity="sha384-+++8TXp9TZMh80HGzzFeldmyu8eR0SVvDtvl0/2ZR7KrcYeaeJmF7cHiucBesDyu"
    crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>

<link rel="stylesheet" href="site.css" />