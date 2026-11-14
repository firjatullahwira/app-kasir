<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Category::pluck('id', 'nama_kategori');

        $produk = [
            ['kode' => 'MKN001', 'nama' => 'Indomie Goreng', 'harga' => 3500, 'stok' => 100, 'kategori' => 'Makanan'],
            ['kode' => 'MKN002', 'nama' => 'Mie Sedaap Soto', 'harga' => 3200, 'stok' => 80, 'kategori' => 'Makanan'],
            ['kode' => 'MKN003', 'nama' => 'Beras 5 Kg', 'harga' => 68000, 'stok' => 20, 'kategori' => 'Makanan'],
            ['kode' => 'MNM001', 'nama' => 'Aqua 600 ml', 'harga' => 4000, 'stok' => 120, 'kategori' => 'Minuman'],
            ['kode' => 'MNM002', 'nama' => 'Teh Botol Sosro', 'harga' => 5500, 'stok' => 60, 'kategori' => 'Minuman'],
            ['kode' => 'MNM003', 'nama' => 'Kopi Kapal Api Sachet', 'harga' => 1500, 'stok' => 200, 'kategori' => 'Minuman'],
            ['kode' => 'SNK001', 'nama' => 'Chitato 68 g', 'harga' => 11000, 'stok' => 40, 'kategori' => 'Snack'],
            ['kode' => 'SNK002', 'nama' => 'Oreo Original', 'harga' => 9500, 'stok' => 45, 'kategori' => 'Snack'],
            ['kode' => 'KBR001', 'nama' => 'Sabun Mandi Lifebuoy', 'harga' => 4500, 'stok' => 50, 'kategori' => 'Kebutuhan Rumah'],
            ['kode' => 'KBR002', 'nama' => 'Detergen Rinso 800 g', 'harga' => 21000, 'stok' => 30, 'kategori' => 'Kebutuhan Rumah'],
            ['kode' => 'KBR003', 'nama' => 'Tisu Paseo', 'harga' => 12000, 'stok' => 4, 'kategori' => 'Kebutuhan Rumah'],
        ];

        foreach ($produk as $p) {
            Product::updateOrCreate(
                ['kode' => $p['kode']],
                [
                    'nama' => $p['nama'],
                    'harga' => $p['harga'],
                    'stok' => $p['stok'],
                    'category_id' => $kategori[$p['kategori']],
                ]
            );
        }
    }
}
