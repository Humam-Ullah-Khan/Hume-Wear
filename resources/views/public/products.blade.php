@extends('layouts.app')

@section('title', 'Shop - Mariab')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-stone-900 mb-2">Our Collection</h1>
    <p class="text-stone-500 mb-10">Browse our latest arrivals</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($products as $product)
        <a href="{{ route('products.show', $product) }}" class="group">
            <div class="aspect-[3/4] bg-stone-200 overflow-hidden rounded-lg">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x500/f5f5f4/1c1917?text=' . urlencode($product->title) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
            <div class="mt-4">
                <p class="text-xs uppercase tracking-wider text-stone-400">{{ $product->category ?? 'Fashion' }}</p>
                <h3 class="font-medium text-stone-900 mt-1">{{ $product->title }}</h3>
                <p class="text-stone-600 font-medium mt-1">PKR {{ number_format($product->price, 2) }}</p>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-20 text-stone-400">
            <p class="text-xl">No products available yet.</p>
            <p class="mt-2">Check back soon for our latest collection.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection