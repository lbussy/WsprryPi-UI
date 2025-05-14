// Debug Logging (Console)
const DEBUG = true;
// Service Ports
const SV_PORT = 31415;
const WS_PORT = 31416;
// Service Components
const PROTO = window.location.protocol;
const WS_PROTO = PROTO === "https:" ? "wss:" : "ws:";
const HOSTNAME = window.location.hostname;
const CURRENT_PATH = window.location.pathname.replace(/\/[^\/]*$/, "");
// Service URLs
const SV_URL = `${PROTO}//${HOSTNAME}:${SV_PORT}`;
const WS_URL = `${WS_PROTO}//${HOSTNAME}:${WS_PORT}`;
const SETTINGS_URL = `${SV_URL}/config`;
const VERSION_URL = `${SV_URL}/version`;
const WSPRNET_URL =
    "https://www.wsprnet.org/olddb?mode=html&band=all&limit=50&findreporter=&sort=date&findcall=";

// Websocket Creation
let ws;
const WS_RECONNECT = 5000; // Retry again every 5s

// Save the last time we sent a config to avoid reload messages on WebSockets
let lastSaveTimestamp = null;
// Keep track of any scheduled reloads
let pendingPopulateConfigTimeout = null;

// Semaphore for singleton data load
let populateConfigRunning = false;
// Semaphore to pause processing (reboot or shutdown)
let systemPaused = false;

// Wait for page to load
$(window).on("load", function () {
    bindActions();
    loadPage();
});

function loadPage() {
    initThemeToggle();
    setConnectionState("disconnected");
    connectWebSocket(WS_URL, WS_RECONNECT);
    populateConfig();
}

// Called after populateConfig() runs
function pageLoaded() {
    // Update items with callsign
    updateCallsign();

    // Update footer
    updateWsprryPiVersion();

    // Start clocks on page
    updateClocks();

    //
    // Per-Page Loaded Actions
    //

    if (typeof initLogStream === "function") {
        initLogStream();
    }

    // // If clickUseLED() exists (on index.php) then run it
    // if (typeof clickUseLED === "function") {
    //     clickUseLED();
    // }

    // // If clickUseShutdown() exists (on index.php) then run it
    // if (typeof clickUseShutdown === "function") {
    //     clickUseShutdown();
    // }

    // If validatePage() exists (on index.php) then run it
    if (typeof validatePage === "function") {
        validatePage();
    }

    // If fetchSPots() exists (on view_spots.php) then run it
    if (typeof fetchSpots === "function") {
        fetchSpots();
    }
}

function bindActions() {
    // Tooltips only hover (no focus), so clicking into inputs still works
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });
    // Reset tooltips on buttons/switch clicks
    $(document).on(
        "click",
        'a[data-bs-toggle="tooltip"], button[data-bs-toggle="tooltip"]',
        resetToolTips
    );

    // Bind the theme toggle
    $("#themeToggle").on("click", clickThemeToggle);

    // Update WSPRNet link and bind changes to callsign
    $('#callsign').on('input blur', updateCallsign);

    // Grab the modal element and its Bootstrap instance
    const systemModalEl = document.getElementById('systemModal');
    const systemModal = new bootstrap.Modal(systemModalEl, {
        backdrop: 'static',
        keyboard: false
    });

    // Reboot Button handler
    $('#rebootButton').off('click').on('click', () => {
        // Do NOT pause on reboot
        showSystemModal('reboot', false);
        sendCommand('reboot');
    });

    // Shutdown Button handler
    $('#shutdownButton').off('click').on('click', () => {
        // Pause on shutdown
        showSystemModal('shutdown');
        sendCommand('shutdown');
    });

    // Hook the Reload button
    $('#systemModal').on('click', '.reload-btn', () => {
        location.reload();
    });

    // Clean up on Exit / X (just unpause, do NOT reload)
    systemModalEl.addEventListener('hidden.bs.modal', () => {
        systemPaused = false;
    });

    //
    // Per-Page Bind Actions
    //

    // Config page bindings
    if (typeof bindIndexActions === "function") {
        bindIndexActions();
    }

    // Log viewer bindings
    if (typeof bindLogViewActions === "function") {
        bindLogViewActions();
    }

    // Spot viewer bindings
    if (typeof bindViewSpotsActions === "function") {
        bindViewSpotsActions();
    }
}

