<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        return view('public.wishlist');
    }

    public function products(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([]);
        }

        $products = Product::whereIn('id', $ids)
            ->get()
            ->map(function ($product) {
                $primary = $product->primary_image
                    ? asset('storage/' . $product->primary_image)
                    : ($product->image
                        ? asset('storage/' . $product->image)
                        : 'https://placehold.co/400x500/f5f0eb/1c1917?text=' . urlencode($product->title));

                $discountPrice = null;
                $discountPercent = null;
                if ($product->discount && $product->discount > 0) {
                    if ($product->discount_type === 'percent') {
                        $discountPrice = $product->price - ($product->price * $product->discount / 100);
                        $discountPercent = $product->discount;
                    } else {
                        $discountPrice = $product->price - $product->discount;
                        $discountPercent = round(($product->discount / $product->price) * 100);
                    }
                }

                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'unique_code' => $product->unique_code,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                    'image' => $primary,
                    'url' => route('products.show', $product),
                    'discount_price' => $discountPrice,
                    'discount_percent' => $discountPercent,
                ];
            });

        return response()->json($products);
    }
}
