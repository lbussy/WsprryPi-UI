// Debug Logging (Console)
const DEBUG = true;
// Service Ports
const SV_PORT = 31415;
const WS_PORT = 31416;
// Service Components
const PROTO = window.location.protocol;
const WS_PROTO = PROTO === 'https:' ? 'wss:' : 'ws:';
const HOSTNAME = window.location.hostname;
const CURRENT_PATH = window.location.pathname.replace(/\/[^\/]*$/, '');
// Service URLs
const SV_URL = `${PROTO}//${HOSTNAME}:${SV_PORT}`;
const WS_URL = `${WS_PROTO}//${HOSTNAME}:${WS_PORT}`;
const SETTINGS_URL = `${SV_URL}/config`
const VERSION_URL = `${SV_URL}/version`;
const WSPRNET_URL = "https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall=";

// Save the last time we sent a config to avoid reload messages on WebSockets
let lastSaveTimestamp = null;
// Keep track of any scheduled reloads
let pendingPopulateConfigTimeout = null;

// Semaphore for singleton data load
let populateConfigRunning = false;
// Semaphore to pause processing (reboot or shutdown)
let systemPaused = false;

// Websocket Creation
let ws;
const WS_RECONNECT = 5000; // Retry again every 5s

$(window).on('load', function () {
    bindActions();
    loadPage();
});

function loadPage() {
    initThemeToggle();
    populateConfig();
}

function pageLoaded() {
    connectWebSocket(WS_URL, WS_RECONNECT);
    updateTxPowerLabel();
    clickUseLED();
    clickUseShutdown();
    updateWSPRNetLink();
    updateWsprryPiVersion();
    updateClocks();
    validatePage();
}

function bindActions() {
    // new — only hover (no focus), so clicking into inputs still works
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    // Bind the Use NTP Switch
    $('#use_ntp').on("change", clickUseNTP);

    // Wire up the LED switch
    $('#use_led')
        .off('change')                   // make sure any old handler is gone
        .on('change', clickUseLED);

    // Delegate clicks on the dropdown-items (only one handler)
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

    // Set connection indicator
    setConnectionState('disconnected');

    // in bindActions():
    $('#rebootButton').on('click', () => sendCommand('reboot'));
    $('#shutdownButton').on('click', () => sendCommand('shutdown'));

    // Bind Submit and Reset Buttons
    $("#submit").click(savePage);
    $("#reset").click(resetPage);
}

// Initialize on page load: read saved theme, set switch & label
function initThemeToggle() {
    const stored = localStorage.getItem('theme') || 'light';
    const isDark = stored === 'dark';
    $('#themeToggle').prop('checked', isDark);
    document.documentElement.setAttribute('data-bs-theme', stored);
    updateLabel(isDark);
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

// Data Load
function populateConfig(callback = null) {
    if (populateConfigRunning) return;
    populateConfigRunning = true;

    $.getJSON(SETTINGS_URL)
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

                // Enable or disable PPM based on NTP setting
                $('#ppm').prop("disabled", $('#use_ntp').is(":checked"));

                $('#tx-power-range')
                    // Set the slider to the configured power
                    .val(configJson.Extended["Power Level"])
                    // GFire the update once so the label shows up
                    .trigger('input');

                // [Server]
                $('#use_shutdown').prop('checked', "Use shutdown: " + configJson["Server"]["Use Shutdown"]);
                setShutdownSelect(configJson["Server"]["Shutdown Button"]);

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
                debugConsole('error', "Error parsing config JSON:", error);
                // Only try to load if the system is *not* paused
                if (!systemPaused) {
                    pendingPopulateConfigTimeout = setTimeout(populateConfig, 10000);
                }
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            debugConsole('error', "Error fetching config JSON:", textStatus, errorThrown);
            // Only try to load if the system is *not* paused
            if (!systemPaused) {
                pendingPopulateConfigTimeout = setTimeout(populateConfig, 10000);
            }
        })
        .always(function () {
            populateConfigRunning = false;
        });
}

/**
 * connectWebSocket
 * ----------------
 * Opens a WebSocket to the same host on the given port, updates the UI
 * connection state via setConnectionState(), and automatically reconnects
 * if the socket closes or errors out.
 *
 * @param {string} url
 *   The TCP port on which the WebSocket server is listening.
 * @param {number} [reconnectDelay=5000]
 *   Milliseconds to wait before trying to reconnect after a close or error.
 */
