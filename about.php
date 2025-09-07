<?php
include "includes/db.php";
function get_section($section) {
  global $conn;
  $q = mysqli_query($conn, "SELECT * FROM site_content WHERE page='about' AND section='$section' LIMIT 1");
  if ($q === false) {
    return null;
  }
  return mysqli_fetch_assoc($q);
}
$hero = get_section('hero');
$profile = get_section('profile');
$vision = get_section('vision');
$value = get_section('value');
$team = get_section('team');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($hero['title'] ?? 'About Us'); ?> - Indonesia Pass Travel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body, html, input, select, textarea, button {
      font-family: 'Inter', Arial, sans-serif !important;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR SAMA DENGAN index.php -->
<header class="sticky top-0 z-40 shadow border-b" style="background-color: #000000ff; border-color: #1e293b; color: #fff;">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="p-2 rounded-2xl shadow" style="background-color: #000000ff; color: #fff;">🎫</div>
      <span class="font-extrabold tracking-tight text-lg">Indonesia Pass Travel</span>
    </div>
    <div class="hidden md:flex items-center gap-6 text-sm">
      <a href="/index.php" style="color: #ffffffff;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#ffffffff'">Home</a>
      <a href="/package.php" style="color: #ffffffff;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#ffffffff'">Tours Package</a>
      <a href="#passes"
         style="background-color: #fff; color: #1d4ed8; padding: 0.5rem 1rem; border-radius: 1rem; font-weight: bold; transition: all 0.2s;"
         onmouseover="this.style.backgroundColor='#fde047';this.style.color='#1e293b'"
         onmouseout="this.style.backgroundColor='#fff';this.style.color='#1d4ed8'">
         Start Planning
      </a>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="relative h-80 flex items-center justify-center">
  <?php if(!empty($hero['image'])): ?>
    <img src="public_html/images/<?php echo htmlspecialchars($hero['image']); ?>" class="absolute inset-0 w-full h-full object-cover -z-10">
    <div class="bg-black/50 absolute inset-0 -z-10"></div>
  <?php endif; ?>
  <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow"><?php echo htmlspecialchars($hero['title'] ?? 'About Us'); ?></h1>
</section>

<!-- PROFILE/SEJARAH -->
<section class="max-w-5xl mx-auto py-12 px-4">
  <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($profile['title'] ?? 'Profil'); ?></h2>
  <div class="grid md:grid-cols-2 gap-8 items-center">
    <?php if(!empty($profile['image'])): ?>
      <div>
        <img src="public_html/images/<?php echo htmlspecialchars($profile['image']); ?>" class="rounded-xl shadow w-full max-w-md mx-auto">
      </div>
    <?php endif; ?>
    <div class="prose max-w-none"><?php echo $profile['content'] ?? ''; ?></div>
  </div>
</section>

<!-- VISI MISI -->
<section class="max-w-5xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($vision['title'] ?? 'Visi Misi'); ?></h2>
  <div class="prose max-w-none"><?php echo $vision['content'] ?? ''; ?></div>
</section>

<!-- VALUE -->
<section class="max-w-5xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($value['title'] ?? 'Nilai'); ?></h2>
  <div class="prose max-w-none"><?php echo $value['content'] ?? ''; ?></div>
</section>

<!-- TEAM -->
<section class="max-w-5xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($team['title'] ?? 'Tim Kami'); ?></h2>
  <div class="grid md:grid-cols-3 gap-6">
    <?php if(!empty($team['image'])): ?>
      <div>
        <img src="public_html/images/<?php echo htmlspecialchars($team['image']); ?>" class="rounded-full w-32 h-32 object-cover mx-auto mb-2">
        <div class="text-center"><?php echo $team['content'] ?? ''; ?></div>
      </div>
    <?php else: ?>
      <div class="text-center md:col-span-3"><?php echo $team['content'] ?? ''; ?></div>
    <?php endif; ?>
  </div>
</section>

<!-- CONTACT SECTION -->
<section id="contact" class="max-w-7xl mx-auto px-4 py-16">
  <h2 class="text-3xl font-extrabold mb-6">Hubungi Kami</h2>
  <div class="bg-white p-6 rounded-2xl shadow max-w-2xl">
    <form action="send_contact.php" method="POST" class="space-y-4">
      <div>
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block mb-1">Email</label>
        <input type="email" name="email" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block mb-1">Pesan</label>
        <textarea name="message" required class="w-full border p-2 rounded h-32"></textarea>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kirim Pesan</button>
    </form>
  </div>
</section>

<!-- FOOTER SAMA DENGAN index.php -->
<footer class="bg-gray-900 text-gray-200 py-6 px-4">
  <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-6">
    <div>
      <h4 class="font-bold mb-2">Indonesia Pass Travel</h4>
      <p class="text-sm">Platform pass perjalanan untuk eksplorasi Indonesia secara mudah & hemat.</p>
    </div>
    <div>
      <h4 class="font-bold mb-2">Destinasi Populer</h4>
      <ul class="text-sm">
        <li>Bali & Nusa</li>
        <li>Bromo & Malang</li>
        <li>Komodo & Flores</li>
        <li>Raja Ampat</li>
      </ul>
    </div>
    <div>
      <h4 class="font-bold mb-2">Layanan</h4>
      <ul class="text-sm">
        <li>Pass Multi Destinasi</li>
        <li>Trip Kustom</li>
        <li>Paket Grup</li>
        <li>Akomodasi</li>
      </ul>
    </div>
    <div>
      <h4 class="font-bold mb-2">Kontak</h4>
      <p class="text-sm">
        Email: hello@indonesiapasstravel.com<br>
        WhatsApp: +62 812-3456-7890<br>
        Alamat: Jakarta, Indonesia
      </p>
    </div>
  </div>
  <div class="max-w-7xl mx-auto mt-8 pt-6 border-t border-gray-800 text-center text-sm">
    &copy; <?php echo date("Y"); ?> Indonesia Pass Travel. All rights reserved.
  </div>
</footer>

</body>
</html>
