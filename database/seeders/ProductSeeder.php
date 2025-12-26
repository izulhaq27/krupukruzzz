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
                'image' => 'products/kerupuk-gurung-1766400991.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Kerupuk Amplang',
                'slug' => 'kerupuk-amplang',
                'description' => 'Kerupuk Amplang rasa ikan tenggiri asli.',
                'price' => 5000,
                'stock' => 50,
                'image' => 'products/kerupuk-amplang-1766396513.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Kerupuk Bawang Pedas',
                'slug' => 'kerupuk-bawang-pedas',
                'description' => 'Kerupuk Bawang dengan sensasi pedas nendang.',
                'price' => 3000,
                'stock' => 80,
                'image' => 'products/kerupuk-bawang-pedas-1766396653.png',
                'category_id' => 2,
            ],
            [
                'name' => 'Kerupuk Rujak',
                'slug' => 'kerupuk-rujak',
                'description' => 'Kerupuk Rujak dengan bumbu tradisional.',
                'price' => 2000,
                'stock' => 150,
                'image' => 'products/kerupuk-rujak-1766467092.png',
                'category_id' => 2,
            ],
        ];

        foreach ($products as $pData) {
            $catId = $pData['category_id'];
            unset($pData['category_id']);

            $product = Product::updateOrCreate(
                ['slug' => $pData['slug']],
                $pData
            );

            // Hubungkan ke kategori
            $product->categories()->sync([$catId]);
        }
    }
}