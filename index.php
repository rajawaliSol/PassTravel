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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Schema.org markup for SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Indonesia Pass Travel",
    "url": "https://indonesiapasstravel.com/",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://indonesiapasstravel.com/?q={search_term_string}",
      "query-input": "required name=search_term_string"
    },
    "publisher": {
      "@type": "Organization",
      "name": "Indonesia Pass Travel",
      "logo": {
        "@type": "ImageObject",
        "url": "https://indonesiapasstravel.com/public_html/images/company-logo.png"
      }
    }
  }
  </script>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Indonesia Pass Travel",
    "url": "https://indonesiapasstravel.com/",
    "logo": "https://indonesiapasstravel.com/public_html/images/company-logo.png",
    "contactPoint": [{
      "@type": "ContactPoint",
      "telephone": "+62-812-3456-7890",
      "contactType": "customer service",
      "areaServed": "ID",
      "availableLanguage": ["Indonesian", "English"]
    }],
    "sameAs": [
      "https://www.instagram.com/indonesiapasstravel",
      "https://www.facebook.com/indonesiapasstravel"
    ]
  }
  </script>
  <style>
    body, html, input, select, textarea, button {
      font-family: 'Inter', Arial, sans-serif !important;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- NAV -->
<header class="sticky top-0 z-40 shadow border-b" style="background-color: #000000ff; border-color: #1e293b; color: #fff;">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="p-2 rounded-2xl shadow" style="background-color: #000000ff;">
        <img src="assets/logopt.jpeg" alt="Logo Indonesia Pass Travel" class="h-8 w-8 object-contain">
      </div>
    </div>
    <div class="hidden md:flex items-center gap-6 text-sm">
      <a href="/package.php" style="color: #ffffffff;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#ffffffff'">Tour Packages</a>
  <a href="about.php" style="color: #ffffffff;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#ffffffff'">About Us</a>
  <a href="rental-mobil.php" style="color: #ffffffff;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#ffffffff'">Rental Mobil</a>
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
<section class="relative">
  <div class="absolute inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1494472155656-f34e81b17ddc?q=80&w=2400&auto=format&fit=crop" class="w-full h-full object-cover" style="z-index: -2; position: absolute; inset: 0;">
    <div style="position: absolute; inset: 0; z-index: -1; background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3), #fff 100%);"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 py-24 flex flex-col md:flex-row gap-8 text-white relative" style="z-index: 10;">
    <!-- Menu nav: dropdown di mobile, vertikal di desktop -->
    <div class="w-full max-w-xs md:mr-10 mb-8 md:mb-0 lg:hidden">
      <!-- Dropdown mobile & tablet -->
      <div class="block md:hidden mb-4">
        <select class="w-full p-3 rounded-2xl border border-gray-300 text-gray-900 font-semibold" onchange="if(this.value) window.location.href=this.value;">
          <option value="">Pilih Menu...</option>
          <option value="#passes">Pass & Paket</option>
          <option value="about.php">About Us</option>
          <option value="#why">Kenapa Kami</option>
          <option value="rental-mobil.php">Rental Mobil</option>
          <option value="#contact">Kontak</option>
          <option value="#passes">Mulai Rencanakan</option>
        </select>
      </div>
      <!-- Vertikal tablet -->
      <nav class="hidden md:flex flex-col gap-4 bg-white/80 backdrop-blur p-6 rounded-2xl shadow text-gray-900">
        <a href="#passes" class="font-semibold hover:text-blue-700 transition">Pass & Paket</a>
        <a href="about.php" class="font-semibold hover:text-blue-700 transition">About Us</a>
  <a href="#why" class="font-semibold hover:text-blue-700 transition">Kenapa Kami</a>
  <a href="rental-mobil.php" class="font-semibold hover:text-blue-700 transition">Rental Mobil</a>
  <a href="#contact" class="font-semibold hover:text-blue-700 transition">Kontak</a>
  <a href="#passes" class="bg-blue-700 text-white px-4 py-2 rounded-2xl font-bold text-center hover:bg-blue-800 transition">Mulai Rencanakan</a>
      </nav>
    </div>
    <div class="flex-1">
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
  </div>
</section>

<!-- WHY US -->
<section id="why" class="max-w-7xl mx-auto px-4 py-16">
  <h2 class="text-3xl font-extrabold mb-10 text-center" style="font-family: 'Inter', Arial, sans-serif;">Why Choose Us</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl shadow">
      <div class="flex justify-center mb-2">
        <span style="font-size:2.2rem;">🤸</span>
      </div>
      <h3 class="font-bold mb-2 text-center">Fleksibel & Transparan</h3>
      <p>Pilih tanggal belakangan, ubah rencana tanpa drama. Semua biaya jelas.</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow">
      <div class="flex justify-center mb-2">
        <span style="font-size:2.2rem;">🎫</span>
      </div>
      <h3 class="font-bold mb-2 text-center">Semua Dalam Satu Pass</h3>
      <p>Transport, aktivitas, dan akomodasi dalam satu paket — tinggal berangkat.</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow">
      <div class="flex justify-center mb-2">
        <span style="font-size:2.2rem;">🤝</span>
      </div>
      <h3 class="font-bold mb-2 text-center">Dukungan Lokal</h3>
      <p>Partner resmi di 50+ kota & pulau, memastikan pengalaman otentik.</p>
    </div>
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

<section class="max-w-7xl mx-auto px-4 py-16 flex flex-col md:flex-row items-center justify-between gap-8">
  <div class="md:w-1/2 text-center md:text-left">
    <div class="flex items-center justify-center md:justify-start mb-3">
      <span style="font-size:2rem; margin-right:0.5rem;">📝</span>
      <span class="text-2xl font-bold" style="font-family:'Inter', Arial, sans-serif; color:#18181b;">Request a Custom Tour</span>
    </div>
    <p class="text-gray-700 mb-4">Punya rencana unik atau kebutuhan khusus? Konsultasikan trip impianmu bersama tim kami!</p>
    <a href="https://wa.me/6281234567890" target="_blank"
       style="display:inline-block;background-color:#1d4ed8;color:#fff;padding:0.75rem 2rem;border-radius:2rem;font-weight:600;font-family:'Inter',Arial,sans-serif;transition:background 0.2s;"
       onmouseover="this.style.backgroundColor='#1e293b'"
       onmouseout="this.style.backgroundColor='#1d4ed8'">
       Start Planning
    </a>
  </div>
  <div class="md:w-1/2">
    <img src="https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?w=1200&h=800&fit=crop" class="rounded-2xl shadow-lg" alt="Custom Tour Image">
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
