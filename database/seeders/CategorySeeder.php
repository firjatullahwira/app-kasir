<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Makanan', 'deskripsi' => 'Makanan instan dan olahan.'],
            ['nama_kategori' => 'Minuman', 'deskripsi' => 'Minuman kemasan.'],
            ['nama_kategori' => 'Snack', 'deskripsi' => 'Makanan ringan.'],
            ['nama_kategori' => 'Kebutuhan Rumah', 'deskripsi' => 'Perlengkapan rumah tangga.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}
