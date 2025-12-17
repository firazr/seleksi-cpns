# Setup & Running Seleksi CPNS Project

Project ini telah siap untuk dijalankan. Semua konfigurasi dan database sudah disiapkan.

## Prasyarat
- XAMPP dengan MySQL sudah berjalan
- PHP 8.2+ (XAMPP)
- Node.js dan npm sudah terinstal
- Composer sudah terinstal

## Status Setup

✅ **Selesai:**
- Composer dependencies terinstal (`vendor/`)
- PHP `APP_KEY` sudah di-generate di `.env`
- Database `seleksi_cpns` sudah dibuat
- Semua migrations sudah berjalan
- Database sudah di-seed dengan data awal:
  - 2 users (admin & peserta)
  - 6 berita items
  - 15 soal test
- Node dependencies terinstal (`node_modules/`)
- Vite assets sudah di-build (`public/build/`)
- Storage symlink sudah dibuat

## Menjalankan Project

### Opsi 1: Menggunakan Laravel Artisan Server (Recommended untuk development)

```powershell
# Pastikan Anda di folder project root
cd C:\xampp\htdocs\seleksi-cpns

# Jalankan development server
# Gunakan XAMPP PHP untuk memastikan pdo_mysql tersedia
C:\xampp\php\php.exe artisan serve

# Server akan berjalan di http://localhost:8000
```

### Opsi 2: Menggunakan XAMPP Apache

1. Pastikan Apache dan MySQL di XAMPP sudah running
2. Akses di browser: `http://localhost/seleksi-cpns/public`

Catatan: Jika menggunakan XAMPP Apache, sesuaikan `APP_URL` di `.env`:
```
APP_URL=http://localhost/seleksi-cpns
```

## Kredensial Default untuk Login

**Admin:**
- Email: `admin@test.com`
- Password: `password`
- Role: admin

**Peserta:**
- Email: `peserta@test.com`
- Password: `password`
- Role: peserta

## Konfigurasi Database

File `.env` sudah dikonfigurasi dengan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seleksi_cpns
DB_USERNAME=root
DB_PASSWORD=
```

Jika MySQL di XAMPP Anda menggunakan password berbeda, update di `.env`:
```
DB_PASSWORD=your_password
```

Lalu jalankan ulang migrasi:
```powershell
C:\xampp\php\php.exe artisan migrate --seed
```

## Development Workflow

### Watch Assets (Auto-rebuild saat ada perubahan CSS/JS)
```powershell
cmd /c npm run dev
```

### Build Assets untuk Production
```powershell
cmd /c npm run build
```

### Jalankan Tinker (Laravel REPL untuk debugging)
```powershell
C:\xampp\php\php.exe artisan tinker
```

### Buat Admin User Baru
```powershell
C:\xampp\php\php.exe artisan tinker

# Di dalam tinker:
User::create([
    'name' => 'Admin Baru',
    'email' => 'admin_baru@test.com',
    'password' => Hash::make('password'),
    'role' => 'admin'
])
```

## Troubleshooting

### Error: "could not find driver"
Pastikan menggunakan XAMPP PHP yang memiliki `pdo_mysql`:
```powershell
C:\xampp\php\php.exe -m | Select-String "pdo_mysql"
```

### Error: "SQLSTATE[HY000]: General error: 1030 Got error..."
Database belum terbuat atau tidak bisa diakses. Cek:
1. MySQL service di XAMPP running
2. Kredensial di `.env` benar
3. Database `seleksi_cpns` sudah ada:
```powershell
C:\xampp\mysql\bin\mysql.exe -u root -e "SHOW DATABASES;"
```

### Folder `storage/` tidak writable
Jalankan:
```powershell
C:\xampp\php\php.exe artisan storage:link
```

## Testing Project

Dari project root:

```powershell
# Jalankan unit tests
C:\xampp\php\php.exe vendor/bin/phpunit

# Jalankan feature tests
C:\xampp\php\php.exe vendor/bin/phpunit tests/Feature
```

## Struktur Project

```
seleksi-cpns/
├── app/
│   ├── Http/Controllers/       # Controller untuk routes
│   ├── Models/                 # Database models
│   └── ...
├── database/
│   ├── migrations/             # Database schemas
│   ├── seeders/                # Database seeds
│   └── schema.sql              # SQL dump (opsional)
├── resources/
│   ├── css/                    # Styles (Vite)
│   ├── js/                     # JavaScript (Vite)
│   └── views/                  # Blade templates
├── routes/
│   └── web.php                 # Web routes
├── storage/
│   ├── app/                    # File uploads
│   ├── logs/                   # Log files
│   └── framework/              # Framework cache
├── public/
│   ├── build/                  # Vite compiled assets
│   ├── images/                 # Static images
│   └── storage/                # Symlink ke storage/app/public
├── vendor/                     # PHP packages (Composer)
├── node_modules/               # Node packages (npm)
├── .env                        # Environment config (jangan commit)
├── .gitignore                  # Git ignore rules
├── composer.json               # PHP dependencies
├── package.json                # Node dependencies
├── vite.config.js              # Vite config
└── artisan                     # Laravel CLI
```

## Info Penting

- **APP_ENV=local**: Project dalam mode development
- **APP_DEBUG=true**: Error detail ditampilkan (ubah ke false untuk production)
- **SESSION_DRIVER=database**: Session disimpan di database (bukan file)
- **CACHE_STORE=database**: Cache menggunakan database
- **QUEUE_CONNECTION=database**: Queue jobs menggunakan database

Untuk production, pastikan update `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

## Dokumentasi Lengkap

- Laravel: https://laravel.com/docs
- Vite: https://vitejs.dev/
- Blade Templates: https://laravel.com/docs/blade

---

**Setup selesai!** Project siap dijalankan dengan `php artisan serve`.
