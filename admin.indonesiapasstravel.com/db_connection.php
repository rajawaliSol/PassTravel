<?php
// File koneksi database khusus untuk folder admin
// Ini memastikan path relatif bekerja dengan benar

// Konfigurasi database
$host = "localhost";
$user = "indopass_userpasstravel";
$pass = "sandacof0388";
$db   = "indopass_passtravel";

// Buat koneksi dengan penanganan error yang lebih baik
try {
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    if (!$conn) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    // Set charset untuk dukungan multi-bahasa
    mysqli_set_charset($conn, "utf8");
    
} catch (Exception $e) {
    // Log error atau tampilkan jika mode debugging aktif
    error_log("Database connection error: " . $e->getMessage());
    if (ini_get('display_errors')) {
        echo "Error koneksi database: " . $e->getMessage();
    }
    die(); // Hentikan eksekusi jika tidak bisa terhubung ke database
}
?>
