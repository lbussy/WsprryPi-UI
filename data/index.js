// Get current path
var currentPath = window.location.pathname.replace(/\/[^\/]*$/, '');
// Set URLs
var settings_url = currentPath + '/wsprrypi_config.php';
var version_url = currentPath + '/version.php';
var wsprnet_url = "https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall=";

var populateConfigRunning = false;

document.addEventListener('DOMContentLoaded', function () {
    bindActions();
    loadPage();
});

function loadPage() {
    updateWSPRNetLink();
    updateClocks();
    updateWsprryPiVersion();
    populateConfig();
    initThemeToggle();
}

function pageLoaded() {
    validatePage();
    updateWSPRNetLink();
    updateTxPowerLabel();
    clickUseLED();
}

function bindActions() {
    // new — only hover (no focus), so clicking into inputs still works
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    // Bind the Use NTP Switch
    $('#use_ntp').on("change", clickUseNTP);

    // 1) Wire up the LED switch
    $('#use_led')
        .off('change')                   // make sure any old handler is gone
        .on('change', clickUseLED);

    // 2) Delegate clicks on the dropdown-items (only one handler)
    $('.dropdown-menu')
        .off('click', '.dropdown-item')
        .on('click', '.dropdown-item', selectLEDPin);

    // Update WSPRNet link and bind changes to callsign
    $('#callsign').on('input blur', updateWSPRNetLink);

    // Bind the transmit power slider
    $('#tx-power-range').on('input', updateTxPowerLabel);

    // Bind the theme toggle
    $("#themeToggle").on("click", clickThemeToggle);

    // Bind clicks on buttons/switches for resetting tooltips
    $(document).on('click', 'a[data-bs-toggle="tooltip"], button[data-bs-toggle="tooltip"]', resetToolTips);

    // If you want it to run live as the user types:
    $('#frequencies').on('input blur', function () {
        validateFrequencies();
        // update classes for styling
        this.checkValidity()
            ? this.classList.add('is-valid') && this.classList.remove('is-invalid')
            : this.classList.add('is-invalid') && this.classList.remove('is-valid');
    });

    // Bind any text/number/select control changes
    $(document).on('input change', '.form-control:not([type="range"], .form-check-input)', validatePage);

    // Bind Submit and Reset Buttons
    $("#submit").click(savePage);
    $("#reset").click(resetPage);
}

// Function to enable/disable & reset PPM field when Use NTP toggles
function clickUseNTP() {
    const $ntp = $('#use_ntp');
    const $ppm = $('#ppm');
    const useNtp = $ntp.is(':checked');

    // disable/enable the PPM input
    $ppm.prop('disabled', useNtp);

    if (useNtp) {
        // when disabling, clear & reset validation
        $ppm
            .removeClass('is-valid is-invalid')
            .prop('required', false);
    } else {
        // when enabling, make it required again
        $ppm.prop('required', true);
    }
}


function clickUseLED() {
    const on = $('#use_led').prop('checked');
    $('#ledDropdownButton').prop('disabled', !on);
}

function selectLEDPin(e) {
    e.preventDefault();                  // stop any default button-submit behavior
    const code = $(this).data('val');    // grab your data-val
    $('#ledDropdownButton')
        .text(code)                        // set the toggler text
        .dropdown('toggle');               // close the menu
}

function updateWSPRNetLink() {
    const $link = $('#wsprnet-link');
    const $text = $link.find('.ms-2');
    const $cs = $('#callsign');
    const callsign = $cs.val().trim();

    if ($cs[0].checkValidity() && callsign !== "") {
        $link
            .attr('href', wsprnet_url + encodeURIComponent(callsign))
            .attr('title', `${callsign} on WSPRNet`);
        $text.text(`${callsign} spots on WSPRNet`);
    } else {
        $link
            .attr('href', wsprnet_url)
            .attr('title', 'WSPR Spot Database');
        $text.text('WSPRNet Database');
    }
}

function updateClocks() {
    const now = new Date();
    // Format HH:MM:SS
    const pad = n => String(n).padStart(2, '0');
    const local = [now.getHours(), now.getMinutes(), now.getSeconds()]
        .map(pad).join(':');
    const utc = [now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds()]
        .map(pad).join(':');

    // only write the times themselves
    document.getElementById('localTime').textContent = local;
    document.getElementById('utcTime').textContent = utc;

    // schedule next update right after the next full second
    const delay = 1000 - now.getMilliseconds();
    setTimeout(updateClocks, delay);
}

