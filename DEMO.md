# Skenario Demo — Aplikasi Kasir

Dokumen ini adalah urutan langkah demo aplikasi, lengkap dengan hasil yang diharapkan dan poin yang bisa dijelaskan saat presentasi.

---

## Persiapan sebelum demo

Lakukan sekali sebelum mulai agar data bersih dan konsisten:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

- Buka `http://127.0.0.1:8000`
- Siapkan dua akun: Admin (`admin@kasir.test`) dan Kasir (`kasir@kasir.test`), keduanya password `password`
- Opsional: buka Postman untuk demo API (langkah 12)

Checklist cepat:

- [ ] Server berjalan, halaman login tampil
- [ ] Database sudah terisi (kategori dan produk contoh ada)
- [ ] Browser tidak sedang login

---

## Urutan Demo

### 1. Proteksi halaman (belum login)

**Aksi:** Buka `http://127.0.0.1:8000/products` tanpa login.
**Hasil:** Otomatis diarahkan ke halaman `/login`.
**Penjelasan:** Route dilindungi middleware `auth`, jadi pengguna yang belum login tidak bisa masuk.

### 2. Login sebagai Admin

**Aksi:** Login dengan `admin@kasir.test` / `password`.
**Hasil:** Masuk ke Dashboard. Navbar menampilkan nama dan peran, serta menu Kategori, Produk, dan Laporan.
**Penjelasan:** Autentikasi memakai `Auth::attempt()`, session diperbarui setelah login untuk keamanan.

### 3. Dashboard

**Aksi:** Tunjukkan kartu statistik dan tabel stok menipis.
**Hasil:** Total produk, stok menipis, transaksi dan omzet hari ini (masih 0), daftar produk stok ≤ 5 (contoh: Tisu Paseo).
**Penjelasan:** Angka dihitung langsung dari database lewat Model (`count`, `sum`, `whereDate`).

### 4. Tambah Kategori

**Aksi:** Menu Kategori → Tambah Kategori → isi nama (mis. "Alat Tulis") dan deskripsi → Simpan.
**Hasil:** Kembali ke daftar dengan pesan sukses, kategori baru tampil.
**Tambahan:** Kirim form kosong untuk menunjukkan pesan validasi.
**Penjelasan:** Validasi memakai Form Request (`CategoryRequest`).

### 5. Tambah Produk

**Aksi:** Menu Produk → Tambah Produk → kode `ATK001`, nama "Pulpen Standard", harga `3000`, stok `50`, kategori "Alat Tulis" → Simpan.
**Hasil:** Produk muncul di daftar. Coba cari "pulpen" lewat kotak pencarian.
**Penjelasan:** Kode produk harus unik, kategori harus ada (relasi foreign key). Pencarian memakai `like`.

### 6. Edit dan batasan hapus

**Aksi:** Edit harga produk tadi menjadi `3500`. Lalu coba hapus kategori "Makanan".
**Hasil:** Edit berhasil. Penghapusan kategori ditolak dengan pesan karena masih dipakai produk.
**Penjelasan:** Mencegah error foreign key dan menjaga integritas data.

### 7. Transaksi penjualan (inti aplikasi)

**Aksi:** Menu Kasir → isi jumlah, contoh: Indomie Goreng `2`, Aqua 600 ml `1` → isi uang bayar `20000`.
**Hasil di layar:** Total `Rp 11.000` dan kembalian `Rp 9.000` muncul otomatis saat mengetik.
**Aksi lanjutan:** Klik Simpan Transaksi.
**Hasil:** Struk tampil (kode transaksi, tanggal, kasir, daftar item, total, bayar, kembalian).
**Penjelasan:** JavaScript hanya untuk tampilan; perhitungan sebenarnya dilakukan ulang di server (`TransactionController@store`).

### 8. Bukti stok berkurang

**Aksi:** Menu Produk, lihat stok Indomie Goreng dan Aqua.
**Hasil:** Stok Indomie turun 2 (100 → 98) dan Aqua turun 1 (120 → 119).
**Penjelasan:** Stok dikurangi dalam satu `DB::transaction` dengan `lockForUpdate`, sehingga aman dari dua kasir yang menjual barang yang sama bersamaan.

### 9. Validasi transaksi

**Aksi A:** Buat transaksi dengan uang bayar kurang dari total.
**Hasil A:** Ditolak dengan pesan "Uang bayar kurang dari total belanja", stok tidak berubah.
**Aksi B:** Isi jumlah melebihi stok (mis. Tisu Paseo `10`).
**Hasil B:** Ditolak dengan pesan stok tidak cukup.
**Penjelasan:** Karena memakai database transaction, kegagalan di tengah proses membatalkan semua perubahan.

### 10. Riwayat dan laporan

**Aksi:** Menu Riwayat → filter tanggal hari ini → buka Detail satu transaksi. Lalu menu Laporan → pilih rentang tanggal → Tampilkan.
**Hasil:** Riwayat menampilkan transaksi tadi. Laporan menampilkan jumlah transaksi, total omzet, dan penjualan per produk.
**Penjelasan:** Laporan memakai query `SUM` dan `groupBy` pada tabel `transaction_items`.

### 11. Hak akses berdasarkan peran

**Aksi:** Logout, lalu login sebagai `kasir@kasir.test`.
**Hasil:** Menu Kategori, Produk, dan Laporan tidak tampil. Membuka `/products` langsung lewat URL menghasilkan halaman **403 Forbidden**.
**Penjelasan:** Middleware kustom `CheckAdminRole` membatasi route khusus admin (otorisasi), berbeda dari `auth` yang hanya mengecek sudah login atau belum (autentikasi).

### 12. Demo REST API (opsional)

Di Postman, atur header `Accept: application/json`:

| Request | Hasil yang diharapkan |
|---|---|
| `GET http://127.0.0.1:8000/api/products` | daftar produk berformat JSON (`data`, `links`, `meta`) |
| `GET http://127.0.0.1:8000/api/products?search=indomie` | hanya produk yang namanya cocok |
| `GET http://127.0.0.1:8000/api/products/1` | detail satu produk, status 200 |
| `GET http://127.0.0.1:8000/api/products/9999` | status 404 |
| `GET http://127.0.0.1:8000/api/stats` | total produk, transaksi dan omzet hari ini |

**Penjelasan:** Respons dibentuk lewat API Resource sehingga formatnya konsisten dan hanya field yang diizinkan yang terkirim.

---

## Poin ringkas untuk presentasi

1. **MVC**: Route → Controller → Model → View.
2. **Keamanan**: password di-hash, CSRF token di setiap form, validasi di server, middleware untuk login dan peran.
3. **Integritas data**: foreign key, `DB::transaction`, `lockForUpdate`, harga disimpan per item (snapshot).
4. **Efisiensi query**: eager loading (`with`) untuk menghindari N+1.

---

## Jika terjadi masalah saat demo

| Masalah | Solusi cepat |
|---|---|
| Login gagal | `php artisan db:seed` lalu coba lagi |
| Data berantakan | `php artisan migrate:fresh --seed` |
| Halaman error setelah ubah `.env` | `php artisan config:clear` |
| Port 8000 terpakai | `php artisan serve --port=8001` |
