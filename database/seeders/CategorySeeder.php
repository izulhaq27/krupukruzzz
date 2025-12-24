<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Sesuai tampilan di dashboard user
        $categories = [
            [
                'name' => 'Original',
                'slug' => 'original',
                'description' => 'Produk dengan rasa original',
                'is_active' => true,
            ],
            [
                'name' => 'Pedas',
                'slug' => 'pedas',
                'description' => 'Produk dengan rasa pedas',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}