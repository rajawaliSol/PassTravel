<?php
include "includes/db.php";

// --- Handle filter/search/sort
$query  = isset($_GET['q']) ? $_GET['q'] : "";
$region = isset($_GET['region']) ? $_GET['region'] : "";
$sort   = isset($_GET['sort']) ? $_GET['sort'] : "popular";

$sql = "SELECT * FROM packages WHERE 1=1";

if ($query) {
    $q = mysqli_real_escape_string($conn, $query);
    $sql .= " AND (name LIKE '%$q%' OR region LIKE '%$q%' OR description LIKE '%$q%')";
}

if ($region) {
    $r = mysqli_real_escape_string($conn, $region);
    $sql .= " AND region = '$r'";
}

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
  <title>Indonesia Pass Travel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">

<!-- NAV -->
<header class="sticky top-0 z-40 backdrop-blur bg-white/70 border-b">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="p-2 rounded-2xl shadow bg-blue-700 text-white">🎫</div>
      <span class="font-extrabold tracking-tight text-lg">Indonesia Pass Travel</span>
    </div>
    <div class="hidden md:flex items-center gap-6 text-sm">
      <a href="#passes" class="hover:text-gray-900">Pass & Paket</a>
      <a href="about.php" class="hover:text-gray-900">About Us</a>
      <a href="#why" class="hover:text-gray-900">Kenapa Kami</a>
      <a href="#contact" class="hover:text-gray-900">Kontak</a>
      <a href="#passes" class="bg-blue-600 text-white px-4 py-2 rounded-2xl">Mulai Rencanakan</a>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="relative">
  <div class="absolute inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1494472155656-f34e81b17ddc?q=80&w=2400&auto=format&fit=crop" class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-white"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 py-24 text-white">
    <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow">Satu Pass. Ribuan Pengalaman ✈️</h1>
    <p class="mt-4 max-w-2xl">Pilih pass fleksibel untuk transport, aktivitas, dan akomodasi di lebih dari 50 destinasi.</p>
    <form method="GET" action="#passes" class="mt-6 bg-white/90 backdrop-blur rounded-2xl p-4 shadow-xl grid md:grid-cols-4 gap-3 text-gray-800">
      <input type="text" name="q" placeholder="Cari destinasi (mis. Bromo, Ubud)" value="<?php echo htmlspecialchars($query); ?>" class="border p-2 rounded">
      <select name="region" class="border p-2 rounded">
        <option value="">Semua Wilayah</option>
        <option <?php if($region=="Jawa") echo "selected"; ?>>Jawa</option>
        <option <?php if($region=="Bali & Nusa") echo "selected"; ?>>Bali & Nusa</option>
        <option <?php if($region=="Nusa Tenggara") echo "selected"; ?>>Nusa Tenggara</option>
        <option <?php if($region=="Sumatra") echo "selected"; ?>>Sumatra</option>
        <option <?php if($region=="Sulawesi") echo "selected"; ?>>Sulawesi</option>
        <option <?php if($region=="Papua") echo "selected"; ?>>Papua</option>
      </select>
      <select name="sort" class="border p-2 rounded">
        <option value="popular">Paling Populer</option>
        <option value="rating" <?php if($sort=="rating") echo "selected"; ?>>Rating Tertinggi</option>
        <option value="price-asc" <?php if($sort=="price-asc") echo "selected"; ?>>Harga Termurah</option>
        <option value="price-desc" <?php if($sort=="price-desc") echo "selected"; ?>>Harga Termahal</option>
      </select>
      <button class="bg-blue-600 text-white rounded px-4">Cari</button>
    </form>
  </div>
</section>

<!-- WHY US -->
<section id="why" class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-3 gap-6">
  <div class="bg-white p-6 rounded-2xl shadow">
    <h3 class="font-bold mb-2">Fleksibel & Transparan</h3>
    <p>Pilih tanggal belakangan, ubah rencana tanpa drama. Semua biaya jelas.</p>
  </div>
  <div class="bg-white p-6 rounded-2xl shadow">
    <h3 class="font-bold mb-2">Semua Dalam Satu Pass</h3>
    <p>Transport, aktivitas, dan akomodasi dalam satu paket — tinggal berangkat.</p>
  </div>
  <div class="bg-white p-6 rounded-2xl shadow">
    <h3 class="font-bold mb-2">Dukungan Lokal</h3>
    <p>Partner resmi di 50+ kota & pulau, memastikan pengalaman otentik.</p>
  </div>
</section>

<!-- PASSES GRID -->
<section id="passes" class="max-w-7xl mx-auto px-4 pb-16">
  <h2 class="text-3xl font-extrabold mb-6">Pass & Paket Populer</h2>
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while ($p = mysqli_fetch_assoc($packages)) { ?>
    <div class="bg-white rounded-2xl shadow hover:shadow-lg overflow-hidden">
      <?php if($p['image']) { ?>
        <img src="uploads/<?php echo $p['image']; ?>" class="h-44 w-full object-cover">
      <?php } ?>
      <div class="p-4">
        <h3 class="font-bold text-lg"><?php echo htmlspecialchars($p['name']); ?></h3>
        <p class="text-sm text-gray-600 mb-2"><?php echo htmlspecialchars($p['region']); ?> - <?php echo $p['days']; ?> Hari</p>
        <p class="text-blue-700 font-semibold mb-3">Rp <?php echo number_format($p['price'],0,",","."); ?></p>
        <a href="paket.php?id=<?php echo $p['id']; ?>" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">Lihat Detail</a>
      </div>
    </div>
    <?php } ?>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="bg-white border-t py-16 px-4">
  <div class="max-w-6xl mx-auto">
    <h3 class="text-2xl font-bold mb-6">Traveler Puas</h3>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-gray-100 p-4 rounded-2xl shadow">"Bisa reschedule tanpa biaya, liburan jadi tenang." <br><b>– Rina</b></div>
      <div class="bg-gray-100 p-4 rounded-2xl shadow">"Komodo Hop Pass worth it — liveaboard & snorkel mantap." <br><b>– Andi</b></div>
      <div class="bg-gray-100 p-4 rounded-2xl shadow">"Satu pass untuk semua, hemat waktu dan biaya." <br><b>– Mei</b></div>
    </div>
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

<!-- FOOTER -->
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