// Initialize on page load: read saved theme, set switch & label
function initThemeToggle() {
    const stored = localStorage.getItem("theme") || "light";
    const isDark = stored === "dark";
    $("#themeToggle").prop("checked", isDark);
    document.documentElement.setAttribute("data-bs-theme", stored);
    updateLabel(isDark);
}

// Update the theme toggle label
function updateLabel(isDark) {
    $("#themeToggleLabel").text(isDark ? "Dark" : "Light");
}

// Handler for clicking the theme toggle
function clickThemeToggle() {
    const isDark = this.checked;
    const newTheme = isDark ? "dark" : "light";
    document.documentElement.setAttribute("data-bs-theme", newTheme);
    localStorage.setItem("theme", newTheme);
    updateLabel(isDark);
}

// Initialize on page load: read saved theme, set switch & label
function initThemeToggle() {
    const stored = localStorage.getItem("theme") || "light";
    const isDark = stored === "dark";
    $("#themeToggle").prop("checked", isDark);
    document.documentElement.setAttribute("data-bs-theme", stored);
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
                $("#transmit").prop("checked", configJson["Control"]["Transmit"]);
                // [Common]
                $("#callsign").val(configJson["Common"]["Call Sign"]);
                $("#gridsquare").val(configJson["Common"]["Grid Square"]);
                $("#dbm").val(configJson["Common"]["TX Power"]);
                $("#frequencies").val(configJson["Common"]["Frequency"]);
                // [Extended]
                // Safely retrieve and parse the PPM value
                let ppmValue = parseFloat(configJson?.["Extended"]?.["PPM"]);

                // Check if ppmValue is a valid number, otherwise default to 0.0
                if (isNaN(ppmValue)) {
                    ppmValue = 0.0;
                }

                // Assign the valid double value to the input field
                $("#ppm").val(ppmValue.toFixed(2)); // Formats as a decimal (e.g., 3.14)
                $("#use_ntp").prop("checked", configJson["Extended"]["Use NTP"]);
                $("#useoffset").prop("checked", configJson["Extended"]["Offset"]);
                $("#use_led").prop("checked", configJson["Extended"]["Use LED"]);
                if (typeof setGPIOSelect === "function") {
                    setGPIOSelect(configJson["Extended"]["LED Pin"]);
                }

                // Enable or disable PPM based on NTP setting
                $("#ppm").prop("disabled", $("#use_ntp").is(":checked"));

                $("#tx-power-range")
                    // Set the slider to the configured power
                    .val(configJson.Extended["Power Level"])
                    // GFire the update once so the label shows up
                    .trigger("input");
                if (typeof updateTxPowerLabel === "function") {
                    updateTxPowerLabel();
                }

                // [Server]
                $("#use_shutdown").prop(
                    "checked",
                    configJson["Server"]["Use Shutdown"]
                );
                if (typeof setShutdownSelect === "function") {
                    setShutdownSelect(configJson["Server"]["Shutdown Button"]);
                }

                // Enable the form
                $("#submit").prop("disabled", false);
                $("#reset").prop("disabled", false);
                $("#wsprconfig").prop("disabled", false);

                // Do actions after page loaded
                pageLoaded();

                // Run callback if provided
                if (typeof callback === "function") {
                    callback();
                }
            } catch (error) {
                debugConsole("error", "Error parsing config JSON:", error);
                // Only try to load if the system is *not* paused
                if (!systemPaused) {
                    pendingPopulateConfigTimeout = setTimeout(populateConfig, 10000);
                }
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            debugConsole(
                "error",
                "Error fetching config JSON:",
                textStatus,
                errorThrown
            );
            // Only try to load if the system is *not* paused
            if (!systemPaused) {
                pendingPopulateConfigTimeout = setTimeout(populateConfig, 10000);
            }
        })
        .always(function () {
            populateConfigRunning = false;
        });
}

