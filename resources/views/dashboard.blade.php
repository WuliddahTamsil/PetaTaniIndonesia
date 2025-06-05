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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        #map { height: 500px; }
        .sidebar {
            width: 300px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: absolute;
                z-index: 1000;
                height: auto;
                max-height: 80vh;
                overflow-y: auto;
            }
            .sidebar-hidden {
                transform: translateX(-100%);
            }
            .sidebar-visible {
                transform: translateX(0);
            }
        }
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .commodity-marker {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .commodity-area {
            stroke: true;
            weight: 2;
            opacity: 1;
            fillOpacity: 0.5;
        }
        #sidebarToggle {
            display: none;
        }
        @media (max-width: 768px) {
            #sidebarToggle {
                display: block;
                position: fixed;
                top: 70px;
                left: 10px;
                z-index: 1001;
                background: white;
                padding: 8px;
                border-radius: 50%;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }
        }
        .custom-marker {
            background: none;
            border: none;
        }
        .leaflet-popup-content {
            max-height: 300px;
            overflow-y: auto;
        }
        .leaflet-popup-content .text-xs {
            font-family: monospace;
            white-space: pre-wrap;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Toggle -->
        <button id="sidebarToggle" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Simplified Sidebar -->
        <div id="sidebar" class="sidebar bg-green-800 text-white flex flex-col md:relative">
            <div class="p-4 flex items-center justify-between border-b border-green-700">
                <h1 class="text-xl font-bold">PetaTani Nusantara</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto p-4 space-y-6">
                <!-- Search Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Commodity Search</h2>
                    <form action="{{ route('dashboard') }}" method="GET" class="space-y-3">
                        <div>
                            <label class="block text-sm mb-1">Commodity</label>
                            <input type="text" name="commodity" id="commodityInput" list="commodityList" class="w-full p-2 rounded text-gray-800" placeholder="Type or select commodity" value="{{ request('commodity') }}">
                            <datalist id="commodityList">
                                <option value="Jagung">
                                <option value="Padi">
                                <option value="Kedelai">
                                <option value="Gandum">
                                <option value="Kopi">
                                <option value="Teh">
                                <option value="Tembakau">
                                <option value="Karet">
                                <option value="Kelapa Sawit">
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-sm mb-1">City/Region</label>
                            <input type="text" name="region" id="regionInput" list="regionList" class="w-full p-2 rounded text-gray-800" placeholder="Type or select region" value="{{ request('region') }}">
                            <datalist id="regionList">
                                <option value="Bogor">
                                <option value="Bandung">
                                <option value="Surabaya">
                                <option value="Yogyakarta">
                                <option value="Medan">
                                <option value="Jakarta">
                                <option value="Semarang">
                                <option value="Malang">
                                <option value="Denpasar">
                            </datalist>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">
                            Search
                        </button>
                        <a href="{{ route('dashboard') }}" class="block w-full">
                            <button type="button" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 rounded">
                            Reset
                        </button>
                        </a>
                    </form>
                </div>
                
                <!-- Commodity Chart -->
                <div class="bg-white rounded-lg p-4 shadow">
                    <h2 class="text-lg font-semibold mb-2">Commodity Trends</h2>
                    <div class="mb-3">
                        <select id="chartType" class="w-full p-2 rounded text-gray-800 text-sm border border-gray-300">
                            <option value="price">Price Trends</option>
                            <option value="production">Production Trends</option>
                            <option value="area">Area Trends</option>
                        </select>
                    </div>
                    <div class="relative" style="height: 250px;">
                        <canvas id="commodityChart"></canvas>
                    </div>
                </div>
                
                <!-- Marketplace Button -->
                <div>
                    <a href="{{ route('marketplace.index') }}" class="block w-full">
                        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">
                            Marketplace
                        </button>
                    </a>
                </div>
                
                <!-- Export Tools -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Export Data</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <button id="exportCsvBtn" class="bg-green-600 hover:bg-green-700 text-white py-2 rounded text-sm">
                            Export CSV
                        </button>
                        <button id="exportExcelBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-sm">
                            Export Excel
                        </button>
                        <button id="exportPdfBtn" class="bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm">
                            Export PDF
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center space-x-4">
                        <h2 class="text-xl font-semibold text-gray-800">Commodity Tracker</h2>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="profileDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                                @if(auth()->check())
                                    @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-8 h-8 rounded-full">
                                    @else
                                    <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white font-semibold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <span>{{ auth()->user()->name }}</span>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Guest</span>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                @if(auth()->check())
                                    <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        @csrf
                                        <button type="submit" class="w-full text-left">Logout</button>
                                    </form>
                                @endif
                                @guest
                                    <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold text-gray-700">Total Komoditas</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $totalCommodities }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold text-gray-700">Total Daerah</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $totalRegions }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold text-gray-700">Total Produksi (Ton)</h3>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalProduction, 2) }}</p>
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div id="map" class="w-full h-[500px] rounded-lg"></div>
                </div>

                <!-- Commodity Chart -->
                    <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold mb-2">Tren Komoditas</h2>
                    <div class="mb-3">
                        <select id="chartType" class="w-full p-2 rounded text-gray-800 text-sm border border-gray-300">
                            <option value="price">Tren Harga</option>
                            <option value="production">Tren Produksi</option>
                            <option value="area">Tren Luas Lahan</option>
                        </select>
                            </div>
                    <div class="relative" style="height: 250px;">
                        <canvas id="commodityChart"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="loading hidden">
        <div class="flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Loading commodity data from BPS...</span>
        </div>
    </div>

    <script>
        // Configuration
        const BPS_API_KEY = 'YOUR_BPS_API_KEY'; // Replace with your actual BPS API key
        const BPS_BASE_URL = 'https://webapi.bps.go.id/v1/api';
        const ITEMS_PER_PAGE = 10;

        // Commodity color mapping
        const commodityColors = {
            'Jagung': '#FFD700',      // Gold
            'Padi': '#FF4500',        // Orange Red
            'Kedelai': '#32CD32',     // Lime Green
            'Gandum': '#FF69B4',      // Hot Pink
            'Kopi': '#8B4513',        // Saddle Brown
            'Teh': '#00CED1',         // Dark Turquoise
            'Tembakau': '#9932CC',    // Dark Orchid
            'Karet': '#1E90FF',       // Dodger Blue
            'Kelapa Sawit': '#FFA500' // Orange
        };

        // Global variables
        let map;
        let currentPage = 1;
        let totalPages = 1;
        let allCommodityData = [];
        let filteredCommodityData = [];
        let commodityMarkers = [];
        let currentLocationMarker = null;
        let currentLocationCircle = null;
        let isFullscreen = false;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            initializeMap();
            setupEventListeners();
            fetchBPSData();
            updateMarketplaceData();
        });

        function initializeMap() {
            // Initialize map centered on Indonesia
            map = L.map('map').setView([-2.5, 118.0], 5);
            
            // Add OpenStreetMap base layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add loading indicator to map
            const loadingDiv = document.getElementById('loadingIndicator');
            document.getElementById('map').appendChild(loadingDiv);
        }

        function setupEventListeners() {
            // Search button
            document.getElementById('searchBtn').addEventListener('click', function() {
                const commodity = document.getElementById('commodityInput').value.trim();
                const region = document.getElementById('regionInput').value.trim();
                filterCommodityData(commodity, region);
            });

            // Reset button
            document.getElementById('resetBtn').addEventListener('click', function() {
                document.getElementById('commodityInput').value = '';
                document.getElementById('regionInput').value = '';
                filterCommodityData('', '');
            });

            // Locate me button
            document.getElementById('locateMeBtn').addEventListener('click', locateUser);

            // Fullscreen button
            document.getElementById('fullscreenBtn').addEventListener('click', toggleFullscreen);

            // Export buttons
            document.getElementById('exportCsvBtn').addEventListener('click', exportToCsv);
            document.getElementById('exportExcelBtn').addEventListener('click', exportToExcel);
            document.getElementById('exportPdfBtn').addEventListener('click', exportToPdf);

            // Pagination buttons
            document.getElementById('prevPageBtn').addEventListener('click', goToPreviousPage);
            document.getElementById('nextPageBtn').addEventListener('click', goToNextPage);

            // Profile dropdown
            document.getElementById('profileDropdownButton').addEventListener('click', function() {
                document.getElementById('profileDropdown').classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('profileDropdown');
                const button = document.getElementById('profileDropdownButton');
                
                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Mobile sidebar toggle
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('sidebar-hidden');
                sidebar.classList.toggle('sidebar-visible');
            });

            // View marketplace button
            document.getElementById('viewMarketplaceBtn').addEventListener('click', function() {
                // Implement marketplace functionality
            });
        }

        async function fetchBPSData() {
            try {
                showLoading();
                
                // In a real application, you would make an actual API call to BPS
                // For demonstration, we'll use simulated data
                // const response = await axios.get(`${BPS_BASE_URL}/list`, {
                //     params: {
                //         model: 'agriculture',
                //         key: BPS_API_KEY,
                //         year: new Date().getFullYear()
                //     }
                // });
                
                // Simulate API delay
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Simulated BPS data response
                const simulatedResponse = {
                    data: {
                        data: [
                            {
                                id: 1,
                                commodity: "Jagung",
                                region: "Bogor",
                                area: 1250,
                                production: 3750,
                                price: 4500,
                                year: 2023,
                                coordinates: [
                                    [-6.6, 106.8],
                                    [-6.58, 106.82],
                                    [-6.57, 106.85],
                                    [-6.59, 106.87],
                                    [-6.62, 106.86],
                                    [-6.63, 106.83],
                                    [-6.61, 106.81]
                                ]
                            },
                            {
                                id: 2,
                                commodity: "Padi",
                                region: "Bogor",
                                area: 2300,
                                production: 9200,
                                price: 8500,
                                year: 2023,
                                coordinates: [
                                    [-6.55, 106.75],
                                    [-6.53, 106.77],
                                    [-6.52, 106.79],
                                    [-6.54, 106.81],
                                    [-6.56, 106.82],
                                    [-6.58, 106.8],
                                    [-6.57, 106.78],
                                    [-6.56, 106.76]
                                ]
                            },
                            {
                                id: 3,
                                commodity: "Teh",
                                region: "Bandung",
                                area: 850,
                                production: 425,
                                price: 12000,
                                year: 2023,
                                coordinates: [
                                    [-6.9, 107.6],
                                    [-6.88, 107.62],
                                    [-6.87, 107.64],
                                    [-6.89, 107.66],
                                    [-6.91, 107.65],
                                    [-6.92, 107.63],
                                    [-6.91, 107.61]
                                ]
                            },
                            {
                                id: 4,
                                commodity: "Kopi",
                                region: "Medan",
                                area: 3200,
                                production: 960,
                                price: 25000,
                                year: 2023,
                                coordinates: [
                                    [3.6, 98.67],
                                    [3.62, 98.69],
                                    [3.64, 98.71],
                                    [3.66, 98.7],
                                    [3.65, 98.68],
                                    [3.63, 98.66],
                                    [3.61, 98.67]
                                ]
                            },
                            {
                                id: 5,
                                commodity: "Karet",
                                region: "Palembang",
                                area: 1800,
                                production: 900,
                                price: 15000,
                                year: 2023,
                                coordinates: [
                                    [-2.99, 104.76],
                                    [-2.97, 104.78],
                                    [-2.96, 104.8],
                                    [-2.98, 104.82],
                                    [-3.0, 104.81],
                                    [-3.01, 104.79],
                                    [-3.0, 104.77]
                                ]
                            },
                            {
                                id: 6,
                                commodity: "Tembakau",
                                region: "Jember",
                                area: 1200,
                                production: 360,
                                price: 30000,
                                year: 2023,
                                coordinates: [
                                    [-8.17, 113.7],
                                    [-8.15, 113.72],
                                    [-8.14, 113.74],
                                    [-8.16, 113.76],
                                    [-8.18, 113.75],
                                    [-8.19, 113.73],
                                    [-8.18, 113.71]
                                ]
                            },
                            {
                                id: 7,
                                commodity: "Jagung",
                                region: "Lampung",
                                area: 1500,
                                production: 4500,
                                price: 4300,
                                year: 2023,
                                coordinates: [
                                    [-5.45, 105.27],
                                    [-5.43, 105.29],
                                    [-5.42, 105.31],
                                    [-5.44, 105.33],
                                    [-5.46, 105.32],
                                    [-5.47, 105.3],
                                    [-5.46, 105.28]
                                ]
                            },
                            {
                                id: 8,
                                commodity: "Padi",
                                region: "Surabaya",
                                area: 2000,
                                production: 8000,
                                price: 8200,
                                year: 2023,
                                coordinates: [
                                    [-7.25, 112.75],
                                    [-7.23, 112.77],
                                    [-7.22, 112.79],
                                    [-7.24, 112.81],
                                    [-7.26, 112.8],
                                    [-7.27, 112.78],
                                    [-7.26, 112.76]
                                ]
                            },
                            {
                                id: 9,
                                commodity: "Kelapa Sawit",
                                region: "Riau",
                                area: 5000,
                                production: 25000,
                                price: 8000,
                                year: 2023,
                                coordinates: [
                                    [0.53, 101.45],
                                    [0.55, 101.47],
                                    [0.57, 101.49],
                                    [0.59, 101.48],
                                    [0.58, 101.46],
                                    [0.56, 101.44],
                                    [0.54, 101.45]
                                ]
                            },
                            {
                                id: 10,
                                commodity: "Kedelai",
                                region: "Yogyakarta",
                                area: 750,
                                production: 1125,
                                price: 9500,
                                year: 2023,
                                coordinates: [
                                    [-7.8, 110.36],
                                    [-7.78, 110.38],
                                    [-7.77, 110.4],
                                    [-7.79, 110.42],
                                    [-7.81, 110.41],
                                    [-7.82, 110.39],
                                    [-7.81, 110.37]
                                ]
                            }
                        ]
                    }
                };

                allCommodityData = simulatedResponse.data.data;
                filteredCommodityData = [...allCommodityData];
                
                updateMapWithCommodities(allCommodityData);
                updateTable(allCommodityData);
                updateChart(allCommodityData);
                
                // Update search results info
                document.getElementById('searchResultsInfo').textContent = 
                    `Showing all commodities from BPS (${allCommodityData.length} records)`;
                
            } catch (error) {
                console.error('Error fetching BPS data:', error);
                alert('Failed to fetch commodity data from BPS. Please try again later.');
            } finally {
                hideLoading();
            }
        }

        function filterCommodityData(commodity, region) {
            filteredCommodityData = allCommodityData.filter(item => {
                const commodityMatch = commodity === '' || 
                    item.commodity.toLowerCase().includes(commodity.toLowerCase());
                const regionMatch = region === '' || 
                    item.region.toLowerCase().includes(region.toLowerCase());
                return commodityMatch && regionMatch;
            });
            
            currentPage = 1;
            updateMapWithCommodities(filteredCommodityData);
            updateTable(filteredCommodityData);
            
            // Update search results info
            let infoText = 'Showing ';
            if (commodity) infoText += `commodity: ${commodity}`;
            if (commodity && region) infoText += ' in ';
            if (region) infoText += `region: ${region}`;
            if (!commodity && !region) infoText = 'Showing all commodities';
            
            infoText += ` (${filteredCommodityData.length} records)`;
            document.getElementById('searchResultsInfo').textContent = infoText;
        }

        function updateMapWithCommodities(data) {
            // Clear existing markers and areas
            if (commodityMarkers.length > 0) {
                commodityMarkers.forEach(marker => map.removeLayer(marker));
                commodityMarkers = [];
            }
            
            // Add new areas and markers
            data.forEach(item => {
                if (item.coordinates && item.coordinates.length > 0) {
                    const color = commodityColors[item.commodity] || '#808080';
                    
                    // Create polygon for the area
                    const area = L.polygon(item.coordinates, {
                        color: color,
                        fillColor: color,
                        weight: 2,
                        opacity: 0.8,
                        fillOpacity: 0.3
                    }).addTo(map);

                    // Calculate center point for marker
                    const centerLat = item.coordinates.reduce((sum, coord) => sum + coord[0], 0) / item.coordinates.length;
                    const centerLng = item.coordinates.reduce((sum, coord) => sum + coord[1], 0) / item.coordinates.length;
                    
                    // Create marker with custom icon
                    const marker = L.marker([centerLat, centerLng], {
                        icon: L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="background-color: ${color}; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.3);"></div>`,
                            iconSize: [12, 12],
                            iconAnchor: [6, 6]
                        })
                    }).addTo(map);

                    // Format coordinates for display
                    const formattedCoordinates = item.coordinates.map(coord => 
                        `${coord[0].toFixed(6)}, ${coord[1].toFixed(6)}`
                    ).join('<br>');

                    // Add popup with information
                    const popupContent = `
                        <div class="p-2">
                            <h3 class="font-bold text-lg mb-2">${item.commodity}</h3>
                            <div class="space-y-1">
                                <p><b>Region:</b> ${item.region}</p>
                                <p><b>Area:</b> ${item.area.toLocaleString()} ha</p>
                                <p><b>Production:</b> ${item.production.toLocaleString()} ton</p>
                                <p><b>Price:</b> IDR ${item.price.toLocaleString()}/kg</p>
                                <p><b>Year:</b> ${item.year}</p>
                                <div class="mt-2">
                                    <p class="font-semibold">Coordinates:</p>
                                    <div class="text-xs bg-gray-100 p-2 rounded mt-1">
                                        ${formattedCoordinates}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Bind popup to both area and marker
                    area.bindPopup(popupContent);
                    marker.bindPopup(popupContent);

                    // Add click event to highlight area when marker is clicked
                    marker.on('click', function() {
                        area.setStyle({
                            fillOpacity: 0.6,
                            weight: 3
                        });
                        setTimeout(() => {
                            area.setStyle({
                                fillOpacity: 0.3,
                                weight: 2
                            });
                        }, 1000);
                    });

                    commodityMarkers.push(area, marker);
                }
            });
            
            // Fit map to show all areas if there are any
            if (commodityMarkers.length > 0) {
                const group = new L.featureGroup(commodityMarkers);
                map.fitBounds(group.getBounds());
            }
        }

        function updateTable(data) {
            const tableBody = document.querySelector('#commodityTable tbody');
            tableBody.innerHTML = '';
            
            // Calculate pagination
            totalPages = Math.ceil(data.length / ITEMS_PER_PAGE);
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, data.length);
            const pageData = data.slice(startIndex, endIndex);
            
            // Add rows for current page
            pageData.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">${item.commodity}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.region}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.area.toLocaleString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.production.toLocaleString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.price.toLocaleString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${item.year}</td>
                `;
                tableBody.appendChild(row);
            });
            
            // Update pagination info
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('tableInfo').textContent = `Showing ${startIndex + 1}-${endIndex} of ${data.length} records`;
            
            // Enable/disable pagination buttons
            document.getElementById('prevPageBtn').disabled = currentPage <= 1;
            document.getElementById('nextPageBtn').disabled = currentPage >= totalPages;
        }

        function goToPreviousPage() {
            if (currentPage > 1) {
                currentPage--;
                updateTable(filteredCommodityData);
            }
        }

        function goToNextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                updateTable(filteredCommodityData);
            }
        }

        function locateUser() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Remove existing location
                        if (currentLocationMarker) {
                            map.removeLayer(currentLocationMarker);
                            map.removeLayer(currentLocationCircle);
                        }

                        // Add new location marker
                        currentLocationMarker = L.marker([lat, lng]).addTo(map);
                        currentLocationCircle = L.circle([lat, lng], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 100
                        }).addTo(map);

                        // Center map on current location
                        map.setView([lat, lng], 15);
                    },
                    error => {
                        console.error('Error getting location:', error);
                        alert('Unable to get your location. Please check your location settings.');
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser');
            }
        }

        function toggleFullscreen() {
            const mapContainer = document.getElementById('map');
            if (!isFullscreen) {
                if (mapContainer.requestFullscreen) {
                    mapContainer.requestFullscreen();
                } else if (mapContainer.webkitRequestFullscreen) {
                    mapContainer.webkitRequestFullscreen();
                } else if (mapContainer.msRequestFullscreen) {
                    mapContainer.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
            isFullscreen = !isFullscreen;
        }

        function showLoading() {
            document.getElementById('loadingIndicator').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loadingIndicator').classList.add('hidden');
        }

        function exportToCsv() {
            const headers = ['Commodity', 'Region', 'Area (ha)', 'Production (ton)', 'Price (IDR/kg)', 'Year'];
            const csvContent = [
                headers.join(','),
                ...filteredCommodityData.map(item => [
                    item.commodity,
                    item.region,
                    item.area,
                    item.production,
                    item.price,
                    item.year
                ].join(','))
            ].join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `commodity_data_${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
        }

        function exportToExcel() {
            const worksheet = XLSX.utils.json_to_sheet(filteredCommodityData.map(item => ({
                'Commodity': item.commodity,
                'Region': item.region,
                'Area (ha)': item.area,
                'Production (ton)': item.production,
                'Price (IDR/kg)': item.price,
                'Year': item.year
            })));

            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Commodity Data');
            XLSX.writeFile(workbook, `commodity_data_${new Date().toISOString().split('T')[0]}.xlsx`);
        }

        function exportToPdf() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(18);
            doc.text('Commodity Data Report', 14, 15);

            // Add date
            doc.setFontSize(10);
            doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 14, 22);

            // Add table
            doc.autoTable({
                head: [['Commodity', 'Region', 'Area (ha)', 'Production (ton)', 'Price (IDR/kg)', 'Year']],
                body: filteredCommodityData.map(item => [
                    item.commodity,
                    item.region,
                    item.area.toLocaleString(),
                    item.production.toLocaleString(),
                    item.price.toLocaleString(),
                    item.year
                ]),
                startY: 30,
                styles: {
                    fontSize: 8,
                    cellPadding: 2
                },
                headStyles: {
                    fillColor: [34, 139, 34],
                    textColor: [255, 255, 255]
                },
                alternateRowStyles: {
                    fillColor: [245, 245, 245]
                }
            });

            // Add summary
            const totalArea = filteredCommodityData.reduce((sum, item) => sum + item.area, 0);
            const totalProduction = filteredCommodityData.reduce((sum, item) => sum + item.production, 0);
            const avgPrice = filteredCommodityData.reduce((sum, item) => sum + item.price, 0) / filteredCommodityData.length;

            doc.setFontSize(12);
            doc.text('Summary:', 14, doc.lastAutoTable.finalY + 10);
            doc.setFontSize(10);
            doc.text([
                `Total Area: ${totalArea.toLocaleString()} ha`,
                `Total Production: ${totalProduction.toLocaleString()} ton`,
                `Average Price: IDR ${Math.round(avgPrice).toLocaleString()}/kg`
            ], 14, doc.lastAutoTable.finalY + 20);

            // Save the PDF
            doc.save(`commodity_data_${new Date().toISOString().split('T')[0]}.pdf`);
        }

        // Add event listener for fullscreen change
        document.addEventListener('fullscreenchange', function() {
            isFullscreen = !!document.fullscreenElement;
            if (isFullscreen) {
                map.invalidateSize();
            }
        });

        // Add marketplace data
        function updateMarketplaceData() {
            // Simulated price updates
            const priceUpdates = [
                { commodity: 'Kopi', price: 25000, change: '+5%' },
                { commodity: 'Jagung', price: 4500, change: '-2%' },
                { commodity: 'Padi', price: 8500, change: '+3%' }
            ];

            const priceUpdatesHtml = priceUpdates.map(update => `
                <div class="flex justify-between items-center text-sm">
                    <span>${update.commodity}</span>
                    <div class="flex items-center">
                        <span class="mr-2">IDR ${update.price.toLocaleString()}/kg</span>
                        <span class="${update.change.startsWith('+') ? 'text-green-600' : 'text-red-600'}">
                            ${update.change}
                        </span>
                    </div>
                </div>
            `).join('');

            document.getElementById('priceUpdates').innerHTML = priceUpdatesHtml;

            // Simulated top buyers
            const topBuyers = [
                { name: 'PT Maju Bersama', commodity: 'Kopi', volume: '100 ton' },
                { name: 'CV Sejahtera', commodity: 'Jagung', volume: '500 ton' },
                { name: 'UD Makmur', commodity: 'Padi', volume: '200 ton' }
            ];

            const topBuyersHtml = topBuyers.map(buyer => `
                <div class="text-sm">
                    <div class="font-medium">${buyer.name}</div>
                    <div class="text-gray-600">${buyer.commodity} - ${buyer.volume}</div>
                </div>
            `).join('');

            document.getElementById('topBuyers').innerHTML = topBuyersHtml;
        }

        function updateChart(data) {
            const ctx = document.getElementById('commodityChart').getContext('2d');
            const chartType = document.getElementById('chartType').value;
            
            // Group data by commodity
            const commodityGroups = {};
            data.forEach(item => {
                if (!commodityGroups[item.commodity]) {
                    commodityGroups[item.commodity] = {
                        totalPrice: 0,
                        totalProduction: 0,
                        totalArea: 0,
                        count: 0
                    };
                }
                commodityGroups[item.commodity].totalPrice += item.price;
                commodityGroups[item.commodity].totalProduction += item.production;
                commodityGroups[item.commodity].totalArea += item.area;
                commodityGroups[item.commodity].count++;
            });

            const labels = Object.keys(commodityGroups);
            let values;
            let label;

            switch(chartType) {
                case 'price':
                    values = labels.map(commodity => 
                        Math.round(commodityGroups[commodity].totalPrice / commodityGroups[commodity].count)
                    );
                    label = 'Average Price (IDR/kg)';
                    break;
                case 'production':
                    values = labels.map(commodity => 
                        Math.round(commodityGroups[commodity].totalProduction)
                    );
                    label = 'Total Production (ton)';
                    break;
                case 'area':
                    values = labels.map(commodity => 
                        Math.round(commodityGroups[commodity].totalArea)
                    );
                    label = 'Total Area (ha)';
                    break;
            }

            const backgroundColors = labels.map(commodity => 
                commodityColors[commodity] || '#808080'
            );

            // Destroy previous chart if it exists
            if (window.commodityChart) {
                window.commodityChart.destroy();
            }

            // Create new chart
            window.commodityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(color => color.replace('0.6', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    if (chartType === 'price') {
                                        return `IDR ${value.toLocaleString()}/kg`;
                                    } else {
                                        return `${value.toLocaleString()} ${chartType === 'production' ? 'ton' : 'ha'}`;
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: label,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        }

        // Add chart type change event listener
        document.getElementById('chartType').addEventListener('change', function() {
            updateChart(filteredCommodityData);
        });
    </script>
</body>
</html>