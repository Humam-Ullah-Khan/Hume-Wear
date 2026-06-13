@extends('layouts.app')

@section('title', $product->title . ' - Hume Wear')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <a href="{{ url('/products') }}" class="text-stone-500 hover:text-stone-900 transition text-sm">&larr; Back to Shop</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8">
        <div class="aspect-[3/4] bg-stone-200 overflow-hidden rounded-lg">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x800/f5f5f4/1c1917?text=' . urlencode($product->title) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
        </div>

        <div class="flex flex-col justify-center">
            <p class="text-xs uppercase tracking-widest text-stone-400 mb-2">{{ $product->category ?? 'Fashion' }}</p>
            <h1 class="text-4xl font-bold text-stone-900 mb-4">{{ $product->title }}</h1>
            <p class="text-3xl font-semibold text-stone-900 mb-6">PKR {{ number_format($product->price, 2) }}</p>

            @if($product->size)
            <div class="mb-6">
                <p class="text-sm font-medium text-stone-700 mb-2">Size</p>
                <span class="inline-block border border-stone-900 px-6 py-2 text-sm font-medium">{{ $product->size }}</span>
            </div>
            @endif

            <div class="border-t border-stone-200 pt-6 mt-2">
                <h3 class="text-sm font-medium text-stone-700 mb-3">Description</h3>
                <p class="text-stone-600 leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection