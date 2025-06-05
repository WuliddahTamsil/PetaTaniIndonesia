<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Pertanian</title>
    <script src="https://cdn.tailwindcss.com"></script> {{-- Using Tailwind for utility classes --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> {{-- Link to your existing CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> {{-- Font Awesome for icons --}}
    <style>
        /* Basic styling for the dashboard header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #eee;
        }

        .header-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        .header-nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
        }

        body {
            font-family: 'Roboto', sans-serif; /* Consistent font */
            background-color: #f8f8f8; /* Light gray background */
        }
        .container {
             width: 90%;
            max-width: 1200px;
            margin: 20px auto; /* Add some top/bottom margin */
            padding: 0;
        }
         section {
            padding: 40px 0;
        }

        /* Add more specific styles as we build sections */

    </style>
</head>
<body>
    <header class="dashboard-header">
        <div class="dashboard-title">
            <h2>Marketplace</h2>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="#crud">CRUD Management</a></li>
                <li><a href="#users">Users/Team</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <div class="user-avatar"></div>
            <span>User Name</span>
            <a href="#logout">Logout</a>
        </div>
    </header>

    {{-- Top Bar (Black Friday/Sale example from reference) --}}
    <div class="bg-black text-white text-center py-2 text-sm">
        Black Friday | Friday | Up to <span class="text-yellow-400 font-bold">59% OFF</span>
    </div>

     {{-- Secondary Nav/Info Bar --}}
    <div class="bg-white py-3 shadow-sm">
        <div class="container flex justify-between items-center text-sm text-gray-700">
            <div class="dropdown">
                All Category <i class="fas fa-chevron-down ml-1 text-xs"></i>
            </div>
            <div class="nav-links flex gap-6">
                <a href="#">Track Order</a>
                <a href="#">Compare</a>
                <a href="#">Customer Support</a>
                <a href="#">Need Help</a>
            </div>
            <div class="contact-info flex items-center gap-2">
                 <i class="fas fa-phone-alt text-xs"></i> <span>+1-202-555-0104</span> {{-- Replace with your contact --}}
            </div>
        </div>
    </div>

    {{-- Hero/Banner Section --}}
    <section class="hero-banner bg-gray-200 py-12">
        <div class="container flex gap-8">
             {{-- Main Banner (Example: Featured Product) --}}
            <div class="w-2/3 bg-white p-8 rounded-lg shadow-md flex items-center">
                <div class="w-1/2">
                    <h3 class="text-lg font-semibold text-blue-600 mb-2">THE BEST PLACE TO BUY</h3>
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Hasil Pertanian <br>& Perkebunan Unggulan</h2> {{-- Adapted for agriculture --}}
                    <p class="text-gray-600 mb-6">Temukan produk segar langsung dari petani terbaik dengan harga kompetitif.</p> {{-- Adapted description --}}
                    <a href="#" class="bg-orange-500 text-white px-6 py-3 rounded-md text-lg font-semibold hover:bg-orange-600">Shop Now →</a> {{-- Example button --}}
                </div>
                 <div class="w-1/2 flex justify-center">
                    <img src="https://via.placeholder.com/300x250?text=Featured+Product+Image" alt="Featured Product" class="max-w-full h-auto">
                </div>
            </div>
            {{-- Side Banners (Example: Promotions) --}}
            <div class="w-1/3 flex flex-col gap-4">
                <div class="bg-blue-200 p-6 rounded-lg shadow-md text-center">
                     <h3 class="text-xl font-bold text-blue-800 mb-2">Promo Kopi Pilihan</h3> {{-- Adapted --}}
                    <p class="text-blue-700 mb-4">Diskon spesial untuk biji kopi terbaik.</p> {{-- Adapted --}}
                    <a href="#" class="text-blue-800 font-semibold">Shop Now →</a>
                </div>
                 <div class="bg-green-200 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold text-green-800 mb-2">Promo Beras Organik</h3> {{-- Adapted --}}
                    <p class="text-green-700 mb-4">Gratis ongkir untuk pembelian minimum.</p> {{-- Adapted --}}
                    <a href="#" class="text-green-800 font-semibold">Shop Now →</a>
                </div>
            </div>
        </div>
    </section>

     {{-- Info Blocks (Fast Delivery, etc.) --}}
    <section class="info-blocks py-8">
        <div class="container flex justify-around text-center text-gray-700">
             <div class="info-item flex flex-col items-center">
                 <i class="fas fa-truck text-2xl mb-2"></i>
                 <span class="font-semibold">Pengiriman Cepat</span> {{-- Adapted --}}
                 <span class="text-sm">Dikirim dalam 24 Jam</span> {{-- Adapted --}}
            </div>
            <div class="info-item flex flex-col items-center">
                 <i class="fas fa-sync-alt text-2xl mb-2"></i>
                 <span class="font-semibold">Jaminan Kualitas</span> {{-- Adapted --}}
                 <span class="text-sm">Produk Segar Terjamin</span> {{-- Adapted --}}
            </div>
            <div class="info-item flex flex-col items-center">
                 <i class="fas fa-shield-alt text-2xl mb-2"></i>
                 <span class="font-semibold">Pembayaran Aman</span> {{-- Adapted --}}
                 <span class="text-sm">Transaksi Terlindungi</span> {{-- Adapted --}}
            </div>
            <div class="info-item flex flex-col items-center">
                 <i class="fas fa-headset text-2xl mb-2"></i>
                 <span class="font-semibold">Dukungan 24/7</span> {{-- Adapted --}}
                 <span class="text-sm">Hubungi Kami Kapan Saja</span> {{-- Adapted --}}
            </div>
        </div>
    </section>

    {{-- Best Deals / Featured Products Section --}}
    <section class="product-listing py-8">
        <div class="container">
            <h2 class="text-2xl font-bold mb-6">Promo terbaik</h2> {{-- Adapted --}}
            <div class="product-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Placeholder Product Card 1 --}}
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/300x200?text=Product+Image" alt="Product Name" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Nama Produk Pertanian</h3> {{-- Adapted --}}
                         <p class="text-gray-700 text-sm mb-2">Deskripsi singkat produk...</p> {{-- Adapted --}}
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-green-700">Rp 50.000</span> {{-- Adapted Price --}}
                             <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600">Add to Cart</button>
                        </div>
                    </div>
                </div>
                 {{-- Placeholder Product Card 2 --}}
                 <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/300x200?text=Product+Image" alt="Product Name" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Nama Produk Pertanian</h3> {{-- Adapted --}}
                         <p class="text-gray-700 text-sm mb-2">Deskripsi singkat produk...</p> {{-- Adapted --}}
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-green-700">Rp 75.000</span> {{-- Adapted Price --}}
                             <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600">Add to Cart</button>
                        </div>
                    </div>
                </div>
                 {{-- Placeholder Product Card 3 --}}
                 <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/300x200?text=Product+Image" alt="Product Name" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Nama Produk Pertanian</h3> {{-- Adapted --}}
                         <p class="text-gray-700 text-sm mb-2">Deskripsi singkat produk...</p> {{-- Adapted --}}
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-green-700">Rp 120.000</span> {{-- Adapted Price --}}
                             <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600">Add to Cart</button>
                        </div>
                    </div>
                </div>
                 {{-- Placeholder Product Card 4 --}}
                 <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/300x200?text=Product+Image" alt="Product Name" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Nama Produk Pertanian</h3> {{-- Adapted --}}
                         <p class="text-gray-700 text-sm mb-2">Deskripsi singkat produk...</p> {{-- Adapted --}}
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-green-700">Rp 90.000</span> {{-- Adapted Price --}}
                             <button class="bg-orange-500 text-white text-sm px-4 py-2 rounded hover:bg-orange-600">Add to Cart</button>
                        </div>
                    </div>
                </div>
                {{-- Add more product cards as needed --}}
            </div>
        </div>
    </section>

    {{-- New Search Form Section --}}
    <section class="new-search-bar-section py-4 bg-white shadow-sm">
        <div class="container">
            <form action="{{ route('search.marketplace') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                <input type="text" name="jenis_komoditas" placeholder="Jenis Komoditas (contoh: Padi)" class="flex-grow p-3 border border-gray-300 rounded-md">
                <input type="text" name="nama_produk" placeholder="Nama Produk (contoh: Beras Organik)" class="flex-grow p-3 border border-gray-300 rounded-md">
                <input type="text" name="kota_lokasi" placeholder="Kota/Lokasi (contoh: Bandung)" class="flex-grow p-3 border border-gray-300 rounded-md">
                <button type="submit" class="bg-green-700 text-white px-6 py-3 rounded-md font-semibold hover:bg-green-800 w-full md:w-auto">Cari Produk</button>
            </form>
        </div>
    </section>

    {{-- Featured Products Section (Now Search Results) --}}
    <section class="product-listing py-8">
        <div class="container">
            <h2 class="text-2xl font-bold mb-6">Hasil Pencarian</h2> {{-- Changed heading --}}
            <div class="product-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Product cards will be loaded here dynamically based on search --}}
            </div>
        </div>
    </section>

    {{-- Footer (can potentially reuse footer component) --}}
    <footer class="bg-gray-800 text-white text-center py-8">
        <div class="container">
            <p>&copy; 2023 Your Website Name. All rights reserved.</p> {{-- Replace with your info --}}
        </div>
    </footer>

</body>
</html> 