function connectWebSocket(url, reconnectDelay = 5000) {
    // Notify the UI we’re attempting to connect
    setConnectionState('connecting');
    debugConsole('debug', `WebSocket ▶️ connecting to ${url}`);

    // Create the WebSocket
    ws = new WebSocket(url);
    // On open: update UI and log
    ws.addEventListener('open', () => {
        debugConsole('debug', 'WebSocket ▶️ open');
        setConnectionState('connected');
        getTxState();
    });

    // On message: Try to parse JSON and react to “transmitting” or
    // "tx_state" state
    ws.addEventListener('message', ev => {
        debugConsole('debug', 'WebSocket ◀️ message:', ev.data);
        let msg;
        try {
            msg = JSON.parse(ev.data);
        } catch (err) {
            debugConsole('warn', 'WebSocket ⚠️ invalid JSON:', err);
            return;
        }

        // If the server is replying to our get_tx_state command:
        if (typeof msg.tx_state === 'boolean') {
            // true → we’re currently transmitting; false → back to connected
            setConnectionState(msg.tx_state ? 'transmitting' : 'connected');
            debugConsole('log', 'Received tx_state:', msg.tx_state);
            return;  // done
        }

        // If the server pushes a “transmit” event:
        if (msg.type === 'transmit') {
            if (msg.state === 'starting') {
                const ts = new Date(msg.timestamp);
                setConnectionState('transmitting', ts);
                debugConsole('log', 'Transmit started at:', ts.toString());
            }
            else if (msg.state === 'finished') {
                setConnectionState('connected');
                debugConsole('log', 'Transmit finished at:', new Date(msg.timestamp).toString());
            }
        }
        // {"state":"reload","timestamp":"2025-04-27T22:25:43Z","type":"configuration"}
        if (msg.type === 'configuration' && msg.state === 'reload') {
            // Clear any pending retry
            if (pendingPopulateConfigTimeout) {
                clearTimeout(pendingPopulateConfigTimeout);
                pendingPopulateConfigTimeout = null;
            }

            // Reload if it’s been more than 2 min since our last save
            const now = Date.now();
            if (!lastSaveTimestamp || (now - lastSaveTimestamp) > 2 * 60 * 1000) {
                console.log("Reloading config by notification.");
                populateConfig();
            }
        }

        // …any other message types…
    });

    // On error: Log and treat as a disconnection
    ws.addEventListener('error', err => {
        debugConsole('error', 'WebSocket ❌ error', err);
        setConnectionState('disconnected');
    });

    // On close: Schedule a reconnect
    ws.addEventListener('close', ev => {
        debugConsole('warn', `WebSocket 🔌 closed (code=${ev.code}), reconnecting in ${reconnectDelay}ms`);
        setConnectionState('disconnected');
        // Only reconnect if the system is *not* paused
        if (!systemPaused) {
            setTimeout(() => connectWebSocket(url, reconnectDelay), reconnectDelay);
        }
    });

    // Return the socket in case the caller wants to send or inspect it
    return ws;
}

/**
 * Update the connection-status icon and its tooltip.
 *
 * @param {'disconnected'|'connecting'|'connected'|'transmitting'} state
 * @param {string} [timestamp]  Optional timestamp for “transmitting”
 */
