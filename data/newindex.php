<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootswatch Zephyr with Fixed Navbar, Form Sections & Footer</title>
    <!-- Bootswatch Zephyr CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/zephyr/bootstrap.min.css"
        rel="stylesheet"
        crossorigin="anonymous" />
    <style>
        /* ensure page content isn’t covered by the fixed navbar or footer */
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
    <style>
        /* make room for an icon on every form-control */
        .form-control {
            padding-right: 2.5rem;
        }

        /* any container you want icons in must be position-relative */
        .position-relative .valid-icon,
        .position-relative .invalid-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            display: none;
            pointer-events: none;
        }

        /* show the right icon based on is-valid / is-invalid */
        .form-control.is-valid+.valid-icon {
            display: block;
        }

        .form-control.is-invalid+.invalid-icon {
            display: block;
        }

        /* show feedback text when in was-validated or using is-valid / is-invalid */
        .was-validated .form-control:valid~.valid-feedback,
        .form-control.is-valid~.valid-feedback {
            display: block;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .form-control.is-invalid~.invalid-feedback {
            display: block;
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">Featured</div>
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
                            <button type="submit" class="btn btn-success">
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

            // live toggle of is-valid / is-invalid for every form-control
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
        // live update of the range readout
        $('#section5-range').on('input', function() {
            $('#section5-range-value').text(this.value);
        });
    </script>
</body>

</html>