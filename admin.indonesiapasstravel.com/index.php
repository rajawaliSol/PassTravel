<?php
// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Koneksi database (pastikan path benar di subdomain)
if (file_exists(__DIR__ . '/db_connection.php')) {
    include __DIR__ . '/db_connection.php';
} elseif (file_exists(__DIR__ . '/../includes/db.php')) {
    include __DIR__ . '/../includes/db.php';
} else {
    die('<div style="padding:20px;background:#f8d7da;border:1px solid #dc3545;">Koneksi database gagal: File db_connection.php atau db.php tidak ditemukan!</div>');
}

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $username = mysqli_real_escape_string($conn, $username);
        $password = md5($password);
        $q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");
        if ($u = mysqli_fetch_assoc($q)) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['username'] = $u['username'];
            $_SESSION['role'] = $u['role'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Login gagal, username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="max-w-sm mx-auto mt-24 bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Login Admin</h1>
    <?php if ($error) { echo '<div class="bg-red-100 text-red-700 p-2 rounded mb-2">'.htmlspecialchars($error).'</div>'; } ?>
    <form method="POST" class="space-y-3">
      <input type="text" name="username" placeholder="Username" class="w-full border p-2 rounded" required autofocus>
      <input type="password" name="password" placeholder="Password" class="w-full border p-2 rounded" required>
      <button class="bg-blue-600 text-white w-full py-2 rounded">Login</button>
    </form>
  </div>
</body>
</html>
