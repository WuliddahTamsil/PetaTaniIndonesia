<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk produk ini'
            ], 422);
        }

        // Check if user has purchased the product
        $hasPurchased = false; // Implement your purchase verification logic here
        $isVerifiedPurchase = $hasPurchased;

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified_purchase' => $isVerifiedPurchase
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan',
            'review' => $review->load('user')
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diperbarui',
            'review' => $review->load('user')
        ]);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus'
        ]);
    }
} 