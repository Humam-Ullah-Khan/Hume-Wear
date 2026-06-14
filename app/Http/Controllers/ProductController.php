<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(5)->get();

        $newArrival = Product::latest()->first();

        $categories = Product::whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', DB::raw('MIN(id) as min_id'))
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                $product = Product::where('category', $item->category)->first();
                return [
                    'name' => $item->category,
                    'image' => $product->image ?? null,
                ];
            });

        $heroSlides = [
            [
                'image' => Setting::get('hero_image_1') ? asset('storage/' . Setting::get('hero_image_1')) : 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=1920&q=80',
                'title' => Setting::get('hero_title_1', 'MONO+CHROME'),
                'subtitle' => Setting::get('hero_subtitle_1', 'Ready To Wear'),
            ],
            [
                'image' => Setting::get('hero_image_2') ? asset('storage/' . Setting::get('hero_image_2')) : 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1920&q=80',
                'title' => Setting::get('hero_title_2', 'ETHNIC ELEGANCE'),
                'subtitle' => Setting::get('hero_subtitle_2', 'New Arrivals'),
            ],
            [
                'image' => Setting::get('hero_image_3') ? asset('storage/' . Setting::get('hero_image_3')) : 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=1920&q=80',
                'title' => Setting::get('hero_title_3', 'SUMMER BREEZE'),
                'subtitle' => Setting::get('hero_subtitle_3', 'Casual Collection'),
            ],
        ];

        return view('public.index', compact('featuredProducts', 'categories', 'newArrival', 'heroSlides'));
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
