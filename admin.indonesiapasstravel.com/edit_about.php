<?php
// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auth check sudah termasuk koneksi database
include "auth_check.php";

// Pastikan koneksi pakai UTF-8
mysqli_set_charset($conn, "utf8mb4");

$message = "";
$error = "";

// Process form submission for updating about page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $heading = mysqli_real_escape_string($conn, $_POST['heading']);
    $content = $_POST['content']; // Allow HTML in content
    
    // Check if about page content already exists
    $check_query = mysqli_query($conn, "SELECT id FROM site_content WHERE page='about' LIMIT 1");
    $content_exists = mysqli_fetch_assoc($check_query);
    
    // Handle image upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), $allowed)) {
            $newname = 'about-' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $newname)) {
                $image = $newname;
            } else {
                $error = "Gagal mengupload gambar. Periksa folder upload.";
            }
        } else {
            $error = "Format file tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        }
    }
    
    if (empty($error)) {
        if ($content_exists) {
            // Update existing record
            $sql = "UPDATE site_content SET title=?, heading=?, content=?";
            $sql .= $image ? ", image=?" : "";
            $sql .= " WHERE page='about'";
            
            $stmt = mysqli_prepare($conn, $sql);
            
            if ($image) {
                mysqli_stmt_bind_param($stmt, "ssss", $title, $heading, $content, $image);
            } else {
                mysqli_stmt_bind_param($stmt, "sss", $title, $heading, $content);
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO site_content (page, title, heading, content, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            
            if (!$image) $image = "about-bg.jpg"; // default image
            $page = "about";
            mysqli_stmt_bind_param($stmt, "sssss", $page, $title, $heading, $content, $image);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Data halaman About Us berhasil disimpan!";
        } else {
            $error = "Terjadi kesalahan: " . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Fetch current about us content
$query = mysqli_query($conn, "SELECT * FROM site_content WHERE page='about' LIMIT 1");
$about = mysqli_fetch_assoc($query);

// Pastikan output HTML pakai UTF-8
header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Us - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- WYSIWYG Editor (self-hosted) -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'advlist autolink lists link image charmap preview anchor',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
            height: 400
        });
    </script>
</head>
<body class="bg-gray-100">
    
    <?php include "header.php"; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Edit About Us</h1>
            <a href="index.php" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Kembali</a>
        </div>
        
        <?php if ($message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="title">Judul Halaman</label>
                    <input type="text" id="title" name="title" class="w-full border rounded px-3 py-2" 
                           value="<?php echo $about ? htmlspecialchars($about['title']) : 'About Us'; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="heading">Tagline</label>
                    <input type="text" id="heading" name="heading" class="w-full border rounded px-3 py-2" 
                           value="<?php echo $about ? htmlspecialchars($about['heading']) : '"..Explore With Us.."'; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="image">Header Image</label>
                    <?php if ($about && $about['image']): ?>
                    <div class="mb-2">
                        <img src="../uploads/<?php echo htmlspecialchars($about['image']); ?>" alt="Current banner" 
                             class="w-64 h-auto mb-2 border">
                        <p class="text-sm text-gray-500">Current image: <?php echo htmlspecialchars($about['image']); ?></p>
                    </div>
                    <?php endif; ?>
                    <input type="file" id="image" name="image" class="w-full border rounded px-3 py-2">
                    <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2" for="content">Content</label>
                    <textarea id="content" name="content" rows="10" class="w-full border rounded px-3 py-2"><?php echo $about ? htmlspecialchars_decode($about['content']) : ''; ?></textarea>
                </div>
                
                <div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Preview</h2>
            <div class="border p-4 rounded">
                <h1 class="text-2xl font-bold"><?php echo $about ? htmlspecialchars($about['title']) : 'About Us'; ?></h1>
                <h2 class="text-xl mt-2 mb-4 italic"><?php echo $about ? htmlspecialchars($about['heading']) : '"..Explore With Us.."'; ?></h2>
                <div class="prose">
                    <?php echo $about ? htmlspecialchars_decode($about['content']) : ''; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
