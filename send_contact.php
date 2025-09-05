<?php
// Handler sederhana. Untuk produksi, gunakan PHPMailer via SMTP.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
        // Kirim ke email admin (sesuaikan)
        $to = 'admin@indonesiapasstravel.com';
        $subject = 'Kontak Baru dari Website';
        $body = "Nama: $name\nEmail: $email\nPesan:\n$message";
        $headers = 'From: no-reply@indonesiapasstravel.com' . "\r\n" .
                   'Reply-To: ' . $email;

        // mail() sering diblok shared hosting; rekomendasi: pakai PHPMailer + SMTP
        @mail($to, $subject, $body, $headers);
        header('Location: index.php?sent=1');
        exit;
    }
}
header('Location: index.php?sent=0');
