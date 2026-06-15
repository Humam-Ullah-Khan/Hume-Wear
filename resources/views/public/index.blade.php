@extends('layouts.app')

@section('title', "Hume Wear - Women's Fashion & Accessories")

@section('hero')
{{-- Hero Section --}}
<div class="relative h-screen w-full overflow-hidden bg-stone-950">
    {{-- Slides --}}
    @foreach($heroSlides as $index => $slide)
    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" id="slide-{{ $index }}">
        <img src="{{ $slide['image'] }}" alt="Collection {{ $index + 1 }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/20"></div>
    </div>
    @endforeach

    {{-- Hero Content --}}
    <div class="absolute bottom-16 left-0 right-0 z-10">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="hero-text text-center md:text-left">
                <p class="text-white/80 text-sm tracking-[0.3em] uppercase mb-3" id="hero-subtitle">{{ $heroSlides[0]['subtitle'] }}</p>
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white tracking-wider" id="hero-title">{{ $heroSlides[0]['title'] }}</h1>
            </div>
        </div>
    </div>

    {{-- Carousel Indicators --}}
    <div class="absolute bottom-8 right-6 md:right-12 z-10 flex items-center gap-2" id="carousel-dots">
        @foreach($heroSlides as $index => $slide)
        <div class="carousel-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
        @endforeach
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 hidden md:flex flex-col items-center gap-2 text-white/60">
        <span class="text-[10px] tracking-[0.3em] uppercase">Scroll</span>
        <div class="w-px h-8 bg-gradient-to-b from-white/60 to-transparent"></div>
    </div>
</div>
@endsection

@section('content')
{{-- Shop By Category --}}
@if($categories->count())
<div class="max-w-[1400px] mx-auto px-6 py-20">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl md:text-4xl font-bold text-stone-900">Shop By Category</h2>
        <div class="flex items-center gap-2" id="category-nav-btns">
            <button onclick="scrollCategories('left')" class="btn-hover w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-400 hover:border-stone-400 hover:text-stone-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button onclick="scrollCategories('right')" class="btn-hover w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-400 hover:border-stone-400 hover:text-stone-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    <div class="relative">
        <div class="overflow-hidden" id="category-container">
            <div class="flex gap-8 transition-transform duration-500" id="category-track">
                @foreach($categories as $category)
                <a href="{{ url('/products?category=' . urlencode($category['name'])) }}" class="flex-shrink-0 text-center group">
                    <div class="w-40 h-40 md:w-48 md:h-48 rounded-full bg-stone-100 overflow-hidden mx-auto mb-4 group-hover:ring-2 group-hover:ring-stone-300 transition">
                        @if($category['image'])
                            <img src="{{ asset('storage/' . $category['image']) }}" alt="{{ $category['name'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-stone-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <p class="text-sm md:text-base text-stone-700 group-hover:text-stone-900 transition">{{ $category['name'] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

{{-- Featured Products --}}
<div class="max-w-[1400px] mx-auto px-6 py-20">
    <div class="text-center mb-14">
        <p class="text-stone-400 text-sm tracking-[0.3em] uppercase mb-3">New Arrivals</p>
        <h2 class="text-3xl md:text-4xl font-bold text-stone-900">Featured Products</h2>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
        @foreach($featuredProducts as $product)
        @php
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
                <img src="{{ $product->primary_image ? asset('storage/' . $product->primary_image) : ($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x500/f5f0eb/1c1917?text=' . urlencode($product->title)) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
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
        @endforeach
    </div>
    <div class="text-center mt-12">
        <a href="{{ url('/products') }}" class="inline-block border border-stone-900 text-stone-900 px-10 py-3 hover:bg-stone-900 hover:text-white btn-hover-outline transition text-sm uppercase tracking-[0.2em] font-medium">View All</a>
    </div>
</div>

