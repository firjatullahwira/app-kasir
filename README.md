# 🛒 Aplikasi Kasir

Aplikasi kasir toko berbasis web yang dibangun dengan **Laravel 12** dan **MySQL**. Dipakai untuk mengelola produk, melayani transaksi penjualan, mencetak struk, dan melihat laporan penjualan.

Project ini dibuat sebagai tugas mata kuliah Pemrograman Framework (studi kasus: Kasir).

---

## Fitur

- **Autentikasi** login dan logout berbasis session
- **Dua peran pengguna**
  - **Admin**: kelola kategori, kelola produk, lihat laporan, dan semua fitur kasir
  - **Kasir**: dashboard, transaksi penjualan, riwayat, dan struk
- **CRUD Kategori** dan **CRUD Produk** (dengan pencarian dan pagination)
- **Transaksi kasir**
  - pilih produk dan jumlah, total dan kembalian dihitung otomatis
  - stok berkurang otomatis, transaksi ditolak jika stok atau uang bayar kurang
  - seluruh proses disimpan dalam satu database transaction (berhasil semua atau batal semua)
  - struk transaksi yang bisa dicetak
- **Riwayat transaksi** dengan filter tanggal
- **Dashboard**: total produk, stok menipis, jumlah transaksi dan omzet hari ini
- **Laporan penjualan** per rentang tanggal, termasuk penjualan per produk (khusus admin)
- **REST API** dasar untuk produk dan statistik (opsional, lihat bagian API)

---

## Teknologi

| Komponen | Versi / Keterangan |
|---|---|
| PHP | 8.2 atau lebih baru |
| Framework | Laravel 12 |
| Database | postgreSQL |
| Tampilan | Blade + CSS sederhana |
| Dependency manager | Composer |

---

## Struktur Database

```
users ──< transactions ──< transaction_items >── products >── categories
```

| Tabel | Isi |
|---|---|
| `users` | akun pengguna (`name`, `email`, `password`, `role`: admin / kasir) |
| `categories` | kategori produk |
| `products` | produk (`kode`, `nama`, `harga`, `stok`, `category_id`) |
| `transactions` | satu baris per struk (`kode_transaksi`, `user_id`, `total`, `bayar`, `kembalian`) |
| `transaction_items` | isi struk (`product_id`, `qty`, `harga`, `subtotal`) |

---

## Cara Menjalankan (Instalasi Lokal)

### 1. Prasyarat

- PHP 8.2+
- Composer
- MySQL (XAMPP / Laragon / MySQL biasa)
- Git

### 2. Clone repository

```bash
git clone https://github.com/firjatullahwira/app-kasir.git
cd app-kasir
git checkout dev
```

### 3. Install dependency

```bash
composer install
```

### 4. Siapkan file `.env`

Salin file contoh, lalu buat application key.

Linux / macOS:

```bash
cp .env.example .env
php artisan key:generate
```

Windows (Command Prompt):

```bash
copy .env.example .env
php artisan key:generate
```

### 5. Buat database dan atur koneksi

Buat database kosong bernama `db_kasir` di MySQL / phpMyAdmin, lalu sesuaikan `.env`:

```env
APP_NAME="Aplikasi Kasir"
APP_LOCALE=id
APP_FAKER_LOCALE=id_ID

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_kasir
DB_USERNAME=postgres
DB_PASSWORD=
```

### 6. Migrasi dan isi data awal

```bash
php artisan migrate --seed
```

Perintah ini membuat semua tabel dan mengisi akun, kategori, serta produk contoh.

### 7. Jalankan aplikasi

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000` di browser.

---

## Akun Demo

| Peran | Email | Password |
|---|---|---|
| Admin | `admin@kasir.test` | `password` |
| Kasir | `kasir@kasir.test` | `password` |

> Ganti password ini jika aplikasi dipakai di luar keperluan belajar.

Reset data ke kondisi awal kapan saja:

```bash
php artisan migrate:fresh --seed
```

---

## Daftar Halaman Utama

| URL | Keterangan | Akses |
|---|---|---|
| `/login` | halaman login | publik |
| `/` | dashboard | login |
| `/transactions/create` | transaksi baru (kasir) | login |
| `/transactions` | riwayat transaksi | login |
| `/transactions/{id}` | struk transaksi | login |
| `/categories` | kelola kategori | admin |
| `/products` | kelola produk | admin |
| `/laporan` | laporan penjualan | admin |

---

## REST API (opsional)

Jika tahap API sudah dikerjakan, endpoint berikut tersedia. Kirim header `Accept: application/json`.

| Method | URL | Keterangan |
|---|---|---|
| GET | `/api/products` | daftar produk (10 per halaman, bisa `?search=`) |
| GET | `/api/products/{id}` | detail satu produk |
| GET | `/api/stats` | ringkasan total produk, transaksi dan omzet hari ini |

> Endpoint API saat ini bersifat publik (tanpa token), hanya untuk keperluan pembelajaran.

---

## Struktur Kode Penting

```
app/
├── Http/
│   ├── Controllers/        # AuthController, CategoryController, ProductController,
│   │                       # TransactionController, DashboardController, ReportController
│   ├── Middleware/         # CheckAdminRole (membatasi halaman khusus admin)
│   └── Requests/           # CategoryRequest, ProductRequest (validasi form)
└── Models/                 # User, Category, Product, Transaction, TransactionItem
database/
├── migrations/             # struktur tabel
└── seeders/                # data awal
resources/views/            # tampilan Blade (layouts, partials, categories, products, transactions, ...)
routes/web.php              # daftar route
```

---

## Catatan Logika Penting

- Total, kembalian, dan pengecekan stok dihitung **di server**, bukan dipercaya dari form.
- Harga disimpan di `transaction_items` saat transaksi, sehingga struk lama tidak berubah walau harga produk diubah.
- Transaksi tidak bisa diedit atau dihapus (data keuangan).
- Kategori atau produk yang sudah dipakai tidak bisa dihapus.

---

## Pengembang

- **Nama:** (isi nama kamu)
- **NIM:** (isi NIM kamu)
- **Kelas:** (isi kelas kamu)
