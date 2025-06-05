<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Detail Produk</title>
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
        .product-image-detail {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
         .price-old {
            text-decoration: line-through;
            color: #8D6E63; /* Cokelat tanah */
        }
        .price-discount {
            color: #D32F2F; /* Merah untuk diskon */
            font-weight: bold;
        }
        .price-normal {
             font-weight: bold;
             color: #2E7D32; /* Hijau tua */
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
                        <a class="nav-link" href="#">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang Kami</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('marketplace.cart') }}">
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
        <div class="row g-4">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $product->image) }}" class="product-image-detail shadow-sm" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                @if($product->is_discounted)
                    <div>
                        <span class="price-old">Rp {{ number_format($product->price) }}</span>
                        <h4 class="price-discount mb-3">Rp {{ number_format($product->discount_price) }}</h4>
                    </div>
                     <span class="badge bg-warning text-dark mb-3">Diskon {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span>
                @else
                    <h4 class="price-normal mb-3">Rp {{ number_format($product->price) }}</h4>
                @endif

                <p>{{ $product->description }}</p>

                <p><strong>Stok Tersedia:</strong> {{ $product->stock }}</p>

                <!-- Tombol Beli (bisa mengarah ke checkout langsung atau keranjang) -->
                <button class="btn btn-primary btn-lg mt-3" onclick="showUserDetailsModal('{{ $product->id }}')">
                     <i class="fas fa-shopping-cart"></i> Beli Sekarang
                </button>

                 <!-- Placeholder untuk fitur tambah ke keranjang -->
                 <button class="btn btn-secondary btn-lg mt-3 ms-2" onclick="addToCart({{ $product->id }})">
                     <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                 </button>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mt-5">
            <div class="col-md-8 mx-auto">
                <h3 class="mb-4">Customer Reviews</h3>

                @forelse ($product->reviews as $review)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->user->name ?? 'Pengguna' }}</h5> {{-- Display user name, default to 'Pengguna' if user relation is not loaded or user is null --}}
                            <p class="card-text">Rating: {{ $review->rating }} / 5</p>
                            <p class="card-text">{{ $review->comment }}</p>
                             {{-- You might want to display the review date here too --}}
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">Belum ada review untuk produk ini.</div>
                @endforelse

                 {{-- Review Submission Form --}}
                 <div class="mt-5">
                     <h4>Leave a Review</h4>
                     <form id="reviewForm" action="{{ route('reviews.store', $product->id) }}" method="POST">
                         @csrf
                         <div class="mb-3">
                             <label for="rating" class="form-label">Rating (1-5)</label>
                             <select class="form-select" id="rating" name="rating" required>
                                 <option value="">Select Rating</option>
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                                 <option value="4">4</option>
                                 <option value="5">5</option>
                             </select>
                         </div>
                         <div class="mb-3">
                             <label for="comment" class="form-label">Comment</label>
                             <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit Review</button>
                     </form>
                 </div>

            </div>
        </div>

    </div>

     <!-- User Details Modal (copy from index blade) -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukkan Detail Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userDetailsForm">
                        <input type="hidden" id="modalProductId">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullName" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phoneNumber" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="processCheckout()">Lanjut ke Pembayaran</button>
                </div>
            </div>
        </div>
    </div>

    <!-- QRIS Modal (copy dari index blade) -->
    <div class="modal fade modal-qris" id="qrisModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran QRIS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="lead">Scan QR Code di bawah ini untuk menyelesaikan pembayaran:</p>
                    <canvas id="qrisCode" class="my-4"></canvas>
                    <p class="text-muted">Gunakan aplikasi mobile banking atau e-wallet yang mendukung QRIS.</p>
                    <p class="text-danger"><i class="fas fa-clock"></i> Selesaikan pembayaran dalam waktu 15 menit.</p>
                </div>
                <div class="modal-footer justify-content-center">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
     <script>
        function checkout(productId) {
            // In a real application, you would send the actual product ID
            // and potentially quantity to the backend to create an order.
            // The backend would then generate a unique QRIS code for that transaction.
            // For this example, we use the dummy QRIS code from the controller.

            fetch('/marketplace/checkout', {
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
                    // Clear previous QR code
                    document.getElementById('qrisCode').innerHTML = '';

                    // Generate and display new QR code
                    QRCode.toCanvas(document.getElementById('qrisCode'), data.qris_code, {
                        width: 256,
                        margin: 2,
                        color: {
                            dark: '#2E7D32', // Warna hijau tua untuk QR
                            light: '#F5F5DC' // Warna latar belakang krem
                        }
                    }, function (error) {
                      if (error) console.error(error)
                    });

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('qrisModal')).show();
                }
            });
        }

        function showUserDetailsModal(productId) {
            // Store the product ID in the modal form
            document.getElementById('modalProductId').value = productId;
            // Show the user details modal
            var userDetailsModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            userDetailsModal.show();
        }

        function processCheckout() {
            const productId = document.getElementById('modalProductId').value;
            const fullName = document.getElementById('fullName').value;
            const address = document.getElementById('address').value;
            const phoneNumber = document.getElementById('phoneNumber').value;

            // Basic validation
            if (!fullName || !address || !phoneNumber) {
                alert('Mohon lengkapi semua detail!');
                return;
            }

            // Close the user details modal
            const userDetailsModalElement = document.getElementById('userDetailsModal');
            const userDetailsModal = bootstrap.Modal.getInstance(userDetailsModalElement);
            if (userDetailsModal) {
                userDetailsModal.hide();
            }

            // Now call the checkout function with the details
            checkout(productId, fullName, address, phoneNumber);
        }

        function addToCart(productId) {
            fetch('{{ route('marketplace.add_to_cart') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                // Di sini Anda bisa tambahkan logika untuk update ikon keranjang di navbar, dll.
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('Gagal menambahkan produk ke keranjang.');
            });
        }

        // Add event listener for review form submission to prevent default and use fetch
        document.getElementById('reviewForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = event.target;
            const formData = new FormData(form);
            const productId = '{{ $product->id }}'; // Get product ID from Blade

            fetch(form.action, {
                method: form.method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); // Show success message
                    // Optional: Dynamically add the new review to the list without refreshing
                    // You would need to structure the response data and update the DOM
                    // For now, a simple refresh might be easier if needed.
                     window.location.reload(); // Refresh to show the new review
                } else {
                    alert('Failed to submit review: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error submitting review:', error);
                alert('Failed to submit review.');
            });
        });
    </script>
</body>
</html> 