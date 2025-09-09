function bindLogViewActions() {
    // assuming you already have scrollLogsToBottom() defined
    $(document).on("shown.bs.tab", 'button[data-bs-toggle="tab"]', () => {
        scrollLogsToBottom();
    });
}

function scrollLogsToBottom() {
    // this is the element that actually scrolls
    const scrollContainer = document.querySelector(".logs-card .card-body");
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
    window.addEventListener("beforeunload", () => {
        isReloading = true;
        evt.close();
    });

    evt.onopen = () => {
        debugConsole("debug", "🎉 Connected to log stream");
    };

    evt.onmessage = (e) => {
        try {
            const { stream, line } = JSON.parse(e.data);
            const time = new Date().toLocaleTimeString();
            const $pane = $("#" + stream);
            $pane.append(`<div>${line}</div>`);
            scrollLogsToBottom();
        } catch (err) {
            debugConsole("error", "Parse error", err);
        }
    };

    evt.onerror = () => {
        if (evt.readyState === EventSource.CLOSED && !isReloading) {
            debugConsole("warn", "SSE connection closed unexpectedly.");
        }
        // otherwise, we’re just auto‐reconnecting—ignore
    };
}
