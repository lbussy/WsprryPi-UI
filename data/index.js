function bindIndexActions() {
    // Bind the Use NTP Switch
    $("#use_ntp").on("change", clickUseNTP);

    // Wire up the LED switch
    $("#use_led").on("change", clickUseLED);

    // Wire up the LED switch
    $("#use_shutdown").on("change", clickUseShutdown);

    // Wire up the pin dropdown menus
    $(".pin-dropdown-btn")
        .off('click', '.dropdown-item', selectPin)
        .on('click', '.dropdown-item', selectPin);

    // Bind the transmit power slider
    $("#tx-power-range").on("input", updateTxPowerLabel);

    // Bind the theme toggle
    $("#themeToggle").on("click", clickThemeToggle);

    // Bind clicks on buttons/switches for resetting tooltips
    $(document).on(
        "click",
        'a[data-bs-toggle="tooltip"], button[data-bs-toggle="tooltip"]',
        resetToolTips
    );

    // Run validation live as the user types:
    $("#frequencies").on("input blur", function () {
        validateFrequencies();
        // update classes for styling
        this.checkValidity()
            ? this.classList.add("is-valid") && this.classList.remove("is-invalid")
            : this.classList.add("is-invalid") && this.classList.remove("is-valid");
    });

    // Bind any text/number/select control changes
    $(document).on(
        "input change",
        '.form-control:not([type="range"], .form-check-input)',
        validatePage
    );

    // Modal Action Handlers
    const $modalEl = $("#testToneModal");
    //const tone_modal = new bootstrap.Modal($modalEl[0]);
    $("#test_tone").on("click", clickTestTone);
    $("#testToneStart").on("click", onTestToneStart);
    $("#testToneEnd").on("click", onTestToneEnd);
    $modalEl.on("hidden.bs.modal", onTestToneEnd);

    // Bind Submit and Reset Buttons
    $("#submit").click(savePage);
    $("#reset").click(resetPage);
}

// Transmit power slider update
function updateTxPowerLabel() {
    var val = this.value;
    var rangeValues = {
        0: "2mA<br/>3.0dBm",
        1: "4mA<br/>6.0dBm",
        2: "6mA<br/>7.8dBm",
        3: "8mA<br/>9.0dBm",
        4: "10mA<br/>10.0dBm",
        5: "12mA<br/>10.8dBm",
        6: "14mA<br/>11.5dBm",
        7: "16mA<br/>12.0dBm",
    };
    var label = rangeValues[val] || val;
    $("#tx-power-range-value").html(label);
}

function clickUseLED() {
    const on = $("#use_led").prop("checked");
    $("#ledDropdownButton").prop("disabled", !on);
}

function clickUseShutdown() {
    const on = $('#use_shutdown').prop('checked');
    $('#shutdownDropdownButton').prop('disabled', !on);
}

function validatePage() {
    const form = document.getElementById("wsprform");
    //form.classList.add('was-validated');

    let invalidCount = 0;

    // ONLY the .form-control elements (no switches, ranges, etc)
    form
        .querySelectorAll(".form-control:not(.form-check-input)")
        .forEach((ctrl) => {
            if (ctrl.checkValidity()) {
                ctrl.classList.add("is-valid");
                ctrl.classList.remove("is-invalid");
            } else {
                ctrl.classList.add("is-invalid");
                ctrl.classList.remove("is-valid");
                invalidCount++;
            }
        });

    return invalidCount === 0;
}

// Function to enable/disable & reset PPM field when Use NTP toggles
function clickUseNTP() {
    const $ntp = $("#use_ntp");
    const $ppm = $("#ppm");
    const useNtp = $ntp.is(":checked");

    // disable/enable the PPM input
    $ppm.prop("disabled", useNtp);

    if (useNtp) {
        // when disabling, clear & reset validation
        $ppm.removeClass("is-valid is-invalid").prop("required", false);
    } else {
        // when enabling, make it required again
        $ppm.prop("required", true);
    }
}

