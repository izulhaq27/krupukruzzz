<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Kerupuk Gurung',
                'slug' => 'kerupuk-gurung',
                'description' => 'Kerupuk Gurung berkualitas tinggi dengan rasa gurih dan renyah.',
                'price' => 2500,
                'stock' => 100,
                'image' => 'Krupuk_Gurung',
            ],
            // Tambahkan produk lainnya...
        ];

        foreach ($products as $product) {
            // ✅ Cek dulu apakah sudah ada, kalau belum baru insert
            Product::firstOrCreate(
                ['slug' => $product['slug']], // Cek berdasarkan slug
                $product // Data yang diinsert kalau bZelum ada
            );
        }
    }
}