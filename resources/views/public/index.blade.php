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
            <button onclick="scrollCategories('left')" class="w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-400 hover:border-stone-400 hover:text-stone-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button onclick="scrollCategories('right')" class="w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-400 hover:border-stone-400 hover:text-stone-900 transition">
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
        <a href="{{ url('/products') }}" class="inline-block border border-stone-900 text-stone-900 px-10 py-3 hover:bg-stone-900 hover:text-white transition text-sm uppercase tracking-[0.2em] font-medium">View All</a>
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

                <a href="{{ route('products.show', $newArrival) }}" class="inline-block bg-stone-900 text-white px-10 py-3 hover:bg-stone-800 transition text-sm uppercase tracking-[0.2em] font-bold">Buy Now</a>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Banner --}}
<div class="relative h-[500px] overflow-hidden">
    <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&q=80" alt="Banner" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <div class="text-center">
            <p class="text-white/80 text-sm tracking-[0.3em] uppercase mb-4">Exclusive Collection</p>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 tracking-wider">TIMELESS ELEGANCE</h2>
            <a href="{{ url('/products') }}" class="inline-block border border-white text-white px-10 py-3 hover:bg-white hover:text-stone-950 transition text-sm uppercase tracking-[0.2em] font-medium">Explore Now</a>
        </div>
    </div>
</div>

{{-- Newsletter --}}
<div class="bg-stone-100 py-20">
    <div class="max-w-xl mx-auto px-6 text-center">
        <p class="text-stone-400 text-sm tracking-[0.3em] uppercase mb-3">Stay Updated</p>
        <h2 class="text-2xl md:text-3xl font-bold text-stone-900 mb-4">Subscribe to Our Newsletter</h2>
        <p class="text-stone-500 mb-8">Be the first to know about new collections and exclusive offers.</p>
        <form action="{{ route('newsletter.store') }}" method="POST" class="flex gap-0">
            @csrf
            <input type="email" name="email" required placeholder="Enter your email" class="flex-1 px-5 py-3 border border-stone-300 border-r-0 focus:outline-none focus:border-stone-500 text-sm bg-white">
            <button type="submit" class="bg-stone-900 text-white px-8 py-3 hover:bg-stone-800 transition text-sm uppercase tracking-wider font-medium">Subscribe</button>
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
        <button onclick="closeNewsletterPopup()" class="bg-stone-900 text-white px-8 py-3 rounded-xl hover:bg-stone-800 transition text-sm font-semibold tracking-wide">
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

</script>
@endsection
