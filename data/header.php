<?php
// Determine the current page (just the filename)
$current = basename($_SERVER['PHP_SELF']); // e.g. "index.php" or "view_logs.php"

// Decide what the “other” page should be
if ($current === 'index.php') {
    $pageTitle  = 'Wsprry Pi Configuration';
} elseif ($current === 'view_logs.php') {
    $pageTitle  = 'Wsprry Pi Logs';
} else {
    // Fallback
    $pageTitle  = 'Wsprry Pi Configuration';
}
?>

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
    href="https://bootswatch.com/5/zephyr/bootstrap.css"
    integrity="sha384-NHWyek2/+UCEGytqt3LdAlmA2nC6I48lH+33xH4Dza+2AvurjUKlwW9JHTNwsGtf"
    crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link
    rel="stylesheet"
    href="https://bootswatch.com/_vendor/bootstrap-icons/font/bootstrap-icons.min.css"
    integrity="sha384-sAjZvrYXacB9bJ0LVUOAvlGp7N5A9s6krO+1oZ2bSc1hG7q3UpoTU50kWYTKDOQC"
    crossorigin="anonymous">

<!-- Font Awesome Icons -->
<script
    src="https://kit.fontawesome.com/fdd3893553.js"
    integrity="sha384-+++8TXp9TZMh80HGzzFeldmyu8eR0SVvDtvl0/2ZR7KrcYeaeJmF7cHiucBesDyu"
    crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>

<link rel="stylesheet" href="site.css" />