<?php
/**
 * Bus Management System - Main Entry Point
 */

require_once 'config/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    // Show login page directly without redirect
    include 'src/views/login.php';
    exit;
}

$page = isset($_GET['page']) ? sanitize($_GET['page']) : 'dashboard';
$user = getCurrentUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Dashboard</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><?php echo APP_NAME; ?></h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="?page=dashboard" class="nav-link">Dashboard</a></li>
                    
                    <?php if ($user['role'] === 'admin' || $user['role'] === 'manager'): ?>
                    <li>
                        <a href="#" class="nav-link dropdown-toggle">Vehicles</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=vehicles-list">List Vehicles</a></li>
                            <li><a href="?page=vehicle-register">Register Vehicle</a></li>
                            <li><a href="?page=vehicle-terminate">Terminate Vehicle</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link dropdown-toggle">Routes</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=routes-list">View Routes</a></li>
                            <li><a href="?page=route-create">Create Route</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link dropdown-toggle">Schedules</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=schedules-list">View Schedules</a></li>
                            <li><a href="?page=schedule-create">Create Schedule</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link dropdown-toggle">Drivers</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=drivers-list">List Drivers</a></li>
                            <li><a href="?page=driver-register">Register Driver</a></li>
                        </ul>
                    </li>
                    <li><a href="?page=bookings" class="nav-link">Bookings</a></li>
                    <li><a href="?page=payments" class="nav-link">Payments</a></li>
                    <li><a href="?page=maintenance" class="nav-link">Maintenance</a></li>
                    <li><a href="?page=reports" class="nav-link">Reports</a></li>
                    <?php endif; ?>
                    
                    <?php if ($user['role'] === 'driver'): ?>
                    <li><a href="?page=driver-schedule" class="nav-link">My Schedule</a></li>
                    <li><a href="?page=trip-records" class="nav-link">Trip Records</a></li>
                    <?php endif; ?>
                    
                    <?php if ($user['role'] === 'passenger'): ?>
                    <li><a href="?page=search-buses" class="nav-link">Search Buses</a></li>
                    <li><a href="?page=my-bookings" class="nav-link">My Bookings</a></li>
                    <?php endif; ?>
                    
                    <li><a href="?page=profile" class="nav-link">Profile</a></li>
                    <li><a href="src/api/logout.php" class="nav-link">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar">☰</button>
                </div>
                <div class="header-center">
                    <h1 id="page-title">Dashboard</h1>
                </div>
                <div class="header-right">
                    <span class="user-info"><?php echo $user['name']; ?> (<?php echo ucfirst($user['role']); ?>)</span>
                </div>
            </header>

            <!-- Page Content -->
            <div class="content-area">
                <?php
                // Include appropriate page
                $page_file = 'src/views/' . $page . '.php';
                if (file_exists($page_file)) {
                    include $page_file;
                } else {
                    include 'src/views/dashboard.php';
                }
                ?>
            </div>
        </main>
    </div>

    <script src="public/js/main.js"></script>
    <script src="public/js/sidebar.js"></script>
</body>
</html>