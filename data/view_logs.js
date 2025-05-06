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

// Websocket Creation
let ws;
const WS_RECONNECT = 5000; // Retry again every 5s

// Semaphore for singleton data load
let populateConfigRunning = false;

$(window).on('load', function() {
    bindActions();
    initThemeToggle();
    initLogStream(); // Wire up logs immediately
    populateConfig(); // Fetch your config in parallel
});

function pageLoaded() {
    connectWebSocket(WS_URL, WS_RECONNECT);
    updateWSPRNetLink();
    updateWsprryPiVersion();
    updateClocks();
}

function bindActions() {
    // new — only hover (no focus), so clicking into inputs still works
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    // Bind the theme toggle
    $("#themeToggle").on("click", clickThemeToggle);

    // Bind clicks on buttons/switches for resetting tooltips
    $(document).on('click', 'a[data-bs-toggle="tooltip"], button[data-bs-toggle="tooltip"]', resetToolTips);

    // assuming you already have scrollLogsToBottom() defined
    $(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"]', () => {
        scrollLogsToBottom();
    });

    // Set connection indicator
    setConnectionState('disconnected');
}

// Data Load
function populateConfig(callback = null) {
    if (populateConfigRunning) return;
    populateConfigRunning = true;

    $.getJSON(SETTINGS_URL)
        .done(function(configJson) {
            try {
                if (!configJson || typeof configJson !== "object") {
                    throw new Error("Invalid JSON data received.");
                }

                // Assign values from JSON to form elements
                //
                $('#callsign').val(configJson["Common"]["Call Sign"]);

                // Do actions after page loaded
                pageLoaded();

                // Run callback if provided
                if (typeof callback === "function") {
                    callback();
                }
            } catch (error) {
                debugConsole('error', "Error parsing config JSON:", error);
                pendingPopulateConfigTimeout = setTimeout(populateConfig, 10000);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            debugConsole('error', "Error fetching config JSON:", textStatus, errorThrown);
            // Only try to load if the system is *not* paused
            pendingPopulateConfigTimeout = setTimeout(populateConfig, 10000);
        })
        .always(function() {
            populateConfigRunning = false;
        });
}

function resetToolTips(e) {
    const el = e.currentTarget;
    const inst = bootstrap.Tooltip.getInstance(el);
    if (inst) inst.hide();
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
            return; // done
        }

        // If the server pushes a “transmit” event:
        if (msg.type === 'transmit') {
            if (msg.state === 'starting') {
                const ts = new Date(msg.timestamp);
                setConnectionState('transmitting', ts);
                debugConsole('log', 'Transmit started at:', ts.toString());
            } else if (msg.state === 'finished') {
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
        setTimeout(() => connectWebSocket(url, reconnectDelay), reconnectDelay);
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
        inst = new bootstrap.Tooltip(icon, {
            trigger: 'hover'
        });
    }
    inst.setContent({
        '.tooltip-inner': text
    });
}

/**
 * Request the current transmit state from the server.
 * Server should reply with JSON: { tx_state: true|false }
 */
function getTxState() {
    if (ws && ws.readyState === WebSocket.OPEN) {
        ws.send(JSON.stringify({
            command: "get_tx_state"
        }));
    } else {
        console.warn("WebSocket not open; cannot request TX state.");
    }
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
        .done(function(response) {
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
        .fail(function() {
            debugConsole('error', 'Error fetching WSPR version.');
        });
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

function scrollLogsToBottom() {
    // this is the element that actually scrolls
    const scrollContainer = document.querySelector('.logs-card .card-body');
    if (scrollContainer) {
        scrollContainer.scrollTop = scrollContainer.scrollHeight;
    }
}

/**
 * initLogStream
 * -------------
 * Wire up the EventSource handlers and beforeunload logic.
 */
function initLogStream() {
    // Path for log display
    const url = `${PROTO}//${HOSTNAME}${CURRENT_PATH}/logs_stream.php`;
    const evt = new EventSource(url);
    let isReloading = false;

    // avoid the “unexpected close” warning when reloading
    window.addEventListener('beforeunload', () => {
        isReloading = true;
        evt.close();
    });

    evt.onopen = () => {
        debugConsole('log', '🎉 Connected to log stream');
    };

    evt.onmessage = e => {
        try {
            const {
                stream,
                line
            } = JSON.parse(e.data);
            const time = new Date().toLocaleTimeString();
            const $pane = $('#' + stream);
            $pane.append(
                `<div>${line}</div>`
            );
            scrollLogsToBottom();
        } catch (err) {
            debugConsole('error', 'Parse error', err);
        }
    };

    evt.onerror = () => {
        if (evt.readyState === EventSource.CLOSED && !isReloading) {
            debugConsole('warn', 'SSE connection closed unexpectedly.');
        }
        // otherwise, we’re just auto‐reconnecting—ignore
    };
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
