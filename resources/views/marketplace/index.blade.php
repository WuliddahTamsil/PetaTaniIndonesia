<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaTani Indonesia - Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Link ke font elegan, contoh: Playfair Display dan Lato dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            /* Latar belakang body dengan gradasi hijau */
            background: linear-gradient(to bottom, #e8f5e9, #a5d6a7); /* Contoh gradasi hijau muda ke sedang */
            font-family: 'Lato', sans-serif;
            color: #333;
            min-height: 100vh; /* Minimal tinggi 100% viewport */
            padding-bottom: 60px; /* Ruang untuk footer */
            position: relative;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: #1b5e20; /* Warna hijau tua untuk judul */
        }
        .navbar {
            background-color: rgba(27, 94, 32, 0.9); /* Warna hijau tua semi-transparan */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand,
        .nav-link {
            color: #e8f5e9 !important; /* Warna teks hijau sangat muda */
        }
        .nav-link:hover {
             color: #c8e6c9 !important; /* Warna teks hijau lebih muda saat hover */
        }
        .btn-primary {
            background-color: #4caf50; /* Hijau sedang */
            border-color: #4caf50;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #388e3c; /* Hijau lebih tua saat hover */
            border-color: #388e3c;
        }
         .btn-outline-primary {
            color: #4caf50;
            border-color: #4caf50;
            transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
         }
         .btn-outline-primary:hover {
             color: white;
             background-color: #4caf50;
             border-color: #4caf50;
         }
        .container.py-5 {
             background-color: rgba(255, 255, 255, 0.85); /* Latar belakang kontainer sedikit lebih transparan */
             backdrop-filter: blur(8px); /* Efek buram lebih kuat */
             border-radius: 15px; /* Sudut membulat */
             box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Bayangan lebih menonjol */
             margin-top: 30px; /* Lebih banyak ruang di atas */
             margin-bottom: 30px; /* Lebih banyak ruang di bawah */
             padding: 30px; /* Padding internal */
        }
        .product-card,
        .p-4.border.rounded-lg.h-100 {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            border: none;
            border-radius: 12px; /* Sudut lebih membulat */
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.95); /* Latar belakang hampir tidak transparan untuk kartu */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .product-card:hover,
        .p-4.border.rounded-lg.h-100:hover {
            transform: translateY(-10px); /* Efek angkat lebih tinggi */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            background-color: #ffffff; /* Tidak transparan saat hover */
        }
        .product-card img {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }
        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fbc02d; /* Warna kuning keemasan untuk diskon */
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            z-index: 1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .price-old {
            text-decoration: line-through;
            color: #757575; /* Warna abu-abu */
        }
        .price-discount {
            color: #c62828; /* Merah gelap untuk diskon */
            font-weight: bold;
        }
        .price-normal {
             font-weight: bold;
             color: #1b5e20; /* Hijau tua */
        }
        .modal-qris .modal-content {
            border-radius: 10px;
            background-color: #ffffff; /* Latar putih untuk modal */
        }
        .modal-qris .modal-header {
            background-color: #4caf50; /* Warna header modal */
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom: none;
        }
        .modal-qris .modal-title {
            color: white;
        }
        .modal-qris .modal-body #qrisCode canvas {
            display: block;
            margin: 0 auto;
        }
         .text-muted {
             color: #616161 !important; /* Warna abu-abu agak gelap */
         }
         .text-secondary {
             color: #388e3c !important; /* Hijau lebih tua untuk secondary */
         }
         .text-info {
              color: #0288d1 !important; /* Biru lebih standar untuk info */
         }
         .text-success {
              color: #2e7d32 !important; /* Hijau tua untuk success */
         }

        /* General button improvements */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
        }

        /* Search bar styling */
        .input-group .form-control,
        .input-group .btn {
             border-radius: 8px !important;
             font-size: 1rem;
             padding: 10px 15px;
        }
         .input-group .btn {
             padding: 10px 20px;
         }


    </style>
     <style>
        /* Custom CSS to hide unwanted pagination icons - keeping this for now */
        /* Adjust selectors based on actual rendered HTML */
        .pagination i.fas.fa-chevron-left,
        .pagination i.fas.fa-chevron-right {
            /* display: none !important; */ /* Commented out for now */
        }

         /* Style for pagination links to look better */
         .pagination .page-link {
            border-radius: 5px !important;
            margin: 0 3px;
            border: 1px solid #a5d6a7; /* Border hijau */
            color: #1b5e20; /* Teks hijau tua */
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
         }

         .pagination .page-item.active .page-link {
             background-color: #4caf50; /* Hijau sedang */
             border-color: #4caf50;
             color: white;
         }

         .pagination .page-link:hover {
             background-color: #e8f5e9; /* Hijau sangat muda saat hover */
             border-color: #a5d6a7;
             color: #1b5e20;
         }

         .pagination .page-item.disabled .page-link {
             color: #bdbdbd; /* Abu-abu untuk disabled */
         }


    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top"> {{-- Added fixed-top --}}
        <div class="container">
            <a class="navbar-brand" href="#">PetaTani Indonesia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('marketplace.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('marketplace.index') }}">Produk</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li> --}} {{-- Category link is now handled by category cards --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang Kami</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('marketplace.cart') }}">
                            <i class="fas fa-shopping-cart"></i>
                            @if(isset($cartItemCount) && $cartItemCount > 0)
                                <span class="badge bg-danger rounded-pill">{{ $cartItemCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Added padding top for fixed navbar --}}
    <div style="padding-top: 80px;"></div> {{-- Increased padding top --}}

    <div class="container py-5"> {{-- This container now has semi-transparent background --}}
        <!-- Fitur Unggulan -->
        <h2 class="mb-4 text-center">Fitur Unggulan <i class="fas fa-award text-info"></i></h2>
        <div class="row text-center mb-5 g-4">
            <div class="col-md col-sm-6">
                <div class="p-4 border rounded-lg h-100 shadow-sm"> {{-- Removed bg-white here as it's handled by general card style --}}
                    <i class="fas fa-truck fa-3x text-success mb-3"></i>
                    <h5>Gratis Ongkir*</h5>
                    <p class="text-muted">*S&K berlaku</p>
                </div>
            </div>
            <div class="col-md col-sm-6">
                 <div class="p-4 border rounded-lg h-100"> {{-- Removed bg-white --}}
                    <i class="fas fa-qrcode fa-3x text-success mb-3"></i> {{-- Changed text-primary to text-success --}}
                    <h5>Pembayaran QRIS</h5>
                    <p class="text-muted">Mudah dan cepat</p>
                </div>
            </div>
            <div class="col-md col-sm-6">
                 <div class="p-4 border rounded-lg h-100"> {{-- Removed bg-white --}}
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                    <h5>Garansi Segar</h5>
                    <p class="text-muted">Kualitas terjamin</p>
                </div>
            </div>
            <div class="col-md col-sm-6">
                 <div class="p-4 border rounded-lg h-100"> {{-- Removed bg-white --}}
                    <i class="fas fa-comments fa-3x text-success mb-3"></i> {{-- Changed text-info to text-success --}}
                    <h5>Dukungan Pelanggan</h5>
                    <p class="text-muted">Siap membantu 24/7</p>
                </div>
            </div>
            <div class="col-md col-sm-6">
                 <div class="p-4 border rounded-lg h-100"> {{-- Removed bg-white --}}
                    <i class="fas fa-users fa-3x text-success mb-3"></i> {{-- Changed text-secondary to text-success --}}
                    <h5>Komunitas Petani</h5>
                    <p class="text-muted">Bergabung dan berbagi</p>
                </div>
            </div>
        </div>

        <!-- Kategori Produk -->
        <h2 class="mb-4 text-center">Jelajahi Kategori <i class="fas fa-tags text-secondary"></i></h2>
        <div class="row text-center mb-5 g-3 justify-content-center">
            @foreach($categories as $category)
             <div class="col-md-4 col-sm-6 mb-3">
                 <a href="{{ route('marketplace.index', ['category' => $category->id, 'search' => request('search'), 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'min_rating' => request('min_rating'), 'sort' => request('sort')]) }}" class="text-decoration-none">
                     <div class="p-3 border rounded-lg h-100 shadow-sm category-card"> {{-- Added category-card class --}}
                         @if($category->icon)
                             <i class="{{ $category->icon }} fa-2x text-success mb-2"></i> {{-- Changed text-primary to text-success --}}
                         @else
                              {{-- Default icon if none provided --}}
                             <i class="fas fa-tag fa-2x text-success mb-2"></i> {{-- Changed text-primary to text-success --}}
                         @endif
                         <p class="mb-0 text-muted text-sm">{{ $category->name }}</p>
                     </div>
                 </a>
             </div>
            @endforeach
        </div>

         {{-- Moved Search Bar above Semua Produk --}}
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('marketplace.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari produk pertanian..." value="{{ request('search') }}">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                      @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                      @endif
                </form>
            </div>
        </div>

        <!-- Products Section -->
        <div class="container py-5">
            <h2 class="mb-4 text-center">Produk Tersedia</h2>
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        @if($product->is_discounted)
                            <div class="discount-badge">
                                Diskon
                    </div>
                        @endif
                        <a href="{{ route('marketplace.show', $product->id) }}" class="text-decoration-none">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-100">
                            <div class="p-3">
                                <h5 class="mb-2 text-dark">{{ $product->name }}</h5>
                                <p class="text-muted small mb-2">{{ $product->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($product->is_discounted)
                                <span class="price-old">Rp {{ number_format($product->price) }}</span>
                                            <span class="price-discount">Rp {{ number_format($product->discount_price) }}</span>
                            @else
                                            <span class="price-normal">Rp {{ number_format($product->price) }}</span>
                            @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="p-3 pt-0">
                            <button class="btn btn-primary btn-sm add-to-cart w-100" data-product-id="{{ $product->id }}">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                         </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada produk yang tersedia.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                <div class="flex items-center space-x-2">
                    @if($products->onFirstPage())
                        <button disabled class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-2"></i>Previous
                        </button>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-chevron-left mr-2"></i>Previous
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    <div class="flex items-center space-x-1">
                        @php
                            $start = max(1, $products->currentPage() - 2);
                            $end = min($products->lastPage(), $products->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $products->url(1) }}" class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded">1</a>
                            @if($start > 2)
                                <span class="px-2 text-gray-500">...</span>
                        @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $products->currentPage())
                                <span class="px-3 py-1 text-white bg-blue-600 rounded">{{ $i }}</span>
                            @else
                                <a href="{{ $products->url($i) }}" class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $products->lastPage())
                            @if($end < $products->lastPage() - 1)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                            <a href="{{ $products->url($products->lastPage()) }}" class="px-3 py-1 text-blue-600 hover:bg-blue-50 rounded">{{ $products->lastPage() }}</a>
                        @endif
                    </div>

                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">
                            Next<i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    @else
                        <button disabled class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            Next<i class="fas fa-chevron-right ml-2"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Discounted Products Section -->
        @if($discountedProducts->count() > 0)
        <div class="container py-5">
            <h2 class="mb-4 text-center">Produk Diskon</h2>
            <div class="row g-4">
                @foreach($discountedProducts as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="discount-badge">
                            Diskon
                        </div>
                        <a href="{{ route('marketplace.show', $product->id) }}" class="text-decoration-none">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-100">
                            <div class="p-3">
                                <h5 class="mb-2 text-dark">{{ $product->name }}</h5>
                                <p class="text-muted small mb-2">{{ $product->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="price-old">Rp {{ number_format($product->price) }}</span>
                                        <span class="price-discount">Rp {{ number_format($product->discount_price) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="p-3 pt-0">
                            <button class="btn btn-primary btn-sm add-to-cart w-100" data-product-id="{{ $product->id }}">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div> {{-- End container --}}

    <!-- Footer -->
     {{-- Position footer at the bottom --}}
    <footer class="bg-dark text-white text-center py-4" style="position: absolute; bottom: 0; width: 100%; height: 60px;">
        <div class="container">
            <p>&copy; {{ date('Y') }} PetaTani Indonesia. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modals (like QRIS modal) would go here if still needed) -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- You might need to include qrious library for QRIS if you reinplement the modal --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    
                    fetch('/marketplace/add-to-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redirect ke halaman cart setelah berhasil menambahkan
                            window.location.href = '/marketplace/cart';
                        } else {
                            alert(data.message || 'Error adding to cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error adding to cart');
                    });
                });
            });
        });
    </script>
</body>
</html> 