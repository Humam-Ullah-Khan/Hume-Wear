@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-stone-800">Edit Product</h1>
    <p class="text-stone-500 mt-1">Update product information</p>
</div>

@if ($errors->any())
    <div class="bg-red-50 text-red-600 p-4 rounded mb-6">
        <ul class="list-disc pl-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-stone-200 p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-6">
            <label class="block text-sm font-medium text-stone-700 mb-1">Product Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" required value="{{ old('title', $product->title) }}" class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-stone-700 mb-1">Description <span class="text-red-500">*</span></label>
            <textarea name="description" required rows="5" class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-stone-700 mb-1">Price (PKR) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-stone-700 mb-1">Size</label>
            <input type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="e.g. S, M, L, XL" class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-stone-700 mb-1">Category</label>
            <input type="text" name="category" value="{{ old('category', $product->category) }}" placeholder="e.g. Dresses, Accessories" class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-stone-700 mb-1">Product Image</label>
            <input type="file" name="image" class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">
            @if($product->image)
                <p class="text-xs text-stone-400 mt-1">Current: {{ $product->image }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-stone-900 text-white px-8 py-3 rounded hover:bg-stone-800 transition font-medium">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="text-stone-500 hover:text-stone-900 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection