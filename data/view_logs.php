<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>Wsprry Pi Logs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="icon" type="image/x-icon" href="/wsprrypi/favicon.ico">

    <!-- Bootswatch Zephyr CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/zephyr/bootstrap.min.css"
        integrity="sha384-HPa/tOlMXnas1gP9Ryc4FDDdj1v81sgWLIWqibn3RkycHRHzPQJ4RJ3G2BxtKM42"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        integrity="sha384-Ay26V7L8bsJTsX9Sxclnvsn+hkdiwRnrjZJXqKmkIDobPgIIWBOVguEcQQLDuhfN"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <!-- Font Awesome Icons -->
    <script
        src="https://kit.fontawesome.com/fdd3893553.js"
        integrity="sha384-+++8TXp9TZMh80HGzzFeldmyu8eR0SVvDtvl0/2ZR7KrcYeaeJmF7cHiucBesDyu"
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>

    <!-- Index CSS -->
    <link rel="stylesheet" href="index.css" />

    <!-- Index CSS -->
    <link rel="stylesheet" href="view_logs.css" />
</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <span class="navbar-brand">
                <i id="connIcon" data-bs-toggle="tooltip" data-bs-original-title="Disconnected."
                    class="fa-solid fa-tower-broadcast"></i>
                Wsprry Pi Logs
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Navbar List Items -->
                <ul class="navbar-nav ms-auto align-items-center">

                    <!-- Wsprry Pi Config -->
                    <li class="nav-item">
                        <a
                            class="nav-link custom-tooltip"
                            href="index.php"
                            target="_self"
                            rel="noopener"
                            data-bs-toggle="tooltip"
                            title="WSPR Config">
                            <i class="fa-solid fa-wrench"></i>
                            <span class="ms-2">WSPR Config</span>
                        </a>
                    </li>
                    <!-- Wsprry Pi Documentation (ReadTheDocs) -->
                    <li class="nav-item">
                        <a
                            class="nav-link custom-tooltip"
                            href="https://wsprry-pi.readthedocs.io/en/latest/"
                            target="_blank"
                            rel="noopener"
                            data-bs-toggle="tooltip"
                            title="Wsprry Pi Documentation">
                            <i class="fa-solid fa-books fa-lg"></i>
                            <span class="ms-2">Documentation</span>
                        </a>
                    </li>
                    <!-- Wsprry Pi Repo (GitHub) -->
                    <li class="nav-item">
                        <a
                            class="nav-link custom-tooltip d-flex align-items-center"
                            href="https://github.com/lbussy/wsprrypi"
                            target="_blank"
                            rel="noopener"
                            data-bs-toggle="tooltip"
                            title="Wsprry Pi on GitHub">
                            <i class="fa-brands fa-github fa-lg"></i>
                            <span class="ms-2">GitHub</span>
                        </a>
                    </li>
                    <!-- TAPR -->
                    <li class="nav-item">
                        <a
                            class="nav-link custom-tooltip"
                            href="https://tapr.org/"
                            target="_blank"
                            rel="noopener"
                            data-bs-toggle="tooltip"
                            title="TAPR">
                            <i class="fa-solid fa-cactus fa-lg"></i>
                            <span class="ms-2">TAPR</span>
                        </a>
                    </li>
                    <!-- WSPRNet Database -->
                    <li class="nav-item">
                        <a
                            class="nav-link custom-tooltip"
                            href="https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall="
                            target="_blank"
                            rel="noopener"
                            data-bs-toggle="tooltip"
                            id="wsprnet-link"
                            title="WSPRNet Database">
                            <i class="fa-solid fa-database fa-lg"></i>
                            <span class="ms-2">WSPRNet Database</span>
                        </a>
                    </li>
                    <!-- Theme dark/light toggle -->
                    <li class="nav-item ms-3">
                        <div
                            class="form-check form-switch d-inline-flex align-items-center mb-0 text-white"
                            style="gap: .5rem;">
                            <label
                                class="form-check-label mb-0 toggle-text"
                                for="themeToggle"
                                id="themeToggleLabel"
                                data-bs-toggle="tooltip"
                                title="Change Theme">Dark</label>
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="themeToggle"
                                data-bs-toggle="tooltip"
                                title="Change Theme">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Logs Here -->
    <div class="container my-5">
        <div class="card shadow-sm logs-card mt-5">

            <div class="card-header d-flex flex-wrap align-items-center">
                <!-- 1) Label (never shrinks) -->
                <span class="me-2 flex-shrink-0">
                    Logs for: <?php echo gethostname(); ?>
                </span>

                <!-- break between label and tabs on mobile (<md) -->
                <div class="w-100 d-md-none"></div>

                <!-- Pushes controls to the right on desktop) -->
                <ul class="nav nav-tabs flex-shrink-1 me-auto" role="tablist">
                </ul>

                <!-- break between tabs and controls on mobile (<md) -->
                <div class="w-100 d-md-none"></div>

                <!-- 3) Controls (never shrinks) -->
                <div class="d-flex align-items-center flex-shrink-0">
                    <!-- Reboot / Shutdown buttons -->
                    <button id="rebootButton" class="btn btn-link p-0 me-2" title="Reboot">
                        <i class="fa-solid fa-rotate-right fa-lg"></i>
                    </button>
                    <button id="shutdownButton" class="btn btn-link p-0 me-3" title="Shutdown">
                        <i class="fa-solid fa-power-off fa-lg"></i>
                    </button>
                    <!-- Clocks -->
                    <div class="small text-end">
                        <div>
                            <span class="time-label">Local:</span>
                            <span class="time-value" id="localTime">--:--:--</span>
                        </div>
                        <div>
                            <span class="time-label">UTC:</span>
                            <span class="time-value" id="utcTime">--:--:--</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body tab-content">
                <div
                    id="info-pane"
                    class="tab-pane fade show active"
                    role="tabpanel"
                    aria-labelledby="info-tab">
                    <div id="info" class="pane info">
                        <!-- live INFO logs append here -->
                    </div>
                </div>

                <!-- Hidden fieldset to hold settings -->
                <div id="server-settings" class="d-none">
                    <input type="text" id="callsign" name="callsign" value="" />
                </div>
            </div>

        </div>
    </div>

    <!-- Fixed Footer -->
    <footer class="fixed-bottom bg-primary text-white">
        <div class="container text-center small">
            <div>Copyright © 2025 Lee Bussy [AA0NT].</div>

            <div>
                WSPR Version: <span id="wspr-version">Loading version...</span>
            </div>

            <div>Licensed under the MIT License</div>
        </div>
    </footer>

    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
    </script>

    <!-- Bootstrap Bundle JS (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <!-- Log Viewer JS -->
    <script src="view_logs.js"></script>

</body>

</html>