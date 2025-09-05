<?php
include "includes/db.php";

// Ambil data about us dari database
$about_query = mysqli_query($conn, "SELECT * FROM site_content WHERE page='about' LIMIT 1");
$about = mysqli_fetch_assoc($about_query);

// Default content jika belum ada di database
if (!$about) {
    $title = "About Us";
    $heading = "\"..Explore With Us..\"";
    $content = "<p>IndonesiaPass Tours & Travel

Vacations are one of life’s true luxuries — a time to relax and recharge from the stress of daily life.
That’s why planning a vacation should be an enjoyable experience, not a burden. Finding the right travel agent can make the difference between a trip that is “just okay” and one you will remember for years. – with a focus of serving inbound travellers to Indonesia – especially to BALI. Design to accommodate the service inbound Domestic and Asian Market (B2B, B2C, FIT and GIT) deliver the best service with competitive prices.</p>
    <p></p>
    <p>IndonesiaPass Tours & Travel</p>
    <p>\".. Explore With Us..\"</p>";
    $image = "about-bg.jpg"; // Default image
}
else {
    $title = $about['title'];
    $heading = $about['heading'];
    $content = $about['content'];
    $image = $about['image'] ?: "about-bg.jpg";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($title); ?> - Indonesia Pass Travel</title>
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
      <a href="index.php" class="hover:text-gray-900">Home</a>
      <a href="about.php" class="hover:text-gray-900 font-bold">About Us</a>
      <a href="#contact" class="hover:text-gray-900">Kontak</a>
      <a href="index.php#passes" class="bg-blue-600 text-white px-4 py-2 rounded-2xl">Lihat Paket</a>
    </div>
  </div>
</header>

<!-- HERO BANNER WITH OVERLAY -->
<section class="relative">
  <div class="w-full h-96 overflow-hidden relative">
    <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="About Us Banner" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-red-500/60 flex items-center justify-center">
      <h1 class="text-5xl md:text-6xl font-extrabold text-white"><?php echo htmlspecialchars($title); ?></h1>
    </div>
  </div>
</section>

<!-- TAGLINE -->
<section class="max-w-5xl mx-auto py-12 px-4">
  <h2 class="text-3xl md:text-4xl font-bold text-center border-b-2 border-red-500 pb-4 mb-8 inline-block mx-auto">
    <?php echo htmlspecialchars($heading); ?>
  </h2>
  
  <div class="grid md:grid-cols-2 gap-8 items-center">
    <div>
      <img src="uploads/company-logo.png" alt="Company Logo" class="w-full max-w-md mx-auto">
    </div>
    
    <div class="prose prose-lg max-w-none">
      <?php echo $content; ?>
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
