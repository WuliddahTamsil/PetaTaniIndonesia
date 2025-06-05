<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $productImages = [
            // Kategori Beras
            [
                'name' => 'Beras Premium',
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Beras Merah Organik',
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Beras Hitam',
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],

            // Kategori Buah-buahan
            [
                'name' => 'Apel Merah',
                'image' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Pisang Raja',
                'image' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Jeruk Medan',
                'image' => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab12?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],

            // Kategori Sayuran
            [
                'name' => 'Tomat Segar',
                'image' => 'https://images.unsplash.com/photo-1546094091536-9d6d4c9c2f5a?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Bayam Organik',
                'image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Wortel Premium',
                'image' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],

            // Kategori Biji-bijian
            [
                'name' => 'Kacang Hijau',
                'image' => 'https://images.unsplash.com/photo-1625944525903-bb2c4877a0c9?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Kedelai Hitam',
                'image' => 'https://images.unsplash.com/photo-1625944525903-bb2c4877a0c9?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Kacang Merah',
                'image' => 'https://images.unsplash.com/photo-1625944525903-bb2c4877a0c9?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],

            // Kategori Rempah-rempah & Kopi
            [
                'name' => 'Kopi Arabika Gayo',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Kopi Robusta Lampung',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Tembakau Virginia',
                'image' => 'https://images.unsplash.com/photo-1519669556878-63bdad8a1a49?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Cengkeh Premium',
                'image' => 'https://images.unsplash.com/photo-1615485500704-8e990f9f0926?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Lada Hitam',
                'image' => 'https://images.unsplash.com/photo-1615485500704-8e990f9f0926?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ],
            [
                'name' => 'Kopi Luwak',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&auto=format&fit=crop&q=80&ixlib=rb-4.0.3'
            ]
        ];

        foreach ($productImages as $productImage) {
            Product::where('name', $productImage['name'])
                  ->update(['image' => $productImage['image']]);
        }
    }
} 