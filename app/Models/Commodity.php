<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region',
        'price',
        'production',
        'area',
        'last_updated'
    ];

    protected $casts = [
        'price' => 'float',
        'production' => 'float',
        'area' => 'float',
        'last_updated' => 'datetime'
    ];
} 