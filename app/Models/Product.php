<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'image',
        'stock',
        'is_discounted',
        'category_id'
    ];

    protected $casts = [
        'is_discounted' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2'
    ];

    public function getFinalPriceAttribute()
    {
        return $this->is_discounted ? $this->discount_price : $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
} 