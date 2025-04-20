<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wsprry Pi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css"
        rel="stylesheet"
        integrity="sha512-g2SduJKxa4Lbn3GW+Q7rNz+pKP9AWMR++Ta8fgwsZRCUsawjPvF/BxSMkGS61VsR9yinGoEgrHPGPn2mrj8+4w=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .custom-navbar {
            position: fixed;
            /* Fix to top */
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            border-bottom: 2px solid #343a40;
            z-index: 1030;
        }

        .custom-navbar .card-body {
            padding: 0.5rem 1rem;
        }

        .navbar-logo {
            width: 30px;
            height: 30px;
        }

        .navbar-nav .nav-link {
            transition: color 0.3s ease-in-out;
        }

        body {
            padding-top: 120px;
            padding-bottom: 80px;
        }

        .btn-fafa {
            border: none;
            outline: none;
            background: none;
            cursor: pointer;
            padding: 0;
            text-decoration: none;
            font-family: inherit;
            font-size: inherit;
            color: inherit !important;
        }

        .btn-fafa:hover {
            font-weight: bold;
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }

        .custom-muted {
            color: #5a6268 !important;
            font-weight: normal;
            opacity: 0.85;
        }

        .custom-tooltip .tooltip-inner {
            background-color: #5a189a;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .custom-tooltip.bs-tooltip-top .tooltip-arrow::before,
        .custom-tooltip.bs-tooltip-bottom .tooltip-arrow::before,
        .custom-tooltip.bs-tooltip-start .tooltip-arrow::before,
        .custom-tooltip.bs-tooltip-end .tooltip-arrow::before {
            background-color: #5a189a;
        }

        /* Ensure validation messages always take up space */
        #ppm~.valid-feedback,
        #ppm~.invalid-feedback {
            min-height: 1.5em;
            /* Adjust as needed */
            display: block;
            /* Ensures space is always there */
            visibility: hidden;
            /* Hides it but keeps the space */
        }

        /* Show feedback messages when validation is active */
        #ppm.is-valid~.valid-feedback {
            visibility: visible;
        }

        #ppm.is-invalid~.invalid-feedback {
            visibility: visible;
        }

        /* Ensure validation messages always take up space */
        #use_ntp~.valid-feedback,
        #use_ntp~.invalid-feedback {
            min-height: 1.5em;
            /* Adjust as needed */
            display: block;
            /* Ensures space is always there */
            visibility: hidden;
            /* Hides it but keeps the space */
        }

        /* Match Bootstrap's "is-valid" green color */
        #power_level {
            accent-color: #198754;
            /* Works for modern browsers */
        }

        /* Fallback for older browsers */
        #power_level::-webkit-slider-thumb {
            background-color: #198754;
            /* Green */
            border: 2px solid #145c32;
            /* Darker green border */
        }

        #power_level::-moz-range-thumb {
            background-color: #198754;
            border: 2px solid #145c32;
        }

        #power_level::-ms-thumb {
            background-color: #198754;
            border: 2px solid #145c32;
        }

        /* Reduce spacing in the footer */
        #footer {
            font-size: 0.85rem;
            /* Smaller text */
            line-height: 1.2;
            /* Reduce line spacing */
        }

        /* Reduce padding for compact height */
        #footer .container {
            padding-top: 4px;
            padding-bottom: 4px;
        }
    </style>

</head>

