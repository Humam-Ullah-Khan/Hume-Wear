@extends('layouts.app')

@section('title', $product->title . ' - Humam Élite')

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

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 pt-32 pb-6">
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
                <button onclick="prevImage()" class="btn-hover absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100 z-10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="nextImage()" class="btn-hover absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100 z-10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endif

                {{-- Dot indicators for mobile --}}
                @if(count($allImageUrls) > 1)
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-10 sm:hidden">
                    @foreach($allImageUrls as $index => $img)
                    <button onclick="changeImage(this, '{{ $img }}', {{ $index }})" class="dot-indicator btn-hover w-2 h-2 rounded-full {{ $index === 0 ? 'bg-stone-900' : 'bg-stone-300' }} transition"></button>
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
                    class="thumb-btn btn-hover flex-shrink-0 w-[60px] sm:w-[72px] h-[75px] sm:h-[90px] bg-[#f5f0eb] overflow-hidden border-2 {{ $index === 0 ? 'border-stone-900' : 'border-transparent' }} hover:border-stone-400 transition rounded-sm">
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
                <button onclick="toggleWishlist(this, {{ $product->id }})" data-product-id="{{ $product->id }}" class="btn-hover flex-shrink-0 w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center hover:border-stone-400 transition mt-1">
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </div>

            <p class="text-xs text-stone-400 uppercase tracking-wider mb-5">SKU: {{ $product->unique_code ?? 'HW-' . str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</p>

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
                    <span class="text-xs text-stone-400 cursor-pointer hover:text-stone-900 btn-hover transition" onclick="showSizeGuide()">Size Guide</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($sizes as $sizeOption)
                    <button
                        onclick="selectSize(this, '{{ $sizeOption }}')"
                        class="size-option btn-hover px-5 py-2.5 border border-stone-300 rounded text-sm font-medium text-stone-600 hover:border-stone-900 hover:text-stone-900 transition">
                        {{ $sizeOption }}
                    </button>
                    @endforeach
                </div>
                <input type="hidden" id="selected-size" value="">
            </div>
            @endif

            {{-- CTA Buttons --}}
            <div class="space-y-3 mb-6">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp']) }}?text={{ urlencode('Hi, I am interested in ' . $product->title . ' - Rs.' . number_format($discountPrice ?? $product->price, 0) . '. I would like to place an order.') }}" target="_blank"
                   class="btn-hover flex items-center justify-center gap-3 w-full bg-stone-900 text-white px-8 py-4 text-sm uppercase tracking-[0.2em] font-bold hover:bg-stone-800 transition rounded">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Order On Whatsapp
                </a>
            </div>

            {{-- Info Links --}}
            <div class="border-t border-stone-200 pt-4 space-y-2 mb-8">
                <p class="text-sm text-stone-500">Delivery & Returns <a href="#" onclick="event.preventDefault(); showDeliveryInfo()" class="text-stone-900 underline font-medium">Click Here.</a></p>
                <p class="text-sm text-stone-500">Terms and Conditions <a href="#" onclick="event.preventDefault(); showTermsInfo()" class="text-stone-900 underline font-medium">Click Here.</a></p>
            </div>

            {{-- Accordion Sections --}}
            <div class="border-t border-stone-200">
                {{-- Description --}}
                <div class="border-b border-stone-200">
                    <button onclick="toggleAccordion('desc')" class="w-full flex items-center justify-between py-4 text-left">
                        <span class="text-sm font-bold text-stone-900 uppercase tracking-wider">Description</span>
                        <svg id="desc-icon" class="w-4 h-4 text-stone-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content" id="desc-content">
                        <div class="pb-6">
                            <p class="text-sm text-stone-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>

                {{-- Product Care --}}
                <div class="border-b border-stone-200">
                    <button onclick="toggleAccordion('care')" class="w-full flex items-center justify-between py-4 text-left">
                        <span class="text-sm font-bold text-stone-900 uppercase tracking-wider">Product Care</span>
                        <svg id="care-icon" class="w-4 h-4 text-stone-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content" id="care-content">
                        <div class="pb-6 space-y-3">
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
                    <div class="accordion-content" id="terms-content">
                        <div class="pb-6">
                            <ul class="text-sm text-stone-600 space-y-1.5 list-disc list-inside">
                                <li>All our products are made to order to ensure the highest quality.</li>
                                <li>To place an order, please contact us at +92 323 1256645.</li>
                                <li>A 50% advance payment is required to confirm your order and begin processing.</li>
                            </ul>
            </div>

            {{-- Product Video --}}
            @if($product->video)
            <div class="mt-8">
                <h3 class="text-sm font-bold text-stone-900 uppercase tracking-wider mb-4">Product Video</h3>
                <div class="aspect-video bg-stone-100 rounded-xl overflow-hidden">
                    <video class="w-full h-full object-cover" controls playsinline>
                        <source src="{{ asset('storage/' . $product->video) }}" type="video/mp4">
                    </video>
                </div>
            </div>
            @endif
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

    function getWishlist() {
        try { return JSON.parse(localStorage.getItem('hw_wishlist') || '[]'); }
        catch(e) { return []; }
    }
    function saveWishlist(ids) {
        localStorage.setItem('hw_wishlist', JSON.stringify(ids));
    }
    function markWishlistButton(el, filled) {
        const svg = el.querySelector('svg');
        if (filled) {
            svg.setAttribute('fill', 'currentColor');
            svg.classList.add('text-red-500');
            el.classList.add('bg-red-50', 'border-red-200');
            el.classList.remove('border-stone-200');
        } else {
            svg.setAttribute('fill', 'none');
            svg.classList.remove('text-red-500');
            el.classList.remove('bg-red-50', 'border-red-200');
            el.classList.add('border-stone-200');
        }
    }
    function toggleWishlist(el, productId) {
        var ids = getWishlist();
        var index = ids.indexOf(productId);
        if (index > -1) {
            ids.splice(index, 1);
            markWishlistButton(el, false);
        } else {
            ids.push(productId);
            markWishlistButton(el, true);
        }
        saveWishlist(ids);
        if (typeof updateWishlistCount === 'function') updateWishlistCount();
    }
    (function() {
        var btn = document.querySelector('[data-product-id]');
        if (btn) {
            var pid = parseInt(btn.dataset.productId);
            var ids = getWishlist();
            if (ids.indexOf(pid) > -1) markWishlistButton(btn, true);
        }
    })();

    function toggleAccordion(id) {
        const content = document.getElementById(id + '-content');
        const icon = document.getElementById(id + '-icon');
        const isOpen = content.classList.contains('open');
        if (isOpen) {
            content.classList.remove('open');
            content.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            content.classList.add('open');
            icon.style.transform = 'rotate(180deg)';
        }
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

    // Force navbar to scrolled state (no dark hero on this page)
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

{{-- Size Guide Popup --}}
<div id="size-guide-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none; opacity:0; transition: opacity 0.3s ease;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePopup('size-guide-popup')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8" style="transform: scale(0.95) translateY(10px); transition: transform 0.3s ease;">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-stone-900">Size Guide</h3>
            <button onclick="closePopup('size-guide-popup')" class="text-stone-400 hover:text-stone-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-200">
                        <th class="text-left py-3 px-4 font-semibold text-stone-700">Size</th>
                        <th class="text-left py-3 px-4 font-semibold text-stone-700">Chest (inches)</th>
                        <th class="text-left py-3 px-4 font-semibold text-stone-700">Waist (inches)</th>
                        <th class="text-left py-3 px-4 font-semibold text-stone-700">Length (inches)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    <tr><td class="py-3 px-4 font-medium text-stone-800">XS</td><td class="py-3 px-4 text-stone-600">34-36</td><td class="py-3 px-4 text-stone-600">28-30</td><td class="py-3 px-4 text-stone-600">26</td></tr>
                    <tr><td class="py-3 px-4 font-medium text-stone-800">S</td><td class="py-3 px-4 text-stone-600">36-38</td><td class="py-3 px-4 text-stone-600">30-32</td><td class="py-3 px-4 text-stone-600">27</td></tr>
                    <tr><td class="py-3 px-4 font-medium text-stone-800">M</td><td class="py-3 px-4 text-stone-600">38-40</td><td class="py-3 px-4 text-stone-600">32-34</td><td class="py-3 px-4 text-stone-600">28</td></tr>
                    <tr><td class="py-3 px-4 font-medium text-stone-800">L</td><td class="py-3 px-4 text-stone-600">40-42</td><td class="py-3 px-4 text-stone-600">34-36</td><td class="py-3 px-4 text-stone-600">29</td></tr>
                    <tr><td class="py-3 px-4 font-medium text-stone-800">XL</td><td class="py-3 px-4 text-stone-600">42-44</td><td class="py-3 px-4 text-stone-600">36-38</td><td class="py-3 px-4 text-stone-600">30</td></tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-stone-400 mt-4 text-center">All measurements are approximate. For a perfect fit, contact us on WhatsApp.</p>
    </div>
</div>

{{-- Delivery & Returns Popup --}}
<div id="delivery-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none; opacity:0; transition: opacity 0.3s ease;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePopup('delivery-popup')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8" style="transform: scale(0.95) translateY(10px); transition: transform 0.3s ease;">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-stone-900">Delivery & Returns</h3>
            <button onclick="closePopup('delivery-popup')" class="text-stone-400 hover:text-stone-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-5 text-sm text-stone-600">
            <div>
                <h4 class="font-semibold text-stone-800 mb-1">Delivery</h4>
                <ul class="space-y-1 list-disc list-inside">
                    <li>All orders are made to order with a making time of 7-14 business days.</li>
                    <li>Once dispatched, delivery within Pakistan takes 3-5 business days.</li>
                    <li>International shipping charges apply based on weight and destination.</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-stone-800 mb-1">Returns & Exchanges</h4>
                <ul class="space-y-1 list-disc list-inside">
                    <li>No refund or exchange policy applies.</li>
                    <li>If your order arrives damaged or incorrect, contact us within 24 hours.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Terms & Conditions Popup --}}
<div id="terms-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none; opacity:0; transition: opacity 0.3s ease;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePopup('terms-popup')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8" style="transform: scale(0.95) translateY(10px); transition: transform 0.3s ease;">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-stone-900">Terms & Conditions</h3>
            <button onclick="closePopup('terms-popup')" class="text-stone-400 hover:text-stone-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <ul class="space-y-3 text-sm text-stone-600 list-disc list-inside">
            <li>All our products are made to order to ensure the highest quality.</li>
            <li>To place an order, please contact us at +92 323 1256645.</li>
            <li>A 50% advance payment is required to confirm your order and begin processing.</li>
        </ul>
    </div>
</div>

<script>
    function openPopup(id) {
        var popup = document.getElementById(id);
        if (popup) {
            popup.style.display = 'flex';
            setTimeout(function() {
                popup.style.opacity = '1';
                popup.querySelector('.relative').style.transform = 'scale(1) translateY(0)';
            }, 10);
        }
    }

    function closePopup(id) {
        var popup = document.getElementById(id);
        if (popup) {
            popup.style.opacity = '0';
            popup.querySelector('.relative').style.transform = 'scale(0.95) translateY(10px)';
            setTimeout(function() { popup.style.display = 'none'; }, 300);
        }
    }

    function showSizeGuide() { openPopup('size-guide-popup'); }
    function showDeliveryInfo() { openPopup('delivery-popup'); }
    function showTermsInfo() { openPopup('terms-popup'); }
</script>
@endsection
