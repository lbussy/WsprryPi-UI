<!--
TODO:
 * Add validation rules
 * Save data
-->

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

    <style>
        /* Center page content between header and footer */

        body {
            padding-top: 56px;
            /* navbar height */
            padding-bottom: 56px;
            /* footer height */
        }
    </style>

    <style>
        /* Create a custom theme toggle */

        /* Custom form input */
        input#themeToggle.form-check-input {
            position: relative !important;
            width: 1.60rem !important;
            /* Match Bootstrap’s switch width */
            height: .87rem !important;
            /* Match Bootstrap’s switch height */
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.5rem !important;
            margin-left: auto;
            /* Preserve centering in your layout */
        }

        /* Draw our own thumb */
        input#themeToggle.form-check-input::before {
            content: "" !important;
            position: absolute !important;
            top: 0.0rem !important;
            /* Vertically center */
            left: 0.68rem !important;
            /* Start at left */
            width: .75rem !important;
            /* Thumb size */
            height: .75rem !important;
            background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
            border-radius: 50% !important;
            transition: transform .15s ease-in-out !important;
        }

        /* Move thumb to the right when checked */
        input#themeToggle.form-check-input:checked::before {
            transform: translateX(calc(100% - 1.37rem)) !important;
        }

        /* Keep the focus ring */
        input#themeToggle.form-check-input:focus {
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25) !important;
        }

        /* Make the Dark/Light label match Bootstrap’s nav‑link color */
        .navbar .form-check-label {
            color: var(--bs-nav-link-color) !important;
            margin-bottom: 0 !important;
        }

        /* Vertically center the switch and its label in the navbar */
        .navbar .form-check.form-switch {
            display: flex;
            align-items: center;
        }

        /* Make sure the label has no extra bottom margin */
        .navbar .form-check-label {
            margin-bottom: 0 !important;
        }

        /* Remove default left‑padding so our inline‑flex aligns perfectly */
        .form-check.form-switch.d-inline-flex {
            padding-left: 0;
            padding-right: 0;
        }

        /* Style the label */
        .navbar .form-check-label.toggle-text {
            display: inline-block;
            width: 5ch;
            /* Enough room for “Light” (5 letters) */
            text-align: right;
        }
    </style>

    <style>
        /* Card padding and columns gutter */

        /* Widen the horizontal padding of the card */
        .card .card-body {
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
        }

        /* Increase horizontal gutter between all columns inside card-body */
        .card .card-body .row {
            --bs-gutter-x: 2rem;
            /* Default is 1rem */
        }
    </style>

    <style>
        /* Time block styles */

        /* Smaller text in time block */
        .card-header .text-end.small {
            font-size: 0.75rem !important;
        }

        /* Make the card‑header a bit less tall */
        .card-header {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
            /* keep left/right padding if you like */
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        /* Remove any extra gap around the time block */
        .card-header .time-block {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2;
            /* tighten up the line spacing */
        }

        /* Reduce the margins around the time */
        .card-header .time-block>div {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Set width of time block */
        .card-header .time-block {
            /* width to fit “Local Time: 00:00:00” */
            flex: 0 0 27ch;
            width: 27ch;
            /* optional: use monospace so digits align perfectly */
            /* font-family: monospace; */
        }

        /* Highlight the reboot/shutdown buttons on hover */
        .card-header .btn-link:hover {
            color: var(--bs-nav-link-hover-color) !important;
            background-color: rgba(var(--bs-nav-link-hover-color-rgb), .1) !important;
            text-decoration: none;
            /* or underline if you’d like */
            cursor: pointer;
        }
    </style>

    <style>
        /* Footer size styling */

        /* Make footer text extra small */
        footer .container {
            font-size: 0.75rem;
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
        }
    </style>

    <style>
        /* LED Pin Drop-down Styling */

        /* Position of dropdown */
        #ledDropdownButton {
            position: relative;
            /* keep your arrow‑positioning context */
            padding: 0.375rem 2.5rem;
            /* restore Bootstrap’s default top/bottom padding, only extend right padding */
            line-height: 1.5;
            /* match Bootstrap’s default button line‑height */
        }

        /* Position of Arrow */
        #ledDropdownButton.dropdown-toggle::after {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            float: none;
            /* cancel default float */
            margin: 0;
            /* remove Bootstrap’s default margin-left */
        }

        /* Min height */
        #ledDropdownButton {
            min-height: calc(1rem * 1.5 + 0.375rem * 2) !important;
        }

        /* Width auto-sizes to column */
        #ledDropdownButton+.dropdown-menu {
            /* let the menu auto‐size to its contents */
            width: auto !important;
            min-width: max-content !important;
        }

        /* Ensure items don’t clip or wrap prematurely */
        #ledDropdownButton+.dropdown-menu .dropdown-item {
            white-space: nowrap;
        }

        /* make the outline‑button use body color all the time */
        #ledDropdownButton.btn-outline-secondary {
            color: var(--bs-body-color) !important;
            border-color: var(--bs-body-color) !important;
            background-color: transparent !important;
            /* keep it “outline” */
        }

        /* only invert colors on hover/focus */
        #ledDropdownButton.btn-outline-secondary:hover,
        #ledDropdownButton.btn-outline-secondary:focus {
            background-color: var(--bs-body-color) !important;
            color: var(--bs-body-bg) !important;
            border-color: var(--bs-body-color) !important;
        }

        /* ensure your menu items also follow body‑color */
        .dropdown-menu.bg-body.text-body .dropdown-item {
            color: var(--bs-body-color) !important;
        }

        .dropdown-menu.bg-body.text-body .dropdown-item:hover,
        .dropdown-menu.bg-body.text-body .dropdown-item:focus {
            background-color: rgba(var(--bs-body-color-rgb), .1) !important;
            color: var(--bs-body-color) !important;
        }
    </style>

    <style>
        /* Strip Bootstrap’s validation ring on switches */

        .form-check-input.is-valid,
        .form-check-input.is-invalid,
        .was-validated .form-check-input:valid,
        .was-validated .form-check-input:invalid {
            /* remove the colored ring */
            box-shadow: none !important;
            /* leave the track & thumb alone! */
            border-color: inherit !important;
        }

        /* Don’t recolor their labels either */
        .form-check-input.is-valid~.form-check-label,
        .form-check-input.is-invalid~.form-check-label,
        .was-validated .form-check-input:valid~.form-check-label,
        .was-validated .form-check-input:invalid~.form-check-label {
            color: inherit !important;
        }
    </style>

    <style>
        /* Form Validation Location */

        /* keep this *after* your other validation rules */
        .position-relative {
            position: relative;
            /* your existing */
            padding-bottom: 1.5em;
            /* reserve one line’s worth of room */
        }

        .position-relative .valid-feedback,
        .position-relative .invalid-feedback {
            position: absolute;
            bottom: 0;
            /* sit at the very bottom of the wrapper */
            left: 0;
            /* flush with the left edge */
            width: 100%;
            margin: 0;
            padding: 0;
            visibility: hidden;
            padding-left: 1.5rem;
            /* reserve that much space on the left */
            /* hide by default */
        }

        /* show exactly one message in that same line */
        .form-control.is-valid~.valid-feedback,
        .was-validated .form-control:valid~.valid-feedback {
            visibility: visible;
        }

        .form-control.is-invalid~.invalid-feedback,
        .was-validated .form-control:invalid~.invalid-feedback {
            visibility: visible;
        }

        /* hide them entirely when disabled */
        .form-control:disabled~.valid-feedback,
        .form-control:disabled~.invalid-feedback {
            visibility: hidden;
        }
    </style>

