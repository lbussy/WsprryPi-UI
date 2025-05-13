<?php
// Determine the current page (just the filename)
$current = basename($_SERVER['PHP_SELF']); // e.g. "index.php" or "view_logs.php"

// Decide what the navbar title should be
if ($current === 'index.php') {
    $navBarTitle = 'Wsprry Pi Configuration';
} elseif ($current === 'view_logs.php') {
    $navBarTitle = 'Wsprry Pi Logs';
} elseif ($current === 'view_spotr.php') {
    $navBarTitle = 'Wsprry Pi Spots';
} else {
    $navBarTitle = 'Wsprry Pi Configuration'; // Fallback
}
?>

<!-- Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
        <span class="navbar-brand">
            <i
                id="connIcon"
                data-bs-toggle="tooltip"
                data-bs-original-title="Disconnected."
                class="fa-solid fa-tower-broadcast"></i>
            <?= htmlspecialchars($navBarTitle) ?>
        </span>
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
            <!-- Navbar List Items -->
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Wsprry Pi UI Choice -->
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="wsprpiDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Wsprry Pi Application
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="wsprpiDropdown">
                        <li>
                            <a
                                class="dropdown-item <?= $current === 'index.php' ? 'disabled' : '' ?>"
                                href="index.php"
                                <?= $current === 'index.php' ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                Configuration
                            </a>
                        </li>
                        <li>
                            <a
                                class="dropdown-item <?= $current === 'view_logs.php' ? 'disabled' : '' ?>"
                                href="view_logs.php"
                                <?= $current === 'view_logs.php' ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                Logs
                            </a>
                        </li>
                        <li>
                            <a
                                class="dropdown-item <?= $current === 'view_spots.php' ? 'disabled' : '' ?>"
                                href="view_spots.php"
                                <?= $current === 'view_spots.php' ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                Spots
                            </a>
                        </li>
                    </ul>
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
                        class="form-check form-switch d-inline-flex align-items-center mb-0 text-white">
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