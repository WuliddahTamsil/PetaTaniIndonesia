<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories first
        $categories = [
            [
                'name' => 'Sayuran',
                'slug' => 'sayuran',
                'description' => 'Berbagai jenis sayuran segar',
                'is_active' => true
            ],
            [
                'name' => 'Buah-buahan',
                'slug' => 'buah-buahan',
                'description' => 'Berbagai jenis buah-buahan segar',
                'is_active' => true
            ],
            [
                'name' => 'Beras',
                'slug' => 'beras',
                'description' => 'Berbagai jenis beras berkualitas',
                'is_active' => true
            ],
            [
                'name' => 'Biji-bijian',
                'slug' => 'biji-bijian',
                'description' => 'Berbagai jenis biji-bijian berkualitas',
                'is_active' => true
            ],
            [
                'name' => 'Rempah-rempah & Kopi',
                'slug' => 'rempah-kopi',
                'description' => 'Berbagai jenis rempah-rempah dan kopi berkualitas',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products
        $products = [
            // Kategori Beras
            [
                'name' => 'Beras Premium',
                'description' => 'Beras premium kualitas terbaik',
                'price' => 15000,
                'discount_price' => 13500,
                'is_discounted' => true,
                'image' => 'products/beras.jpg',
                'stock' => 100,
                'category_id' => 3,
                'seller_name' => 'Toko Beras Sejahtera',
                'market_location' => 'Jakarta'
            ],
            [
                'name' => 'Beras Merah Organik',
                'description' => 'Beras merah organik kaya nutrisi',
                'price' => 25000,
                'discount_price' => 22000,
                'is_discounted' => true,
                'image' => 'products/beras-merah.jpg',
                'stock' => 50,
                'category_id' => 3,
                'seller_name' => 'Toko Beras Sehat',
                'market_location' => 'Bandung'
            ],
            [
                'name' => 'Beras Hitam',
                'description' => 'Beras hitam premium kaya antioksidan',
                'price' => 30000,
                'discount_price' => null,
                'is_discounted' => false,
                'image' => 'products/beras-hitam.jpg',
                'stock' => 30,
                'category_id' => 3,
                'seller_name' => 'Toko Beras Premium',
                'market_location' => 'Surabaya'
            ],

            // Kategori Buah-buahan
            [
                'name' => 'Apel Merah',
                'description' => 'Apel merah segar impor',
                'price' => 25000,
                'discount_price' => 20000,
                'is_discounted' => true,
                'image' => 'products/apel.jpg',
                'stock' => 30,
                'category_id' => 2,
                'seller_name' => 'Buah Segar',
                'market_location' => 'Surabaya'
            ],
            [
                'name' => 'Pisang Raja',
                'description' => 'Pisang raja lokal segar',
                'price' => 15000,
                'discount_price' => 12000,
                'is_discounted' => true,
                'image' => 'products/pisang.jpg',
                'stock' => 40,
                'category_id' => 2,
                'seller_name' => 'Kebun Buah Lokal',
                'market_location' => 'Yogyakarta'
            ],
            [
                'name' => 'Jeruk Medan',
                'description' => 'Jeruk medan manis segar',
                'price' => 20000,
                'discount_price' => null,
                'is_discounted' => false,
                'image' => 'products/jeruk.jpg',
                'stock' => 25,
                'category_id' => 2,
                'seller_name' => 'Toko Buah Segar',
                'market_location' => 'Medan'
            ],

            // Kategori Sayuran
            [
                'name' => 'Tomat Segar',
                'description' => 'Tomat segar dari kebun lokal',
                'price' => 8000,
                'discount_price' => null,
                'is_discounted' => false,
                'image' => 'products/tomat.jpg',
                'stock' => 50,
                'category_id' => 1,
                'seller_name' => 'Kebun Sayur Organik',
                'market_location' => 'Bandung'
            ],
            [
                'name' => 'Bayam Organik',
                'description' => 'Bayam organik segar',
                'price' => 5000,
                'discount_price' => 4000,
                'is_discounted' => true,
                'image' => 'products/bayam.jpg',
                'stock' => 35,
                'category_id' => 1,
                'seller_name' => 'Kebun Sayur Sehat',
                'market_location' => 'Bogor'
            ],
            [
                'name' => 'Wortel Premium',
                'description' => 'Wortel premium segar',
                'price' => 12000,
                'discount_price' => 10000,
                'is_discounted' => true,
                'image' => 'products/wortel.jpg',
                'stock' => 45,
                'category_id' => 1,
                'seller_name' => 'Kebun Sayur Premium',
                'market_location' => 'Malang'
            ],

            // Kategori Biji-bijian
            [
                'name' => 'Kacang Hijau',
                'description' => 'Kacang hijau kualitas premium',
                'price' => 18000,
                'discount_price' => 15000,
                'is_discounted' => true,
                'image' => 'products/kacang-hijau.jpg',
                'stock' => 60,
                'category_id' => 4,
                'seller_name' => 'Toko Biji-bijian',
                'market_location' => 'Solo'
            ],
            [
                'name' => 'Kedelai Hitam',
                'description' => 'Kedelai hitam organik',
                'price' => 22000,
                'discount_price' => null,
                'is_discounted' => false,
                'image' => 'products/kedelai-hitam.jpg',
                'stock' => 40,
                'category_id' => 4,
                'seller_name' => 'Toko Biji Organik',
                'market_location' => 'Semarang'
            ],
            [
                'name' => 'Kacang Merah',
                'description' => 'Kacang merah kualitas terbaik',
                'price' => 20000,
                'discount_price' => 18000,
                'is_discounted' => true,
                'image' => 'products/kacang-merah.jpg',
                'stock' => 55,
                'category_id' => 4,
                'seller_name' => 'Toko Biji Premium',
                'market_location' => 'Denpasar'
            ],

            // Kategori Rempah-rempah & Kopi
            [
                'name' => 'Kopi Arabika Gayo',
                'description' => 'Kopi arabika premium dari Gayo, Aceh',
                'price' => 85000,
                'discount_price' => 75000,
                'is_discounted' => true,
                'image' => 'products/kopi-gayo.jpg',
                'stock' => 25,
                'category_id' => 5,
                'seller_name' => 'Kopi Gayo Premium',
                'market_location' => 'Aceh'
            ],
            [
                'name' => 'Kopi Robusta Lampung',
                'description' => 'Kopi robusta kualitas terbaik dari Lampung',
                'price' => 65000,
                'discount_price' => null,
                'is_discounted' => false,
                'image' => 'products/kopi-lampung.jpg',
                'stock' => 30,
                'category_id' => 5,
                'seller_name' => 'Kopi Lampung',
                'market_location' => 'Lampung'
            ],
            [
                'name' => 'Tembakau Virginia',
                'description' => 'Tembakau virginia kualitas premium',
                'price' => 120000,
                'discount_price' => 100000,
                'is_discounted' => true,
                'image' => 'products/tembakau-virginia.jpg',
                'stock' => 20,
                'category_id' => 5,
                'seller_name' => 'Tembakau Premium',
                'market_location' => 'Jember'
            ],
            [
                'name' => 'Cengkeh Premium',
                'description' => 'Cengkeh kualitas terbaik dari Maluku',
                'price' => 95000,
                'discount_price' => 85000,
                'is_discounted' => true,
                'image' => 'products/cengkeh.jpg',
                'stock' => 40,
                'category_id' => 5,
                'seller_name' => 'Rempah Maluku',
                'market_location' => 'Maluku'
            ],
            [
                'name' => 'Lada Hitam',
                'description' => 'Lada hitam kualitas premium',
                'price' => 75000,
                'discount_price' => null,
                'is_discounted' => false,
                'image' => 'products/lada-hitam.jpg',
                'stock' => 35,
                'category_id' => 5,
                'seller_name' => 'Rempah Bangka',
                'market_location' => 'Bangka'
            ],
            [
                'name' => 'Kopi Luwak',
                'description' => 'Kopi luwak premium kualitas terbaik',
                'price' => 150000,
                'discount_price' => 135000,
                'is_discounted' => true,
                'image' => 'products/kopi-luwak.jpg',
                'stock' => 15,
                'category_id' => 5,
                'seller_name' => 'Kopi Luwak Premium',
                'market_location' => 'Bali'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 