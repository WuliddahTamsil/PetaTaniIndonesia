<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
     <style>
        body {
            background-color: #F5F5DC; /* Warna krem tanah */
        }
        .navbar {
            background-color: #2E7D32; /* Hijau tua */
        }
        .navbar-brand,
        .nav-link {
            color: white !important;
        }
        .btn-primary {
            background-color: #4CAF50; /* Hijau sedang */
            border-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #388E3C; /* Hijau lebih tua saat hover */
            border-color: #388E3C;
        }
     </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('marketplace.index') }}">FarmBrite Marketplace</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a> {{-- Placeholder --}}
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang Kami</a> {{-- Placeholder --}}
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a> {{-- Placeholder --}}
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('marketplace.cart') }}"> {{-- Link ke halaman keranjang --}}
                            <i class="fas fa-shopping-cart"></i>
                             @if(isset($cart) && count($cart) > 0)
                                <span class="badge bg-danger rounded-pill">{{ count($cart) }}</span>
                             @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        @if(isset($cart) && count($cart) > 0)
            <div class="table-responsive">
                <table class="table shadow-sm">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 5px;">
                                        {{ $item['name'] }}
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item['price']) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $item['id'] }}', {{ $item['quantity'] }} - 1)">-</button>
                                        <input type="text" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}" style="width: 50px; margin: 0 5px;" readonly data-product-id="{{ $item['id'] }}">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $item['id'] }}', {{ $item['quantity'] }} + 1)">+</button>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item['price'] * $item['quantity']) }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="removeItem('{{ $item['id'] }}')"><i class="fas fa-trash"></i> Hapus</button>
                                </td>
                            </tr>
                             @php $total += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Ringkasan Belanja</h5>
                            <p class="card-text">Subtotal: Rp {{ number_format($total) }}</p>
                            {{-- Placeholder for Shipping and Total --}}
                            {{-- <p class="card-text">Ongkos Kirim: Rp ...</p> --}}
                            {{-- <h5 class="card-text">Total: Rp ...</h5> --}}
                             <a href="#" class="btn btn-primary w-100 mt-3">Lanjut ke Pembayaran</a> {{-- Link ke halaman checkout --}}
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="alert alert-info text-center" role="alert">
                Keranjang belanja Anda kosong.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(productId, quantity) {
            // Prevent quantity from going below 1
            if (quantity < 1) {
                return;
            }

            fetch('{{ route('marketplace.update_cart') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to reflect changes
                    window.location.reload();
                } else {
                    alert('Gagal memperbarui jumlah: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
                alert('Terjadi kesalahan saat memperbarui jumlah.');
            });
        }

        function removeItem(productId) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                fetch('{{ route('marketplace.remove_cart') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to reflect changes
                        window.location.reload();
                    } else {
                        alert('Gagal menghapus produk: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    alert('Terjadi kesalahan saat menghapus produk.');
                });
            }
        }
    </script>
</body>
</html> 