<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'unique_code',
        'brand',
        'description',
        'price',
        'discount',
        'discount_type',
        'size',
        'colors',
        'tags',
        'image',
        'images',
        'primary_image',
        'video',
        'category',
        'fabric',
        'visibility',
        'notes',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'images' => 'array',
    ];
}
