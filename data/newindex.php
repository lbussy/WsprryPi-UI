<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wsprry Pi</title>
    <link rel="icon" type="image/x-icon" href="/wsprrypi/favicon.ico">

    <!-- Bootswatch Zephyr CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/zephyr/bootstrap.min.css"
        integrity="sha384-HPa/tOlMXnas1gP9Ryc4FDDdj1v81sgWLIWqibn3RkycHRHzPQJ4RJ3G2BxtKM42"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <!-- Bootstrap Select -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css"
        rel="stylesheet"
        integrity="sha512-g2SduJKxa4Lbn3GW+Q7rNz+pKP9AWMR++Ta8fgwsZRCUsawjPvF/BxSMkGS61VsR9yinGoEgrHPGPn2mrj8+4w=="
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
        /* Ensure page content isn’t covered by the fixed navbar or footer */
        body {
            padding-top: 56px;
            /* navbar height */
            padding-bottom: 56px;
            /* footer height */
        }
    </style>

    <style>
        /* Make room for a validation icon on every form-control */
        .form-control {
            padding-right: 2.5rem;
        }

        /* Any container with a validation icon must be position-relative */
        .position-relative .valid-icon,
        .position-relative .invalid-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            display: none;
            pointer-events: none;
        }

        /* Show the right icon based on is-valid / is-invalid */
        .form-control.is-valid+.valid-icon {
            display: block;
        }

        .form-control.is-invalid+.invalid-icon {
            display: block;
        }

        /* Show feedback text when in was-validated or using is-valid / is-invalid */
        .was-validated .form-control:valid~.valid-feedback,
        .form-control.is-valid~.valid-feedback {
            display: block;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .form-control.is-invalid~.invalid-feedback {
            display: block;
        }
    </style>

    <style>
        /* Create a custom theme toggle */
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

        /* Style teh label */
        .navbar .form-check-label.toggle-text {
            display: inline-block;
            width: 5ch;
            /* Enough room for “Light” (5 letters) */
            text-align: right;
        }
    </style>

    <style>
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
        /* Make footer text extra small */
        footer .container {
            font-size: 0.75rem;
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
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

                <form class="needs-validation" novalidate>

                    <!-- Section 1 (inline labels & controls) -->
                    <fieldset class="mb-4">
                        <legend>Transmission Control</legend>
                        <div class="row gx-3">
                            <!-- Left column: switch with label on its left -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch form-check-reverse mb-0">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="section1-switch-left">
                                    <label
                                        class="form-check-label mb-0"
                                        for="section1-switch-left">
                                        Enable Transmission:
                                    </label>
                                </div>
                            </div>

                            <!-- Right column: switch + dropdown, with label above dropdown when wrapping -->
                            <div class="col-md-6">
                                <div class="row gx-2 align-items-center">
                                    <!-- Option switch -->
                                    <div class="col-auto d-flex align-items-center mb-2 mb-md-0 me-md-4">
                                        <div class="form-check form-switch form-check-reverse mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="section1-switch-right">
                                            <label
                                                class="form-check-label mb-0"
                                                for="section1-switch-right">
                                                Enable LED:
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Dropdown label: full width on xs/sm, auto width on md+ -->
                                    <div class="col-12 col-md-auto mb-1 mb-md-0">
                                        <label
                                            for="section1-dropdown"
                                            class="form-label mb-0">
                                            LED Pin:
                                        </label>
                                    </div>
                                    <!-- Dropdown select: full width on xs/sm, auto width on md+ -->
                                    <div class="col-12 col-md-auto">
                                        <select
                                            id="gpio_select"
                                            name="gpio"
                                            class="selectpicker"
                                            data-width="100%"
                                            data-live-search="false"
                                            data-show-subtext="false">
                                            <option value="GPIO17" data-content="GPIO17 (Pin 11)">GPIO17</option>
                                            <option value="GPIO18" data-content="GPIO18 (TAPR default Pin 12)">GPIO18</option>
                                            <option value="GPIO21" data-content="GPIO21 (Pin 13)">GPIO21</option>
                                            <option value="GPIO22" data-content="GPIO22 (Pin 15)">GPIO22</option>
                                            <option value="GPIO23" data-content="GPIO23 (Pin 16)">GPIO23</option>
                                            <option value="GPIO24" data-content="GPIO24 (Pin 18)">GPIO24</option>
                                            <option value="GPIO25" data-content="GPIO25 (Pin 22)">GPIO25</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 2 -->
                    <fieldset class="mb-4">
                        <legend>Operator Information</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="section6-field1" class="form-label mb-0">
                                            Call Sign:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section6-field1"
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
                                        <label for="section6-field2" class="form-label mb-0">
                                            Grid Square:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section6-field2"
                                            class="form-control"
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 3 -->
                    <fieldset class="mb-4">
                        <legend>Transmitter Information</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column: label + text input -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="section3-field1" class="form-label mb-0">
                                            Transmit Power in dBm:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section3-field1"
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
                                        <label for="section3-field2" class="form-label mb-0">
                                            Frequencies:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section3-field2"
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
                                                id="section3-switch" />
                                            <label
                                                class="form-check-label mb-0"
                                                for="section3-switch">
                                                Randomize:
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 4 -->
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
                                        id="section4-switch"
                                        required />
                                    <label
                                        class="form-check-label mb-0"
                                        for="section4-switch">
                                        Use NTP:
                                    </label>
                                </div>
                            </div>

                            <!-- Right column: label + numeric input -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label
                                            for="section4-number"
                                            class="form-label mb-0">
                                            PPM Offset:
                                        </label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="number"
                                            id="section4-number"
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

                    <!-- Section 5 -->
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

                    <!-- Section 6 -->
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
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"
        integrity="sha512-yrOmjPdp8qH8hgLfWpSFhC/+R9Cj9USL8uJxYIveJZGAiedxyIxwNw4RsLDlcjNlIRR4kkHaDHSmNHAkxFTmgg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>
    <script>
        $(function() {
            const $form = $('.needs-validation');

            $form.on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $form.addClass('was-validated');
            });

            // Live toggle of is-valid / is-invalid for every form-control
            $form.find('.form-control').on('input', function() {
                const $el = $(this);
                if (this.checkValidity()) {
                    $el.addClass('is-valid').removeClass('is-invalid');
                } else {
                    $el.addClass('is-invalid').removeClass('is-valid');
                }
            });
        });
    </script>
    <script>
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
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $(function() {
            // Call on page load
            $("#gpio_select")
                .selectpicker("val", 18) // sets the <select> and redraws in one go
                .trigger("change"); // optional: still fires your change listeners
        });

        $('.selectpicker').selectpicker({
            showContent: false // only the <option>’s “GPIOXX” value appears in the closed button
        });

        function clickUseLED() {
            if ($('#use_led').is(":checked")) {
                // Enable LED pin when using LED
                $('#gpio_select').prop("disabled", false);
            } else {
                // Disable LED pin when not using LED
                $('#gpio_select').prop("disabled", true);
            }
        };

        function getGPIONumber() {
            let gpioValue = $("#gpio_select").val(); // Get the selected value (e.g., "GPIO17")
            let gpioNumber = gpioValue.match(/\d+/); // Extract numeric portion using regex
            return gpioNumber ? parseInt(gpioNumber[0]) : null; // Convert to integer and return
        };

        function setGPIOSelect(gpioNumber) {
            let gpioValue = "GPIO" + gpioNumber; // Construct the expected value, e.g., "GPIO17"
            // Check if the option exists before setting it
            if ($("#gpio_select option[value='" + gpioValue + "']").length > 0) {
                if ($("#gpio_select option[value='" + gpioValue + "']").length) {
                    $("#gpio_select")
                        .selectpicker("val", gpioValue) // sets the <select> and redraws in one go
                        .trigger("change"); // optional: still fires your change listeners
                }
            } else {
                console.warn("GPIO value not found:", gpioValue);
            }
        };
    </script>

</body>

</html>