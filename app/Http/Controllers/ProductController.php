<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();
        return view('public.index', compact('featuredProducts'));
    }

    public function products()
    {
        $products = Product::latest()->get();
        return view('public.products', compact('products'));
    }

    public function show(Product $product)
    {
        return view('public.show', compact('product'));
    }
}