{{-- New Arrival --}}
@if($newArrival)
<div class="bg-[#f0ece6]">
    <div class="max-w-[1400px] mx-auto px-6 py-8 md:py-12">
        <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
            {{-- Image --}}
            <div class="w-full md:w-1/2 flex justify-center">
                <div class="w-full max-w-md aspect-square rounded-xl overflow-hidden">
                    <img src="{{ $newArrival->primary_image ? asset('storage/' . $newArrival->primary_image) : ($newArrival->image ? asset('storage/' . $newArrival->image) : 'https://placehold.co/600x600/f0ece6/1c1917?text=' . urlencode($newArrival->title)) }}" alt="{{ $newArrival->title }}" class="w-full h-full object-cover">
                </div>
            </div>

            {{-- Content --}}
            <div class="w-full md:w-1/2">
                <p class="text-sm font-bold tracking-[0.15em] text-stone-800 uppercase mb-4">New Products</p>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-stone-900 mb-6 uppercase leading-tight break-words">{{ $newArrival->title }}</h2>

                <a href="{{ route('products.show', $newArrival) }}" class="btn-hover inline-block bg-stone-900 text-white px-10 py-3 hover:bg-stone-800 transition text-sm uppercase tracking-[0.2em] font-bold">Buy Now</a>
            </div>
        </div>
    </div>
</div>
@endif