function setConnectionState(state, timestamp = "") {
    const icon = document.getElementById('connIcon');
    if (!icon) return;

    // Remove old state classes
    icon.classList.remove(
        'state-disconnected',
        'state-connecting',
        'state-connected',
        'state-transmitting'
    );

    // Add the new one
    icon.classList.add(`state-${state}`);

    // Choose the tooltip text
    let text;
    switch (state) {
        case 'disconnected':
            text = 'Disconnected.';
            break;
        case 'connecting':
            text = 'Connecting…';
            break;
        case 'connected':
            text = 'Ready.';
            break;
        case 'transmitting':
            text = `Transmission started${timestamp ? ': ' + timestamp : '.'}`;
            break;
        default:
            text = '';
    }

    // Update Bootstrap’s tooltip data attr (do NOT set title)
    icon.setAttribute('data-bs-original-title', text);

    // Remove the native title so the browser never shows it
    icon.removeAttribute('title');

    // (Re)initialize or fetch the Tooltip instance, then update its content
    let inst = bootstrap.Tooltip.getInstance(icon);
    if (!inst) {
        inst = new bootstrap.Tooltip(icon, { trigger: 'hover' });
    }
    inst.setContent({ '.tooltip-inner': text });
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

function clickUseLED() {
    const on = $('#use_led').prop('checked');
    $('#ledDropdownButton').prop('disabled', !on);
}

function clickUseShutdown() {
    const on = $('#use_shutdown').prop('checked');
    $('#shutdownDropdownButton').prop('disabled', !on);
}

function updateWSPRNetLink() {
    const $link = $('#wsprnet-link');
    const $text = $link.find('.ms-2');
    const $cs = $('#callsign');
    const callsign = $cs.val().trim();

    if ($cs[0].checkValidity() && callsign !== "") {
        $link
            .attr('href', WSPRNET_URL + encodeURIComponent(callsign))
            .attr('title', `${callsign} on WSPRNet`);
        $text.text(`${callsign} spots on WSPRNet`);
    } else {
        $link
            .attr('href', WSPRNET_URL)
            .attr('title', 'WSPR Spot Database');
        $text.text('WSPRNet Database');
    }
}

function updateWsprryPiVersion() {
    $.getJSON(VERSION_URL)
        .done(function (response) {
            if (response && response.wspr_version) {
                let versionText = response.wspr_version;

                // Update with version
                let versionElement = document.getElementById("wspr-version");

                if (versionElement) {
                    versionElement.textContent = versionText;
                }
            } else {
                debugConsole('error', 'Invalid JSON format from version.');
            }
        })
        .fail(function () {
            debugConsole('error', 'Error fetching WSPR version.');
        });
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

function selectLEDPin(e) {
    e.preventDefault();                  // stop any default button-submit behavior
    const code = $(this).data('val');    // grab your data-val
    $('#ledDropdownButton')
        .text(code)                        // set the toggler text
        .dropdown('toggle');               // close the menu
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
        debugConsole('warn', 'GPIO value not found:', code);
    }
}

/**
 * Programmatically select a pin in your custom dropdown.
 * @param {number} gpioNumber  e.g. 19
 */
function setShutdownSelect(gpioNumber) {
    const code = 'GPIO' + gpioNumber;
    const $btn = $('#shutdownDropdownButton');
    const $item = $(`.dropdown-item[data-val="${code}"]`);
    if ($item.length) {
        $btn.text(code);
    } else {
        debugConsole('warn', 'GPIO value not found:', code);
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
        "Use Shutdown": $('#use_shutdown').is(":checked"),
        "Shutdown Button": parseInt($('#shutdown_pin').val(), 10) || 19,
    };

    var Config = {
        Control,
        Common,
        Extended,
        Server,
    };
    var json = JSON.stringify(Config);

    $.ajax({
        url: SETTINGS_URL,
        type: 'PUT',
        contentType: 'application/json',
        data: json,
    })
        .done(function (data) {
            lastSaveTimestamp = Date.now(); // Save to prevent forced reload
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

function resetToolTips(e) {
    const el = e.currentTarget;
    const inst = bootstrap.Tooltip.getInstance(el);
    if (inst) inst.hide();
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

/**
 * Logs at the specified level.
 *
 * @param {'debug'|'log'|'warn'|'error'} method
 *   The console method to invoke.
 * @param  {...any} args
 *   The message (or messages) to log.
 */
function debugConsole(method, ...args) {
    // Only suppress verbose logs if DEBUG=false
    if (!DEBUG && (method === 'debug' || method === 'log')) {
        return;
    }

    // If the console method exists, call it; otherwise fall back to console.log
    if (['debug', 'log', 'warn', 'error'].includes(method) && typeof console[method] === 'function') {
        console[method](...args);
    } else {
        console.log(...args);
    }
}

/**
 * Send a JSON “command” message over the WebSocket.
 *
 * @param {any} payload
 *   Anything serializable — e.g. a string, object, number, etc.
 */
function sendCommand(payload) {
    if (ws && ws.readyState === WebSocket.OPEN) {
        // Pop the alert box
        showSystemModal(payload);
        const msg = { command: payload };
        const json = JSON.stringify(msg);
        ws.send(json);
        debugConsole('debug', 'WebSocket ▶️ command sent:', json);
    } else {
        debugConsole('warn', 'WebSocket not open; cannot send command:', payload);
    }
}

/**
 * Request the current transmit state from the server.
 * Server should reply with JSON: { tx_state: true|false }
 */
function getTxState() {
    if (ws && ws.readyState === WebSocket.OPEN) {
        ws.send(JSON.stringify({ command: "get_tx_state" }));
    } else {
        console.warn("WebSocket not open; cannot request TX state.");
    }
}

/**
 * showSystemModal
 * ----------------
 * Displays a Bootstrap modal warning the user that shutdown or reboot
 * has been initiated.  “Reload Page” reloads immediately; “Exit” simply
 * closes the modal and unpauses the system.
 *
 * @param {'shutdown'|'reboot'} action
 *   Which action was initiated.
 */
function showSystemModal(action) {
    // Map actions to human–readable messages
    const msgs = {
        shutdown: 'System shutdown has been initiated.',
        reboot: 'System reboot has been initiated.'
    };
    const message = msgs[action] || 'Action initiated.';

    // If a previous modal exists, remove it
    $('#systemModal').remove();

    // Build the modal markup
    const modalHtml = `
      <div class="modal fade" id="systemModal" tabindex="-1" aria-labelledby="systemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="systemModalLabel">Notice</h5>
            </div>
            <div class="modal-body">
              ${message}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary exit-btn" data-bs-dismiss="modal">Exit</button>
              <button type="button" class="btn btn-primary reload-btn">Reload Page</button>
            </div>
          </div>
        </div>
      </div>
    `;

    // Inject into DOM
    $('body').append(modalHtml);

    // Pause the system
    systemPaused = true;

    // Create & show the Bootstrap modal
    const sysModalEl = document.getElementById('systemModal');
    const sysModal = new bootstrap.Modal(sysModalEl, { backdrop: 'static', keyboard: false });
    sysModal.show();

    // “Reload Page” button handler
    $(sysModalEl).on('click', '.reload-btn', (e) => {
        e.preventDefault();
        location.reload();
    });

    // When the modal is fully hidden, unpause and restore services
    $(sysModalEl).on('hidden.bs.modal', () => {
        systemPaused = false;
        // restart your websocket & config polling if you like:
        connectWebSocket(WS_URL, WS_RECONNECT);
        setTimeout(populateConfig, 10000);
        // remove the modal from DOM
        $(sysModalEl).remove();
    });
}
