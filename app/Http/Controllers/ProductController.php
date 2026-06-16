<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(5)->get();

        $newArrival = Product::latest()->first();

        $videoProducts = Product::whereNotNull('video')->where('video', '!=', '')->latest()->take(8)->get();

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

        return view('public.index', compact('featuredProducts', 'categories', 'newArrival', 'heroSlides', 'videoProducts'));
    }

    public function products(Request $request)
    {
        $query = Product::query();

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Category
        if ($request->filled('category')) {
            $categories = $request->category;
            $query->where(function ($q) use ($categories) {
                foreach ($categories as $cat) {
                    $q->orWhere('category', $cat);
                }
            });
        }

        // Sort
        switch ($request->input('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'best_selling':
                $query->orderBy('id', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->get();

        // Filter options from DB
        $allCategories = Product::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category')->sort()->values();
        $maxPrice = (int) Product::max('price');

        return view('public.products', compact('products', 'allCategories', 'maxPrice'));
    }

    public function show(Product $product)
    {
        return view('public.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (empty($query)) {
            $products = Product::latest()->take(8)->get();
        } else {
            $products = Product::where(function ($q) use ($query) {
                $q->whereRaw("CAST(id AS CHAR) = ?", [$query])
                  ->orWhere('unique_code', 'like', "%{$query}%")
                  ->orWhere('title', 'like', "%{$query}%")
                  ->orWhere('brand', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%")
                  ->orWhere('fabric', 'like', "%{$query}%")
                  ->orWhere('tags', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get();
        }

        return response()->json(
            $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'unique_code' => $product->unique_code,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                    'image' => $product->primary_image ? asset('storage/' . $product->primary_image) : ($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/80x100/f5f0eb/1c1917?text=' . urlencode($product->title)),
                    'url' => route('products.show', $product),
                ];
            })
        );
    }
}
