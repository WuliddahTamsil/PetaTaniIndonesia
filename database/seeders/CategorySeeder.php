<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sayuran', 'icon' => 'fas fa-carrot'],
            ['name' => 'Buah', 'icon' => 'fas fa-apple-alt'],
            ['name' => 'Biji-bijian', 'icon' => 'fas fa-seedling'],
            // Anda bisa menambahkan kategori lain di sini
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insertOrIgnore([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => null,
                'icon' => $category['icon'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 