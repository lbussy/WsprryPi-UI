<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <!-- Bootswatch, Boostrap, and Fontawesome, included here: -->
    <?php require_once 'header.php'; ?>

    <!-- This page's css -->
    <link rel="stylesheet" href="site.css" />

    <!-- This page's css -->
    <link rel="stylesheet" href="view_logs.css" />
</head>

<body>
    <!-- Fixed Navbar -->
    <?php require_once 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="card shadow-sm logs-card mt-5">

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <!-- Card Title -->
                <span>Logs for: <?php echo gethostname(); ?></span>

                <!-- Break after title on XS only -->
                <div class="w-100 d-sm-none"></div>

                <!-- Group wrapper: Icons + Clocks -->
                <div class="d-flex flex-wrap align-items-center group-wrapper">
                    <!-- icons -->
                    <div class="icons-wrapper d-flex align-items-center mb-2 mb-sm-0 me-sm-3">
                        <!-- Reboot button with extra right margin -->
                        <button
                            type="button"
                            id="rebootButton"
                            class="btn btn-link text-body p-0 custom-tooltip me-2"
                            data-bs-toggle="tooltip"
                            title="Reboot">
                            <i class="fa-solid fa-rotate-right fa-lg"></i>
                        </button>

                        <!-- Shutdown button -->
                        <button
                            type="button"
                            id="shutdownButton"
                            class="btn btn-link text-body p-0 custom-tooltip"
                            data-bs-toggle="tooltip"
                            title="Shutdown">
                            <i class="fa-solid fa-power-off fa-lg"></i>
                        </button>
                    </div>

                    <!-- Break between icons and times on XS only -->
                    <div class="w-100 d-sm-none"></div>

                    <!-- Local and UTC Times -->
                    <div class="times-wrapper small mb-2 mb-sm-0">
                        <!-- Local Time Line -->
                        <div class="time-line d-flex align-items-center">
                            <span class="time-label">Local Time:</span>
                            <span class="time-value" id="localTime">--:--:--</span>
                        </div>
                        <!-- UTC Time Line -->
                        <div class="time-line d-flex align-items-center">
                            <span class="time-label">UTC Time:</span>
                            <span class="time-value" id="utcTime">--:--:--</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body tab-content">
                <div
                    id="info-pane"
                    class="tab-pane fade show active"
                    role="tabpanel"
                    aria-labelledby="info-tab">
                    <div id="info" class="pane info">
                        <!-- live INFO logs append here -->
                    </div>
                </div>

                <!-- Hidden fieldset to hold settings -->
                <div id="server-settings" class="d-none">
                    <input type="text" id="callsign" name="callsign" value="" />
                </div>
            </div>
        </div>
    </div>

    <!-- System action modal -->
    <?php require_once 'system_action_modal.php'; ?>

    <!-- Static page footer -->
    <?php require_once 'footer.php'; ?>

    <!-- jQuery and Bootswatch -->
    <?php require_once 'site.js.includes.php'; ?>

    <!-- Main JavaScript -->
    <script src="site.js"></script>

    <!-- Index JavaScript -->
    <script src="view_logs.js"></script>
</body>

</html>