<body>
    <div class="card bg-dark text-white border-dark fixed-top">
        <div class="card-body p-2">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <!-- Logo & Brand -->
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="navbar-brand">
                        <img src="antenna.svg" style="width:30px;height:30px;" alt="Logo" class="me-2" />
                        Wsprry Pi
                    </a>

                    <!-- Navbar Toggler (for mobile) -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navbar Links -->
                    <div class="collapse navbar-collapse custom-muted" id="navbarResponsive">
                        <ul class="navbar-nav"></ul> <!-- Left-side nav (if needed) -->
                        <ul class="navbar-nav ms-md-auto">
                            <li class="nav-item">
                                <a target="_blank" rel="noopener" class="nav-link text-white"
                                    href="https://github.com/lbussy/WsprryPi/">
                                    <i class="fa-brands fa-github"></i>&nbsp;&nbsp;GitHub
                                </a>
                            </li>
                            <li class="nav-item">
                                <a target="_blank" rel="noopener" class="nav-link text-white"
                                    href="http://wsprdocs.aa0nt.net">
                                    <i class="fa-solid fa-book"></i>&nbsp;&nbsp;Documentation
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="card border-dark mb-3">
            <div class="card-header d-flex custom-muted">
                Connected to: <?php echo gethostname(); ?>
                <span class="ms-auto d-flex">
                    <form action="semaphore.php" method="post">
                        <input type="hidden" name="action" value="reboot">
                        <button type="submit" class="btn-fafa me-2 custom-tooltip" data-bs-toggle="tooltip" title="Reboot">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </form>
                    <form action="semaphore.php" method="post">
                        <input type="hidden" name="action" value="shutdown">
                        <button type="submit" class="btn-fafa custom-tooltip" data-bs-toggle="tooltip" title="Shutdown">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                </span>
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Wsprry Pi Configuration</h3>
                    <div class="text-muted small text-end">
                        <span id="localTime"></span><br>
                        <span id="utcTime"></span>
                    </div>
                </div>

                <form id="wsprform">
                    <fieldset id="wsprconfig" class="form-group" disabled="disabled">
                        <!-- First Row -->
                        <legend class="mt-4">Control</legend>
                        <div class="row">
                            <!-- Left Column: Enable Transmission -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100 gx-2 align-items-center">
                                    <!-- Label and Checkbox: Stack on small, side-by-side on larger screens -->
                                    <div class="col-md-4 text-md-end">
                                        <label class="form-check-label" for="transmit">Enable Transmission:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check form-switch was-validated">
                                            <input class="form-check-input" type="checkbox" id="transmit" data-form-type="other">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Enable LED + GPIO Select -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100 gx-2 align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="use_led" class="form-check-label">
                                            Enable LED:
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row gx-2 align-items-center">
                                            <div class="col-auto">
                                                <div class="form-check form-switch was-validated">
                                                    <input class="form-check-input" type="checkbox" id="use_led" data-form-type="other">
                                                </div>
                                            </div>
                                            <div class="col-auto text-md-end">
                                                <label for="gpio_select" class="form-check-label">
                                                    LED Pin:
                                                </label>
                                            </div>
                                            <div class="col-md-8 was-validated">
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
                            </div>
                        </div>
                        <!-- First Row -->

                        <!-- Second Row -->
                        <legend class="mt-4">Operator Information</legend>
                        <div class="row gx-2 align-items-center was-validated">
                            <!-- Call Sign -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100">
                                    <div class="col-md-4 text-md-end">
                                        <label for="callsign" class="form-label mb-0">Call Sign:</label>
                                    </div>
                                    <div class="col-md-8 was-validated">
                                        <input type="text" id="callsign" class="form-control" placeholder="Enter callsign" required
                                            pattern="^([A-Za-z]{1,2}[0-9][A-Za-z0-9]{1,3}|[A-Za-z][0-9][A-Za-z]|[0-9][A-Za-z][0-9][A-Za-z0-9]{2,3})$"
                                            minlength="3" maxlength="6">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please enter your callsign.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grid Square -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="gridsquare" class="form-label mb-0">Grid Square:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input
                                            type="text"
                                            id="gridsquare"
                                            class="form-control"
                                            placeholder="Enter grid square"
                                            required
                                            minlength="4"
                                            maxlength="4"
                                            pattern="[A-Za-z]{2}[0-9]{2}">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">
                                            Please enter your four-character grid square.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Second Row -->

                        <!-- Third Row -->
                        <legend class="mt-4">Station Information</legend>
                        <div class="row">
                            <!-- Transmit Power Input -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100">
                                    <div class="col-md-4 text-end">
                                        <label class="form-label" for="dbm">Transmit Power<br>(in dBm):</label>
                                    </div>
                                    <div class="col-md-8 was-validated">
                                        <input type="number" min="-10" max="62" step="1"
                                            class="form-control" id="dbm"
                                            placeholder="Enter transmit power" required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">
                                            Please enter your transmit power in dBm (without the 'dBm' suffix.)
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Frequencies + Randomize -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100 align-items-center">

                                    <!-- Frequency Label -->
                                    <div class="col-md-4 text-md-end">
                                        <label class="form-label" for="frequencies">Frequency:</label>
                                    </div>
                                    <div class="col-md-5 was-validated">
                                        <input type="text" class="form-control" id="frequencies"
                                            placeholder="Enter frequency" oninput="checkFreq();">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">
                                            Add a single frequency or a space-delimited list (see
                                            <a href="https://wsprry-pi.readthedocs.io/en/latest/Operations/index.html"
                                                target="_blank" rel="noopener noreferrer">documentation</a>).
                                        </div>
                                    </div>

                                    <!-- Randomize -->
                                    <div class="col-md-2 text-md-end mb-2 mb-md-0">
                                        <label class="form-check-label" for="useoffset">Randomize:</label>
                                    </div>
                                    <div class="col-md-1 was-validated">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="useoffset" data-form-type="other">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Third Row -->

                        <!-- Fourth Row -->
                        <legend class="mt-4">Frequency Calibration</legend>
                        <div class="row">
                            <!-- Transmit Power Input -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100">
                                    <div class="col-8 col-md-4 text-md-end mb-2 mb-md-0">
                                        <label class="form-label" for="use_ntp">Use NTP:</label>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="form-check form-switch was-validated">
                                            <input class="form-check-input" type="checkbox" id="use_ntp" data-form-type="other">
                                            <div class="valid-feedback"></div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Frequencies + Randomize -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="row w-100">

                                    <div class="col-md-4 text-end">
                                        <label class="form-check-label" for="ppm">PPM Offset:</label>
                                    </div>
                                    <div class="col-md-8 was-validated">
                                        <input type="number" min="-200" max="200" step=".000001"
                                            class="form-control w-100" id="ppm"
                                            placeholder="Enter PPM">
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">
                                            Enter a positive or negative decimal number for frequency correction.
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Fourth Row -->

                        <!-- Fifth Row -->
                        <legend class="mt-4">Transmit Power</legend>
                        <div class="row  justify-content-center">
                            <div class="row justify-content-center">
                                <p>This sets power on the Raspberry Pi GPIO only. Any amplification (such as that which is provided by the TAPR board) must be taken into account.</p>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="range-wrap d-flex align-items-center">
                                        <input id="power_level" type="range" class="form-range flex-grow-1" min="0" max="7">
                                        <output id="rangeText" class="ms-3"></output>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p></p>

                        <!-- End Fifth Row -->

                        <!-- Hidden Form Items -->
                        <div id="hidden-row" class="d-none">
                            <input type="text" class="form-control" id="web_port" placeholder="">
                            <input type="text" class="form-control" id="socket_port" placeholder="">
                            <input type="text" class="form-control" id="use_shutdown" placeholder="">
                            <input type="text" class="form-control" id="shutdown_button" placeholder="">
                        </div>
                        <!-- End Hidden Form Items -->

                        <!-- Button Row -->
                        <div id="buttons" class="modal-footer justify-content-center">
                            <button id="submit" type="button" class="btn btn-dark me-2">Save</button>
                            <button id="reset" type="button" class="btn btn-light">Reset</button>
                        </div>
                        <!-- End Button Row -->

                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <footer id="footer" class="bg-dark text-white fixed-bottom w-100">
        <div class="container py-2">
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="list-inline mb-1 small">
                        <li class="list-inline-item">
                            <a href="http://wsprdocs.aa0nt.net" target="_blank" class="text-white">Docs</a>
                        </li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item">
                            <a href="https://github.com/lbussy/WsprryPi" target="_blank" class="text-white">GitHub</a>
                        </li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item">
                            <a href="https://tapr.org/" target="_blank" class="text-white">TAPR</a>
                        </li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item">
                            <a
                                href="https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall="
                                class="text-white"
                                id="wsprnet-link"
                                target="_blank">
                                WSPR Spot Database
                            </a>
                        </li>
                    </ul>
                    <p class="mb-1 small">
                        Created by Lee Bussy, AA0NT.
                        <span class="d-none d-md-inline" id="wspr-version">Loading version...</span>
                    </p>
                    <p class="d-md-none text-center small mb-1">
                        <span id="wspr-version-mobile">Loading version...</span>
                    </p>
                    <p class="mb-0 small">
                        Original WsprryPi: <a href="https://github.com/lbussy/WsprryPi/blob/main/LICENSE.md" class="text-white">GPL</a> |
                        New Code & Web UI: <a href="https://github.com/lbussy/WsprryPi/blob/main/LICENSE.md" class="text-white">MIT License</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"
        integrity="sha512-yrOmjPdp8qH8hgLfWpSFhC/+R9Cj9USL8uJxYIveJZGAiedxyIxwNw4RsLDlcjNlIRR4kkHaDHSmNHAkxFTmgg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>
    <script
        src="https://kit.fontawesome.com/e51821420e.js"
        integrity="sha384-adrPvaOUW0sIi6DYKaiegi+445kGpOKaOO3euXdFzK9LVnD/6SdYjYtJbMAnxvKa"
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>

    <script>
        var settings_url = window.location.pathname + "/wsprrypi_config.php";
        var version_url = window.location.pathname + "/version.php";
        var populateConfigRunning = false;

        var rangeValues = {
            // Define range labels for slider
            // P(dBm) = 10 ⋅ log10( P(mW) / 1mW)
            "0": "2mA<br />3.0dBm",
            "1": "4mA<br />6.0dBm",
            "2": "6mA<br />7.8dBm",
            "3": "8mA<br />9.0dBm",
            "4": "10mA<br />10.0dBm",
            "5": "12mA<br />10.8dBm",
            "6": "14mA<br />11.5dBm",
            "7": "16mA<br />12.0dBm"
        };

        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
            bindActions();
            loadPage();
        });

        $('.selectpicker').selectpicker({
            showContent: false // only the <option>’s “GPIOXX” value appears in the closed button
        });

        function bindActions() {
            // Turn on tooltips
            $('[data-bs-toggle="tooltip"]').tooltip()

            // Grab Use NTP Switch
            $('#use_ntp').on("change", clickUseNTP);

            // Grab Use LED switch (key) {
            $("#use_led").on("click", clickUseLED);

            $('#callsign').on('input', updateWSPRNetLink);

            // Grab Submit and Reset Buttons
            $("#submit").click(savePage);
            $("#reset").click(resetPage);

            // Handle slider move and bubble value
            $('#power_level').on('input change', powerLevelChange);

            // Attach event listener for validation when in PPM
            $('#ppm').on("input", validatePPM);

        };

        function checkFreq() {
            let isValid = true;
            freqString = $("#frequencies").val().toLowerCase();

            // Min length would be one of 2m, 4m, 6m, = 2
            if (freqString.length < 2) isValid = false;

            // Check for alphanumerics, spaces or hypens only
            compareRegEx = "^[a-zA-Z0-9 \-]*$";
            if (!freqString.match(compareRegEx)) isValid = false;

            // Split on whitespace (duplicates are merged)
            freqArray = freqString.split(/\s+/);
            freqArrayLength = freqArray.length;
            for (var i = 0; i < freqArrayLength; i++) {
                freqWord = freqArray[i];
                // Make sure this is not an empty string
                if (!freqArray[i] == " ") {
                    // Check if all numbers (also catches exponents)
                    if (isNumeric(freqWord)) {
                        // Ok
                    }
                    // Check for LF or MF
                    else if (freqWord == "lf" || freqWord == "mf") {
                        // Ok
                    }
                    // Check for "-15" on the end
                    else if (freqWord.endsWith("-15") && !freqWord.endsWith("--15")) {
                        // If removing the "-15" does not yield a number
                        if (isNaN(trimLast(freqWord, 3)) || trimLast(freqWord, 1) < 3) {
                            // See if it indicates a band plan
                            if (!trimLast(freqWord, 3).endsWith("m")) {
                                // Not a number but does not end in 'm'
                                if (trimLast(freqWord, 3) == "lf" || trimLast(freqWord, 3) == "mf") {
                                    // Ol, LF or MF
                                } else {
                                    isValid = false;
                                }
                            } else if (isNumeric(trimLast(freqWord, 4))) {
                                // It's numeric, is it a band plan?
                                if (!isBand(trimLast(freqWord, 4))) {
                                    // Not a band plan
                                    isValid = false;
                                } else {
                                    band = parseInt(trimLast(freqWord, 4));
                                    if (band == 160) {
                                        // Ok - 160m is good with -15
                                    } else {
                                        isValid = false;
                                    }
                                }
                            } else {
                                // All letters
                                isValid = false;
                            }
                        } else {
                            // Straight frequency, no -15 available
                            isValid = false;
                        }
                    }
                    // Check for "m" on the end
                    else if (freqWord.endsWith("m")) {
                        // Check to see if it's a number
                        if (isNaN(trimLast(freqWord, 1)) || trimLast(freqWord, 1) < 1) {
                            // Not a valid number
                            isValid = false;
                        } else if (!isBand(trimLast(freqWord, 1))) {
                            // Not a valid band plan
                            isValid = false;
                        }
                        // Ok
                    }
                    // Anything else is invalid
                    else {
                        // Not Ok
                        isValid = false;
                    }
                }
            }

            // Handle showing validity
            if (isValid) {
                $("#frequencies").removeClass("is-invalid");
                $("#frequencies").addClass("is-valid");
            } else {
                $("#frequencies").removeClass("is-valid");
                $("#frequencies").addClass("is-invalid");
            }
        };

        function isNumeric(num) {
            return !isNaN(num)
        };

        function trimLast(string, num) {
            return string.substring(0, string.length - num);
        };

        function isBand(num) {
            const bandArray = [160, 80, 60, 40, 30, 20, 17, 15, 12, 10, 6, 4, 2];
            return bandArray.includes(parseInt(num));
        };

        function loadPage() {
            populateConfig();
            updateWsprryPiVersion();
            updateTime();
            setInterval(updateTime, 1000);
        };

        function validatePage() {
            // $('element').hasClass('className')
            var thisSection = $('#wsprconfig');
            var thisForm = document.querySelector('#wsprform');
            var failcount = 0;
            if (!thisForm.reportValidity()) failcount++;
            if (!$("#frequencies").hasClass('is-valid')) failcount++;
            return (failcount > 0 ? false : true);
        };

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
                        updateWSPRNetLink();
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

                        // Validate frequency field
                        checkFreq();

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

        function clickUseNTP() {
            if ($('#use_ntp').is(":checked")) {
                // Disable PPM when using self-cal and remove validation
                $('#ppm').prop("disabled", true);
                $('#ppm').removeClass("is-valid is-invalid"); // Clear validation classes
            } else {
                // Enable PPM when not using self-cal and trigger validation
                $('#ppm').prop("disabled", false).trigger("input");
            }
        }

        function validatePPM() {
            let ppmInput = $('#ppm');
            let value = parseFloat(ppmInput.val());

            if ($('#use_ntp').is(":checked")) {
                // If NTP is checked, ignore validation
                ppmInput.removeClass("is-valid is-invalid");
                return;
            }

            if (isNaN(value) || value < -200 || value > 200) {
                ppmInput.addClass("is-invalid").removeClass("is-valid");
            } else {
                ppmInput.addClass("is-valid").removeClass("is-invalid");
            }
        }

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

        function updateWsprryPiVersion() {
            $.getJSON(version_url)
                .done(function(response) {
                    if (response && response.wspr_version) {
                        let versionText = "WSPR Version: " + response.wspr_version;

                        // Update both desktop and mobile versions
                        let desktopElement = document.getElementById("wspr-version");
                        let mobileElement = document.getElementById("wspr-version-mobile");

                        if (desktopElement) {
                            desktopElement.textContent = versionText;
                        }

                        if (mobileElement) {
                            mobileElement.textContent = versionText;
                        }

                        // Force reflow for Safari
                        [desktopElement, mobileElement].forEach(el => {
                            if (el) {
                                el.style.display = "none";
                                el.offsetHeight;
                                el.style.display = "block";
                            }
                        });
                    } else {
                        console.error("Invalid JSON format from version.");
                    }
                })
                .fail(function() {
                    console.error("Error fetching WSPR version.");
                });
        }

        function updateTime() {
            let now = new Date();

            // Format Local Time (24-hour format)
            let localHours = String(now.getHours()).padStart(2, "0");
            let localMinutes = String(now.getMinutes()).padStart(2, "0");
            let localSeconds = String(now.getSeconds()).padStart(2, "0");
            let localTime = `Local: ${localHours}:${localMinutes}:${localSeconds}`;

            // Format UTC Time (24-hour format)
            let utcHours = String(now.getUTCHours()).padStart(2, "0");
            let utcMinutes = String(now.getUTCMinutes()).padStart(2, "0");
            let utcSeconds = String(now.getUTCSeconds()).padStart(2, "0");
            let utcTime = `UTC: ${utcHours}:${utcMinutes}:${utcSeconds}`;

            // Update the elements
            document.getElementById("localTime").textContent = localTime;
            document.getElementById("utcTime").textContent = utcTime;
        }

        function updateWSPRNetLink() {
            // Function to update WSPRNet link and link text based on callsign input
            const baseUrl = "https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall=";
            const $link = $('#wsprnet-link');
            const $callsignInput = $('#callsign');

            const callsign = $callsignInput.val().trim();

            // Check validity using built-in form validation
            if ($callsignInput[0].checkValidity()) {
                $link.attr('href', baseUrl + encodeURIComponent(callsign));
                $link.text(`${callsign} on WSPRNet`);
            } else {
                $link.attr('href', baseUrl);
                $link.text("WSPR Spot Database");
            }
        }

        function powerLevelChange() {
            $('#rangeText').html(rangeValues[$(this).val()]);
            const val = parseFloat($('#power_level').val());
            let percentage = (val / 7); // Normalize between 0 and 1
            const minOffset = 0.0095;
            const maxOffset = 0.984;
            const offsetRange = maxOffset - minOffset;
            percentage = ((percentage * offsetRange) + minOffset) * 100;
            $('#rangeText').css("left", percentage + "%");
        }
    </script>
</body>

</html>