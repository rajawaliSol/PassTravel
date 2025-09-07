<?php
include "../includes/db.php";

// Helper untuk ambil data per section
 $default_sections = [
  'hero' => ['title' => '', 'content' => '', 'image' => ''],
  'profile' => ['title' => '', 'content' => '', 'image' => ''],
  'vision' => ['title' => '', 'content' => '', 'image' => ''],
  'value' => ['title' => '', 'content' => '', 'image' => ''],
  'team' => ['title' => '', 'content' => '', 'image' => ''],
 ];

$sections = $default_sections;
foreach ($sections as $section => &$data) {
  $q = mysqli_query($conn, "SELECT * FROM site_content WHERE page='about' AND section='$section' LIMIT 1");
  if ($row = mysqli_fetch_assoc($q)) {
    $data = $row;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($sections as $section => $data) {
    $title = mysqli_real_escape_string($conn, $_POST[$section.'_title'] ?? '');
    $content = mysqli_real_escape_string($conn, $_POST[$section+'_content'] ?? '');
    $image = $data['image'];
    if (isset($_FILES[$section.'_image']) && $_FILES[$section.'_image']['error'] == 0) {
      $filename = time().'_'.basename($_FILES[$section.'_image']['name']);
      $target = '../public_html/images/'.$filename;
      if (move_uploaded_file($_FILES[$section.'_image']['tmp_name'], $target)) {
        $image = $filename;
      }
    }
    $cek = mysqli_query($conn, "SELECT id FROM site_content WHERE page='about' AND section='$section'");
    if (mysqli_num_rows($cek)) {
      mysqli_query($conn, "UPDATE site_content SET title='$title', content='$content', image='$image' WHERE page='about' AND section='$section'");
    } else {
      mysqli_query($conn, "INSERT INTO site_content (page, section, title, content, image) VALUES ('about', '$section', '$title', '$content', '$image')");
    }
  }
  header('Location: edit_about.php?success=1');
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit About Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
<div class="max-w-3xl mx-auto py-10 px-4">
  <h1 class="text-2xl font-bold mb-6">Edit About Us</h1>
  <?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">Data berhasil disimpan!</div>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data" class="space-y-8">
    <?php 
      $section_labels = [
        'hero' => 'Hero',
        'profile' => 'Profil',
        'vision' => 'Visi Misi',
        'value' => 'Nilai',
        'team' => 'Tim Kami',
      ];
      foreach ($sections as $section => $data): 
    ?>
      <div class="bg-white p-6 rounded shadow mb-10">
        <h2 class="font-bold text-lg mb-2 text-blue-700">Section: <?=$section_labels[$section]?></h2>
        <div class="mb-2">
          <label class="block mb-1 font-semibold">Judul</label>
          <input type="text" name="<?=$section?>_title" value="<?=htmlspecialchars($data['title'])?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1 font-semibold">Konten</label>
          <textarea name="<?=$section?>_content" class="w-full border p-2 rounded" rows="4"><?=htmlspecialchars($data['content'])?></textarea>
        </div>
        <div class="mb-2">
          <label class="block mb-1 font-semibold">Gambar (opsional)</label>
          <?php if($data['image']): ?>
            <img src="../public_html/images/<?=htmlspecialchars($data['image'])?>" class="h-24 mb-2 rounded shadow">
          <?php endif; ?>
          <input type="file" name="<?=$section?>_image" accept="image/*">
        </div>
      </div>
      <?php if (next($sections)): ?>
        <hr class="my-8 border-t-2 border-gray-200">
      <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded font-bold">Simpan Semua</button>
  </form>
</div>
</body>
</html>