function updateWsprryPiVersion() {
    $.getJSON(version_url)
        .done(function (response) {
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
        .fail(function () {
            console.error("Error fetching WSPR version.");
        });
}

// Transmit power slider update
function updateTxPowerLabel() {
    var val = this.value;
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
    var label = rangeValues[val] || val;
    $('#tx-power-range-value').html(label);
}

// Data Load
function populateConfig(callback = null) {
    if (populateConfigRunning) return;
    populateConfigRunning = true;

    $.getJSON(settings_url)
        .done(function (configJson) {
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

                $('#tx-power-range')
                    // Set the slider to the configured power
                    .val(configJson.Extended["Power Level"])
                    // GFire the update once so the label shows up
                    .trigger('input');

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

                // Do actions after page loaded
                pageLoaded();

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
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert("Unable to retrieve data.");
            console.error("Error fetching config JSON:", textStatus, errorThrown);
            setTimeout(populateConfig, 10000);
        })
        .always(function () {
            populateConfigRunning = false;
        });
}

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
        "Power Level": parseInt(+$('#tx-power-range').val()),
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
        .done(function (data) {
            // Ok
        })
        .fail(function (xhr) {
            alert("Settings update failed with status: " + xhr.status, xhr.responseText);
        })
        .always(function () {
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
}

// Update the theme toggle label
function updateLabel(isDark) {
    $('#themeToggleLabel').text(isDark ? 'Dark' : 'Light');
}

// Handler for clicking the theme toggle
function clickThemeToggle() {
    const isDark = this.checked;
    const newTheme = isDark ? 'dark' : 'light';
    document.documentElement.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateLabel(isDark);
}

// Initialize on page load: read saved theme, set switch & label
function initThemeToggle() {
    const stored = localStorage.getItem('theme') || 'light';
    const isDark = stored === 'dark';
    $('#themeToggle').prop('checked', isDark);
    document.documentElement.setAttribute('data-bs-theme', stored);
    updateLabel(isDark);
}

function resetToolTips(e) {
    const el = e.currentTarget;
    const inst = bootstrap.Tooltip.getInstance(el);
    if (inst) inst.hide();
}

function validatePage() {
    const form = document.getElementById('wsprform');
    //form.classList.add('was-validated');

    let invalidCount = 0;

    // ONLY the .form-control elements (no switches, ranges, etc)
    form.querySelectorAll('.form-control:not(.form-check-input)')
        .forEach(ctrl => {
            if (ctrl.checkValidity()) {
                ctrl.classList.add('is-valid');
                ctrl.classList.remove('is-invalid');
            } else {
                ctrl.classList.add('is-invalid');
                ctrl.classList.remove('is-valid');
                invalidCount++;
            }
        });

    return invalidCount === 0;
}

/**
 * Validate the “Frequencies” field.
 * @returns {boolean} true if valid, false otherwise.
 */
function validateFrequencies() {
    const fld = document.getElementById('frequencies');
    const raw = fld.value.trim();

    // empty is invalid
    if (!raw) {
        fld.setCustomValidity('Please enter at least one frequency');
        return false;
    }

    // build our two regexes
    const numericRx = /^\d+(?:\.\d+)?(?:hz|khz|mhz|ghz)?$/i;
    const bandRx = /^(?:lf(?:-15)?|mf(?:-15)?|160m(?:-15)?|80m|60m|40m|30m|20m|17m|15m|12m|10m|6m|4m|2m)$/i;

    // split on any whitespace
    const tokens = raw.split(/\s+/);
    for (const tok of tokens) {
        if (!(numericRx.test(tok) || bandRx.test(tok))) {
            fld.setCustomValidity(`Invalid frequency: “${tok}”`);
            return false;
        }
    }

    // all good
    fld.setCustomValidity('');
    return true;
}

// If you want it to run live as the user types:
$('#frequencies').on('input blur', function () {
    validateFrequencies();
    // update classes for styling
    this.checkValidity()
        ? this.classList.add('is-valid') && this.classList.remove('is-invalid')
        : this.classList.add('is-invalid') && this.classList.remove('is-valid');
});