<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'unique_code' => 'nullable|max:20|unique:products,unique_code',
            'brand' => 'nullable|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:fixed,percent',
            'size' => 'nullable|max:50',
            'colors' => 'nullable',
            'tags' => 'nullable',
            'category' => 'nullable|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'visibility' => 'nullable|in:draft,published',
            'primary_image' => 'nullable|numeric',
            'video' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
            'notes' => 'nullable|string',
        ]);

        if (empty($validated['unique_code'])) {
            $validated['unique_code'] = $this->generateUniqueCode();
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('products', 'public');
            }
        }

        $validated['images'] = !empty($imagePaths) ? $imagePaths : null;

        if (!empty($imagePaths)) {
            $primaryIdx = (int) $request->input('primary_image', 0);
            $selectedIndex = isset($imagePaths[$primaryIdx]) ? $primaryIdx : 0;
            $validated['image'] = $imagePaths[$selectedIndex];
            $validated['primary_image'] = $imagePaths[$selectedIndex];
        }

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('products/videos', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'unique_code' => 'nullable|max:20|unique:products,unique_code,' . $product->id,
            'brand' => 'nullable|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:fixed,percent',
            'size' => 'nullable|max:50',
            'colors' => 'nullable',
            'tags' => 'nullable',
            'category' => 'nullable|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'visibility' => 'nullable|in:draft,published',
            'primary_image' => 'nullable',
            'video' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
            'notes' => 'nullable|string',
            'remove_images' => 'nullable',
            'remove_video' => 'nullable',
        ]);

        $existingImages = is_array($product->images) ? $product->images : [];
        $newImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $newImages[] = $file->store('products', 'public');
            }
        }

        $removeImages = json_decode($request->input('remove_images', '[]'), true) ?? [];
        $existingImages = array_values(array_diff($existingImages, $removeImages));

        foreach ($removeImages as $img) {
            if ($img && Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        $allImages = array_merge($existingImages, $newImages);
        $validated['images'] = !empty($allImages) ? $allImages : null;

        $primaryInput = $request->input('primary_image');
        if ($primaryInput !== null) {
            if (strpos($primaryInput, 'new_') === 0) {
                $newIdx = (int) str_replace('new_', '', $primaryInput);
                if (isset($newImages[$newIdx])) {
                    $validated['image'] = $newImages[$newIdx];
                    $validated['primary_image'] = $newImages[$newIdx];
                }
            } else {
                if (in_array($primaryInput, $allImages)) {
                    $validated['image'] = $primaryInput;
                    $validated['primary_image'] = $primaryInput;
                }
            }
        }

        $product->update($validated);

        if ($request->hasFile('video')) {
            if ($product->video && Storage::disk('public')->exists($product->video)) {
                Storage::disk('public')->delete($product->video);
            }
            $product->video = $request->file('video')->store('products/videos', 'public');
        } elseif ($request->input('remove_video') === '1' && $product->video) {
            if (Storage::disk('public')->exists($product->video)) {
                Storage::disk('public')->delete($product->video);
            }
            $product->video = null;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $allImages = is_array($product->images) ? $product->images : [];
        $allImages[] = $product->image;
        foreach (array_filter(array_unique($allImages)) as $img) {
            if ($img && Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }
        if ($product->video && Storage::disk('public')->exists($product->video)) {
            Storage::disk('public')->delete($product->video);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function generateUniqueCode(): string
    {
        $lastProduct = Product::whereNotNull('unique_code')
            ->orderByRaw("CAST(SUBSTRING(unique_code, 4) AS UNSIGNED) DESC")
            ->first();

        if ($lastProduct && preg_match('/^HW-(\d+)$/', $lastProduct->unique_code, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        return 'HW-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