</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-tower-broadcast"></i>
                Wsprry Pi
            </a>
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

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <!-- Card Title -->
                <span>Configuration for: <?php echo gethostname(); ?></span>

                <!-- Break after title on XS only -->
                <div class="w-100 d-sm-none"></div>

                <!-- Group wrapper: Icons + Clocks -->
                <div class="d-flex flex-wrap align-items-center group-wrapper">
                    <!-- icons -->
                    <div class="icons-wrapper d-flex align-items-center mb-2 mb-sm-0 me-sm-3">
                        <form action="semaphore.php" method="post" class="d-inline-block me-2">
                            <input type="hidden" name="action" value="reboot">
                            <button
                                type="submit"
                                class="btn btn-link text-body p-0 custom-tooltip"
                                data-bs-toggle="tooltip"
                                title="Reboot"><i class="fa-solid fa-rotate-right fa-lg"></i></button>
                        </form>
                        <form action="semaphore.php" method="post" class="d-inline-block">
                            <input type="hidden" name="action" value="shutdown">
                            <button
                                type="submit"
                                class="btn btn-link text-body p-0 custom-tooltip"
                                data-bs-toggle="tooltip"
                                title="Shutdown"><i class="fa-solid fa-power-off fa-lg"></i></button>
                        </form>
                    </div>

                    <!-- Break between icons and times on XS only -->
                    <div class="w-100 d-sm-none"></div>

                    <!-- Local and UTC Times -->
                    <div class="times-wrapper text-end small mb-2 mb-sm-0">
                        <div id="localTime">Local Time: --:--:--</div>
                        <div id="utcTime">UTC Time: --:--:--</div>
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
                                            <button
                                                id="ledDropdownButton"
                                                class="btn btn-outline-secondary dropdown-toggle w-100 text-start text‐body"
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
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
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
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
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
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
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
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <div class="form-check form-switch form-check-reverse mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
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
                                        id="use_ntp"
                                        required />
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
                                            min="-200"
                                            max="200"
                                            step="0.000001"
                                            required />
                                        <div class="valid-feedback">Valid</div>
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

                    <!-- Section 6: Submit/Cancel -->
                    <fieldset class="mb-4">
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-danger">
                                Save
                            </button>
                            <button type="reset" class="btn btn-secondary">
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

    <script>
        // Force validation event on page locale_get_default

        document.addEventListener('DOMContentLoaded', function() {
            populateConfig();
            updateWsprryPiVersion();
            updateWSPRNetLink();
        });
    </script>

    <script>
        // Power Slider

        // Lookup table
        var rangeValues = {
            "0": "2mA<br/>3.0dBm",
            "1": "4mA<br/>6.0dBm",
            "2": "6mA<br/>7.8dBm",
            "3": "8mA<br/>9.0dBm",
            "4": "10mA<br/>10.0dBm",
            "5": "12mA<br/>10.8dBm",
            "6": "14mA<br/>11.5dBm",
            "7": "16mA<br/>12.0dBm"
        };

        // Update function
        function updateTxPowerLabel() {
            var val = this.value;
            var label = rangeValues[val] || val;
            $('#tx-power-range-value').html(label);
        }

        // Bind & trigger on page load
        $(function() {
            var $slider = $('#tx-power-range');
            $slider.on('input', updateTxPowerLabel);
            // Set initial value
            updateTxPowerLabel.call($slider.get(0));
        });
    </script>

    <script>
        // Theme toggle control

        $(function() {
            const toggle = $('#themeToggle');
            const label = $('#themeToggleLabel');

            // Helper to set label based on checked state
            function updateLabel(isDark) {
                label.text(isDark ? 'Dark' : 'Light');
            }

            // On load: Read stored theme (default to light)
            const stored = localStorage.getItem('theme') || 'light';
            const isDark = stored === 'dark';
            toggle.prop('checked', isDark);
            document.documentElement.setAttribute('data-bs-theme', stored);
            updateLabel(isDark);

            // On change: Toggle theme, persist, and update label
            toggle.on('change', function() {
                const newTheme = this.checked ? 'dark' : 'light';
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateLabel(this.checked);
            });
        });
    </script>

    <script>
        // Handle clocks

        function updateClocks() {
            const now = new Date();
            // Format HH:MM:SS
            const pad = n => String(n).padStart(2, '0');
            const local = [now.getHours(), now.getMinutes(), now.getSeconds()]
                .map(pad).join(':');
            const utc = [now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds()]
                .map(pad).join(':');
            document.getElementById('localTime').textContent = `Local Time: ${local}`;
            document.getElementById('utcTime').textContent = `UTC Time:   ${utc}`;
        }
        updateClocks();
        setInterval(updateClocks, 1000);
    </script>

    <script>
        // Turn on Bootstrap tooltips

        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        // LED Enable and Dropdown

        (function() {
            const switchEl = document.getElementById('use_led');
            const btn = document.getElementById('ledDropdownButton');
            const items = document.querySelectorAll('.dropdown-item');

            // 1) Sync enabled/disabled state & clear label when off
            function sync() {
                const on = switchEl.checked;
                btn.disabled = !on;
                if (!on) {
                    // leave the placeholder in place
                    // btn.textContent = '';   // ← remove or comment out this line
                }
            }
            switchEl.addEventListener('change', sync);
            sync(); // initial on-load

            // 2) When an item is clicked, set button to only the raw code
            items.forEach(item => {
                item.addEventListener('click', function(e) {
                    const code = item.getAttribute('data-val');
                    btn.textContent = code;
                });
            });
        })();
    </script>

    <script>
        // Form Validation

        $(function() {
            const $form = $('#wsprform');
            // pick up only the real form controls (text, number, select, etc.)
            const $fields = $form.find('.form-control')
                .not('[type="range"], .form-check-input');

            // validate on blur or input
            $fields.on('blur input', function() {
                const el = this;
                const $el = $(el);
                if (el.checkValidity()) {
                    $el.removeClass('is-invalid').addClass('is-valid');
                } else {
                    $el.removeClass('is-valid').addClass('is-invalid');
                }
            });

            // on submit, check each field and prevent submission if any are invalid
            $form.on('submit', function(e) {
                let allValid = true;
                $fields.each(function() {
                    if (!this.checkValidity()) {
                        $(this).addClass('is-invalid');
                        allValid = false;
                    }
                });
                if (!allValid) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        });
    </script>

    <script>
        $(function() {
            const $ntp = $('#use_ntp');
            const $ppm = $('#ppm');

            function syncFromNtp() {
                const useNtp = $ntp.is(':checked');
                $ppm.prop('disabled', useNtp);
                // When disabling PPM we should also clear it & reset validation
                if (useNtp) {
                    $ppm.val('').removeClass('is-valid is-invalid');
                    $ppm.prop('required', false);
                } else {
                    $ppm.prop('required', true);
                }
            }

            // Bind event
            $ntp.on('change', syncFromNtp);

            // Initialize on page load
            syncFromNtp();
        });
    </script>

    <script>
        // Data Load

        var settings_url = window.location.pathname.replace(/\/[^\/]*$/, '/wsprrypi_config.php');
        var version_url = window.location.pathname.replace(/\/[^\/]*$/, '/version.php');
        var populateConfigRunning = false;

        function populateConfig(callback = null) {
            if (populateConfigRunning) return;
            populateConfigRunning = true;

            $.getJSON(settings_url)
                .done(function(configJson) {
                    try {
                        if (!configJson || typeof configJson !== "object") {
                            throw new Error("Invalid JSON data received.");
                        }

                        // Assign values from JSON to form elements
                        //
                        // [Control]
                        $('#transmit').prop('checked', configJson["Control"]["Transmit"]);
                        // [Common]
                        $('#callsign').val(configJson["Common"]["Call Sign"]);
                        $('#gridsquare').val(configJson["Common"]["Grid Square"]);
                        $('#dbm').val(configJson["Common"]["TX Power"]);
                        $('#frequencies').val(configJson["Common"]["Frequency"]);
                        // [Extended]
                        // Safely retrieve and parse the PPM value
                        let ppmValue = parseFloat(configJson?.["Extended"]?.["PPM"]);

                        // Check if ppmValue is a valid number, otherwise default to 0.0
                        if (isNaN(ppmValue)) {
                            ppmValue = 0.0;
                        }

                        // Assign the valid double value to the input field
                        $('#ppm').val(ppmValue.toFixed(2)); // Formats as a decimal (e.g., 3.14)
                        $('#use_ntp').prop('checked', configJson["Extended"]["Use NTP"]);
                        $('#useoffset').prop('checked', configJson["Extended"]["Offset"]);
                        $('#use_led').prop('checked', configJson["Extended"]["Use LED"]);
                        setGPIOSelect(configJson["Extended"]["LED Pin"]);
                        $('#power_level').val(configJson["Extended"]["Power Level"]).change();
                        // [Server]
                        $('#web_port').val(configJson["Server"]["Web Port"]);
                        $('#socket_port').val(configJson["Server"]["Socket Port"]);
                        $('#use_shutdown').val(configJson["Server"]["Use Shutdown"]);
                        $('#shutdown_button').val(configJson["Server"]["Shutdown Button"]);

                        // Enable or disable PPM based on NTP setting
                        $('#ppm').prop("disabled", $('#use_ntp').is(":checked"));

                        // Enable the form
                        $('#submit').prop("disabled", false);
                        $('#reset').prop("disabled", false);
                        $('#wsprconfig').prop("disabled", false);

                        // Validate Fields
                        validatePage();

                        // Run callback if provided
                        if (typeof callback === "function") {
                            callback();
                        }
                    } catch (error) {
                        alert("Unable to parse data.");
                        console.error("Error parsing config JSON:", error);
                        setTimeout(populateConfig, 10000);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Unable to retrieve data.");
                    console.error("Error fetching config JSON:", textStatus, errorThrown);
                    setTimeout(populateConfig, 10000);
                })
                .always(function() {
                    populateConfigRunning = false;
                });
        };

        function updateWSPRNetLink() {
            const baseUrl = "https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall=";
            const $link = $('#wsprnet-link');
            const $text = $link.find('.ms-2');
            const $cs = $('#callsign');
            const callsign = $cs.val().trim();

            if ($cs[0].checkValidity() && callsign !== "") {
                $link
                    .attr('href', baseUrl + encodeURIComponent(callsign))
                    .attr('title', `${callsign} on WSPRNet`);
                $text.text(`${callsign} on WSPRNet`);
            } else {
                $link
                    .attr('href', baseUrl)
                    .attr('title', 'WSPR Spot Database');
                $text.text('WSPRNet Database');
            }
        }

        // Call update WSPRNet database link update whenever the callsign changes
        $('#callsign').on('input blur', updateWSPRNetLink);

        function savePage() {
            if (!validatePage()) {
                alert("Please correct the errors on the page.");
                return false;
            }

            $('#submit').prop("disabled", true);
            $('#reset').prop("disabled", true);

            var Control = {
                "Transmit": $('#transmit').is(":checked"),
            };

            var Common = {
                "Call Sign": $('#callsign').val(),
                "Grid Square": $('#gridsquare').val(),
                "TX Power": parseInt($('#dbm').val()),
                "Frequency": $('#frequencies').val(),
            };

            var Extended = {
                "PPM": parseFloat($('#ppm').val()),
                "Use NTP": $('#use_ntp').is(":checked"),
                "Offset": $('#useoffset').is(":checked"),
                "Use LED": $('#use_led').is(":checked"),
                "LED Pin": parseInt(getGPIONumber()),
                "Power Level": parseInt($('#power_level').val()),
            };

            var Server = {
                "Web Port": $('#web_port').val(),
                "Socket Port": $('#socket_port').val(),
                "Use Shutdown": $('#use_shutdown').val(),
                "Shutdown Button": $('#shutdown_button').val(),
            };

            var Config = {
                Control,
                Common,
                Extended,
                Server,
            };
            var json = JSON.stringify(Config);

            $.ajax({
                    url: settings_url,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: json,
                })
                .done(function(data) {
                    // Ok
                })
                .fail(function(xhr) {
                    alert("Settings update failed with status: " + xhr.status, xhr.responseText);
                })
                .always(function() {
                    setTimeout(() => {
                        $('#submit').prop("disabled", false);
                        $('#reset').prop("disabled", false);
                    }, 500);
                });
        }

        function resetPage() {
            // Disable Form
            $('#submit').prop("disabled", false);
            $('#reset').prop("disabled", false);
            $('#wsprconfig').prop("disabled", true);
            populateConfig();
        };

        /**
         * Read the current LED‐pin selection out of your custom dropdown.
         * @returns {number|null} the pin number, e.g. 18, or null if nothing selected
         */
        function getGPIONumber() {
            const txt = $('#ledDropdownButton').text().trim();
            const m = txt.match(/\d+/);
            return m ? parseInt(m[0], 10) : null;
        }

        /**
         * Programmatically select a pin in your custom dropdown.
         * @param {number} gpioNumber  e.g. 18
         */
        function setGPIOSelect(gpioNumber) {
            const code = 'GPIO' + gpioNumber;
            const $btn = $('#ledDropdownButton');
            const $item = $(`.dropdown-item[data-val="${code}"]`);
            if ($item.length) {
                $btn.text(code);
            } else {
                console.warn('GPIO value not found:', code);
            }
        }

        function updateWsprryPiVersion() {
            $.getJSON(version_url)
                .done(function(response) {
                    if (response && response.wspr_version) {
                        let versionText = response.wspr_version;

                        // Update with version
                        let versionElement = document.getElementById("wspr-version");

                        if (versionElement) {
                            versionElement.textContent = versionText;
                        }
                    } else {
                        console.error("Invalid JSON format from version.");
                    }
                })
                .fail(function() {
                    console.error("Error fetching WSPR version.");
                });
        }

        function validatePage() {
            const form = document.getElementById('wsprform');
            form.classList.add('was-validated');

            // ONLY the .form-control elements (no switches, ranges, etc)
            form.querySelectorAll('.form-control:not(.form-check-input)')
                .forEach(ctrl => {
                    if (ctrl.checkValidity()) {
                        ctrl.classList.add('is-valid');
                    } else {
                        ctrl.classList.add('is-invalid');
                    }
                });
        }
    </script>
</body>

</html>