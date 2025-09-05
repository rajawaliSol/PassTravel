<?php
// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai session
session_start();

// Verifikasi login
if (!isset($_SESSION['user_id'])) { 
    header('Location: index.php'); 
    exit; 
}

// Tentukan role user
$role = $_SESSION['role'] ?? 'staff';

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
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="max-w-3xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Dashboard (<?php echo htmlspecialchars($role); ?>)</h1>
      <a href="logout.php" class="text-red-600">Logout</a>
    </div>
    <div class="grid md:grid-cols-3 gap-4">
      <a href="packages.php" class="bg-white p-6 rounded shadow text-center font-semibold">Kelola Paket</a>
      <a href="edit_about.php" class="bg-white p-6 rounded shadow text-center font-semibold">Edit About Us</a>
      <?php if ($role === 'admin') { ?>
      <a href="users.php" class="bg-white p-6 rounded shadow text-center font-semibold">Kelola Pengguna</a>
      <?php } ?>
    </div>
  </div>
</body>
</html>
