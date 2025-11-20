# E-Rekam Medis

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT) [![PHP](https://img.shields.io/badge/php-8.4.12-8892BF)](https://www.php.net/) [![Laravel](https://img.shields.io/badge/laravel-12-red)](https://laravel.com/)

Sistem Informasi Rekam Medis Elektronik (E-Rekam Medis) — aplikasi web berbasis Laravel untuk mengelola rekam medis pasien di rumah sakit atau klinik. Menyediakan modul pendaftaran, IGD, rawat jalan/inap, kasir, apotik, laboratorium, radiologi, gizi, laundry, storage, dan manajemen user berbasis role.

## 📋 Fitur Utama

-   **Autentikasi & Otorisasi**: Role-based access control (4 level: Admin, Dokter, Pasien, Petugas) menggunakan Spatie Laravel Permission
-   **Manajemen User**: Profil, assign role/permission, tampilan DataTables interaktif
-   **Rekam Medis**: CRUD lengkap, pencarian & filter (pasien/dokter/tanggal), detail dan dashboard per role
-   **Modul Rumah Sakit**: Pendaftaran, IGD, Rawat Jalan/Inap, Kasir, Apotik, Laboratorium, Radiologi, Gizi, Laundry, Storage
-   **Fitur Tambahan**: Jadwal dokter/pasien, statistik dashboard, notifikasi

## 🛠️ Tech Stack

**Backend**: PHP 8.4.12 | Laravel 12.37.0 | MySQL | Spatie Permission 6.x | Yajra DataTables 12.x

**Frontend**: TailwindCSS 3.x | AlpineJS 3.x | SweetAlert2 | Vite 6.x

**Dev Tools**: Laravel Breeze (auth) | Laravel Pint (formatter) | PHPUnit 11.x (testing)

## 📦 Instalasi Cepat

**Prasyarat**: PHP 8.2+, Composer, Node.js & npm, MySQL, Git

### 1. Clone & setup

```bash
git clone https://github.com/Tzannns/E-Rekam_medis.git
cd E-Rekam_medis
composer install
npm install
```

### 2. Environment

macOS/Linux:

```bash
cp .env.example .env
php artisan key:generate
```

Windows PowerShell:

```powershell
copy .env.example .env
php artisan key:generate
```

### 3. Database configuration (`.env`)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_rekam_medis
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat database

```bash
mysql -u root -e "CREATE DATABASE e_rekam_medis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. Migrasi & seeder

```bash
php artisan migrate --seed
```

### 6. Build assets & jalankan

Development:

```bash
npm run dev
```

Production:

```bash
npm run build
```

Serve aplikasi:

```bash
php artisan serve
```

Akses: `http://localhost:8000`

## 👤 Akun Default (Seeder)

> ⚠️ **Ganti password di production!**

-   Admin: `admin@rekammedis.com` / `password`
-   Dokter: `dokter@rekammedis.com` / `password`
-   Pasien: `pasien@rekammedis.com` / `password`
-   Petugas: `petugas@rekammedis.com` / `password`

## 🔄 Migrasi: SQLite → MySQL

Jika ada data di `database/database.sqlite`:

```bash
php artisan db:migrate-sqlite-to-mysql
```

Perintah ini menyalin/sinkronisasi data ke MySQL.

## 📁 Struktur Project

```
.
├── app/                    # Kode aplikasi
│   ├── Console/Commands/   # Artisan commands custom
│   ├── Helpers/            # Helper classes (AppointmentHelper.php, RouteHelper.php, dll)
│   ├── Http/
│   │   ├── Controllers/    # Controllers (grouped by role)
│   │   ├── Middleware/
│   │   └── Requests/       # Form Request validation
│   ├── Models/             # Eloquent models (Pasien, Dokter, Appointment, dll)
│   ├── Notifications/
│   └── Providers/
├── bootstrap/              # Bootstrap framework
├── config/                 # Konfigurasi aplikasi
├── database/
│   ├── factories/          # Model factories
│   ├── migrations/         # Database schema
│   └── seeders/            # Database seeds
├── public/                 # Web entry & build assets
├── resources/
│   ├── views/              # Blade templates
│   ├── css/
│   └── js/
├── routes/                 # web.php, auth.php, console.php
├── storage/                # logs, cache, uploads
├── tests/                  # PHPUnit tests (Feature, Unit)
├── vendor/                 # Composer dependencies
├── artisan
└── [vite.config.js, package.json, composer.json, ...]
```

**Lokasi penting:**

-   Models: `app/Models`
-   Controllers: `app/Http/Controllers`
-   Views: `resources/views`
-   Frontend source: `resources/js`, `resources/css` → build ke `public/build`

## 🧪 Testing

```bash
php artisan test
```

Jalankan test tertentu:

```bash
php artisan test --filter=NamaTest
```

## 🎨 Code Style

Format kode dengan Laravel Pint:

```bash
vendor/bin/pint
```

## 🐳 Docker (Optional)

Tidak ada `docker-compose.yml` default. Standar setup: PHP-FPM + Nginx + MySQL + Node build container.

## ⚠️ Troubleshooting

-   **Error Vite manifest** ("Unable to locate file in Vite manifest"): Jalankan `npm run build` atau `npm run dev`
-   **Asset tidak muncul**: Pastikan `APP_URL` di `.env` sesuai URL akses

## 🤝 Contributing

Kontribusi welcome! Buka issue atau PR — ikuti gaya kode existing dan jalankan test terkait.

## 📝 License

MIT License — lihat: https://opensource.org/licenses/MIT

---

**Dibuat dengan ❤️ menggunakan Laravel**
