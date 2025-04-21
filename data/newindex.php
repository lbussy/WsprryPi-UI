<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootswatch Zephyr with Fixed Navbar, Form Sections & Footer</title>
    <link rel="icon" type="image/x-icon" href="/wsprrypi/favicon.ico">
    <!-- Bootswatch Zephyr CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/zephyr/bootstrap.min.css"
        rel="stylesheet"
        crossorigin="anonymous" />
    <style>
        /* Ensure page content isn’t covered by the fixed navbar or footer */
        body {
            padding-top: 56px;
            /* navbar height */
            padding-bottom: 56px;
            /* footer height */
        }
    </style>
    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        rel="stylesheet"
        crossorigin="anonymous" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/e51821420e.js" crossorigin="anonymous"></script>

    <style>
        /* Make room for an icon on every form-control */
        .form-control {
            padding-right: 2.5rem;
        }

        /* Any container you want icons in must be position-relative */
        .position-relative .valid-icon,
        .position-relative .invalid-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            display: none;
            pointer-events: none;
        }

        /* Show the right icon based on is-valid / is-invalid */
        .form-control.is-valid+.valid-icon {
            display: block;
        }

        .form-control.is-invalid+.invalid-icon {
            display: block;
        }

        /* Show feedback text when in was-validated or using is-valid / is-invalid */
        .was-validated .form-control:valid~.valid-feedback,
        .form-control.is-valid~.valid-feedback {
            display: block;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .form-control.is-invalid~.invalid-feedback {
            display: block;
        }
    </style>
    <style>
        /* Ensure the input has the right size & positioning */
        input#themeToggle.form-check-input {
            position: relative !important;
            width: 1.60rem !important;
            /* Match Bootstrap’s switch width */
            height: .87rem !important;
            /* Match Bootstrap’s switch height */
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.5rem !important;
            margin-left: auto;
            /* Preserve centering in your layout */
        }

        /* Draw our own thumb */
        input#themeToggle.form-check-input::before {
            content: "" !important;
            position: absolute !important;
            top: 0.0rem !important;
            /* Vertically center */
            left: 0.68rem !important;
            /* Start at left */
            width: .75rem !important;
            /* Thumb size */
            height: .75rem !important;
            background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
            border-radius: 50% !important;
            transition: transform .15s ease-in-out !important;
        }

        /* Move thumb to the right when checked */
        input#themeToggle.form-check-input:checked::before {
            transform: translateX(calc(100% - 1.37rem)) !important;
        }

        /* Keep the focus ring */
        input#themeToggle.form-check-input:focus {
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25) !important;
        }

        /* Make the Dark/Light label match Bootstrap’s nav‑link color */
        .navbar .form-check-label {
            color: var(--bs-nav-link-color) !important;
            margin-bottom: 0 !important;
        }

        /* Vertically center the switch and its label in the navbar */
        .navbar .form-check.form-switch {
            display: flex;
            align-items: center;
        }

        /* Make sure the label has no extra bottom margin */
        .navbar .form-check-label {
            margin-bottom: 0 !important;
        }

        /* Remove default left‑padding so our inline‑flex aligns perfectly */
        .form-check.form-switch.d-inline-flex {
            padding-left: 0;
            padding-right: 0;
        }

        /* After your other navbar CSS */
        .navbar .form-check-label.toggle-text {
            display: inline-block;
            width: 5ch;
            /* Enough room for “Light” (5 letters) */
            text-align: right;
        }
    </style>
    <style>
        /* Make the horizontal padding of the card wider */
        .card .card-body {
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
        }

        /* Increase horizontal gutter between all columns inside card-body */
        .card .card-body .row {
            --bs-gutter-x: 2rem;
            /* Default is 1rem */
        }
    </style>
    <style>
        /* Smaller text */
        .card-header .text-end.small {
            font-size: 0.75rem !important;
        }

        /* Make the card‑header a bit less tall */
        .card-header {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
            /* keep left/right padding if you like */
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        /* Remove any extra gap around the time block */
        .card-header .time-block {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.2;
            /* tighten up the line spacing */
        }

        /* Reduce the margins */
        .card-header .time-block>div {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Set width of time block */
        .card-header .time-block {
            /* width to fit “Local Time: 00:00:00” */
            flex: 0 0 27ch;
            width: 27ch;
            /* optional: use monospace so digits align perfectly */
            /* font-family: monospace; */
        }

        /* Highlight the header buttons on hover */
        .card-header .btn-link:hover {
            color: var(--bs-nav-link-hover-color) !important;
            text-decoration: none;
            /* or underline if you’d like */
            cursor: pointer;
        }

        .card-header .btn-link:hover {
            background-color: rgba(var(--bs-nav-link-hover-color-rgb), .1) !important;
        }
    </style>

</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">MyApp</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav"
                aria-controls="mainNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <!-- add align-items-center here -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <!-- make this li a flex container too -->

                    <li class="nav-item ms-3">
                        <div
                            class="form-check form-switch d-inline-flex align-items-center mb-0 text-white"
                            style="gap: .5rem;">
                            <label
                                class="form-check-label mb-0 toggle-text"
                                for="themeToggle"
                                id="themeToggleLabel">Dark</label>
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="themeToggle">
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Connected to: <?php echo gethostname(); ?></span>
                <div class="d-flex align-items-center time-block text-end small">
                    <!-- icons -->
                    <form action="semaphore.php" method="post">
                        <input type="hidden" name="action" value="reboot">
                        <button
                            type="submit"
                            class="btn btn-link text-body p-0 me-2 custom-tooltip"
                            data-bs-toggle="tooltip"
                            title="Reboot">
                            <i class="fa-solid fa-rotate-right me-2" style="cursor: pointer;"></i>
                        </button>
                    </form>
                    <form action="semaphore.php" method="post">
                        <input type="hidden" name="action" value="shutdown">
                        <button
                            type="submit"
                            class="btn btn-link text-body p-0 me-2 custom-tooltip"
                            data-bs-toggle="tooltip"
                            title="Shutdown">
                            <i class="fa-solid fa-power-off me-3" style="cursor: pointer;"></i>
                        </button>
                    </form>
                    <!-- times -->
                    <div>
                        <div id="localTime">Local Time: --:--:--</div>
                        <div id="utcTime">UTC Time: --:--:--</div>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <form class="needs-validation" novalidate>

                    <!-- Section 1 (inline labels & controls) -->
                    <fieldset class="mb-4">
                        <legend>Section 1</legend>
                        <div class="row gx-3">
                            <!-- Left column: switch with label on its left -->
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch form-check-reverse mb-0">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="section1-switch-left">
                                    <label
                                        class="form-check-label mb-0"
                                        for="section1-switch-left">Enable</label>
                                </div>
                            </div>

                            <!-- Right column: switch + dropdown, with label above dropdown when wrapping -->
                            <div class="col-md-6">
                                <div class="row gx-2 align-items-center">
                                    <!-- Option switch -->
                                    <div class="col-auto d-flex align-items-center mb-2 mb-md-0 me-md-4">
                                        <div class="form-check form-switch form-check-reverse mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="section1-switch-right">
                                            <label
                                                class="form-check-label mb-0"
                                                for="section1-switch-right">Option</label>
                                        </div>
                                    </div>
                                    <!-- Dropdown label: full width on xs/sm, auto width on md+ -->
                                    <div class="col-12 col-md-auto mb-1 mb-md-0">
                                        <label
                                            for="section1-dropdown"
                                            class="form-label mb-0">Choose:</label>
                                    </div>
                                    <!-- Dropdown select: full width on xs/sm, auto width on md+ -->
                                    <div class="col-12 col-md-auto">
                                        <select
                                            id="section1-dropdown"
                                            class="form-select form-select-sm w-100 w-md-auto mb-0">
                                            <option selected>Choose…</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 2 -->
                    <fieldset class="mb-4">
                        <legend>Section 2</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="section6-field1" class="form-label mb-0">Label 1</label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section6-field1"
                                            class="form-control"
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Right column -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="section6-field2" class="form-label mb-0">Label 2</label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section6-field2"
                                            class="form-control"
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 3 -->
                    <fieldset class="mb-4">
                        <legend>Section 3</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column: label + text input -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="section3-field1" class="form-label mb-0">Label 1</label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section3-field1"
                                            class="form-control"
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right column: label + text input, then switch + label -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label for="section3-field2" class="form-label mb-0">Label 2</label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="text"
                                            id="section3-field2"
                                            class="form-control"
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <div class="form-check form-switch form-check-reverse mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="section3-switch" />
                                            <label
                                                class="form-check-label mb-0"
                                                for="section3-switch">Option</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 4 -->
                    <fieldset class="mb-4">
                        <legend>Section 4</legend>
                        <div class="row gx-2 align-items-center">
                            <!-- Left column: switch with label on its left -->
                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check form-switch form-check-reverse mb-0">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="section4-switch"
                                        required />
                                    <label
                                        class="form-check-label mb-0"
                                        for="section4-switch">Enable</label>
                                </div>
                            </div>

                            <!-- Right column: label + numeric input -->
                            <div class="col-md-6 mb-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto text-end">
                                        <label
                                            for="section4-number"
                                            class="form-label mb-0">Value</label>
                                    </div>
                                    <div class="col position-relative">
                                        <input
                                            type="number"
                                            id="section4-number"
                                            class="form-control"
                                            min="-200"
                                            max="200"
                                            step="0.000001"
                                            required />
                                        <div class="valid-feedback">Valid</div>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 5 -->
                    <fieldset class="mb-4">
                        <legend>Section 5</legend>
                        <div class="d-flex justify-content-center align-items-center">
                            <input
                                type="range"
                                id="section5-range"
                                class="form-range me-3"
                                style="width: 60%;"
                                min="0"
                                max="7"
                                step="1"
                                value="0" />
                            <label for="section5-range" class="form-label mb-0">
                                Level: <span id="section5-range-value" class="fw-bold">0</span>
                            </label>
                        </div>
                    </fieldset>

                    <!-- Section 6 -->
                    <fieldset class="mb-4">
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                Reset
                            </button>
                        </div>
                    </fieldset>

                </form>
            </div>
            <div class="card-footer text-muted">2 days ago</div>
        </div>
    </div>

    <!-- Fixed Footer -->
    <footer class="fixed-bottom bg-primary text-white">
        <div class="container text-center py-3">
            © 2025 MyApp
        </div>
    </footer>

    <!-- jQuery 3.7.1 -->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>
    <!-- Bootstrap Bundle JS (Includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous">
    </script>
    <script>
        // Example jQuery usage
        $(function() {
            $('.card').on('click', function() {
                // alert('Card clicked!');
            });
        });
    </script>
    <script>
        $(function() {
            const $form = $('.needs-validation');

            $form.on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $form.addClass('was-validated');
            });

            // Live toggle of is-valid / is-invalid for every form-control
            $form.find('.form-control').on('input', function() {
                const $el = $(this);
                if (this.checkValidity()) {
                    $el.addClass('is-valid').removeClass('is-invalid');
                } else {
                    $el.addClass('is-invalid').removeClass('is-valid');
                }
            });
        });
    </script>
    <script>
        // Live update of the range readout
        $('#section5-range').on('input', function() {
            $('#section5-range-value').text(this.value);
        });
    </script>
    <script>
        $(function() {
            const toggle = $('#themeToggle');
            const label = $('#themeToggleLabel');

            // Helper to set label based on checked state
            function updateLabel(isDark) {
                label.text(isDark ? 'Dark' : 'Light');
            }

            // On load: Read stored theme (default to light)
            const stored = localStorage.getItem('theme') || 'light';
            const isDark = stored === 'dark';
            toggle.prop('checked', isDark);
            document.documentElement.setAttribute('data-bs-theme', stored);
            updateLabel(isDark);

            // On change: Toggle theme, persist, and update label
            toggle.on('change', function() {
                const newTheme = this.checked ? 'dark' : 'light';
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateLabel(this.checked);
            });
        });
    </script>
    <script>
        function updateClocks() {
            const now = new Date();
            // Format HH:MM:SS
            const pad = n => String(n).padStart(2, '0');
            const local = [now.getHours(), now.getMinutes(), now.getSeconds()]
                .map(pad).join(':');
            const utc = [now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds()]
                .map(pad).join(':');
            document.getElementById('localTime').textContent = `Local Time: ${local}`;
            document.getElementById('utcTime').textContent = `UTC Time:   ${utc}`;
        }
        updateClocks();
        setInterval(updateClocks, 1000);
    </script>
</body>

</html>