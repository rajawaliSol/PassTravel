<?php
// Authentication check script for admin pages

// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai session
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Coba koneksi ke database dengan penanganan error
try {
    // Coba menggunakan koneksi lokal terlebih dahulu
    if (file_exists('./db_connection.php')) {
        include_once "./db_connection.php";
    } else {
        // Fallback ke koneksi global jika file lokal tidak ada
        include_once "../includes/db.php";
    }
} catch (Exception $e) {
    echo "<div style='padding: 20px; background: #f8d7da; border: 1px solid #dc3545; margin: 10px;'>";
    echo "<h2>Error Koneksi Database</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
    die();
}

// Optional: Add additional role-based checks if needed
$role = $_SESSION['role'] ?? 'staff';
// if ($role !== 'admin' && $current_page_requires_admin) {
//     header('Location: dashboard.php');
//     exit;
// }
?>
