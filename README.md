# Indonesia Pass Travel - Website

This repo contains a simple PHP website with an admin panel to manage travel packages.

## Structure

- index.php — Landing page showing latest 6 packages
- send_contact.php — Simple contact handler (recommend PHPMailer + SMTP in production)
- /includes/db.php — Database connection
- /uploads/ — Uploaded package images
- /admin.indonesiapasstravel.com — Admin login, dashboard, packages CRUD, users (admin only)

## Requirements

- PHP 7.4+ and MySQL
- On Windows: use XAMPP/WAMP; on hosting: cPanel/Apache

## Setup

1. Create DB and tables (phpMyAdmin → Import):

```sql
CREATE DATABASE indopass_passtravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE indopass_passtravel;

CREATE TABLE packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  region VARCHAR(100),
  days INT,
  price DECIMAL(12,2),
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','staff') DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE USER 'indopass_userpasstravel'@'localhost' IDENTIFIED BY 'sandacof0388';
GRANT ALL PRIVILEGES ON indopass_passtravel.* TO 'indopass_userpasstravel'@'localhost';
FLUSH PRIVILEGES;

INSERT INTO users (username, password, role) VALUES ('admin', MD5('admin123'), 'admin');
```

2. Edit kredensial database di `includes/db.php` sesuai dengan konfigurasi database Anda:

```php
$host = "localhost";
$user = "indopass_userpasstravel";
$pass = "sandacof0388";
$db   = "indopass_passtravel";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
```

3. Ensure `uploads/` is writable.

## Run locally (XAMPP)

- Put this folder under `C:/xampp/htdocs/NewTravelSite`
- Start Apache and MySQL in XAMPP
- Open <http://localhost/NewTravelSite/>
- Admin panel: <http://localhost/NewTravelSite/admin.indonesiapasstravel.com/> (admin / admin123)

## Notes

- For reliable email, replace `send_contact.php` with PHPMailer using SMTP.
- Basic escaping is included; consider CSRF protection and prepared statements for production.

## Deploy (cPanel)

- Upload root files (`index.php`, `send_contact.php`, `includes/`, `uploads/`) ke `public_html/`
- Upload folder `admin.indonesiapasstravel.com/` ke `public_html/admin.indonesiapasstravel.com/`
- Buat subdomain `admin.indonesiapasstravel.com` dan arahkan document root ke `public_html/admin.indonesiapasstravel.com/`
