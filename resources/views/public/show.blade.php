@extends('layouts.app')

@section('title', $product->title . ' - Hume Wear')

@section('content')
@php
    $allImages = is_array($product->images) ? $product->images : [];
    $mainImage = $product->primary_image
        ? asset('storage/' . $product->primary_image)
        : ($product->image
            ? asset('storage/' . $product->image)
            : 'https://placehold.co/600x750/f5f0eb/1c1917?text=' . urlencode($product->title));

    $allImageUrls = [];
    if($product->primary_image) $allImageUrls[] = asset('storage/' . $product->primary_image);
    foreach($allImages as $img) {
        $url = asset('storage/' . $img);
        if(!in_array($url, $allImageUrls)) $allImageUrls[] = $url;
    }
    if($product->image && !in_array(asset('storage/' . $product->image), $allImageUrls)) {
        $allImageUrls[] = asset('storage/' . $product->image);
    }

    $sizes = $product->size ? array_map('trim', explode(',', $product->size)) : [];

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

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 py-6">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs text-stone-400 mb-6">
        <a href="{{ url('/') }}" class="hover:text-stone-900 transition">Home</a>
        <span>›</span>
        @if($product->category)
            <a href="{{ url('/products?category=' . urlencode($product->category)) }}" class="hover:text-stone-900 transition">{{ $product->category }}</a>
            <span>›</span>
        @endif
        <span class="text-stone-700 truncate max-w-[200px]">{{ $product->title }}</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-12 items-start">
        {{-- Left: Image Gallery --}}
        <div class="w-full lg:w-1/2 lg:sticky lg:top-28">
            {{-- Main Image Container with fixed 3:4 aspect ratio --}}
            <div id="image-container" class="relative group w-full overflow-hidden bg-[#f5f0eb] rounded-sm" style="height:0;padding-bottom:133.33%">
                <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $product->title }}" class="absolute inset-0 w-full h-full object-cover transition duration-500">

                @if($discountPercent)
                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 bg-red-600 text-white text-xs font-bold px-2.5 py-1 sm:px-3 sm:py-1.5 uppercase tracking-wider rounded-sm z-10">
                    -{{ $discountPercent }}%
                </div>
                @endif

                @if(count($allImageUrls) > 1)
                <button onclick="prevImage()" class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100 z-10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="nextImage()" class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100 z-10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endif

                {{-- Dot indicators for mobile --}}
                @if(count($allImageUrls) > 1)
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-10 sm:hidden">
                    @foreach($allImageUrls as $index => $img)
                    <button onclick="changeImage(this, '{{ $img }}', {{ $index }})" class="dot-indicator w-2 h-2 rounded-full {{ $index === 0 ? 'bg-stone-900' : 'bg-stone-300' }} transition"></button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if(count($allImageUrls) > 1)
            <div class="flex gap-2 mt-3 overflow-x-auto hide-scrollbar">
                @foreach($allImageUrls as $index => $img)
                <button
                    onclick="changeImage(this, '{{ $img }}', {{ $index }})"
                    data-index="{{ $index }}"
                    class="thumb-btn flex-shrink-0 w-[60px] sm:w-[72px] h-[75px] sm:h-[90px] bg-[#f5f0eb] overflow-hidden border-2 {{ $index === 0 ? 'border-stone-900' : 'border-transparent' }} hover:border-stone-400 transition rounded-sm">
                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Right: Product Details --}}
        <div class="w-full lg:w-1/2 flex flex-col">
            {{-- Brand + SKU --}}
            <div class="flex items-start justify-between mb-2">
                <div>
                    @if($product->brand)
                        <p class="text-xs text-stone-400 uppercase tracking-[0.2em] font-medium">{{ $product->brand }}</p>
                    @endif
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-stone-900 mt-1 leading-tight">{{ $product->title }}</h1>
                </div>
                <button onclick="toggleWishlist(this)" class="flex-shrink-0 w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center hover:border-stone-400 transition mt-1">
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </div>

            <p class="text-xs text-stone-400 uppercase tracking-wider mb-5">SKU: MB-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</p>

            {{-- Price --}}
            <div class="flex items-center gap-3 mb-6">
                @if($discountPrice !== null)
                    <span class="text-2xl sm:text-3xl font-bold text-stone-900">Rs.{{ number_format($discountPrice, 0) }}</span>
                    <span class="text-lg text-stone-400 line-through">Rs.{{ number_format($product->price, 0) }}</span>
                @else
                    <span class="text-2xl sm:text-3xl font-bold text-stone-900">Rs.{{ number_format($product->price, 0) }}</span>
                @endif
            </div>

            {{-- Size Selector --}}
            @if(count($sizes) > 0)
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-semibold text-stone-800 uppercase tracking-wider">Size</label>
                    <span class="text-xs text-stone-400 cursor-pointer hover:text-stone-900 transition">Size Guide</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($sizes as $sizeOption)
                    <button
                        onclick="selectSize(this, '{{ $sizeOption }}')"
                        class="size-option px-5 py-2.5 border border-stone-300 rounded text-sm font-medium text-stone-600 hover:border-stone-900 hover:text-stone-900 transition">
                        {{ $sizeOption }}
                    </button>
                    @endforeach
                </div>
                <input type="hidden" id="selected-size" value="">
            </div>
            @endif

            {{-- CTA Buttons --}}
            <div class="space-y-3 mb-6">
                <a href="https://wa.me/?text={{ urlencode('I am interested in ' . $product->title . ' - Rs.' . number_format($discountPrice ?? $product->price, 0)) }}" target="_blank"
                   class="flex items-center justify-center gap-3 w-full bg-stone-900 text-white px-8 py-4 text-sm uppercase tracking-[0.2em] font-bold hover:bg-stone-800 transition rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Add to Cart
                </a>
                <a href="https://wa.me/923324122262?text={{ urlencode('Hi, I would like to know more about ' . $product->title) }}" target="_blank"
                   class="flex items-center justify-center gap-3 w-full border border-stone-300 text-stone-700 px-8 py-3.5 text-sm uppercase tracking-[0.2em] font-medium hover:bg-stone-50 transition rounded">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Chat with a fashion consultant
                </a>
            </div>

            {{-- Info Links --}}
            <div class="border-t border-stone-200 pt-4 space-y-2 mb-8">
                <p class="text-sm text-stone-500">Delivery & Returns <a href="#" class="text-stone-900 underline font-medium">Click Here.</a></p>
                <p class="text-sm text-stone-500">Terms and Conditions <a href="#" class="text-stone-900 underline font-medium">Click Here.</a></p>
            </div>

            {{-- Accordion Sections --}}
            <div class="border-t border-stone-200">
                {{-- Description --}}
                <div class="border-b border-stone-200">
                    <button onclick="toggleAccordion('desc')" class="w-full flex items-center justify-between py-4 text-left">
                        <span class="text-sm font-bold text-stone-900 uppercase tracking-wider">Description</span>
                        <svg id="desc-icon" class="w-4 h-4 text-stone-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="desc-content" class="hidden pb-6">
                        <p class="text-sm text-stone-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>

                {{-- Product Care --}}
                <div class="border-b border-stone-200">
                    <button onclick="toggleAccordion('care')" class="w-full flex items-center justify-between py-4 text-left">
                        <span class="text-sm font-bold text-stone-900 uppercase tracking-wider">Product Care</span>
                        <svg id="care-icon" class="w-4 h-4 text-stone-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="care-content" class="hidden pb-6 space-y-3">
                        <div>
                            <p class="text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Fabric</p>
                            <p class="text-sm text-stone-600">Premium quality fabric. Handle with care while cleaning.</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Care Instructions</p>
                            <ul class="text-sm text-stone-600 space-y-1 list-disc list-inside">
                                <li>Don't wash, dry clean only</li>
                                <li>Can be ironed on low heat</li>
                                <li>Don't use too much bleach</li>
                                <li>Store in garment bag</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Terms --}}
                <div>
                    <button onclick="toggleAccordion('terms')" class="w-full flex items-center justify-between py-4 text-left">
                        <span class="text-sm font-bold text-stone-900 uppercase tracking-wider">Terms & Conditions</span>
                        <svg id="terms-icon" class="w-4 h-4 text-stone-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="terms-content" class="hidden pb-6">
                        <ul class="text-sm text-stone-600 space-y-1.5 list-disc list-inside">
                            <li>All orders are made to order.</li>
                            <li>Making time is approximately 7-14 business days.</li>
                            <li>International shipping charges apply based on weight and destination.</li>
                            <li>For orders please contact: orders@humbewear.com</li>
                            <li>50% deposit required for in-store orders.</li>
                            <li>No cancellations once order is placed.</li>
                            <li>No refund or exchange policy applies.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const images = {!! json_encode($allImageUrls) !!};
    let currentIndex = 0;
    let selectedSize = '';

    function changeImage(el, src, index) {
        const mainImg = document.getElementById('main-product-image');
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 150);
        currentIndex = index;
        updateThumbs();
    }

    function updateThumbs() {
        document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
            btn.classList.remove('border-stone-900', 'border-transparent');
            btn.classList.add(i === currentIndex ? 'border-stone-900' : 'border-transparent');
        });
        document.querySelectorAll('.dot-indicator').forEach((dot, i) => {
            dot.classList.remove('bg-stone-900', 'bg-stone-300');
            dot.classList.add(i === currentIndex ? 'bg-stone-900' : 'bg-stone-300');
        });
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        changeImage(null, images[currentIndex], currentIndex);
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        changeImage(null, images[currentIndex], currentIndex);
    }

    function selectSize(el, size) {
        document.querySelectorAll('.size-option').forEach(btn => {
            btn.classList.remove('bg-stone-900', 'text-white', 'border-stone-900');
            btn.classList.add('border-stone-300', 'text-stone-600');
        });
        el.classList.remove('border-stone-300', 'text-stone-600');
        el.classList.add('bg-stone-900', 'text-white', 'border-stone-900');
        document.getElementById('selected-size').value = size;
        selectedSize = size;
    }

    function toggleWishlist(el) {
        const svg = el.querySelector('svg');
        const isFilled = svg.getAttribute('fill') === 'currentColor';
        if (isFilled) {
            svg.setAttribute('fill', 'none');
            el.classList.remove('bg-red-50', 'border-red-200');
            el.classList.add('border-stone-200');
        } else {
            svg.setAttribute('fill', 'currentColor');
            svg.classList.add('text-red-500');
            el.classList.add('bg-red-50', 'border-red-200');
            el.classList.remove('border-stone-200');
        }
    }

    function toggleAccordion(id) {
        const content = document.getElementById(id + '-content');
        const icon = document.getElementById(id + '-icon');
        const isHidden = content.classList.contains('hidden');
        content.classList.toggle('hidden');
        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    // Enforce fixed aspect ratio on image container
    (function fixImageHeight() {
        const container = document.getElementById('image-container');
        if (!container) return;
        const setHeight = () => {
            const w = container.offsetWidth;
            container.style.height = (w * 4 / 3) + 'px';
            container.style.paddingBottom = '0';
        };
        setHeight();
        if (window.ResizeObserver) {
            new ResizeObserver(setHeight).observe(container);
        } else {
            window.addEventListener('resize', setHeight);
        }
    })();

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    });
</script>
@endsection
