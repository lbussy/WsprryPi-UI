<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>Wsprry Pi</title>
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
</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <span class="navbar-brand">
                <i
                    id="connIcon"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="Disconnected."
                    class="fa-solid fa-tower-broadcast"></i>
                Wsprry Pi
            </span>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav"
                aria-controls="mainNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Navbar List Items -->
                <ul class="navbar-nav ms-auto align-items-center">
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
                    <!-- Wsprry Pi Documentation (GitHub) -->
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

    <!-- Main Content -->
    <div class="container my-5">
        <div class="card shadow-sm">

            <!-- Alert container for reboot or shutdown -->
            <div id="alertContainer"></div>

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <!-- Card Title -->
                <span>Configuration for: <?php echo gethostname(); ?></span>

                <!-- Break after title on XS only -->
                <div class="w-100 d-sm-none"></div>

                <!-- Group wrapper: Icons + Clocks -->
                <div class="d-flex flex-wrap align-items-center group-wrapper">
                    <!-- icons -->
                    <div class="icons-wrapper d-flex align-items-center mb-2 mb-sm-0 me-sm-3">
                        <!-- Reboot button with extra right margin -->
                        <button
                            type="button"
                            id="rebootButton"
                            class="btn btn-link text-body p-0 custom-tooltip me-2"
                            data-bs-toggle="tooltip"
                            title="Reboot">
                            <i class="fa-solid fa-rotate-right fa-lg"></i>
                        </button>

                        <!-- Shutdown button -->
                        <button
                            type="button"
                            id="shutdownButton"
                            class="btn btn-link text-body p-0 custom-tooltip"
                            data-bs-toggle="tooltip"
                            title="Shutdown">
                            <i class="fa-solid fa-power-off fa-lg"></i>
                        </button>
                    </div>

                    <!-- Break between icons and times on XS only -->
                    <div class="w-100 d-sm-none"></div>

                    <!-- Local and UTC Times -->
                    <div class="times-wrapper small mb-2 mb-sm-0">
                        <!-- Local Time Line -->
                        <div class="time-line d-flex align-items-center">
                            <span class="time-label">Local Time:</span>
                            <span class="time-value" id="localTime">--:--:--</span>
                        </div>
                        <!-- UTC Time Line -->
                        <div class="time-line d-flex align-items-center">
                            <span class="time-label">UTC Time:</span>
                            <span class="time-value" id="utcTime">--:--:--</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form id="wsprform" class="needs-validation" novalidate>

                    <!-- Section 1: Transmission Control -->
                    <fieldset class="mb-4">
                        <legend>Transmission Control</legend>
                        <div class="row gx-3">

                            <!-- Left column: transmit switch -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch form-check-reverse mb-0">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        data-bs-toggle="tooltip"
                                        title="Enable transmission"
                                        id="transmit">
                                    <label
                                        class="form-check-label mb-0"
                                        for="transmit">
                                        Enable Transmission:
                                    </label>
                                </div>
                            </div>

                            <!-- Right column: switch + label + dropdown -->
                            <div class="col-md-6">
                                <div class="d-flex flex-wrap align-items-center">

                                    <!-- use_led Switch -->
                                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                                        <div class="form-check form-switch form-check-reverse mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                data-bs-toggle="tooltip"
                                                title="Enable LED on transmission"
                                                id="use_led">
                                            <label
                                                class="form-check-label mb-0 ms-2"
                                                for="use_led">
                                                Enable LED:
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Static “LED Pin:” label -->
                                    <label
                                        for="led_pin"
                                        class="form-label mb-0 me-3 mb-2 mb-md-0 text-nowrap">
                                        LED Pin:
                                    </label>

                                    <!-- Dropdown (flex‑grow: fill remaining space) -->
                                    <div class="flex-grow-1 mb-2 mb-md-0">
                                        <div class="dropdown w-100">
                                            <div
                                                class="dropdown w-100 custom-tooltip"
                                                data-bs-toggle="tooltip"
                                                title="Pick which GPIO pin drives the LED">
                                                <button
                                                    id="ledDropdownButton"
                                                    class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    disabled>
                                                    Please select
                                                </button>
                                                <ul class="dropdown-menu bg-body text-body" aria-labelledby="ledDropdownButton">
                                                    <li><button class="dropdown-item" data-val="GPIO17">GPIO17 (Pin 11)</button></li>
                                                    <li><button class="dropdown-item" data-val="GPIO18">GPIO18 (Pin 12 - TAPR default))</button></li>
                                                    <li><button class="dropdown-item" data-val="GPIO21">GPIO21 (Pin 13)</button></li>
                                                    <li><button class="dropdown-item" data-val="GPIO22">GPIO22 (Pin 15)</button></li>
                                                    <li><button class="dropdown-item" data-val="GPIO23">GPIO23 (Pin 16)</button></li>
                                                    <li><button class="dropdown-item" data-val="GPIO24">GPIO24 (Pin 18)</button></li>
                                                    <li><button class="dropdown-item" data-val="GPIO25">GPIO25 (Pin 22)</button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </fieldset>

                    <!-- Section 2: Operator Information -->
                    <fieldset class="mb-4">
                        <legend>Operator Information</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="callsign" class="form-label mb-0">
                                            Call Sign:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="callsign"
                                            class="form-control"
                                            minlength="3"
                                            maxlength="6"
                                            data-bs-toggle="tooltip"
                                            title="1-3 letters/digits, then one digit (0-9), then 1-4 letters/digits.  Max 6 characters"
                                            pattern="^[A-Za-z0-9]{1,3}[0-9][A-Za-z0-9]{1,4}$"
                                            required />
                                        <div class="valid-feedback">Ok</div>
                                        <div class="invalid-feedback">Enter a valid callsign, max 6 characters.</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Right column -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="gridsquare" class="form-label mb-0">
                                            Grid Square:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="gridsquare"
                                            class="form-control"
                                            data-bs-toggle="tooltip"
                                            title="Enter exactly 2 letters followed by 2 digits (e.g. FN20)"
                                            pattern="^[A-Za-z]{2}[0-9]{2}$"
                                            required />
                                        <div class="valid-feedback">Ok</div>
                                        <div class="invalid-feedback">Enter exactly 2 letters followed by 2 digits (e.g. FN20).</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 3: Transmitter Information -->
                    <fieldset class="mb-4">
                        <legend>Transmitter Information</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column: label + text input -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="dbm" class="form-label mb-0">
                                            Transmit Power in dBm:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="dbm"
                                            class="form-control"
                                            pattern="^(?:0|3|7|10|13|17|20|23|27|30|33|37|40|43|47|50|53|57|60)$"
                                            data-bs-toggle="tooltip"
                                            title="Valid dBm are one of: 0, 3, 7, 10, 13, 17, 20, 23, 27, 30, 33, 37, 40, 43, 47, 50, 53, 57, or 60"
                                            required />
                                        <div class="valid-feedback">Ok</div>
                                        <div class="invalid-feedback">Enter a valid dBm value, see documentation.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right column: label + text input, then switch + label -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="frequencies" class="form-label mb-0">
                                            Frequencies:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="frequencies"
                                            class="form-control"
                                            required />
                                        <div class="valid-feedback">Ok</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <div class="form-check form-switch form-check-reverse mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch" data-bs-toggle="tooltip"
                                                title="Add a random offset to frequencies"
                                                id="useoffset" />
                                            <label
                                                class="form-check-label mb-0"
                                                for="useoffset">
                                                Randomize:
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 4: Frequency Calibration -->
                    <fieldset class="mb-4">
                        <legend>Frequency Calibration</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column: switch with label on its left -->
                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check form-switch form-check-reverse mb-0">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        data-bs-toggle="tooltip"
                                        title="Use NTP for frequency calibration"
                                        id="use_ntp" />
                                    <label
                                        class="form-check-label mb-0"
                                        for="use_ntp">
                                        Use NTP:
                                    </label>
                                </div>
                            </div>

                            <!-- Right column: label + numeric input -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label
                                            for="ppm"
                                            class="form-label mb-0">
                                            PPM Offset:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="number"
                                            id="ppm"
                                            class="form-control"
                                            data-bs-toggle="tooltip"
                                            title="Enter a decimal value between -200.000000 to 200.000000"
                                            min="-200"
                                            max="200"
                                            step="0.000001" />
                                        <div class="valid-feedback">Ok</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 5: Transmit Power -->
                    <fieldset class="mb-4">
                        <legend>Transmit Power</legend>
                        <div class="d-flex justify-content-center align-items-center">
                            <input
                                type="range"
                                id="tx-power-range"
                                class="form-range me-3"
                                style="width: 60%;"
                                min="0"
                                max="7"
                                step="1"
                                value="0" />
                            <label for="tx-power-range" class="form-label small mb-0">
                                <span id="tx-power-range-value" class="small"></span>
                            </label>
                        </div>
                    </fieldset>

                    <!-- Section 6: Hidden fieldset for server settings -->
                    <fieldset class="mb-4">
                        <div id="server-settings" class="d-none">
                            <input type="number" id="web_port" name="web_port" value="" />
                            <input type="number" id="socket_port" name="socket_port" value="" />
                            <input type="checkbox" id="use_shutdown" name="use_shutdown" />
                            <input type="number" id="shutdown_button" name="shutdown_button" value="" />
                        </div>

                        <!-- Section 7: Submit/Cancel -->
                        <fieldset class="mb-4">
                            <div class="d-flex justify-content-center gap-3">
                                <button id="submit" type="submit" class="btn btn-danger">
                                    Save
                                </button>
                                <button id="reset" type="reset" class="btn btn-secondary">
                                    Reset
                                </button>
                            </div>
                        </fieldset>

                </form>
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
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

    <!-- Bootstrap Bundle JS (Includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous">
    </script>

    <!-- Index JavaScript -->
    <script src="index.js"></script>
</body>

</html>