function setLEDPin(gpioNumber) {
    const code = "GPIO" + gpioNumber;
    const $btn = $("#ledDropdownButton");
    const $item = $(`.dropdown-item[data-val="${code}"]`);
    if ($item.length) {
        $btn.text(code);
    } else {
        debugConsole("warn", "GPIO value not found:", code);
    }
}

/**
 * Read the current LED‐pin selection out of your custom dropdown.
 * @returns {number|null} the pin number, e.g. 18, or null if nothing
 * is selected
 */
function getLEDPin() {
    const txt = $("#ledDropdownButton").text().trim();
    const m = txt.match(/\d+/);
    return m ? parseInt(m[0], 10) : null;
}

/**
 * Universal dropdown-pin selector
 */
function selectPin(e) {
    e.preventDefault();
    const $item = $(this);
    const code = $item.data("val");

    // find the related dropdown-toggle button
    const menuId = $item.closest(".dropdown-menu").attr("aria-labelledby");
    const $btn = $("#" + menuId);

    // set its text, then close the menu
    $btn.text(code).dropdown("toggle");
}

/**
 * Programmatically set a pin in your custom dropdown.
 * @param {number} gpioNumber  e.g. 18
 */
function setShutdownPin(gpioNumber) {
    const code = "GPIO" + gpioNumber;
    const $btn = $("#shutdownDropdownButton");
    const $item = $(`.dropdown-item[data-val="${code}"]`);
    if ($item.length) {
        $btn.text(code);
    } else {
        debugConsole("warn", "GPIO value not found:", code);
    }
}

/**
 * Read the current shutdown pin selection out of your custom dropdown.
 * @returns {number|null} the pin number, e.g. 18, or null if nothing
 * is selected
 */
function getShutdownPin() {
    const txt = $("#shutdownDropdownButton").text().trim();
    const m = txt.match(/\d+/);
    return m ? parseInt(m[0], 10) : null;
}