function resetToolTips(e) {
    const el = e.currentTarget;
    const inst = bootstrap.Tooltip.getInstance(el);
    if (inst) inst.hide();
}

/**
 * Update the connection-status icon and its tooltip.
 *
 * @param {'disconnected'|'connecting'|'connected'|'transmitting'} state
 * @param {string} [timestamp]  Optional timestamp for “transmitting”
 */
function setConnectionState(state, timestamp = "") {
    const icon = document.getElementById("connIcon");
    if (!icon) return;

    // Remove old state classes
    icon.classList.remove(
        "state-disconnected",
        "state-connecting",
        "state-connected",
        "state-transmitting"
    );

    // Add the new one
    icon.classList.add(`state-${state}`);

    // Choose the tooltip text
    let text;
    switch (state) {
        case "disconnected":
            text = "Disconnected.";
            break;
        case "connecting":
            text = "Connecting…";
            break;
        case "connected":
            text = "Ready.";
            break;
        case "transmitting":
            text = `Transmission in progress${timestamp ? ": " + timestamp : "."}`;
            break;
        default:
            text = "";
    }

    // Update Bootstrap’s tooltip data attr (do NOT set title)
    icon.setAttribute("data-bs-original-title", text);

    // Remove the native title so the browser never shows it
    icon.removeAttribute("title");

    // (Re)initialize or fetch the Tooltip instance, then update its content
    let inst = bootstrap.Tooltip.getInstance(icon);
    if (!inst) {
        inst = new bootstrap.Tooltip(icon, { trigger: "hover" });
    }
    inst.setContent({ ".tooltip-inner": text });
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
    if (!DEBUG && (method === "debug" || method === "log")) {
        return;
    }

    // If the console method exists, call it; otherwise fall back to console.log
    if (
        ["debug", "log", "warn", "error"].includes(method) &&
        typeof console[method] === "function"
    ) {
        console[method](...args);
    } else {
        console.log(...args);
    }
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
    setConnectionState("connecting");
    debugConsole("debug", `WebSocket ▶️ connecting to ${url}`);

    // Create the WebSocket
    ws = new WebSocket(url);
    // On open: update UI and log
    ws.addEventListener("open", () => {
        debugConsole("debug", "WebSocket ▶️ open");
        setConnectionState("connected");
        // If the systemModal is currently shown, re-enable its Reload button:
        // re-enable Reload if modal is showing for reboot
        const $reload = $("#systemModal .reload-btn");
        if ($reload.is(":visible")) {
            $reload.prop("disabled", false);
        }
        getTxState();
    });

    // On message: Try to parse JSON and react to “transmitting” or
    // "tx_state" state
    ws.addEventListener("message", (ev) => {
        debugConsole("debug", "WebSocket ◀️ message:", ev.data);
        let msg;
        try {
            msg = JSON.parse(ev.data);
        } catch (err) {
            debugConsole("warn", "WebSocket ⚠️ invalid JSON:", err);
            return;
        }

        // If the server is replying to our get_tx_state command:
        if (typeof msg.tx_state === "boolean") {
            // true → we’re currently transmitting; false → back to connected
            setConnectionState(msg.tx_state ? "transmitting" : "connected");
            debugConsole("log", "Received tx_state:", msg.tx_state);
            return; // done
        }

        // If the server pushes a “transmit” event:
        if (msg.type === "transmit") {
            if (msg.state === "starting") {
                const ts = new Date(msg.timestamp);
                setConnectionState("transmitting", ts);
                debugConsole("log", "Transmit started at:", ts.toString());
            } else if (msg.state === "finished") {
                setConnectionState("connected");
                debugConsole(
                    "log",
                    "Transmit finished at:",
                    new Date(msg.timestamp).toString()
                );
            }
        }
        // {"state":"reload","timestamp":"2025-04-27T22:25:43Z","type":"configuration"}
        if (msg.type === "configuration" && msg.state === "reload") {
            // Clear any pending retry
            if (pendingPopulateConfigTimeout) {
                clearTimeout(pendingPopulateConfigTimeout);
                pendingPopulateConfigTimeout = null;
            }

            // Reload if it’s been more than 2 min since our last save
            const now = Date.now();
            if (!lastSaveTimestamp || now - lastSaveTimestamp > 2 * 60 * 1000) {
                debugConsole("debug", "Reloading config by notification.");
                populateConfig();
            }
        }

        // …any other message types…
    });

    // On error: Log and treat as a disconnection
    ws.addEventListener("error", (err) => {
        debugConsole("error", "WebSocket ❌ error", err);
        setConnectionState("disconnected");
    });

    // On close: Schedule a reconnect
    ws.addEventListener("close", (ev) => {
        debugConsole(
            "warn",
            `WebSocket 🔌 closed (code=${ev.code}), reconnecting in ${reconnectDelay}ms`
        );
        setConnectionState("disconnected");
        // Only reconnect if the system is *not* paused
        if (!systemPaused) {
            setTimeout(() => connectWebSocket(url, reconnectDelay), reconnectDelay);
        }
    });

    // Return the socket in case the caller wants to send or inspect it
    return ws;
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
 * Update the connection-status icon and its tooltip.
 *
 * @param {'disconnected'|'connecting'|'connected'|'transmitting'} state
 * @param {string} [timestamp]  Optional timestamp for “transmitting”
 */
function setConnectionState(state, timestamp = "") {
    const icon = document.getElementById("connIcon");
    if (!icon) return;

    // Remove old state classes
    icon.classList.remove(
        "state-disconnected",
        "state-connecting",
        "state-connected",
        "state-transmitting"
    );

    // Add the new one
    icon.classList.add(`state-${state}`);

    // Choose the tooltip text
    let text;
    switch (state) {
        case "disconnected":
            text = "Disconnected.";
            break;
        case "connecting":
            text = "Connecting…";
            break;
        case "connected":
            text = "Ready.";
            break;
        case "transmitting":
            text = `Transmission in progress${timestamp ? ": " + timestamp : "."}`;
            break;
        default:
            text = "";
    }

    // Update Bootstrap’s tooltip data attr (do NOT set title)
    icon.setAttribute("data-bs-original-title", text);

    // Remove the native title so the browser never shows it
    icon.removeAttribute("title");

    // (Re)initialize or fetch the Tooltip instance, then update its content
    let inst = bootstrap.Tooltip.getInstance(icon);
    if (!inst) {
        inst = new bootstrap.Tooltip(icon, { trigger: "hover" });
    }
    inst.setContent({ ".tooltip-inner": text });
}

function updateCallsign() {
    // Update WSPRNet Link:
    const $link = $("#wsprnet-link");
    const $text = $link.find(".ms-2");
    const $cs = $("#callsign");
    const callsign = $cs.val().trim();

    if ($cs[0].checkValidity() && callsign !== "") {
        $link
            .attr("href", WSPRNET_URL + encodeURIComponent(callsign))
            .attr("title", `${callsign} on WSPRNet`);
        $text.text(`${callsign} on WSPRNet`);
    } else {
        $link.attr("href", WSPRNET_URL).attr("title", "WSPRNet Database");
        $text.text("WSPRNet Database");
    }

    // Update Spots For page card header
    if (typeof refreshSpotsHeader === "function") {
        refreshSpotsHeader();
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
                debugConsole("error", "Invalid JSON format from version.");
            }
        })
        .fail(function () {
            debugConsole("error", "Error fetching WSPR version.");
        });
}

function updateClocks() {
    const now = new Date();
    // Format HH:MM:SS
    const pad = (n) => String(n).padStart(2, "0");
    const local = [now.getHours(), now.getMinutes(), now.getSeconds()]
        .map(pad)
        .join(":");
    const utc = [now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds()]
        .map(pad)
        .join(":");

    // only write the times themselves
    document.getElementById("localTime").textContent = local;
    document.getElementById("utcTime").textContent = utc;

    // schedule next update right after the next full second
    const delay = 1000 - now.getMilliseconds();
    setTimeout(updateClocks, delay);
}
