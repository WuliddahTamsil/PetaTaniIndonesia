<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commodity;
use Carbon\Carbon;

class CommoditySeeder extends Seeder
{
    public function run()
    {
        $commodities = [
            // Komoditas Pangan
            [
                'name' => 'Beras Premium',
                'region' => 'Jawa Barat',
                'production' => 2500,
                'area' => 500,
                'price' => 15000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],
            [
                'name' => 'Beras Medium',
                'region' => 'Jawa Tengah',
                'production' => 1800,
                'area' => 400,
                'price' => 12000,
                'last_updated' => Carbon::now()->subDays(3),
                'coordinates' => ['lat' => -7.7956, 'lng' => 110.3695]
            ],
            [
                'name' => 'Jagung',
                'region' => 'Jawa Timur',
                'production' => 3000,
                'area' => 600,
                'price' => 8000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => -7.2575, 'lng' => 112.7521]
            ],
            [
                'name' => 'Kedelai',
                'region' => 'Sulawesi Selatan',
                'production' => 1200,
                'area' => 300,
                'price' => 14000,
                'last_updated' => Carbon::now()->subDays(4),
                'coordinates' => ['lat' => -5.1477, 'lng' => 119.4327]
            ],
            [
                'name' => 'Kacang Tanah',
                'region' => 'Lampung',
                'production' => 800,
                'area' => 200,
                'price' => 18000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -5.4500, 'lng' => 105.2667]
            ],

            // Komoditas Hortikultura
            [
                'name' => 'Cabai Merah',
                'region' => 'Sumatera Utara',
                'production' => 500,
                'area' => 100,
                'price' => 45000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => 3.5952, 'lng' => 98.6722]
            ],
            [
                'name' => 'Tomat',
                'region' => 'Jawa Barat',
                'production' => 1200,
                'area' => 150,
                'price' => 12000,
                'last_updated' => Carbon::now()->subDays(3),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],
            [
                'name' => 'Bawang Merah',
                'region' => 'Nusa Tenggara Timur',
                'production' => 600,
                'area' => 120,
                'price' => 35000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -10.1833, 'lng' => 123.5833]
            ],
            [
                'name' => 'Bawang Putih',
                'region' => 'Jawa Tengah',
                'production' => 400,
                'area' => 80,
                'price' => 40000,
                'last_updated' => Carbon::now()->subDays(4),
                'coordinates' => ['lat' => -7.7956, 'lng' => 110.3695]
            ],
            [
                'name' => 'Kentang',
                'region' => 'Jawa Barat',
                'production' => 1500,
                'area' => 200,
                'price' => 15000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],

            // Komoditas Perkebunan
            [
                'name' => 'Kopi Arabika',
                'region' => 'Sumatera Utara',
                'production' => 800,
                'area' => 400,
                'price' => 85000,
                'last_updated' => Carbon::now()->subDays(3),
                'coordinates' => ['lat' => 3.5952, 'lng' => 98.6722]
            ],
            [
                'name' => 'Kopi Robusta',
                'region' => 'Lampung',
                'production' => 1200,
                'area' => 600,
                'price' => 65000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -5.4500, 'lng' => 105.2667]
            ],
            [
                'name' => 'Teh',
                'region' => 'Jawa Barat',
                'production' => 2000,
                'area' => 800,
                'price' => 25000,
                'last_updated' => Carbon::now()->subDays(4),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],
            [
                'name' => 'Karet',
                'region' => 'Sumatera Selatan',
                'production' => 3000,
                'area' => 1000,
                'price' => 35000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => -3.3199, 'lng' => 103.9144]
            ],
            [
                'name' => 'Kelapa Sawit',
                'region' => 'Riau',
                'production' => 5000,
                'area' => 2000,
                'price' => 12000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => 0.5071, 'lng' => 101.4478]
            ],

            // Komoditas Buah-buahan
            [
                'name' => 'Pisang',
                'region' => 'Jawa Timur',
                'production' => 2500,
                'area' => 300,
                'price' => 8000,
                'last_updated' => Carbon::now()->subDays(3),
                'coordinates' => ['lat' => -7.2575, 'lng' => 112.7521]
            ],
            [
                'name' => 'Mangga',
                'region' => 'Jawa Tengah',
                'production' => 1800,
                'area' => 250,
                'price' => 15000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -7.7956, 'lng' => 110.3695]
            ],
            [
                'name' => 'Jeruk',
                'region' => 'Jawa Barat',
                'production' => 1200,
                'area' => 200,
                'price' => 12000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],
            [
                'name' => 'Durian',
                'region' => 'Sumatera Utara',
                'production' => 500,
                'area' => 100,
                'price' => 45000,
                'last_updated' => Carbon::now()->subDays(4),
                'coordinates' => ['lat' => 3.5952, 'lng' => 98.6722]
            ],
            [
                'name' => 'Rambutan',
                'region' => 'Jawa Barat',
                'production' => 800,
                'area' => 150,
                'price' => 10000,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],

            // Komoditas Sayuran
            [
                'name' => 'Bayam',
                'region' => 'Jawa Barat',
                'production' => 400,
                'area' => 50,
                'price' => 8000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],
            [
                'name' => 'Kangkung',
                'region' => 'Jawa Tengah',
                'production' => 300,
                'area' => 40,
                'price' => 7000,
                'last_updated' => Carbon::now()->subDays(3),
                'coordinates' => ['lat' => -7.7956, 'lng' => 110.3695]
            ],
            [
                'name' => 'Sawi',
                'region' => 'Jawa Timur',
                'production' => 350,
                'area' => 45,
                'price' => 7500,
                'last_updated' => Carbon::now()->subDays(2),
                'coordinates' => ['lat' => -7.2575, 'lng' => 112.7521]
            ],
            [
                'name' => 'Selada',
                'region' => 'Jawa Barat',
                'production' => 250,
                'area' => 30,
                'price' => 12000,
                'last_updated' => Carbon::now()->subDays(4),
                'coordinates' => ['lat' => -6.9147, 'lng' => 107.6098]
            ],
            [
                'name' => 'Brokoli',
                'region' => 'Jawa Tengah',
                'production' => 200,
                'area' => 25,
                'price' => 25000,
                'last_updated' => Carbon::now()->subDays(1),
                'coordinates' => ['lat' => -7.7956, 'lng' => 110.3695]
            ]
        ];

        foreach ($commodities as $commodity) {
            Commodity::create([
                'name' => $commodity['name'],
                'region' => $commodity['region'],
                'production' => $commodity['production'],
                'area' => $commodity['area'],
                'price' => $commodity['price'],
                'last_updated' => $commodity['last_updated'],
                'coordinates' => json_encode($commodity['coordinates'])
            ]);
        }
    }
} 