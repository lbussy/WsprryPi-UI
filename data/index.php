<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <!-- Bootswatch, Boostrap, and Fontawesome, included here: -->
    <?php require_once 'header.php'; ?>

    <!-- This page's css -->
    <link rel="stylesheet" href="site.css" />

    <!-- This page's css -->
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <!-- Fixed Navbar -->
    <?php require_once 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="card shadow-sm logs-card mt-5">

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

                    <!-- Section 1: Hardware Control -->
<!-- Section 1: Hardware Control -->
<fieldset class="mb-4">
  <legend>Hardware Control</legend>
  <div class="row gx-2 gy-2 align-items-center">
    <!-- 1) Enable Transmission -->
    <div class="col-12 col-lg-2 d-flex align-items-center">
      <div class="form-check form-switch form-check-reverse mb-0">
        <input class="form-check-input" type="checkbox" role="switch" id="transmit">
        <label class="form-check-label mb-0" for="transmit">Transmit</label>
      </div>
    </div>

    <!-- 2) Enable LED -->
    <div class="col-12 col-lg-2 d-flex align-items-center justify-content-lg-end">
      <div class="form-check form-switch form-check-reverse mb-0">
        <input
          class="form-check-input"
          type="checkbox"
          role="switch"
          data-bs-toggle="tooltip"
          title="Enable to turn on an LED when transmitting"
          id="use_led">
        <label class="form-check-label mb-0 ms-2" for="use_led">TX LED</label>
      </div>
    </div>

    <!-- 3) LED Pin -->
    <div class="col-12 col-lg-3 d-flex align-items-center">
      <label for="led_pin" class="form-label mb-0 me-2 flex-shrink-0">Pin</label>
      <div class="dropdown flex-grow-1">
        <button
          id="ledDropdownButton"
          class="btn btn-outline-secondary dropdown-toggle w-100 text-start pin-dropdown-btn"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false">
          Please select
        </button>
        <ul class="dropdown-menu bg-body text-body" aria-labelledby="ledDropdownButton">
          <li><button class="dropdown-item" data-val="GPIO0">GPIO0 (Pin 27)</button></li>
          <li><button class="dropdown-item" data-val="GPIO1">GPIO1 (Pin 28)</button></li>
          <li><button class="dropdown-item" data-val="GPIO2">GPIO2 (Pin 3)</button></li>
          <li><button class="dropdown-item" data-val="GPIO3">GPIO3 (Pin 5)</button></li>
          <li><button class="dropdown-item" data-val="GPIO5">GPIO5 (Pin 29)</button></li>
          <li><button class="dropdown-item" data-val="GPIO6">GPIO6 (Pin 31)</button></li>
          <li><button class="dropdown-item" data-val="GPIO7">GPIO7 (Pin 26)</button></li>
          <li><button class="dropdown-item" data-val="GPIO8">GPIO8 (Pin 24)</button></li>
          <li><button class="dropdown-item" data-val="GPIO9">GPIO9 (Pin 21)</button></li>
          <li><button class="dropdown-item" data-val="GPIO10">GPIO10 (Pin 19)</button></li>
          <li><button class="dropdown-item" data-val="GPIO11">GPIO11 (Pin 23)</button></li>
          <li><button class="dropdown-item" data-val="GPIO12">GPIO12 (Pin 32)</button></li>
          <li><button class="dropdown-item" data-val="GPIO13">GPIO13 (Pin 33)</button></li>
          <li><button class="dropdown-item" data-val="GPIO14">GPIO14 (Pin 8)</button></li>
          <li><button class="dropdown-item" data-val="GPIO15">GPIO15 (Pin 10)</button></li>
          <li><button class="dropdown-item" data-val="GPIO16">GPIO16 (Pin 36)</button></li>
          <li><button class="dropdown-item" data-val="GPIO17">GPIO17 (Pin 11)</button></li>
          <li><button class="dropdown-item" data-val="GPIO18">GPIO18 (Pin 12 – TAPR default)</button></li>
          <li><button class="dropdown-item" data-val="GPIO20">GPIO20 (Pin 38)</button></li>
          <li><button class="dropdown-item" data-val="GPIO21">GPIO21 (Pin 40)</button></li>
          <li><button class="dropdown-item" data-val="GPIO22">GPIO22 (Pin 15)</button></li>
          <li><button class="dropdown-item" data-val="GPIO23">GPIO23 (Pin 16)</button></li>
          <li><button class="dropdown-item" data-val="GPIO24">GPIO24 (Pin 18)</button></li>
          <li><button class="dropdown-item" data-val="GPIO25">GPIO25 (Pin 22)</button></li>
        </ul>
      </div>
    </div>

    <!-- 4) Enable Shutdown -->
    <div class="col-12 col-lg-2 d-flex align-items-center justify-content-lg-end">
      <div class="form-check form-switch form-check-reverse mb-0">
        <input
          class="form-check-input"
          type="checkbox"
          role="switch"
          data-bs-toggle="tooltip"
          title="Enable to shutdown system when a button is pushed"
          id="use_shutdown">
        <label class="form-check-label mb-0 ms-2" for="use_shutdown">Shutdown</label>
      </div>
    </div>

    <!-- 5) Shutdown Pin -->
    <div class="col-12 col-lg-3 d-flex align-items-center">
      <label for="shutdown_pin" class="form-label mb-0 me-2 flex-shrink-0">Pin</label>
      <div class="dropdown flex-grow-1">
        <button
          id="shutdownDropdownButton"
          class="btn btn-outline-secondary dropdown-toggle w-100 text-start pin-dropdown-btn"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false">
          Please select
        </button>
        <ul class="dropdown-menu bg-body text-body" aria-labelledby="shutdownDropdownButton">
          <li><button class="dropdown-item" data-val="GPIO0">GPIO0 (Pin 27)</button></li>
          <li><button class="dropdown-item" data-val="GPIO1">GPIO1 (Pin 28)</button></li>
          <li><button class="dropdown-item" data-val="GPIO2">GPIO2 (Pin 3)</button></li>
          <li><button class="dropdown-item" data-val="GPIO3">GPIO3 (Pin 5)</button></li>
          <li><button class="dropdown-item" data-val="GPIO5">GPIO5 (Pin 29)</button></li>
          <li><button class="dropdown-item" data-val="GPIO6">GPIO6 (Pin 31)</button></li>
          <li><button class="dropdown-item" data-val="GPIO7">GPIO7 (Pin 26)</button></li>
          <li><button class="dropdown-item" data-val="GPIO8">GPIO8 (Pin 24)</button></li>
          <li><button class="dropdown-item" data-val="GPIO9">GPIO9 (Pin 21)</button></li>
          <li><button class="dropdown-item" data-val="GPIO10">GPIO10 (Pin 19)</button></li>
          <li><button class="dropdown-item" data-val="GPIO11">GPIO11 (Pin 23)</button></li>
          <li><button class="dropdown-item" data-val="GPIO12">GPIO12 (Pin 32)</button></li>
          <li><button class="dropdown-item" data-val="GPIO13">GPIO13 (Pin 33)</button></li>
          <li><button class="dropdown-item" data-val="GPIO14">GPIO14 (Pin 8)</button></li>
          <li><button class="dropdown-item" data-val="GPIO15">GPIO15 (Pin 10)</button></li>
          <li><button class="dropdown-item" data-val="GPIO16">GPIO16 (Pin 36)</button></li>
          <li><button class="dropdown-item" data-val="GPIO17">GPIO17 (Pin 11)</button></li>
          <li><button class="dropdown-item" data-val="GPIO19">GPIO19 (Pin 35 – TAPR default)</button></li>
          <li><button class="dropdown-item" data-val="GPIO20">GPIO20 (Pin 38)</button></li>
          <li><button class="dropdown-item" data-val="GPIO21">GPIO21 (Pin 40)</button></li>
          <li><button class="dropdown-item" data-val="GPIO22">GPIO22 (Pin 15)</button></li>
          <li><button class="dropdown-item" data-val="GPIO23">GPIO23 (Pin 16)</button></li>
          <li><button class="dropdown-item" data-val="GPIO24">GPIO24 (Pin 18)</button></li>
          <li><button class="dropdown-item" data-val="GPIO25">GPIO25 (Pin 22)</button></li>
        </ul>
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
                                            TX dBm:
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
                                            data-bs-toggle="tooltip"
                                            title="You may enter one or more frequencies in plain numeric form (Hz), with a magnitude indicator (Hz, KHz, MHz), or in band notation such as 20m. A 0 is a skipped transmission window."
                                            required />
                                        <div class="valid-feedback">Ok</div>
                                        <div class="invalid-feedback">Invalid, see documentation.</div>
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

                    <!-- Section 6: Submit/Cancel/Test Tone -->
                    <fieldset class="mb-4">
                        <div class="d-flex justify-content-center gap-3">
                            <button
                                id="submit"
                                type="submit"
                                class="btn btn-danger"
                                data-bs-toggle="tooltip"
                                title="Save settings">
                                Save
                            </button>
                            <button
                                id="reset"
                                type="reset"
                                class="btn btn-secondary"
                                data-bs-toggle="tooltip"
                                title="Reset to saved settings">
                                Reset
                            </button>
                            <button
                                id="test_tone"
                                type="button"
                                class="btn btn-outline-warning"
                                data-bs-toggle="tooltip"
                                title="Click to generate a test tone">
                                Tone
                            </button>
                        </div>
                    </fieldset>

                    <!-- Test Tone Modal -->
                    <div
                        class="modal fade"
                        id="testToneModal"
                        tabindex="-1"
                        aria-labelledby="testToneModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="testToneModalLabel">Test Tone</h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Use the controls below to start or stop the test tone.
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        id="testToneStart"
                                        class="btn btn-primary">
                                        Start
                                    </button>
                                    <button
                                        type="button"
                                        id="testToneEnd"
                                        class="btn btn-danger">
                                        End
                                    </button>
                                    <button
                                        type="button"
                                        id="testToneClose"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- System action modal -->
    <?php require_once 'system_action_modal.php'; ?>

    <!-- Static page footer -->
    <?php require_once 'footer.php'; ?>

    <!-- jQuery and Bootswatch -->
    <?php require_once 'site.js.includes.php'; ?>

    <!-- Main JavaScript -->
    <script src="site.js"></script>

    <!-- Index JavaScript -->
    <script src="index.js"></script>
</body>

</html>