# TokoSinarMaju

[![CI](https://github.com/itspaulg/tokosinarmaju-software-testing/actions/workflows/ci.yml/badge.svg)](https://github.com/itspaulg/tokosinarmaju-software-testing/actions/workflows/ci.yml)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white)
![Tests](https://img.shields.io/badge/tests-81%20passed-brightgreen)
![Coverage](https://img.shields.io/badge/coverage-62.9%25-brightgreen)

Aplikasi inventory dan POS sederhana berbasis Laravel 10. Dibuat sebagai Final Project untuk mata kuliah Software Testing.

## Fitur

- CRUD master data: Barang, Kategori, Satuan, Supplier, Pelanggan
- Transaksi pembelian dari supplier (tunai/kredit)
- Transaksi penjualan ke pelanggan
- Autentikasi pengguna menggunakan Laravel Breeze

## Stack

- PHP 8.2
- Laravel 10
- MySQL 9 untuk production, SQLite in-memory untuk testing
- PHPUnit 10 + Xdebug
- Tailwind CSS + Vite
- GitHub Actions

## Cara Menjalankan Aplikasi

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve

Aplikasi bisa diakses di http://127.0.0.1:8000.

## Cara Menjalankan Test

php artisan test
php artisan test --coverage
php artisan test --filter=BarangCrudTest

## Strategi Pengujian

Pengujian pada project ini menggunakan pendekatan testing pyramid: lapisan paling banyak diisi unit test, kemudian feature/integration test, dan terakhir test bawaan dari auth scaffold.

### Unit Test (18 test)

Unit test difokuskan pada model Eloquent: pengujian mass assignment, relasi antar model (belongsTo, hasMany), dan operasi create. Model yang diuji meliputi Barang, Kategori, Satuan, Supplier, Pelanggan, Pembelian, DetailPembelian, Transaksi, dan TransaksiDetail.

Beberapa skenario yang diuji:
- Pembelian dapat dibuat dengan supplier yang valid
- Pembelian memiliki banyak DetailPembelian (relasi hasMany)
- TransaksiDetail belongs to Transaksi dan Barang

### Feature / Integration Test (40 test)

Feature test memvalidasi alur HTTP request secara menyeluruh: dari routing, middleware autentikasi, controller, hingga database. Setiap controller utama diuji full CRUD-nya (index, create, store, edit, show, destroy).

Skenario yang diuji antara lain:
- Guest user yang belum login akan di-redirect ke halaman login
- User yang sudah terautentikasi dapat melakukan CRUD pada master data
- Endpoint pembelian dan transaksi penjualan dapat diakses dan menyimpan data dengan benar
- Update routes (PUT/PATCH) berjalan sesuai ekspektasi

### Auth & Profile Test (23 test)

Test bawaan dari Laravel Breeze yang mencakup login, register, password reset, email verification, dan profile update.

### Database Strategy

Saat testing, project ini menggunakan SQLite in-memory dengan trait RefreshDatabase. Setiap test case mendapatkan database baru yang bersih, dan eksekusi keseluruhan test suite hanya membutuhkan sekitar 1.5 detik untuk 81 test.

### Coverage

Total: 81 tests passed (129 assertions) dengan code coverage 62.9% (di atas target minimal 60%). Coverage diukur menggunakan Xdebug yang dipanggil di dalam pipeline CI.

## CI/CD

GitHub Actions secara otomatis menjalankan pipeline setiap kali ada push atau pull request ke branch main:

1. Setup PHP 8.2 beserta ekstensi (mbstring, sqlite, gd, intl, bcmath, Xdebug)
2. Install Composer dependencies
3. Generate APP_KEY dan setup .env dengan SQLite in-memory
4. Menjalankan php artisan test --coverage
5. Menampilkan laporan coverage per file

Konfigurasi lengkap dapat dilihat pada .github/workflows/ci.yml.

## Struktur Folder

tests/
- Unit/              -> unit test untuk model
- Feature/           -> integration test untuk routing & controller

app/
- Models/            -> Eloquent models
- Http/Controllers/  -> CRUD controllers
- Http/Requests/     -> form validation

database/
- migrations/        -> 13 tabel

.github/workflows/
- ci.yml             -> pipeline GitHub Actions
