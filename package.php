<?php
include "includes/db.php";

$query  = isset($_GET['q']) ? $_GET['q'] : "";
$region = isset($_GET['region']) ? $_GET['region'] : "";
$sort   = isset($_GET['sort']) ? $_GET['sort'] : "popular";

$sql = "SELECT * FROM packages WHERE 1=1";
// Tambahkan filter jika perlu, contoh:
// if ($query) { $sql .= " AND name LIKE '%$query%'"; }
// if ($region) { $sql .= " AND region='$region'"; }

if ($sort == "price-asc") $sql .= " ORDER BY price ASC";
elseif ($sort == "price-desc") $sql .= " ORDER BY price DESC";
elseif ($sort == "rating") $sql .= " ORDER BY rating DESC";
else $sql .= " ORDER BY id DESC"; // default: terbaru

$packages = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tour Packages | Indonesia Pass Travel</title>
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
      <a href="about.php" style="color: #ffffffff;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#ffffffff'">About Us</a>
      <a href="#passes"
         style="background-color: #fff; color: #1d4ed8; padding: 0.5rem 1rem; border-radius: 1rem; font-weight: bold; transition: all 0.2s;"
         onmouseover="this.style.backgroundColor='#fde047';this.style.color='#1e293b'"
         onmouseout="this.style.backgroundColor='#fff';this.style.color='#1d4ed8'">
         Mulai Rencanakan
      </a>
    </div>
  </div>
</header>

<!-- ISI HALAMAN -->
<div class="max-w-7xl mx-auto px-4 py-16">
  <h1 class="text-3xl font-extrabold mb-8" style="color:#18181b;">Explore Our Tours</h1>
  <div class="flex flex-col md:flex-row md:items-start gap-8">
    <!-- Kiri: Tombol Sort & Filter -->
    <div class="flex flex-col gap-4 md:w-2/3">
      <div class="flex gap-4">
        <button onclick="alert('Fitur Sort!')" class="border border-gray-400 px-6 py-2 rounded-lg font-semibold bg-white hover:bg-gray-100 transition flex items-center gap-2">
          <span>🔽</span> Sort
        </button>
        <button onclick="alert('Fitur Filter!')" class="border border-gray-900 px-6 py-2 rounded-lg font-semibold bg-gray-900 text-white hover:bg-gray-800 transition flex items-center gap-2">
          <span>⚙️</span> Filter
        </button>
      </div>
    </div>
    <!-- Kanan: Kategori -->
    <div class="flex flex-col gap-3 md:w-1/3">
      <button class="flex items-center gap-3 px-4 py-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 transition font-semibold text-gray-800">
        <span style="font-size:1.5rem;">🌍</span> All
      </button>
      <button class="flex items-center gap-3 px-4 py-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 transition font-semibold text-gray-800">
        <span style="font-size:1.5rem;">🌏</span> Asia
      </button>
      <button class="flex items-center gap-3 px-4 py-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 transition font-semibold text-gray-800">
        <span style="font-size:1.5rem;">🇪🇺</span> Europe
      </button>
      <button class="flex items-center gap-3 px-4 py-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 transition font-semibold text-gray-800">
        <span style="font-size:1.5rem;">🕍</span> Pilgrimage
      </button>
    </div>
  </div>
  <!-- Divider sebelum PASSES GRID -->
    <hr class="my-10 border-gray-300">
    <!-- PASSES GRID -->
<section id="passes" class="max-w-7xl mx-auto px-4 pb-16">
  <h2 class="text-3xl font-extrabold mb-6" style="color: #222;">Pass & Paket Populer</h2>
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while ($p = mysqli_fetch_assoc($packages)) { ?>
    <div style="background-color: #18181b; border-radius: 2rem;" class="shadow hover:shadow-lg overflow-hidden">
      <?php if($p['image']) { ?>
        <img src="uploads/<?php echo $p['image']; ?>" class="h-44 w-full object-cover" style="border-top-left-radius: 2rem; border-top-right-radius: 2rem;">
      <?php } ?>
      <div class="p-4">
        <h3 class="font-bold text-lg" style="color: #fff;"><?php echo htmlspecialchars($p['name']); ?></h3>
        <p class="text-sm mb-2" style="color: #d1d5db;"><?php echo htmlspecialchars($p['region']); ?> - <?php echo $p['days']; ?> Hari</p>
        <p class="font-semibold mb-3" style="color: #ffffffff;">Rp <?php echo number_format($p['price'],0,",","."); ?></p>
        <a href="paket.php?id=<?php echo $p['id']; ?>"
           style="display:inline-block;background-color: #ffffffff;color: #0084ffff;padding:0.75rem 2rem;border-radius:2rem;font-weight:600;transition:background 0.2s;"
           onmouseover="this.style.backgroundColor='#000000ff'"
           onmouseout="this.style.backgroundColor='#ffffffff'">
           Book Now
        </a>
      </div>
    </div>
    <?php } ?>
  </div>
</section>
  <!-- ...copy atau buat konten sesuai kebutuhan... -->
</div>

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