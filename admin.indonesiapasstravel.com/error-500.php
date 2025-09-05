<?php
// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - Indonesia Pass Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto my-16 p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-red-600 mb-6">Internal Server Error</h1>
        
        <div class="mb-6">
            <p class="mb-2">Terjadi kesalahan pada server. Berikut informasi debugging yang mungkin membantu:</p>
            
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <h3 class="font-bold">PHP Info:</h3>
                <p>PHP Version: <?php echo phpversion(); ?></p>
                <p>Error Display: <?php echo ini_get('display_errors') ? 'On' : 'Off'; ?></p>
                <p>Error Reporting Level: <?php echo ini_get('error_reporting'); ?></p>
            </div>
            
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <h3 class="font-bold">File Structure:</h3>
                <p>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
                <p>Script Filename: <?php echo $_SERVER['SCRIPT_FILENAME']; ?></p>
                <p>Current File: <?php echo __FILE__; ?></p>
            </div>
            
            <div class="bg-gray-100 p-4 rounded-lg">
                <h3 class="font-bold">Database Connection Test:</h3>
                <?php
                try {
                    if (!file_exists('../includes/db.php')) {
                        echo "<p class='text-red-600'>File db.php tidak ditemukan!</p>";
                        echo "<p>Path relatif: ../includes/db.php</p>";
                        echo "<p>Path absolut: " . realpath('../includes/db.php') . "</p>";
                    } else {
                        echo "<p class='text-green-600'>File db.php ditemukan.</p>";
                        include_once '../includes/db.php';
                        if (isset($conn) && $conn) {
                            echo "<p class='text-green-600'>Koneksi database berhasil!</p>";
                        } else {
                            echo "<p class='text-red-600'>Koneksi database gagal!</p>";
                            if (function_exists('mysqli_connect_error')) {
                                echo "<p>Error: " . mysqli_connect_error() . "</p>";
                            }
                        }
                    }
                } catch (Exception $e) {
                    echo "<p class='text-red-600'>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </div>
        
        <div class="mt-8">
            <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
