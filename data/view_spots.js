// view_spots.js
; (function ($) {
    'use strict';

    // Lookback window (minutes)
    const MINUTES = 60;

    // Client‐side cache TTL before hitting server‐proxy again (ms)
    const TTL_MS = 2 * 60 * 1000;    // 2 minutes

    // Auto-refresh interval (ms)
    const REFRESH_MS = 5 * 60 * 1000;    // 5 minutes

    // Columns to show
    const COLUMNS = [
        "time",
        "tx_sign",
        "frequency",
        "snr",
        "drift",
        "tx_loc",
        "power",
        "rx_sign",
        "rx_loc",
        "distance",
        "code",
        "version",
    ];

    // Map numeric codes → human modes
    const CODE_MAP = {
        1: "WSPR-2",
        2: "WSPR-15",
        3: "FST4W-120",
        4: "FST4W-300",
        5: "FST4W-900",
        8: "FST4W-1800",
    };

    // Column header names
    const HEADERS = {
        time: "Timestamp",
        tx_sign: "Transmitter",
        frequency: "Freq (Hz)",
        snr: "SNR (dB)",
        drift: "Drift (Hz)",
        tx_loc: "TX Grid",
        power: "Power (dBm)",
        rx_sign: "Receiver",
        rx_loc: "RX Grid",
        distance: "Distance (km)",
        code: "Type",
        version: "Decoder Ver.",
    };

    let _cacheData = null,
        _cacheTS = 0;

    // Show a Bootstrap spinner in the card-body
    function renderLoading() {
        $('.card-body.tab-content').html(`
        <div class="d-flex justify-content-center my-5">
            <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading…</span>
            </div>
        </div>
        `);
    }
    
        // Helper: format UTC date → "YYYY-MM-DD HH:MM:SS"
    function utcString(d) {
        return d.toISOString().slice(0, 19).replace('T', ' ');
    }

    // Render a loading spinner in the card-body
    function renderLoading() {
        $('.card-body.tab-content').html(`
        <div class="d-flex justify-content-center my-5">
            <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading…</span>
            </div>
        </div>
        `);
    }

    // Render an error message in the card-body
    function renderError(msg){
        $('.card-body.tab-content')
        .html(`<p class="text-danger">${msg}</p>`);
    }

    // Render the table of spots and scroll to bottom
    function renderTable(spots) {
        const $c = $('.card-body.tab-content').empty();
        if (!Array.isArray(spots) || spots.length === 0) {
            return $c.html("<p>No spots in the last 2 hours.</p>");
        }
    
        // Build responsive table wrapper
        const $wrap  = $('<div>').addClass('table-responsive');
        const $tbl   = $('<table>')
            .addClass('table table-striped table-hover table-sm table-bordered align-middle');
        const $thead = $('<thead>').addClass('table-light');
        const $hrow  = $('<tr>');
    
        // HEADER
        COLUMNS.forEach(col => {
            $('<th>')
                .attr('scope', 'col')
                .text(HEADERS[col] || col.toUpperCase())
                .appendTo($hrow);
        });
        $thead.append($hrow);
        $tbl.append($thead);
    
        // BODY
        const $tbody = $('<tbody>');
        spots.forEach(spot => {
            const $tr = $('<tr>');
            COLUMNS.forEach(col => {
                let val = spot[col];
                if (col === 'code') {
                    val = CODE_MAP[val] || val;
                }
                $('<td>').text(val).appendTo($tr);
            });
            $tbody.append($tr);
        });
        $tbl.append($tbody);
    
        // Inject into DOM
        $wrap.append($tbl);
        $c.append($wrap);
    
        // Scroll the inner pane to the bottom
        const $pane = $('.spots-card .table-responsive');
        setTimeout(() => {
            $pane.scrollTop($pane.prop('scrollHeight'));
        }, 0);
    }

    // Schedule next refresh using constant
    function scheduleNext() {
        setTimeout(fetchSpots, REFRESH_MS);
    }

    // Fetch, parse, render, handle errors, cache & repeat
    function fetchSpots(){
        const now      = Date.now();
        const callSign = $('#callsign').val().toUpperCase().trim();

        if(!callSign){
        renderError('Please enter a callsign.');
        return scheduleNext();
        }

        // Client cache
        if(_cacheData && (now - _cacheTS) < TTL_MS){
        renderTable(_cacheData);
        return scheduleNext();
        }

        // Show loading spinner
        renderLoading();

        // Build time window
        const end   = new Date(now);
        const start = new Date(now - MINUTES * 60 * 1000);

        $.ajax({
        url:      'fetch_spots.php',
        dataType: 'text',
        cache:    false,
        data: {
            tx_sign: callSign,
            start:   utcString(start),
            end:     utcString(end)
        }
        })
        .done(raw => {
        const lines = $.trim(raw).split('\n').filter(l => l);
        let data;
        try {
            data = lines.map(l => JSON.parse(l));
        } catch {
            return renderError('Invalid data received.');
        }
        // Optional extra filter for last 2h
        const cutoff = now - 2 * 3600 * 1000;
        data = data.filter(s => {
            const ts = Date.parse(s.time + 'Z');
            return !isNaN(ts) && ts >= cutoff;
        });
        _cacheData = data;
        _cacheTS   = now;
        renderTable(data);
        })
        .fail((_, status) => {
        console.error('Fetch error:', status);
        renderError('Error loading spots.');
        })
        .always(scheduleNext);
    }

    // Expose for external callers
    window.fetchSpots = fetchSpots;

})(jQuery);
