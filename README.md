# TokoSinarMaju

Aplikasi inventory & POS sederhana berbasis Laravel 10 untuk Final Project Software Testing.

## Fitur
- Manajemen Master Data: Barang, Kategori, Satuan, Supplier, Pelanggan
- Transaksi Pembelian (dari Supplier)
- Transaksi Penjualan (ke Pelanggan)
- Authentication via Laravel Breeze

## Stack
- PHP 8.2
- Laravel 10
- MySQL 8+ (production), SQLite in-memory (testing)
- PHPUnit 10
- Tailwind CSS

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Testing

```bash
php artisan test
```

Total: **46 tests passed**
- 16 Unit tests (Model: Barang, Kategori, Satuan, Supplier, Pelanggan, Pembelian, Transaksi)
- 7 Feature tests (CRUD & Auth Redirect untuk Kategori, Supplier, Pelanggan)
- 23 Auth/Profile tests (Laravel Breeze defaults)

## CI/CD
GitHub Actions otomatis menjalankan PHPUnit pada setiap push/PR ke branch main.
