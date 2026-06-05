<?php
/**
 * Database Configuration
 * Configure your database connection here
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bus_management');

// Application settings
define('APP_NAME', 'Bus Management System');
define('APP_URL', 'http://localhost/bus-management-system');
define('TIMEZONE', 'UTC');

// Set timezone
date_default_timezone_set(TIMEZONE);

// Database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die('Database Connection Failed: ' . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset('utf8mb4');
    
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper function to get current user
function getCurrentUser() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

// Helper function to redirect
function redirect($path) {
    header('Location: ' . APP_URL . $path);
    exit;
}

// Helper function to sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>