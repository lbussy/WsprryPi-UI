<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>WsprryPi Live Logs</title>
    <link rel="icon" type="image/x-icon" href="/wsprrypi/favicon.ico">

    <style>
        body {
            display: flex;
            gap: 1rem;
            font-family: monospace;
        }

        .pane {
            flex: 1;
            height: 80vh;
            overflow-y: auto;
            padding: 0.5rem;
            background: #111;
            color: #eee;
        }

        .info {
            border: 2px solid #4caf50;
        }

        .error {
            border: 2px solid #f44336;
        }

        .timestamp {
            color: #888;
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div id="info" class="pane info">
        <h3>INFO</h3>
    </div>
    <div id="error" class="pane error">
        <h3>ERROR</h3>
    </div>

    <!-- jQuery 3.7.1 -->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

    <script>
        const basePath = window.location.pathname.replace(/\/[^\/]*$/, '') || '/';
        const url = window.location.origin + basePath + '/logs_stream.php';
        const evt = new EventSource(url);

        let isReloading = false;
        window.addEventListener('beforeunload', () => {
            // Signal that we’re intentionally tearing down
            isReloading = true;
            // Close the SSE connection so no onerror is fired afterwards
            evt.close();
        });

        evt.onopen = () => {
            console.info('🎉 Connected to log stream');
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
                $pane.scrollTop($pane[0].scrollHeight);
            } catch (err) {
                console.error('Parse error', err);
            }
        };

        evt.onerror = () => {
            if (evt.readyState === EventSource.CLOSED) {
                if (!isReloading) {
                    console.warn('SSE connection closed unexpectedly.');
                }
            }
            // else: still in retry‐loop—ignore or log at debug‐level only
        };
    </script>
</body>

</html>