<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
$role = $_SESSION['role'] ?? 'staff';
?>

<nav class="bg-blue-700 text-white shadow-md mb-6">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-3">
            <div class="flex items-center space-x-4">
                <a href="dashboard.php" class="font-bold text-lg">Admin Panel</a>
                <a href="packages.php" class="hover:text-blue-200">Paket</a>
                <a href="edit_about.php" class="hover:text-blue-200">About Us</a>
                <?php if ($role === 'admin'): ?>
                <a href="users.php" class="hover:text-blue-200">Users</a>
                <?php endif; ?>
            </div>
            <div class="flex items-center space-x-4">
                <span>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>
