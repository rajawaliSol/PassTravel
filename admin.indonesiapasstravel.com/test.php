<?php
// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Informasi dasar PHP
echo "<h1>Test Script - Indonesia Pass Travel</h1>";
echo "<h2>PHP Info</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Path: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";

// Cek struktur direktori
echo "<h2>File Structure Check</h2>";

function check_file($path) {
    if (file_exists($path)) {
        echo "<p style='color:green'>✓ FOUND: $path</p>";
        echo "<p>File size: " . filesize($path) . " bytes</p>";
        echo "<p>Last modified: " . date("Y-m-d H:i:s", filemtime($path)) . "</p>";
    } else {
        echo "<p style='color:red'>✗ NOT FOUND: $path</p>";
    }
    echo "<hr>";
}

// Cek file krusial
check_file('./index.php');
check_file('./db_connection.php');
check_file('../includes/db.php');

// Cek koneksi database
echo "<h2>Database Connection Test</h2>";
try {
    $host = "localhost";
    $user = "indopass_userpasstravel";
    $pass = "sandacof0388";
    $db   = "indopass_passtravel";
    
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    if ($conn) {
        echo "<p style='color:green'>✓ Database connection successful!</p>";
        echo "<p>Server info: " . mysqli_get_server_info($conn) . "</p>";
        echo "<p>Host info: " . mysqli_get_host_info($conn) . "</p>";
        
        // Cek tabel users
        $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
        if (mysqli_num_rows($result) > 0) {
            echo "<p style='color:green'>✓ Table 'users' exists</p>";
            
            // Cek data users
            $users = mysqli_query($conn, "SELECT * FROM users LIMIT 5");
            $count = mysqli_num_rows($users);
            echo "<p>Found $count users in database</p>";
        } else {
            echo "<p style='color:red'>✗ Table 'users' does not exist!</p>";
        }
        
        mysqli_close($conn);
    } else {
        echo "<p style='color:red'>✗ Database connection failed: " . mysqli_connect_error() . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Error: " . $e->getMessage() . "</p>";
}

// Cek session
echo "<h2>Session Test</h2>";
session_start();
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session save path: " . session_save_path() . "</p>";

if (empty($_SESSION)) {
    echo "<p>No session data found</p>";
    $_SESSION['test'] = 'Session test at ' . date('Y-m-d H:i:s');
    echo "<p>Created test session data</p>";
} else {
    echo "<p>Existing session data:</p>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
}

// Tambahkan informasi extensions
echo "<h2>PHP Extensions</h2>";
$required_extensions = [
    'mysqli', 
    'session', 
    'standard',
    'curl',
    'json',
    'gd',
    'mbstring'
];

foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color:green'>✓ $ext is loaded</p>";
    } else {
        echo "<p style='color:red'>✗ $ext is NOT loaded</p>";
    }
}
?>
