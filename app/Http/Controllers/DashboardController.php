<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commodity;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Commodity::query();

        // Handle search
        if ($request->has('commodity')) {
            $query->where('name', 'like', '%' . $request->commodity . '%');
        }

        if ($request->has('region')) {
            $query->where('region', 'like', '%' . $request->region . '%');
        }

        $commodities = $query->get();

        // Get summary data
        $totalCommodities = $commodities->count();
        $totalRegions = $commodities->pluck('region')->unique()->count();
        $totalProduction = $commodities->sum('production');

        // Get GIS data for each commodity
        $gisData = $commodities->map(function ($commodity) {
            return [
                'id' => $commodity->id,
                'name' => $commodity->name,
                'region' => $commodity->region,
                'production' => $commodity->production,
                'area' => $commodity->area,
                'price' => $commodity->price,
                'coordinates' => $this->getCoordinatesForRegion($commodity->region),
                'last_updated' => $commodity->last_updated
            ];
        });

        return view('dashboard-new', compact(
            'commodities',
            'totalCommodities',
            'totalRegions',
            'totalProduction',
            'gisData'
        ));
    }

    private function getCoordinatesForRegion($region)
    {
        // Koordinat untuk setiap kota/daerah
        $coordinates = [
            'Bogor' => ['lat' => -6.5971, 'lng' => 106.8060],
            'Bandung' => ['lat' => -6.9175, 'lng' => 107.6191],
            'Surabaya' => ['lat' => -7.2575, 'lng' => 112.7521],
            'Yogyakarta' => ['lat' => -7.7956, 'lng' => 110.3695],
            'Medan' => ['lat' => 3.5952, 'lng' => 98.6722],
            'Jakarta' => ['lat' => -6.2088, 'lng' => 106.8456],
            'Semarang' => ['lat' => -6.9932, 'lng' => 110.4229],
            'Malang' => ['lat' => -7.9839, 'lng' => 112.6214],
            'Denpasar' => ['lat' => -8.6705, 'lng' => 115.2126]
        ];

        return $coordinates[$region] ?? ['lat' => 0, 'lng' => 0];
    }
} 