<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
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
        'category',
        'visibility',
        'publish_date',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'images' => 'array',
    ];
}