// Open Test Tone Modal
function clickTestTone(e) {
    // Disable Buttons
    e.preventDefault();
    const btn = this;
    toggleButtonLoading(btn, true);
    setTimeout(() => {
        toggleButtonLoading(btn, false);
    }, 500);
    $("#testToneStart").prop("disabled", false);
    $("#testToneEnd").prop("disabled", true);
    $("#testToneClose").prop("disabled", false);
    const modalEl = document.getElementById("testToneModal");
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

// Start Test Tone
function onTestToneStart(e) {
    e.preventDefault();
    const btn = this;
    toggleButtonLoading(btn, true);
    $("#testToneStart").prop("disabled", true);
    $("#testToneEnd").prop("disabled", true);
    debugConsole("debug", "Test tone start.");
    sendCommand("tone_start");
    setTimeout(() => {
        toggleButtonLoading(btn, false);
        $("#testToneStart").prop("disabled", true);
        $("#testToneEnd").prop("disabled", false);
    }, 500);
}

// End Test Tone
function onTestToneEnd(e) {
    e.preventDefault();
    const btn = this;
    toggleButtonLoading(btn, true);
    $("#testToneStart").prop("disabled", true);
    $("#testToneEnd").prop("disabled", true);
    debugConsole("debug", "Test tone end.");
    sendCommand("tone_end");
    setTimeout(() => {
        toggleButtonLoading(btn, false);
        $("#testToneStart").prop("disabled", false);
        $("#testToneEnd").prop("disabled", true);
    }, 500);
}

// Save all fields
function savePage(e) {
    if (!validatePage()) {
        alert("Please correct the errors on the page.");
        return false;
    }
    e.preventDefault();
    const btn = this;
    // Disable Buttons
    $("#submit").prop("disabled", true);
    $("#reset").prop("disabled", true);
    toggleButtonLoading(btn, true);

    // Load form elements
    //
    // Hardware Control
    let transmit = parseBool($("#transmit").is(":checked"));
    let use_led = parseBool($("#use_led").is(":checked"));
    let led_pin = parseInt(getLEDPin()) || 18;
    let use_shutdown = parseBool($("#use_shutdown").is(":checked"));
    let shutdown_pin = parseInt(getShutdownPin()) || 19;

    // Operator Information
    let callsign = $("#callsign").val() || "";
    let gridsquare = $("#gridsquare").val() || "";

    // Transmitter Information
    let dbm = parseInt($("#dbm").val());
    let frequencies = $("#frequencies").val() || "";
    let useoffset = parseBool($("#useoffset").is(":checked"));

    // Frequency Calibration
    let use_ntp = parseBool($("#use_ntp").is(":checked"));
    let ppm_val = parseFloat($("#ppm").val()) || 0.0;

    // Transmit Power
    const raw = $("#tx-power-range").val();
    let transmit_power = parseInt(raw, 10);
    // Use 7 if parsing fails
    if (!(transmit_power >= 0 && transmit_power <= 7)) {
        transmit_power = 7;
    }

    var Control = {
        "Transmit": transmit,
    };

    var Common = {
        "Call Sign": callsign,
        "Grid Square": gridsquare,
        "TX Power": dbm,
        "Frequency": frequencies,
    };

    var Extended = {
        "PPM": ppm_val,
        "Use NTP": use_ntp,
        "Offset": useoffset,
        "Use LED": use_led,
        "LED Pin": led_pin,
        "Power Level": transmit_power,
    };

    var Server = {
        "Use Shutdown": use_shutdown,
        "Shutdown Button": shutdown_pin,
    };

    var configJson = {
        Control,
        Common,
        Extended,
        Server,
    };
    var json = JSON.stringify(configJson);

    $.ajax({
        url: SETTINGS_URL,
        type: "PUT",
        contentType: "application/json",
        data: json,
    })
        .done(function (data) {
            lastSaveTimestamp = Date.now(); // Save to prevent forced reload
        })
        .fail(function (xhr) {
            alert(
                "Settings update failed with status: " + xhr.status,
                xhr.responseText
            );
        })
        .always(function () {
            setTimeout(() => {
                $("#submit").prop("disabled", false);
                $("#reset").prop("disabled", false);
                $("#wsprform").prop("disabled", false);
                toggleButtonLoading(btn, false);
            }, 500);
        });
}

// Reload page config
function resetPage(e) {
    // Disable Form
    e.preventDefault();
    const btn = this;
    toggleButtonLoading(btn, true);
    $("#submit").prop("disabled", true);
    $("#reset").prop("disabled", true);
    $("#test_tone").prop("disabled", true);
    $("#wsprform").prop("disabled", true);
    populateConfig();
    setTimeout(() => {
        toggleButtonLoading(btn, false);
    }, 500);
}

/**
 * Validate the “Frequencies” field.
 * @returns {boolean} true if valid, false otherwise.
 */
function validateFrequencies() {
    const fld = document.getElementById("frequencies");
    const raw = fld.value.trim();

    // empty is invalid
    if (!raw) {
        fld.setCustomValidity("Please enter at least one frequency");
        return false;
    }

    // build our two regexes
    const numericRx = /^\d+(?:\.\d+)?(?:hz|khz|mhz|ghz)?$/i;
    const bandRx =
        /^(?:lf(?:-15)?|mf(?:-15)?|160m(?:-15)?|80m|60m|40m|30m|20m|17m|15m|12m|10m|6m|4m|2m)$/i;

    // split on any whitespace
    const tokens = raw.split(/\s+/);
    for (const tok of tokens) {
        if (!(numericRx.test(tok) || bandRx.test(tok))) {
            fld.setCustomValidity(`Invalid frequency: “${tok}”`);
            return false;
        }
    }

    // all good
    fld.setCustomValidity("");
    return true;
}
