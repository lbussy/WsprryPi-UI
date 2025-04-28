<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>Wsprry Pi Logs</title>
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

    <style>
        .logs-card {
            display: flex;
            flex-direction: column;
            /* exactly fit between navbar (56px), footer (56px), and your 3rem top margin */
            height: calc(100vh - 56px - 56px - 3rem);
            /* pick *either* this… */
            margin-top: 3rem;
        }

        /* only the body scrolls */
        .logs-card .card-body {
            flex: 1;
            overflow-y: auto;
            background: #111;
            color: #eee;
            font-family: monospace;
            padding: 0.5rem;
        }

        .pane {
            height: 100%;
            /* fill the card-body */
            overflow-y: auto;
            /* each pane scrolls itself */
            background: #111;
            color: #eee;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <span class="navbar-brand">
                <i id="connIcon" data-bs-toggle="tooltip" data-bs-original-title="Disconnected."
                    class="fa-solid fa-tower-broadcast"></i>
                Wsprry Pi Logs
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Navbar List Items -->
                <ul class="navbar-nav ms-auto align-items-center">

                    <!-- Wsprry Pi Config -->
                    <li class="nav-item">
                        <a
                            class="nav-link custom-tooltip"
                            href="index.php"
                            target="_self"
                            rel="noopener"
                            data-bs-toggle="tooltip"
                            title="WSPR Config">
                            <i class="fa-solid fa-wrench"></i>
                            <span class="ms-2">WSPR Config</span>
                        </a>
                    </li>
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
                    <!-- Wsprry Pi Repo (GitHub) -->
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

    <!-- Logs Here -->
    <div class="container my-5">
        <div class="card shadow-sm logs-card mt-5">

            <div class="card-header d-flex flex-wrap align-items-center">
                <!-- 1) Label (never shrinks) -->
                <span class="me-2 flex-shrink-0">
                    Logs for: <?php echo gethostname(); ?>
                </span>

                <!-- break between label and tabs on mobile (<md) -->
                <div class="w-100 d-md-none"></div>

                <!-- 2) Tabs (flexible; pushes controls to the right on desktop) -->
                <ul class="nav nav-tabs flex-shrink-1 me-auto" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#info-pane"
                            type="button"
                            role="tab"
                            aria-controls="info-pane"
                            aria-selected="true">Standard</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="error-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#error-pane"
                            type="button"
                            role="tab"
                            aria-controls="error-pane"
                            aria-selected="false">Errors</button>
                    </li>
                </ul>

                <!-- break between tabs and controls on mobile (<md) -->
                <div class="w-100 d-md-none"></div>

                <!-- 3) Controls (never shrinks) -->
                <div class="d-flex align-items-center flex-shrink-0">
                    <!-- Reboot / Shutdown buttons -->
                    <button id="rebootButton" class="btn btn-link p-0 me-2" title="Reboot">
                        <i class="fa-solid fa-rotate-right fa-lg"></i>
                    </button>
                    <button id="shutdownButton" class="btn btn-link p-0 me-3" title="Shutdown">
                        <i class="fa-solid fa-power-off fa-lg"></i>
                    </button>
                    <!-- Clocks -->
                    <div class="small text-end">
                        <div>
                            <span class="time-label">Local:</span>
                            <span class="time-value" id="localTime">--:--:--</span>
                        </div>
                        <div>
                            <span class="time-label">UTC:</span>
                            <span class="time-value" id="utcTime">--:--:--</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card body: only these two panes swap -->
            <div class="card-body tab-content">
                <!-- INFO pane -->
                <div
                    id="info-pane"
                    class="tab-pane fade show active"
                    role="tabpanel"
                    aria-labelledby="info-tab">
                    <div id="info" class="pane info">
                        <!-- live INFO logs append here -->
                    </div>
                </div>

                <!-- ERROR pane -->
                <div
                    id="error-pane"
                    class="tab-pane fade"
                    role="tabpanel"
                    aria-labelledby="error-tab">
                    <div id="error" class="pane error">
                        <!-- live ERROR logs append here -->
                    </div>
                </div>

                <!-- Hidden fieldset to hold settings -->
                <div id="server-settings" class="d-none">
                    <input type="text" id="callsign" name="callsign" value="" />
                </div>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
    </script>

    <!-- Bootstrap Bundle JS (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <script>
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
                        `<div><span class="timestamp">[${time}]</span>${line}</div>`
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
    </script>

</body>

</html>