@if($videoProducts && $videoProducts->count())
{{-- Watch. Tap. Shop. Video Section --}}
<div class="max-w-[1400px] mx-auto px-6 py-12 md:py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-stone-900">Watch. Tap. Shop.</h2>
        <div class="flex items-center gap-4">
            <a href="{{ url('/products') }}" class="text-sm text-stone-500 hover:text-stone-900 transition underline">View All</a>
            <div class="flex items-center gap-2">
                <button onclick="scrollVideoCards('left')" class="w-10 h-10 rounded-full border border-stone-300 flex items-center justify-center text-stone-400 hover:border-stone-500 hover:text-stone-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="scrollVideoCards('right')" class="w-10 h-10 rounded-full border border-stone-300 flex items-center justify-center text-stone-400 hover:border-stone-500 hover:text-stone-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="relative overflow-hidden">
        <div class="flex gap-4 transition-transform duration-500" id="video-track">
            @foreach($videoProducts as $index => $vp)
                @php
                    $discountPrice = null;
                    $discountPercent = null;
                    if($vp->discount && $vp->discount > 0) {
                        if($vp->discount_type === 'percent') {
                            $discountPrice = $vp->price - ($vp->price * $vp->discount / 100);
                            $discountPercent = $vp->discount;
                        } else {
                            $discountPrice = $vp->price - $vp->discount;
                            $discountPercent = round(($vp->discount / $vp->price) * 100);
                        }
                    }
                @endphp
                <div class="flex-shrink-0 w-[180px] md:w-[220px] cursor-pointer group video-card"
                    data-id="{{ $vp->id }}"
                    data-title="{{ addslashes($vp->title) }}"
                    data-brand="{{ addslashes($vp->brand ?? '') }}"
                    data-price="{{ $vp->price }}"
                    data-discount-price="{{ $discountPrice ?? '' }}"
                    data-discount-percent="{{ $discountPercent ?? '' }}"
                    data-video="{{ $vp->video ? asset('storage/' . $vp->video) : '' }}"
                    data-image="{{ $vp->primary_image ? asset('storage/' . $vp->primary_image) : ($vp->image ? asset('storage/' . $vp->image) : '') }}"
                    data-url="{{ route('products.show', $vp) }}"
                    onclick="openVideoModalFromCard(this)">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden relative bg-stone-900">
                        @if($vp->video)
                            <video class="w-full h-full object-cover" muted preload="metadata" playsinline
                                onmouseenter="this.play()" onmouseleave="this.pause(); this.currentTime=0;">
                                <source src="{{ asset('storage/' . $vp->video) }}" type="video/mp4">
                            </video>
                        @elseif($vp->primary_image || $vp->image)
                            <img src="{{ $vp->primary_image ? asset('storage/' . $vp->primary_image) : asset('storage/' . $vp->image) }}" alt="{{ $vp->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-stone-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        @endif
                        {{-- Play Button --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                <svg class="w-5 h-5 text-stone-900 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        {{-- Product Info --}}
                        <div class="absolute bottom-0 left-0 right-0 p-3">
                            <p class="text-white text-sm font-semibold leading-tight line-clamp-2">{{ $vp->title }}</p>
                            <p class="text-white text-xs mt-1">
                                @if($discountPrice !== null)
                                    PKR {{ number_format($discountPrice, 0) }}
                                @else
                                    PKR {{ number_format($vp->price, 0) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Video Modal --}}
<div id="video-modal" class="fixed inset-0 z-[200] hidden" style="display:none;">
    <div class="absolute inset-0 bg-black/80" onclick="closeVideoModal()"></div>

    {{-- Close Button --}}
    <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-[210] px-6 py-2 bg-white text-stone-900 rounded-lg text-sm font-semibold hover:bg-stone-100 transition shadow-lg">
        Close
    </button>

    {{-- Modal Content --}}
    <div class="absolute inset-0 flex items-center justify-center z-[205] px-4 py-16" onclick="event.stopPropagation()">
        {{-- Card Wrapper (relative, not overflow-hidden) --}}
        <div class="relative flex-shrink-0">
            {{-- Video Card --}}
            <div class="relative w-[280px] sm:w-[300px] md:w-[340px] h-[70vh] max-h-[600px] rounded-2xl overflow-hidden bg-black shadow-2xl">
                {{-- Video --}}
                <video id="modal-video" class="absolute inset-0 w-full h-full object-cover" muted playsinline poster="" onclick="toggleModalPlay()">
                    <source src="" type="video/mp4">
                </video>

                {{-- Play/Pause Overlay --}}
                <div id="modal-play-overlay" class="absolute inset-0 flex items-center justify-center pointer-events-none z-[5]">
                    <div class="w-16 h-16 rounded-full bg-black/30 backdrop-blur-sm flex items-center justify-center">
                        <svg id="modal-play-icon" class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>

                {{-- Mute Button (top-right) --}}
                <button id="modal-mute-btn" onclick="toggleModalMute()" class="absolute top-3 right-3 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-stone-900 hover:bg-white transition z-10">
                    <svg id="modal-mute-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
                </button>

                {{-- Share Button (inside card, above product bar) --}}
                <button onclick="openSharePopup()" class="absolute right-3 bottom-[100px] md:bottom-[80px] w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-stone-900 hover:bg-white transition shadow-lg z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </button>

                {{-- Product Info Bar (overlays bottom of video) --}}
                <div class="absolute bottom-0 left-0 right-0 z-10">
                    <a id="modal-product-link" href="#" class="flex items-center gap-3 bg-white/95 backdrop-blur-sm p-3">
                        <img id="modal-product-thumb" src="" alt="" class="w-12 h-12 rounded-lg object-cover bg-stone-200 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h3 id="modal-product-title" class="text-stone-900 text-sm font-bold truncate"></h3>
                            <p class="mt-0.5 flex items-center gap-2 flex-wrap">
                                <span id="modal-product-price" class="text-stone-900 font-bold"></span>
                                <span id="modal-product-original" class="text-stone-400 line-through text-sm"></span>
                                <span id="modal-product-discount" class="text-green-600 text-xs font-semibold"></span>
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-stone-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
        </div>
    </div>
    </div>
</div>

{{-- Share Popup --}}
<div id="share-popup" class="fixed inset-0 z-[300] hidden items-center justify-center" style="display:none;">
    <div class="absolute inset-0 bg-black/60" onclick="closeSharePopup()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[300px] p-6 z-[310]" onclick="event.stopPropagation()">
        <button onclick="closeSharePopup()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <h3 class="text-lg font-bold text-stone-900 text-center mb-5">Share it on</h3>
        <div class="space-y-3 mb-5">
            <button onclick="shareToFacebook()" class="w-full flex items-center gap-3 px-4 py-3 rounded-full border border-stone-200 hover:bg-stone-50 transition text-sm font-medium text-stone-700">
                <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </button>
            <button onclick="shareToWhatsApp()" class="w-full flex items-center gap-3 px-4 py-3 rounded-full border border-stone-200 hover:bg-stone-50 transition text-sm font-medium text-stone-700">
                <svg class="w-5 h-5" fill="#25D366" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp
            </button>
            <button onclick="shareToPinterest()" class="w-full flex items-center gap-3 px-4 py-3 rounded-full border border-stone-200 hover:bg-stone-50 transition text-sm font-medium text-stone-700">
                <svg class="w-5 h-5" fill="#E60023" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641 0 12.017 0z"/></svg>
                Pinterest
            </button>
        </div>
        <div class="relative flex items-center gap-4 mb-5">
            <div class="flex-1 h-px bg-stone-200"></div>
            <span class="text-xs text-stone-400 font-medium">OR</span>
            <div class="flex-1 h-px bg-stone-200"></div>
        </div>
        <button onclick="copyShareLink()" class="w-full py-3 bg-stone-900 text-white rounded-full text-sm font-semibold hover:bg-stone-800 transition text-center">Copy Link</button>
    </div>
</div>

<script>
    var videoScrollAmount = 0;
    var currentModalProduct = null;

    function scrollVideoCards(direction) {
        var track = document.getElementById('video-track');
        if (!track) return;
        var cardWidth = window.innerWidth < 768 ? 196 : 236;
        var maxScroll = track.scrollWidth - track.parentElement.offsetWidth;
        if (direction === 'right') {
            videoScrollAmount = Math.min(maxScroll, videoScrollAmount + cardWidth);
        } else {
            videoScrollAmount = Math.max(0, videoScrollAmount - cardWidth);
        }
        track.style.transform = 'translateX(-' + videoScrollAmount + 'px)';
    }

    function openVideoModal(id, title, brand, price, discountPrice, discountPercent, videoUrl, imageUrl, productUrl) {
        currentModalProduct = { id: id, title: title, brand: brand, price: price, discountPrice: discountPrice, discountPercent: discountPercent, videoUrl: videoUrl, imageUrl: imageUrl, productUrl: productUrl };

        var modal = document.getElementById('video-modal');
        var video = document.getElementById('modal-video');
        var thumb = document.getElementById('modal-product-thumb');
        var titleEl = document.getElementById('modal-product-title');
        var priceEl = document.getElementById('modal-product-price');
        var originalEl = document.getElementById('modal-product-original');
        var discountEl = document.getElementById('modal-product-discount');
        var linkEl = document.getElementById('modal-product-link');

        video.src = videoUrl;
        video.poster = imageUrl;
        thumb.src = imageUrl;
        thumb.alt = title;
        titleEl.textContent = title;
        priceEl.textContent = 'PKR ' + new Intl.NumberFormat('en-PK').format(discountPrice || price);

        if (discountPrice && discountPrice < price) {
            originalEl.textContent = 'PKR ' + new Intl.NumberFormat('en-PK').format(price);
            originalEl.style.display = 'inline';
            discountEl.textContent = discountPercent ? '-' + discountPercent + '%' : '';
            discountEl.style.display = 'inline';
        } else {
            originalEl.style.display = 'none';
            discountEl.style.display = 'none';
        }

        linkEl.href = productUrl;
        modal.style.display = 'block';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        var overlay = document.getElementById('modal-play-overlay');
        overlay.style.display = 'flex';

        video.onplay = function() { overlay.style.display = 'none'; };
        video.onpause = function() { overlay.style.display = 'flex'; };

        video.play().catch(function() {});
    }

    function closeVideoModal() {
        var modal = document.getElementById('video-modal');
        var video = document.getElementById('modal-video');
        var overlay = document.getElementById('modal-play-overlay');
        video.pause();
        video.src = '';
        overlay.style.display = 'none';
        modal.style.display = 'none';
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        closeSharePopup();
    }

    function toggleModalPlay() {
        var video = document.getElementById('modal-video');
        var overlay = document.getElementById('modal-play-overlay');
        if (video.paused) {
            video.play();
        } else {
            video.pause();
            overlay.style.display = 'flex';
        }
    }

    function toggleModalMute() {
        var video = document.getElementById('modal-video');
        var icon = document.getElementById('modal-mute-icon');
        video.muted = !video.muted;
        if (video.muted) {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>';
        } else {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657A8 8 0 0017.657 7.343"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.657 13.657A4 4 0 0014.657 10.343"/>';
        }
    }

    function openSharePopup() {
        if (!currentModalProduct) return;
        document.getElementById('share-popup').style.display = 'flex';
        document.getElementById('share-popup').classList.remove('hidden');
    }

    function closeSharePopup() {
        document.getElementById('share-popup').style.display = 'none';
        document.getElementById('share-popup').classList.add('hidden');
    }

    function shareToFacebook() {
        if (!currentModalProduct) return;
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(currentModalProduct.productUrl), '_blank', 'width=600,height=400');
    }

    function shareToWhatsApp() {
        if (!currentModalProduct) return;
        window.open('https://wa.me/?text=' + encodeURIComponent('Check out ' + currentModalProduct.title + ' at HUME WEAR ' + currentModalProduct.productUrl), '_blank');
    }

    function shareToPinterest() {
        if (!currentModalProduct) return;
        window.open('https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(currentModalProduct.productUrl) + '&media=' + encodeURIComponent(currentModalProduct.imageUrl) + '&description=' + encodeURIComponent(currentModalProduct.title), '_blank', 'width=600,height=400');
    }

    function copyShareLink() {
        if (!currentModalProduct) return;
        navigator.clipboard.writeText(currentModalProduct.productUrl).then(function() {
            var btn = document.querySelector('#share-popup button:last-child');
            if (btn) {
                var original = btn.textContent;
                btn.textContent = 'Copied!';
                setTimeout(function() { btn.textContent = original; }, 2000);
            }
        });
    }
</script>
@endif

{{-- Newsletter --}}
<div class="bg-stone-100 py-20">
    <div class="max-w-xl mx-auto px-6 text-center">
        <p class="text-stone-400 text-sm tracking-[0.3em] uppercase mb-3">Stay Updated</p>
        <h2 class="text-2xl md:text-3xl font-bold text-stone-900 mb-4">Subscribe to Our Newsletter</h2>
        <p class="text-stone-500 mb-8">Be the first to know about new collections and exclusive offers.</p>
        <form action="{{ route('newsletter.store') }}" method="POST" class="flex gap-0">
            @csrf
            <input type="email" name="email" required placeholder="Enter your email" class="flex-1 px-5 py-3 border border-stone-300 border-r-0 focus:outline-none focus:border-stone-500 text-sm bg-white">
            <button type="submit" class="btn-hover bg-stone-900 text-white px-8 py-3 hover:bg-stone-800 transition text-sm uppercase tracking-wider font-medium">Subscribe</button>
        </form>
    </div>
</div>

{{-- Newsletter Success Popup --}}
@if(session('newsletter_success'))
<div id="newsletter-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none; opacity:0; transition: opacity 0.3s ease;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeNewsletterPopup()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-center" style="transform: scale(0.95) translateY(10px); transition: transform 0.3s ease;">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-stone-900 mb-2">You're Subscribed!</h3>
        <p class="text-stone-500 text-sm mb-6">{{ session('newsletter_success') }}</p>
        <button onclick="closeNewsletterPopup()" class="btn-hover bg-stone-900 text-white px-8 py-3 rounded-xl hover:bg-stone-800 transition text-sm font-semibold tracking-wide">
            Done
        </button>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    // Hero Carousel
    const slides = @json($heroSlides);

    let currentSlide = 0;
    let slideInterval;

    function goToSlide(index) {
        document.getElementById('slide-' + currentSlide).classList.remove('active');
        document.querySelectorAll('.carousel-dot')[currentSlide].classList.remove('active');

        currentSlide = index;

        document.getElementById('slide-' + currentSlide).classList.add('active');
        document.querySelectorAll('.carousel-dot')[currentSlide].classList.add('active');

        document.getElementById('hero-title').textContent = slides[currentSlide].title;
        document.getElementById('hero-subtitle').textContent = slides[currentSlide].subtitle;

        resetInterval();
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % slides.length);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }

    resetInterval();

    // Category Scroll
    var categoryScrollAmount = 0;

    function scrollCategories(direction) {
        var container = document.getElementById('category-container');
        var track = document.getElementById('category-track');

        if (!container || !track) return;

        var containerWidth = container.offsetWidth;
        var trackWidth = track.scrollWidth;
        var scrollStep = 300;
        var maxScroll = trackWidth - containerWidth;

        if (maxScroll <= 0) return;

        if (direction === 'right') {
            categoryScrollAmount = Math.min(maxScroll, categoryScrollAmount + scrollStep);
        } else {
            categoryScrollAmount = Math.max(0, categoryScrollAmount - scrollStep);
        }

        track.style.transform = 'translateX(-' + categoryScrollAmount + 'px)';
    }

    // Newsletter popup
    var newsletterPopup = document.getElementById('newsletter-popup');
    if (newsletterPopup) {
        setTimeout(function() {
            newsletterPopup.style.display = 'flex';
            setTimeout(function() {
                newsletterPopup.style.opacity = '1';
                newsletterPopup.querySelector('.relative').style.transform = 'scale(1) translateY(0)';
            }, 10);
        }, 500);
    }

    function closeNewsletterPopup() {
        if (newsletterPopup) {
            newsletterPopup.style.opacity = '0';
            newsletterPopup.querySelector('.relative').style.transform = 'scale(0.95) translateY(10px)';
            setTimeout(function() { newsletterPopup.style.display = 'none'; }, 300);
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }

    function openVideoModalFromCard(el) {
        var d = el.dataset;
        openVideoModal(
            d.id,
            d.title,
            d.brand,
            parseFloat(d.price),
            d.discountPrice ? parseFloat(d.discountPrice) : null,
            d.discountPercent ? parseFloat(d.discountPercent) : null,
            d.video,
            d.image,
            d.url
        );
    }

</script>
@endsection
