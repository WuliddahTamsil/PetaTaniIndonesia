<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Import the Category model
use App\Models\Product; // Import the Product model
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Storage; // Import Storage facade for file uploads

class SellerController extends Controller
{
    /**
     * Display the seller dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('seller.dashboard');
    }

    /**
     * Display a listing of products for the authenticated seller.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function products()
    {
        // Get products for the authenticated seller
        // This assumes the user is logged in and products are associated via user_id
        $products = collect(); // Default to empty collection
        if (Auth::check()) {
             $products = Product::where('user_id', Auth::id())->get();
        }
       
        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // Max 2MB
            // We will automatically associate seller_name and market_location with the logged-in user later
            // For now, based on the database schema, they exist, but we won't take them from the form
            // 'seller_name' => 'required|string|max:255',
            // 'market_location' => 'required|string|max:255',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // Create the product and associate it with the current seller (TODO: Replace with actual user ID)
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];
        $product->category_id = $validatedData['category_id'];
        $product->image = $imagePath; // Store the image path
        
        // Associate with the logged-in user/seller
        // This assumes the user is logged in and the User model has 'name' and 'market_location' attributes
        if (Auth::check()) {
            $product->user_id = Auth::id(); // Assuming products belong to users/sellers
            $product->seller_name = Auth::user()->name; // Assuming user model has a name
            $product->market_location = Auth::user()->market_location; // Assuming user model has market_location
        } else {
             // TODO: Handle case where user is not authenticated (e.g., redirect to login)
             // For now, these columns might remain null if nullable in DB
        }

        $product->save();

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully.');
    }
}
