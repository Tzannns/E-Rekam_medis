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
-   Notifikasi menggunakan SweetAlert2

## 🛠️ Teknologi yang Digunakan

### Backend

-   **PHP**: 8.4.12
-   **Laravel**: 12.37.0
-   **MySQL**: Database utama
-   **Spatie Laravel Permission**: 6.23 (Role & Permission management)
-   **Yajra DataTables**: 12 (Server-side processing untuk tabel)

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
git clone https://github.com/yourusername/e-rekam-medis.git
cd e-rekam-medis
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

```
e-rekam-medis/
├── app/
│   ├── Console/Commands/     # Artisan commands
│   ├── Http/
│   │   ├── Controllers/      # Controllers
│   │   │   ├── Admin/        # Admin controllers
│   │   │   ├── Dokter/       # Dokter controllers
│   │   │   ├── Pasien/       # Pasien controllers
│   │   │   └── Petugas/      # Petugas controllers
│   │   └── Requests/         # Form requests
│   └── Models/               # Eloquent models
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # CSS files
│   └── js/                   # JavaScript files
├── routes/
│   └── web.php               # Web routes
└── tests/                    # Tests
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestName
```

## 🎨 Code Style

Aplikasi menggunakan Laravel Pint untuk code style. Jalankan:

```bash
vendor/bin/pint
```

## 🔒 Security

-   Pastikan file `.env` tidak di-commit ke repository
-   Gunakan strong password untuk production
-   Update dependencies secara berkala
-   Gunakan HTTPS di production

## 📝 License

Aplikasi ini menggunakan [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan buat issue atau pull request.

## 📞 Support

Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan buat issue di repository ini.

## 🙏 Acknowledgments

-   [Laravel](https://laravel.com) - The PHP Framework
-   [Spatie](https://spatie.be) - Laravel Permission package
-   [TailwindCSS](https://tailwindcss.com) - CSS Framework
-   [SweetAlert2](https://sweetalert2.github.io) - Beautiful alerts

---

**Dibuat dengan ❤️ menggunakan Laravel**
