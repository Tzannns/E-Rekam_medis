# E-Rekam Medis

Sistem Informasi Rekam Medis Elektronik (E-Rekam Medis) adalah aplikasi web berbasis Laravel untuk mengelola rekam medis pasien di rumah sakit atau klinik. Aplikasi ini menyediakan sistem manajemen rekam medis yang terintegrasi dengan role-based access control untuk berbagai pengguna.

## 📋 Fitur Utama

### 🔐 Autentikasi & Autorisasi

-   Sistem login dan registrasi
-   Role-based access control (RBAC)
-   4 level akses: Admin, Dokter, Pasien, dan Petugas
-   Manajemen permission menggunakan Spatie Laravel Permission

### 👥 Manajemen User

-   Manajemen pengguna (Admin, Dokter, Pasien, Petugas)
-   Profil pengguna
-   Assign role dan permission
-   DataTables untuk tampilan data yang interaktif

### 📝 Rekam Medis

-   CRUD rekam medis lengkap
-   Pencarian dan filter rekam medis
-   Filter berdasarkan pasien, dokter, dan tanggal
-   Tampilan detail rekam medis
-   Dashboard untuk setiap role

### 🏥 Modul Rumah Sakit

-   **Pendaftaran**: Manajemen pendaftaran pasien
-   **IGD**: Instalasi Gawat Darurat
-   **Rawat Jalan**: Manajemen rawat jalan
-   **Rawat Inap**: Manajemen rawat inap
-   **Kasir**: Manajemen pembayaran
-   **Apotik**: Manajemen obat dan resep
-   **Laboratorium**: Manajemen hasil lab
-   **Radiologi**: Manajemen hasil radiologi
-   **Gizi**: Manajemen gizi pasien
-   **Laundry**: Manajemen laundry rumah sakit
-   **Storage**: Manajemen gudang
-   **Manajemen**: Manajemen umum rumah sakit

### 📅 Fitur Tambahan

-   Jadwal dokter dan pasien
-   Profil pasien
-   Dashboard dengan statistik

## 🛠️ Teknologi yang Digunakan

### Backend

-   **PHP**: 8.4.12
-   **Laravel**: 12.37.0
-   **MySQL**: Database utama
-   **Spatie Laravel Permission**: 6.23 (Role & Permission management)

### Frontend

-   **TailwindCSS**: 3.4.18 (Utility-first CSS framework)
-   **AlpineJS**: 3.15.1 (Lightweight JavaScript framework)
-   **SweetAlert2**: 11.26.3 (Beautiful alert dialogs)
-   **Vite**: 6.0.11 (Build tool)

### Development Tools

-   **Laravel Breeze**: 2.3.8 (Authentication scaffolding)
-   **Laravel Pint**: 1.25.1 (Code style fixer)
-   **PHPUnit**: 11.5.43 (Testing framework)

## 📦 Instalasi

### Prasyarat

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL
-   Git

### Langkah-langkah Instalasi

1. **Clone repository**

```bash
git clone https://github.com/Tzannns/E-Rekam_medis.git
cd E-Rekam_medis
```

2. **Install dependencies**

```bash
composer install
npm install
```

3. **Setup environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_rekam_medis
DB_USERNAME=root
DB_PASSWORD=
```

5. **Buat database**

```bash
mysql -u root -e "CREATE DATABASE e_rekam_medis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

6. **Jalankan migrasi dan seeder**

```bash
php artisan migrate
php artisan db:seed
```

7. **Build assets**

```bash
npm run build
# atau untuk development
npm run dev
```

8. **Jalankan server**

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`

## 👤 Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin

-   **Email**: admin@rekammedis.com
-   **Password**: password

### Dokter

-   **Email**: dokter@rekammedis.com
-   **Password**: password

### Pasien

-   **Email**: pasien@rekammedis.com
-   **Password**: password

### Petugas

-   **Email**: petugas@rekammedis.com
-   **Password**: password

## 🔄 Migrasi Data dari SQLite ke MySQL

Jika Anda memiliki data di SQLite dan ingin memindahkannya ke MySQL, gunakan command berikut:

```bash
php artisan db:migrate-sqlite-to-mysql
```

Command ini akan:

-   Membaca data dari `database/database.sqlite`
-   Memindahkan data ke MySQL
-   Update data yang sudah ada (idempotent)

## 📁 Struktur Project

````
e-rekam-medis/
├── app/
│   ├── Console/Commands/     # Artisan commands
│   ├── Http/
# E-Rekam Medis

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT) [![PHP](https://img.shields.io/badge/php-8.4.12-8892BF)](https://www.php.net/) [![Laravel](https://img.shields.io/badge/laravel-12.37.0-red)](https://laravel.com/)

Sistem Informasi Rekam Medis Elektronik (E-Rekam Medis) — sebuah aplikasi web berbasis Laravel untuk mengelola rekam medis pasien di rumah sakit atau klinik. Menyediakan modul pendaftaran, IGD, rawat jalan/inap, kasir, apotik, laboratorium, radiologi, gizi, laundry, storage, dan manajemen user berbasis role.

Ringkas: mudah dikembangkan untuk kebutuhan rumah sakit kecil/klinik, memakai Laravel 12, TailwindCSS + Vite, dan Spatie Permission.

## Quick Start

1. Clone repository

```bash
git clone https://github.com/Tzannns/E-Rekam_medis.git
cd E-Rekam_medis
````

2. Install PHP & JS dependencies

```bash
composer install
npm install
```

3. Setup environment

On macOS / Linux:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
copy .env.example .env
```

Then generate app key:

```bash
php artisan key:generate
```

4. Configure DB in `.env` (example):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_rekam_medis
DB_USERNAME=root
DB_PASSWORD=
```

5. Create database (example MySQL command):

```bash
mysql -u root -e "CREATE DATABASE e_rekam_medis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

6. Run migrations & seeders

```bash
php artisan migrate --seed
```

7. Build assets (development)

```bash
npm run dev
```

Or build for production:

```bash
npm run build
```

8. Serve the app (local)

```bash
php artisan serve
```

App will be available at `http://localhost:8000` by default.

## Tech Stack

-   PHP 8.4.12
-   Laravel 12.37.0
-   MySQL
-   Spatie Laravel Permission 6.x
-   Yajra DataTables
-   TailwindCSS 3.x, AlpineJS 3.x, Vite
-   Laravel Breeze (auth scaffolding)
-   PHPUnit (testing)

## Docker (optional)

You can run the app with Docker by creating a simple `docker-compose.yml` (not provided here). Common approach:

-   PHP-FPM + Nginx container
-   MySQL container
-   Node build container (or build locally)

If you want, I can add a reference `docker-compose.yml` and Dockerfile.

## Default Accounts

After running seeders, these accounts exist for convenience (change in production):

-   Admin: `admin@rekammedis.com` / `password`
-   Dokter: `dokter@rekammedis.com` / `password`
-   Pasien: `pasien@rekammedis.com` / `password`
-   Petugas: `petugas@rekammedis.com` / `password`

## Migration: SQLite → MySQL

If you have an existing SQLite DB and want to migrate data to MySQL, this project includes a helper command:

```bash
php artisan db:migrate-sqlite-to-mysql
```

This command will read from `database/database.sqlite` and copy/update records into MySQL.

## Project Structure (short)

Main folders and where to look:

```
.
├── app/                    # Application code (Models, Http, Console, Providers, Helpers)
│   ├── Console/Commands/
│   ├── Helpers/            # Custom helper classes (e.g., AppointmentHelper)
│   ├── Http/
│   │   ├── Controllers/    # Controllers grouped by role (Admin, Dokter, Pasien, Petugas)
│   │   └── Requests/       # Form Request validation classes
│   ├── Models/             # Eloquent models
│   └── Notifications/
├── bootstrap/              # Framework bootstrap files
├── config/                 # Configuration files
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/                 # Web entry (index.php, public assets, build/)
├── resources/
│   ├── views/              # Blade templates
│   ├── css/
│   └── js/
├── routes/                 # Route definitions (web.php, auth.php, console.php)
├── storage/                # Logs, cache, generated files
├── tests/                  # PHPUnit tests (Feature, Unit)
├── vendor/                 # Composer dependencies
├── artisan
└── vite.config.js / package.json / composer.json
```

Notes:

-   Models live in `app/Models`.
-   Controllers in `app/Http/Controllers` (organized by role).
-   Frontend source in `resources/js` and `resources/css`; built files are in `public/build`.

## Testing

Run project tests with PHPUnit / Artisan:

```bash
php artisan test
```

Or run a specific test file / filter:

```bash
php artisan test --filter=TestName
```

## Code Style

This project uses Laravel Pint. To format code:

```bash
vendor/bin/pint
```

## Troubleshooting

-   Vite manifest error ("Unable to locate file in Vite manifest"): run `npm run build` or `npm run dev` / `composer run dev`.
-   If assets don't load, ensure `APP_URL` in `.env` matches where you're serving the app.

## Contributing

Contributions are welcome. Open issues or PRs — follow existing code style and run relevant tests.

## License

This project is licensed under the MIT License.

---

**Dibuat dengan ❤️ menggunakan Laravel**
