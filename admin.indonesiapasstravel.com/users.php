<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
if (($_SESSION['role'] ?? 'staff') !== 'admin') { die('Akses ditolak'); }

// Tambah user
if (isset($_POST['add'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = $_POST['role'] === 'admin' ? 'admin' : 'staff';
    mysqli_query($conn, "INSERT INTO users(username,password,role) VALUES('$username','$password','$role')");
    header('Location: users.php');
    exit;
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    if ($id === intval($_SESSION['user_id'])) { die('Tidak bisa hapus diri sendiri'); }
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header('Location: users.php');
    exit;
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="max-w-3xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Kelola Pengguna</h1>
      <a href="dashboard.php" class="bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
    </div>

    <form method="POST" class="bg-white p-4 rounded shadow mb-6 grid grid-cols-3 gap-3">
      <input type="text" name="username" placeholder="Username" required class="border p-2 rounded col-span-1">
      <input type="password" name="password" placeholder="Password" required class="border p-2 rounded col-span-1">
      <select name="role" class="border p-2 rounded col-span-1">
        <option value="staff">Staff</option>
        <option value="admin">Admin</option>
      </select>
      <button name="add" class="col-span-3 bg-blue-600 text-white py-2 rounded">Tambah User</button>
    </form>

    <table class="w-full bg-white rounded shadow">
      <tr class="bg-gray-200 text-left">
        <th class="p-2">Username</th>
        <th class="p-2">Role</th>
        <th class="p-2">Aksi</th>
      </tr>
      <?php while ($u = mysqli_fetch_assoc($users)) { ?>
      <tr class="border-b">
        <td class="p-2"><?php echo htmlspecialchars($u['username']); ?></td>
        <td class="p-2"><?php echo htmlspecialchars($u['role']); ?></td>
        <td class="p-2">
          <?php if (intval($u['id']) !== intval($_SESSION['user_id'])) { ?>
            <a href="?hapus=<?php echo $u['id']; ?>" class="text-red-600" onclick="return confirm('Hapus user ini?')">Hapus</a>
          <?php } else { echo '-'; } ?>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
