@extends('layouts.app')

@section('title', 'Mariab - Women\'s Fashion & Accessories')

@section('content')
<div class="bg-stone-100">
    <div class="max-w-7xl mx-auto px-4 py-20 text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-stone-900 mb-4">Elevate Your Style</h1>
        <p class="text-stone-600 text-lg max-w-xl mx-auto mb-8">Discover our curated collection of women's fashion and accessories.</p>
        <a href="{{ url('/products') }}" class="inline-block bg-stone-900 text-white px-10 py-3 rounded hover:bg-stone-800 transition text-sm uppercase tracking-widest">Shop Now</a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($featuredProducts as $product)
        <a href="{{ route('products.show', $product) }}" class="group">
            <div class="aspect-[3/4] bg-stone-200 overflow-hidden rounded-lg">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x500/f5f5f4/1c1917?text=' . urlencode($product->title) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
            <div class="mt-4">
                <h3 class="font-medium text-stone-900">{{ $product->title }}</h3>
                <p class="text-stone-500 mt-1">PKR {{ number_format($product->price, 2) }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<div class="bg-stone-900 text-white py-16 text-center">
    <p class="text-3xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">Timeless Elegance</p>
    <p class="text-stone-400 max-w-md mx-auto">Premium quality fabrics and handcrafted accessories for the modern woman.</p>
</div>
@endsection