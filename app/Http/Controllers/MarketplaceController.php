<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Handle search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('seller_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('market_location', 'like', '%' . $searchTerm . '%');
            });
        }

        // Handle category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Get products with pagination
        $products = $query->paginate(12);
        
        // Get discounted products
        $discountedProducts = Product::where('is_discounted', true)
                                   ->where('discount_price', '>', 0)
                                   ->get();

        // Get cart item count
        $cartItemCount = 0;
        if (auth()->check()) {
            $cartItemCount = Cart::where('user_id', auth()->id())->count();
        }

        // Get all categories for filter
        $categories = Category::where('is_active', true)->get();

        return view('marketplace.index', compact(
            'products',
            'discountedProducts',
            'cartItemCount',
            'categories'
        ));
    }

    public function checkout(Request $request)
    {
        // Generate QRIS code (dalam implementasi nyata, ini akan terintegrasi dengan payment gateway)
        $qrisCode = '00020101021226630016COM.MERCHANT.WEB01111234567890215COM.MERCHANT.WEB02151234567890303UMI51440014ID.CO.QRIS.WWW01189360091234567890215COM.MERCHANT.WEB0315123456789040005802ID5915COM.MERCHANT.WEB6007JAKARTA61051234562070703A016304';

        return response()->json([
            'success' => true,
            'qris_code' => $qrisCode
        ]);
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $cart = $request->session()->get('cart', []);

        // Check if product already in cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->final_price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        $request->session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang!']);
    }

    public function cart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        return view('marketplace.cart', compact('cart'));
    }

    public function show(Product $product)
    {
        $product->load(['reviews.user', 'category']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('marketplace.show', compact('product', 'relatedProducts'));
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
                $request->session()->put('cart', $cart);
                return response()->json(['success' => true, 'message' => 'Jumlah produk diperbarui!']);
            } else {
                // Remove item if quantity is 0 or less
                unset($cart[$productId]);
                $request->session()->put('cart', $cart);
                return response()->json(['success' => true, 'message' => 'Produk dihapus dari keranjang!']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang.'], 404);
        }
    }

    /**
     * Remove a product from the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCart(Request $request)
    {
        $productId = $request->input('product_id');

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $request->session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => 'Produk dihapus dari keranjang!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang.'], 404);
        }
    }
} 