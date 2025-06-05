<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaTani Nusantara - Commodity Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #map { height: 500px; }
        .commodity-marker {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .weather-card {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }
        .market-trend {
            transition: all 0.3s ease;
        }
        .market-trend:hover {
            transform: translateY(-5px);
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-green-500"></div>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification">
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            <span id="notificationText"></span>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-green-800 text-white flex flex-col md:relative">
            <div class="p-4 flex items-center justify-between border-b border-green-700">
                <h1 class="text-xl font-bold">PetaTani Nusantara</h1>
                <button id="toggleSidebar" class="md:hidden">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto p-4 space-y-6">
                <!-- Search Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Commodity Search</h2>
                    <form action="{{ route('dashboard') }}" method="GET" class="space-y-3">
                        <div>
                            <label class="block text-sm mb-1">Commodity</label>
                            <div class="relative">
                                <input type="text" name="commodity" id="commodityInput" list="commodityList" 
                                    class="w-full p-2 rounded text-gray-800" 
                                    placeholder="Type or select commodity" 
                                    value="{{ request('commodity') }}">
                                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                            </div>
                            <datalist id="commodityList">
                                @foreach($commodities->pluck('name')->unique() as $name)
                                    <option value="{{ $name }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-sm mb-1">City/Region</label>
                            <div class="relative">
                                <input type="text" name="region" id="regionInput" list="regionList" 
                                    class="w-full p-2 rounded text-gray-800" 
                                    placeholder="Type or select region" 
                                    value="{{ request('region') }}">
                                <i class="fas fa-map-marker-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                            <datalist id="regionList">
                                @foreach($commodities->pluck('region')->unique() as $region)
                                    <option value="{{ $region }}">
                                @endforeach
                            </datalist>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                        <a href="{{ route('dashboard') }}" class="block w-full">
                            <button type="button" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 rounded flex items-center justify-center">
                                <i class="fas fa-redo mr-2"></i> Reset
                            </button>
                        </a>
                    </form>
                </div>

                <!-- Legend -->
                <div class="bg-white rounded-lg p-4 text-gray-800">
                    <h2 class="text-lg font-semibold mb-2">Legend</h2>
                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #22c55e;"></div>
                            <span>Produksi Tinggi (>2000 ton)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #eab308;"></div>
                            <span>Produksi Sedang (1000-2000 ton)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #ef4444;"></div>
                            <span>Produksi Rendah (<1000 ton)</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg p-4 text-gray-800">
                    <h2 class="text-lg font-semibold mb-2">Quick Actions</h2>
                    <div class="space-y-2">
                        <button onclick="exportData('csv')" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded flex items-center justify-center">
                            <i class="fas fa-file-csv mr-2"></i> Export CSV
                        </button>
                        <button onclick="exportData('excel')" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded flex items-center justify-center">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </button>
                        <button onclick="exportData('pdf')" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded flex items-center justify-center">
                            <i class="fas fa-file-pdf mr-2"></i> Export PDF
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <!-- Weather and Market Trends -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <!-- Weather Card -->
                    <div class="weather-card rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Cuaca Hari Ini</h3>
                                <p class="text-2xl font-bold" id="weatherTemp">--°C</p>
                                <p id="weatherDesc">Loading...</p>
                            </div>
                            <i class="fas fa-cloud-sun text-4xl"></i>
                        </div>
                    </div>

                    <!-- Market Trends -->
                    <div class="bg-white rounded-lg shadow p-4 market-trend">
                        <h3 class="text-lg font-semibold text-gray-700">Tren Pasar</h3>
                        <div class="mt-2">
                            <div class="flex items-center justify-between">
                                <span>Harga Naik</span>
                                <span class="text-green-500">+5.2%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 52%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Production Forecast -->
                    <div class="bg-white rounded-lg shadow p-4 market-trend">
                        <h3 class="text-lg font-semibold text-gray-700">Ramalan Produksi</h3>
                        <div class="mt-2">
                            <div class="flex items-center justify-between">
                                <span>Bulan Depan</span>
                                <span class="text-blue-500">+8.7%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 87%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Features Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Commodity Comparison Tool -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Perbandingan Komoditas</h2>
                            <button onclick="addComparisonRow()" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                        <div id="comparisonContainer" class="space-y-3">
                            <div class="comparison-row flex gap-2">
                                <select class="flex-1 p-2 border rounded commodity-select">
                                    <option value="">Pilih Komoditas</option>
                                    @foreach($commodities->pluck('name')->unique() as $name)
                                        <option value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <select class="flex-1 p-2 border rounded region-select">
                                    <option value="">Pilih Daerah</option>
                                    @foreach($commodities->pluck('region')->unique() as $region)
                                        <option value="{{ $region }}">{{ $region }}</option>
                                    @endforeach
                                </select>
                                <button onclick="removeComparisonRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button onclick="compareCommodities()" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                                Bandingkan
                            </button>
                        </div>
                    </div>

                    <!-- Comparison Modal -->
                    <div id="comparisonModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Hasil Perbandingan Komoditas</h2>
                                <button onclick="closeComparisonModal()" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <!-- Comparison Tabs -->
                            <div class="mb-4">
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8">
                                        <button onclick="switchComparisonTab('table')" class="comparison-tab active border-green-500 text-green-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            Tabel Perbandingan
                                        </button>
                                        <button onclick="switchComparisonTab('chart')" class="comparison-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            Grafik Perbandingan
                                        </button>
                                    </nav>
                                </div>
                            </div>

                            <!-- Table View -->
                            <div id="tableComparison" class="comparison-view">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komoditas</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Daerah</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produksi (Ton)</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Luas Lahan (Ha)</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga (Rp/kg)</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terakhir Update</th>
                                            </tr>
                                        </thead>
                                        <tbody id="comparisonTableBody" class="bg-white divide-y divide-gray-200">
                                            <!-- Will be populated by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Chart View -->
                            <div id="chartComparison" class="comparison-view hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded">
                                        <h3 class="text-lg font-semibold mb-2">Perbandingan Produksi</h3>
                                        <canvas id="productionComparisonChart"></canvas>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded">
                                        <h3 class="text-lg font-semibold mb-2">Perbandingan Harga</h3>
                                        <canvas id="priceComparisonChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Export Options -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <button onclick="exportComparison('pdf')" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    <i class="fas fa-file-pdf mr-2"></i> Export PDF
                                </button>
                                <button onclick="exportComparison('excel')" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Price Alerts -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Peringatan Harga</h2>
                            <button onclick="showAddAlertModal()" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                <i class="fas fa-bell"></i> Tambah Alert
                            </button>
                        </div>
                        <div id="alertsList" class="space-y-3">
                            <!-- Sample alerts -->
                            <div class="alert-item p-3 bg-gray-50 rounded flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold">Beras Premium</h4>
                                    <p class="text-sm text-gray-600">Harga di atas Rp 15.000/kg</p>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-500 mr-2">Aktif</span>
                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- News Feed Section -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold">Berita & Informasi</h2>
                        <div class="flex space-x-2">
                            <button onclick="filterNews('all')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Semua</button>
                            <button onclick="filterNews('market')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Pasar</button>
                            <button onclick="filterNews('weather')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Cuaca</button>
                            <button onclick="filterNews('tips')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Tips</button>
                        </div>
                    </div>
                    <div id="newsFeed" class="space-y-4">
                        <!-- Berita 1 -->
                        <div class="news-item p-4 border rounded hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">Harga Beras Stabil di Pasar Tradisional</h3>
                                    <p class="text-sm text-gray-600 mt-1">Harga beras di pasar tradisional tetap stabil meskipun terjadi kenaikan di beberapa daerah. Petani berharap harga akan tetap terjangkau...</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>2 jam yang lalu</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-green-600">Pasar</span>
                                    </div>
                                </div>
                                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80" 
                                     alt="Pasar Tradisional" 
                                     class="w-32 h-32 object-cover rounded-lg ml-4">
                            </div>
                        </div>

                        <!-- Berita 2 -->
                        <div class="news-item p-4 border rounded hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">Cuaca Cerah, Panen Padi Optimal</h3>
                                    <p class="text-sm text-gray-600 mt-1">Cuaca cerah di beberapa daerah membuat proses panen padi berjalan optimal. Petani berharap hasil panen tahun ini lebih baik...</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>5 jam yang lalu</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-blue-600">Cuaca</span>
                                    </div>
                                </div>
                                <img src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80" 
                                     alt="Panen Padi" 
                                     class="w-32 h-32 object-cover rounded-lg ml-4">
                            </div>
                        </div>

                        <!-- Berita 3 -->
                        <div class="news-item p-4 border rounded hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">Tips Menyimpan Hasil Panen</h3>
                                    <p class="text-sm text-gray-600 mt-1">Simak tips-tips menyimpan hasil panen agar tetap segar dan berkualitas. Mulai dari suhu penyimpanan hingga teknik pengemasan...</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>1 hari yang lalu</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-purple-600">Tips</span>
                                    </div>
                                </div>
                                <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80" 
                                     alt="Penyimpanan Hasil Panen" 
                                     class="w-32 h-32 object-cover rounded-lg ml-4">
                            </div>
                        </div>

                        <!-- Berita 4 -->
                        <div class="news-item p-4 border rounded hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">Teknologi Modern untuk Pertanian</h3>
                                    <p class="text-sm text-gray-600 mt-1">Penerapan teknologi modern dalam pertanian semakin meningkat. Drone dan sensor IoT membantu petani meningkatkan efisiensi...</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>2 hari yang lalu</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-orange-600">Teknologi</span>
                                    </div>
                                </div>
                                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80" 
                                     alt="Teknologi Pertanian" 
                                     class="w-32 h-32 object-cover rounded-lg ml-4">
                            </div>
                        </div>
                    </div>

                    <!-- Load More Button -->
                    <div class="mt-4 text-center">
                        <button onclick="loadMoreNews()" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            <i class="fas fa-sync-alt mr-2"></i> Muat Berita Lainnya
                        </button>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Komoditas</h3>
                                <p class="text-2xl font-bold text-green-600">{{ $totalCommodities }}</p>
                            </div>
                            <i class="fas fa-seedling text-3xl text-green-500"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Daerah</h3>
                                <p class="text-2xl font-bold text-green-600">{{ $totalRegions }}</p>
                            </div>
                            <i class="fas fa-map-marked-alt text-3xl text-green-500"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Produksi</h3>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($totalProduction, 2) }} ton</p>
                            </div>
                            <i class="fas fa-chart-line text-3xl text-green-500"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Lahan</h3>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($commodities->sum('area'), 2) }} ha</p>
                            </div>
                            <i class="fas fa-ruler-combined text-3xl text-green-500"></i>
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-4 border-b">
                        <h2 class="text-lg font-semibold">Peta Distribusi Komoditas</h2>
                    </div>
                    <div id="map" class="w-full h-[500px] rounded-lg"></div>
                </div>

                <!-- Charts and Table Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Production Chart -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Tren Produksi Komoditas</h2>
                            <div class="flex space-x-2">
                                <button onclick="updateChart('production', 'bar')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                                <button onclick="updateChart('production', 'line')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                            </div>
                        </div>
                        <canvas id="productionChart" height="300"></canvas>
                    </div>

                    <!-- Price Chart -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Tren Harga Komoditas</h2>
                            <div class="flex space-x-2">
                                <button onclick="updateChart('price', 'bar')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                                <button onclick="updateChart('price', 'line')" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                            </div>
                        </div>
                        <canvas id="priceChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Commodity Table -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold">Data Komoditas</h2>
                        <div class="flex space-x-2">
                            <input type="text" id="tableSearch" placeholder="Search..." class="px-3 py-1 border rounded">
                            <select id="tableFilter" class="px-3 py-1 border rounded">
                                <option value="">All Regions</option>
                                @foreach($commodities->pluck('region')->unique() as $region)
                                    <option value="{{ $region }}">{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komoditas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Daerah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produksi (Ton)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Luas Lahan (Ha)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga (Rp/kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($commodities as $commodity)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $commodity->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $commodity->region }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($commodity->production, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($commodity->area, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($commodity->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $commodity->last_updated->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="showDetails('{{ $commodity->id }}')" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Initialize map
        const map = L.map('map').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add markers for each commodity
        const gisData = @json($gisData);
        const markers = {};
        let currentHighlightedMarker = null;

        gisData.forEach(commodity => {
            const { coordinates, name, region, production, area, price } = commodity;
            
            // Create custom icon
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div class="commodity-marker" style="background-color: ${getColorByProduction(production)}"></div>`
            });

            // Create marker
            const marker = L.marker([coordinates.lat, coordinates.lng], { icon }).addTo(map);
            
            // Create popup content
            const popupContent = `
                <div class="p-2">
                    <h3 class="font-bold text-lg">${name}</h3>
                    <p class="text-sm">Daerah: ${region}</p>
                    <p class="text-sm">Produksi: ${production.toLocaleString()} ton</p>
                    <p class="text-sm">Luas Lahan: ${area.toLocaleString()} hektar</p>
                    <p class="text-sm">Harga: Rp ${price.toLocaleString()}/kg</p>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            markers[commodity.id] = marker;

            // Store commodity data in marker
            marker.commodityData = commodity;
        });

        // Function to get color based on production
        function getColorByProduction(production) {
            if (production > 2000) return '#22c55e'; // Green for high production
            if (production > 1000) return '#eab308'; // Yellow for medium production
            return '#ef4444'; // Red for low production
        }

        // Function to highlight marker
        function highlightMarker(marker) {
            if (currentHighlightedMarker) {
                // Reset previous marker
                const prevIcon = L.divIcon({
                    className: 'custom-marker',
                    html: `<div class="commodity-marker" style="background-color: ${getColorByProduction(currentHighlightedMarker.commodityData.production)}"></div>`
                });
                currentHighlightedMarker.setIcon(prevIcon);
            }

            // Highlight new marker
            const highlightIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div class="commodity-marker" style="background-color: #3b82f6; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5);"></div>`
            });
            marker.setIcon(highlightIcon);
            currentHighlightedMarker = marker;

            // Center map on marker
            map.setView(marker.getLatLng(), 10);
            marker.openPopup();
        }

        // Function to search and highlight commodity
        function searchAndHighlightCommodity(searchTerm) {
            searchTerm = searchTerm.toLowerCase();
            let found = false;

            // Search through markers
            Object.values(markers).forEach(marker => {
                const commodity = marker.commodityData;
                if (commodity.name.toLowerCase().includes(searchTerm) || 
                    commodity.region.toLowerCase().includes(searchTerm)) {
                    highlightMarker(marker);
                    found = true;
                }
            });

            if (!found) {
                showNotification('Komoditas tidak ditemukan');
            }
        }

        // Add event listeners for search inputs
        document.getElementById('commodityInput').addEventListener('input', function(e) {
            if (e.target.value) {
                searchAndHighlightCommodity(e.target.value);
            }
        });

        document.getElementById('regionInput').addEventListener('input', function(e) {
            if (e.target.value) {
                searchAndHighlightCommodity(e.target.value);
            }
        });

        // Add search form submit handler
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const commodityValue = document.getElementById('commodityInput').value;
            const regionValue = document.getElementById('regionInput').value;
            
            if (commodityValue || regionValue) {
                searchAndHighlightCommodity(commodityValue || regionValue);
            }
        });

        // Function to reset map view
        function resetMapView() {
            map.setView([-2.5489, 118.0149], 5);
            if (currentHighlightedMarker) {
                const prevIcon = L.divIcon({
                    className: 'custom-marker',
                    html: `<div class="commodity-marker" style="background-color: ${getColorByProduction(currentHighlightedMarker.commodityData.production)}"></div>`
                });
                currentHighlightedMarker.setIcon(prevIcon);
                currentHighlightedMarker.closePopup();
                currentHighlightedMarker = null;
            }
        }

        // Add reset button handler
        document.querySelector('a[href="{{ route("dashboard") }}"]').addEventListener('click', function(e) {
            e.preventDefault();
            resetMapView();
            this.closest('form').reset();
        });

        // Prepare data for charts
        const commodities = @json($commodities);
        const commodityNames = [...new Set(commodities.map(c => c.name))];
        
        // Initialize charts
        let productionChart = new Chart(document.getElementById('productionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: commodityNames,
                datasets: [{
                    label: 'Total Produksi (Ton)',
                    data: commodityNames.map(name => 
                        commodities.filter(c => c.name === name)
                            .reduce((sum, c) => sum + c.production, 0)
                    ),
                    backgroundColor: '#22c55e'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        let priceChart = new Chart(document.getElementById('priceChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: commodityNames,
                datasets: [{
                    label: 'Rata-rata Harga (Rp/kg)',
                    data: commodityNames.map(name => {
                        const items = commodities.filter(c => c.name === name);
                        return items.reduce((sum, c) => sum + c.price, 0) / items.length;
                    }),
                    borderColor: '#eab308',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Function to update chart type
        function updateChart(chartType, type) {
            const chart = chartType === 'production' ? productionChart : priceChart;
            chart.config.type = type;
            chart.update();
        }

        // Table search and filter functionality
        document.getElementById('tableSearch').addEventListener('input', filterTable);
        document.getElementById('tableFilter').addEventListener('change', filterTable);

        function filterTable() {
            const searchText = document.getElementById('tableSearch').value.toLowerCase();
            const filterRegion = document.getElementById('tableFilter').value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const region = row.children[1].textContent;
                const matchesSearch = text.includes(searchText);
                const matchesFilter = !filterRegion || region === filterRegion;
                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
        }

        // Export functionality
        function exportData(type) {
            showLoading();
            // Simulate export process
            setTimeout(() => {
                hideLoading();
                showNotification(`Data exported successfully as ${type.toUpperCase()}`);
            }, 1500);
        }

        // Loading overlay
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Notification system
        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationText = document.getElementById('notificationText');
            notificationText.textContent = message;
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        // Weather API integration (simulated)
        function updateWeather() {
            const weatherTemp = document.getElementById('weatherTemp');
            const weatherDesc = document.getElementById('weatherDesc');
            // Simulate weather data
            weatherTemp.textContent = '28°C';
            weatherDesc.textContent = 'Cerah';
        }

        // Initialize weather
        updateWeather();

        // Toggle sidebar on mobile
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });

        // Show commodity details
        function showDetails(id) {
            const commodity = commodities.find(c => c.id === id);
            if (commodity) {
                showNotification(`Detail ${commodity.name}: ${commodity.production} ton di ${commodity.region}`);
            }
        }

        // Enhanced Comparison Functions
        function addComparisonRow() {
            const container = document.getElementById('comparisonContainer');
            const newRow = document.createElement('div');
            newRow.className = 'comparison-row flex gap-2';
            newRow.innerHTML = `
                <select class="flex-1 p-2 border rounded commodity-select">
                    <option value="">Pilih Komoditas</option>
                    @foreach($commodities->pluck('name')->unique() as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select class="flex-1 p-2 border rounded region-select">
                    <option value="">Pilih Daerah</option>
                    @foreach($commodities->pluck('region')->unique() as $region)
                        <option value="{{ $region }}">{{ $region }}</option>
                    @endforeach
                </select>
                <button onclick="removeComparisonRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(newRow);
        }

        function removeComparisonRow(button) {
            button.closest('.comparison-row').remove();
        }

        function compareCommodities() {
            const rows = document.querySelectorAll('.comparison-row');
            const comparisons = [];
            
            rows.forEach(row => {
                const commodity = row.querySelector('.commodity-select').value;
                const region = row.querySelector('.region-select').value;
                if (commodity && region) {
                    comparisons.push({ commodity, region });
                }
            });

            if (comparisons.length < 2) {
                showNotification('Pilih minimal 2 komoditas untuk dibandingkan');
                return;
            }

            showLoading();
            
            // Simulate API call to get comparison data
            setTimeout(() => {
                const comparisonData = generateComparisonData(comparisons);
                displayComparisonResults(comparisonData);
                hideLoading();
            }, 1000);
        }

        function generateComparisonData(comparisons) {
            // This would typically come from your backend
            return comparisons.map(comp => {
                const commodity = @json($commodities).find(c => 
                    c.name === comp.commodity && c.region === comp.region
                );
                return {
                    name: comp.commodity,
                    region: comp.region,
                    production: commodity ? commodity.production : Math.random() * 2000,
                    area: commodity ? commodity.area : Math.random() * 1000,
                    price: commodity ? commodity.price : Math.random() * 20000,
                    last_updated: commodity ? commodity.last_updated : new Date().toISOString()
                };
            });
        }

        function displayComparisonResults(data) {
            // Populate table
            const tableBody = document.getElementById('comparisonTableBody');
            tableBody.innerHTML = data.map(item => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">${item.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.region}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.production.toLocaleString()} ton</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.area.toLocaleString()} ha</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp ${item.price.toLocaleString()}/kg</td>
                    <td class="px-6 py-4 whitespace-nowrap">${new Date(item.last_updated).toLocaleDateString()}</td>
                </tr>
            `).join('');

            // Create charts
            createComparisonCharts(data);

            // Show modal
            document.getElementById('comparisonModal').classList.remove('hidden');
            document.getElementById('comparisonModal').classList.add('flex');
        }

        function createComparisonCharts(data) {
            // Production Chart
            const productionCtx = document.getElementById('productionComparisonChart').getContext('2d');
            new Chart(productionCtx, {
                type: 'bar',
                data: {
                    labels: data.map(item => `${item.name} (${item.region})`),
                    datasets: [{
                        label: 'Produksi (Ton)',
                        data: data.map(item => item.production),
                        backgroundColor: '#22c55e'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            // Price Chart
            const priceCtx = document.getElementById('priceComparisonChart').getContext('2d');
            new Chart(priceCtx, {
                type: 'bar',
                data: {
                    labels: data.map(item => `${item.name} (${item.region})`),
                    datasets: [{
                        label: 'Harga (Rp/kg)',
                        data: data.map(item => item.price),
                        backgroundColor: '#eab308'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }

        function closeComparisonModal() {
            document.getElementById('comparisonModal').classList.add('hidden');
            document.getElementById('comparisonModal').classList.remove('flex');
        }

        function switchComparisonTab(tab) {
            // Update tab styles
            document.querySelectorAll('.comparison-tab').forEach(t => {
                t.classList.remove('border-green-500', 'text-green-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            event.target.classList.remove('border-transparent', 'text-gray-500');
            event.target.classList.add('border-green-500', 'text-green-600');

            // Show selected view
            document.querySelectorAll('.comparison-view').forEach(v => v.classList.add('hidden'));
            document.getElementById(tab + 'Comparison').classList.remove('hidden');
        }

        function exportComparison(type) {
            showLoading();
            // Simulate export process
            setTimeout(() => {
                hideLoading();
                showNotification(`Perbandingan berhasil diekspor dalam format ${type.toUpperCase()}`);
            }, 1500);
        }

        function showAddAlertModal() {
            // Simulate showing modal
            showNotification('Fitur peringatan harga akan segera hadir');
        }

        // Enhanced News Functions
        function loadMoreNews() {
            showLoading();
            // Simulate loading more news
            setTimeout(() => {
                const newsFeed = document.getElementById('newsFeed');
                const newNews = [
                    {
                        title: "Pasar Ekspor Komoditas Pertanian",
                        content: "Peluang ekspor komoditas pertanian ke pasar internasional semakin terbuka lebar. Beberapa negara menunjukkan minat tinggi...",
                        time: "3 hari yang lalu",
                        category: "Pasar",
                        image: "https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80"
                    },
                    {
                        title: "Pemupukan yang Tepat",
                        content: "Pemupukan yang tepat dapat meningkatkan hasil panen secara signifikan. Berikut adalah panduan lengkap tentang jenis pupuk dan waktu aplikasi...",
                        time: "4 hari yang lalu",
                        category: "Tips",
                        image: "https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80"
                    }
                ];

                newNews.forEach(news => {
                    const newsElement = createNewsElement(news);
                    newsFeed.appendChild(newsElement);
                });

                hideLoading();
                showNotification('Berita baru berhasil dimuat');
            }, 1000);
        }

        function createNewsElement(news) {
            const div = document.createElement('div');
            div.className = 'news-item p-4 border rounded hover:shadow-md transition-shadow';
            div.innerHTML = `
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">${news.title}</h3>
                        <p class="text-sm text-gray-600 mt-1">${news.content}</p>
                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <span>${news.time}</span>
                            <span class="mx-2">•</span>
                            <span class="text-${getCategoryColor(news.category)}-600">${news.category}</span>
                        </div>
                    </div>
                    <img src="${news.image}" 
                         alt="${news.title}" 
                         class="w-32 h-32 object-cover rounded-lg ml-4">
                </div>
            `;
            return div;
        }

        function getCategoryColor(category) {
            const colors = {
                'Pasar': 'green',
                'Cuaca': 'blue',
                'Tips': 'purple',
                'Teknologi': 'orange'
            };
            return colors[category] || 'gray';
        }

        function filterNews(category) {
            showLoading();
            const newsItems = document.querySelectorAll('.news-item');
            
            setTimeout(() => {
                newsItems.forEach(item => {
                    const itemCategory = item.querySelector('span:last-child').textContent;
                    if (category === 'all' || itemCategory === category) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                hideLoading();
                showNotification(`Menampilkan berita kategori: ${category}`);
            }, 500);
        }

        // Add event listeners for new features
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize news feed
            const newsFeed = document.getElementById('newsFeed');
            // Here you would typically fetch and populate news items
            
            // Initialize price alerts
            const alertsList = document.getElementById('alertsList');
            // Here you would typically fetch and populate alerts
        });
    </script>
</body>
</html> 