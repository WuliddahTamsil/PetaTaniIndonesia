<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('landingpage');
});

// Routes for Authentication

// Show the login form
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Handle login attempt
Route::post('/login', function () {
    // Validate the login data
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to authenticate the user
    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();

        // Redirect to the dashboard on successful login
        return redirect()->intended('/dashboard');
    }

    // If authentication fails, redirect back with an error message
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.post');

// Show the registration form
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Handle registration submission
Route::post('/register', function () {
    // Validate the registration data
    $validated = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the user
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    // Redirect to login page with success message
    return redirect()->route('login')->with('success', 'Registration successful! Please login.');
})->name('register.post');

// Handle logout
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Placeholder route for the dashboard (you will need to create a real one)
Route::get('/dashboard', function () {
    return view('dashboard'); // Assuming you have a dashboard.blade.php view
})->name('dashboard');

// Add new route for commodity data
Route::get('/api/commodity-data', function () {
    // Sample data - Replace with actual database query
    return response()->json([
        'commodities' => [
            [
                'name' => 'Jagung',
                'region' => 'Bogor',
                'price' => 8500,
                'production' => 1200,
                'area' => 150,
                'lastUpdated' => '2024-03-20'
            ],
            [
                'name' => 'Padi',
                'region' => 'Bandung',
                'price' => 12000,
                'production' => 2500,
                'area' => 200,
                'lastUpdated' => '2024-03-19'
            ],
            [
                'name' => 'Kedelai',
                'region' => 'Surabaya',
                'price' => 9500,
                'production' => 800,
                'area' => 100,
                'lastUpdated' => '2024-03-18'
            ]
        ],
        'trends' => [
            'price' => [8000, 8500, 9000, 8800, 9200, 9500],
            'production' => [1000, 1200, 1100, 1300, 1400, 1500],
            'area' => [100, 120, 110, 130, 140, 150]
        ]
    ]);
})->name('api.commodity-data');

// Route for the Marketplace page
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::post('/marketplace/checkout', [MarketplaceController::class, 'checkout'])->name('marketplace.checkout');
Route::post('/marketplace/add-to-cart', [MarketplaceController::class, 'addToCart'])->name('marketplace.add_to_cart');
Route::get('/marketplace/cart', [MarketplaceController::class, 'cart'])->name('marketplace.cart');

// New routes for updating and removing cart items
Route::post('/marketplace/cart/update', [MarketplaceController::class, 'updateCart'])->name('marketplace.update_cart');
Route::post('/marketplace/cart/remove', [MarketplaceController::class, 'removeCart'])->name('marketplace.remove_cart');
Route::get('/marketplace/{product}', [MarketplaceController::class, 'show'])->name('marketplace.show');

// Review Routes
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Admin Dashboard Routes
Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    
    // Admin Product Management Routes
    Route::get('/products', [App\Http\Controllers\AdminController::class, 'products'])->name('admin.products.index');
    Route::get('/products/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.products.destroy');
    
    // Admin Category Management Routes
    Route::get('/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories.index');
    Route::get('/categories/create', [App\Http\Controllers\AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [App\Http\Controllers\AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
});

// Seller Dashboard Routes
Route::prefix('seller')->middleware(['seller'])->group(function () {
    Route::get('/', [App\Http\Controllers\SellerController::class, 'index'])->name('seller.dashboard');
    
    // Seller Product Management Routes
    Route::get('/products', [App\Http\Controllers\SellerController::class, 'products'])->name('seller.products.index');
    Route::get('/products/create', [App\Http\Controllers\SellerController::class, 'create'])->name('seller.products.create');
    Route::post('/products', [App\Http\Controllers\SellerController::class, 'store'])->name('seller.products.store');
});

Route::get('/marketplace/search', [MarketplaceController::class, 'index'])->name('search.marketplace');
