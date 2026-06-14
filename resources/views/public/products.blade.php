@extends('layouts.app')

@section('title', 'Shop - Hume Wear')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 pt-32 pb-12">
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-stone-900">Our Collection</h1>
        <p class="text-stone-500 mt-2">Browse our latest arrivals</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
        @forelse($products as $product)
        @php
            $images = is_array($product->images) ? $product->images : [];
            $primary = $product->primary_image ? asset('storage/' . $product->primary_image) : ($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x500/f5f0eb/1c1917?text=' . urlencode($product->title));
            $hoverImage = null;
            if(count($images) > 0) {
                foreach($images as $img) {
                    $url = asset('storage/' . $img);
                    if($url !== $primary) {
                        $hoverImage = $url;
                        break;
                    }
                }
            }
            $discountPrice = null;
            $discountPercent = null;
            if($product->discount && $product->discount > 0) {
                if($product->discount_type === 'percent') {
                    $discountPrice = $product->price - ($product->price * $product->discount / 100);
                    $discountPercent = $product->discount;
                } else {
                    $discountPrice = $product->price - $product->discount;
                    $discountPercent = round(($product->discount / $product->price) * 100);
                }
            }
        @endphp
        <a href="{{ route('products.show', $product) }}" class="group">
            <div class="aspect-[3/4] bg-[#f5f0eb] overflow-hidden rounded-xl relative">
                <img src="{{ $primary }}" alt="{{ $product->title }}" class="w-full h-full object-cover transition duration-700 {{ $hoverImage ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}">
                @if($hoverImage)
                <img src="{{ $hoverImage }}" alt="{{ $product->title }}" class="w-full h-full object-cover absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-700">
                @endif
                @if($discountPercent)
                <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-600 text-white text-xs font-bold px-2 py-0.5 sm:px-2.5 sm:py-1 uppercase tracking-wider rounded-sm z-10">
                    -{{ $discountPercent }}%
                </div>
                @endif
            </div>
            <div class="mt-3">
                <h3 class="text-sm text-stone-800 leading-snug">{{ $product->title }}</h3>
                @if($discountPrice !== null)
                <p class="text-stone-500 text-sm mt-1">
                    <span class="text-red-600 font-semibold">PKR {{ number_format($discountPrice, 0) }}</span>
                    <span class="line-through ml-1">PKR {{ number_format($product->price, 0) }}</span>
                </p>
                @else
                <p class="text-stone-500 text-sm mt-1">PKR {{ number_format($product->price, 0) }}</p>
                @endif
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

<script>
    (function() {
        var nav = document.getElementById('main-nav');
        if (nav) {
            nav.dataset.alwaysScrolled = '';
            nav.classList.remove('at-top');
            nav.classList.add('scrolled');
            var topBar = document.getElementById('top-bar');
            if (topBar) topBar.classList.add('hidden-bar');
        }
        document.querySelectorAll('.nav-text').forEach(function(el) {
            el.classList.remove('text-white');
            el.classList.add('text-stone-900');
        });
        document.querySelectorAll('.nav-icon').forEach(function(el) {
            el.classList.remove('text-white');
            el.classList.add('text-stone-900');
        });
    })();
</script>
@endsection
