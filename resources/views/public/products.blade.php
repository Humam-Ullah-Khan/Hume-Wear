@extends('layouts.app')

@section('title', 'Shop - Humam Élite')

@section('content')
<style>
    input[type="range"]::-webkit-slider-thumb { -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%; background: #1c1917; cursor: pointer; border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
    input[type="range"]::-moz-range-thumb { width: 18px; height: 18px; border-radius: 50%; background: #1c1917; cursor: pointer; border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
    .filter-group { max-height: 0; overflow: hidden; padding-top: 0; padding-bottom: 0; margin-bottom: 0; border: none; opacity: 0; transition: max-height 0.35s ease, opacity 0.3s ease, padding 0.3s ease, margin 0.3s ease; }
    .filter-group.open { max-height: 200px; opacity: 1; padding: 1.25rem; margin-bottom: 1rem; border: 1px solid #f5f5f4; }
</style>
<div class="max-w-[1400px] mx-auto px-6 pt-32 pb-12">

    {{-- Page Skeleton --}}
    <div id="page-skeleton">
        <div class="mb-8">
            <div class="skeleton skeleton-title" style="width:250px"></div>
            <div class="skeleton skeleton-text-sm mt-3" style="width:150px"></div>
        </div>
        <div class="flex gap-2 mb-8">
            @for($i = 0; $i < 3; $i++)
            <div class="skeleton skeleton-btn"></div>
            @endfor
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            @for($i = 0; $i < 10; $i++)
            <div>
                <div class="skeleton skeleton-img mb-3"></div>
                <div class="skeleton skeleton-text mb-2" style="width:85%"></div>
                <div class="skeleton skeleton-text-sm" style="width:45%"></div>
            </div>
            @endfor
        </div>
    </div>

    {{-- Real Content --}}
    <div id="page-content" style="display:none">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-stone-900">Our Collection</h1>
        <p class="text-stone-500 mt-2">{{ $products->count() }} {{ Str::plural('product', $products->count()) }} found</p>
    </div>

    {{-- Filters --}}
    <form id="filter-form" class="mb-10">
        {{-- Filter Buttons + Sort --}}
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <button type="button" onclick="toggleFilterGroup('price-group')" class="filter-toggle px-4 py-2 text-sm border border-stone-200 rounded-full hover:border-stone-400 transition flex items-center gap-1.5" id="btn-price">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Price
            </button>
            <button type="button" onclick="toggleFilterGroup('category-group')" class="filter-toggle px-4 py-2 text-sm border border-stone-200 rounded-full hover:border-stone-400 transition flex items-center gap-1.5" id="btn-category">
                Category
            </button>
            <button type="button" onclick="clearAllFilters()" id="clear-all-btn" class="hidden px-4 py-2 text-sm text-red-500 hover:text-red-700 transition font-medium ml-1">
                ✕ Clear All
            </button>

            <div class="ml-auto">
                <select name="sort" onchange="applyFilters()" class="px-4 py-2 text-sm border border-stone-200 rounded-lg bg-white text-stone-700 focus:outline-none focus:ring-2 focus:ring-stone-300 cursor-pointer">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="best_selling" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                </select>
            </div>
        </div>

        {{-- Price Panel --}}
        <div id="price-group" class="filter-group{{ request('max_price') ? ' open' : '' }}" data-group="price-group">
            <div class="flex items-center gap-4">
                <span class="text-xs text-stone-400">PKR 0</span>
                <input type="range" id="price-slider" min="0" max="{{ $maxPrice }}" value="{{ request('max_price', $maxPrice) }}" oninput="onPriceSlide(this.value)" class="flex-1 h-1.5 bg-stone-200 rounded-lg appearance-none cursor-pointer">
                <span id="price-label" class="text-sm text-stone-700 font-semibold whitespace-nowrap min-w-[120px] text-right">PKR {{ number_format(request('max_price', $maxPrice)) }}</span>
            </div>
            <input type="hidden" name="max_price" id="max_price_input" value="{{ request('max_price') }}">
        </div>

        {{-- Category Panel --}}
        @if($allCategories->count())
        <div id="category-group" class="filter-group{{ count(request('category', [])) ? ' open' : '' }}" data-group="category-group">
            <div class="flex flex-wrap gap-2">
                @foreach($allCategories as $cat)
                <button type="button" onclick="toggleChip(this, 'category', '{{ $cat }}')" class="filter-chip px-4 py-1.5 text-sm border rounded-full transition {{ in_array($cat, request('category', [])) ? 'bg-stone-900 text-white border-stone-900' : 'bg-white text-stone-600 border-stone-200 hover:border-stone-400' }}" data-group="category" data-value="{{ $cat }}">
                    {{ $cat }}
                </button>
                @endforeach
            </div>
        </div>
        @endif

    </form>

    {{-- Products Grid --}}
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
            <svg class="w-16 h-16 mx-auto mb-4 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <p class="text-xl">No products match your filters.</p>
            <p class="mt-2">Try adjusting or clearing your filters.</p>
            <button onclick="clearAllFilters()" class="mt-4 px-6 py-2.5 bg-stone-900 text-white text-sm rounded-full hover:bg-stone-800 transition">Clear All Filters</button>
        </div>
        @endforelse
    </div>
</div><!-- /page-content -->
</div>

<script>
    var activeFilters = {
        category: @json(request('category', []))
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Show active filter panels
        document.querySelectorAll('.filter-group').forEach(function(el) {
            if (el.classList.contains('open')) {
                var btnId = 'btn-' + el.id.replace('-group', '');
                var btn = document.getElementById(btnId);
                if (btn) { btn.classList.add('bg-stone-900', 'text-white', 'border-stone-900'); btn.classList.remove('text-stone-600', 'border-stone-200'); }
            }
        });
        if (document.getElementById('max_price_input').value) {
            document.getElementById('btn-price').classList.add('bg-stone-900', 'text-white', 'border-stone-900');
        }
        updateClearButton();
    });

    function toggleFilterGroup(id) {
        var el = document.getElementById(id);
        var btnId = 'btn-' + id.replace('-group', '');
        var btn = document.getElementById(btnId);
        var isOpen = el.classList.contains('open');

        // Close all other panels
        document.querySelectorAll('.filter-group').forEach(function(panel) {
            if (panel.id !== id) {
                panel.classList.remove('open');
                var otherBtnId = 'btn-' + panel.id.replace('-group', '');
                var otherBtn = document.getElementById(otherBtnId);
                if (otherBtn) { otherBtn.classList.remove('bg-stone-900', 'text-white', 'border-stone-900'); otherBtn.classList.add('text-stone-600', 'border-stone-200'); }
            }
        });

        if (isOpen) {
            el.classList.remove('open');
            if (btn) { btn.classList.remove('bg-stone-900', 'text-white', 'border-stone-900'); btn.classList.add('text-stone-600', 'border-stone-200'); }
        } else {
            el.classList.add('open');
            if (btn) { btn.classList.add('bg-stone-900', 'text-white', 'border-stone-900'); btn.classList.remove('text-stone-600', 'border-stone-200'); }
        }
    }

    function toggleChip(btn, group, value) {
        var isActive = btn.classList.contains('bg-stone-900');
        if (isActive) {
            btn.classList.remove('bg-stone-900', 'text-white', 'border-stone-900');
            btn.classList.add('bg-white', 'text-stone-600', 'border-stone-200');
            activeFilters[group] = activeFilters[group].filter(function(v) { return v !== value; });
        } else {
            btn.classList.add('bg-stone-900', 'text-white', 'border-stone-900');
            btn.classList.remove('bg-white', 'text-stone-600', 'border-stone-200');
            activeFilters[group].push(value);
        }
        applyFilters();
    }

    function onPriceSlide(val) {
        var max = {{ $maxPrice }};
        document.getElementById('price-label').textContent = 'PKR ' + Number(val).toLocaleString();
        document.getElementById('max_price_input').value = (parseInt(val) >= max) ? '' : val;
    }

    function applyFilters() {
        var params = new URLSearchParams();
        var maxPrice = document.getElementById('max_price_input').value;
        if (maxPrice) params.append('max_price', maxPrice);
        var sort = document.querySelector('select[name="sort"]').value;
        if (sort !== 'newest') params.append('sort', sort);
        Object.keys(activeFilters).forEach(function(group) {
            activeFilters[group].forEach(function(val) {
                params.append(group + '[]', val);
            });
        });
        var qs = params.toString();
        window.location.href = '{{ route("products.index") }}' + (qs ? '?' + qs : '');
    }

    function clearAllFilters() {
        window.location.href = '{{ route("products.index") }}';
    }

    function updateClearButton() {
        var hasFilters = Object.values(activeFilters).some(function(arr) { return arr.length > 0; });
        hasFilters = hasFilters || !!document.getElementById('max_price_input').value;
        document.getElementById('clear-all-btn').classList.toggle('hidden', !hasFilters);
    }

    // Force scrolled navbar on shop page
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
</div>

<script>
    window.addEventListener('load', function() {
        var skeleton = document.getElementById('page-skeleton');
        var content = document.getElementById('page-content');
        if (skeleton && content) {
            skeleton.style.transition = 'opacity 0.4s ease';
            skeleton.style.opacity = '0';
            setTimeout(function() {
                skeleton.style.display = 'none';
                content.style.display = 'block';
                content.style.opacity = '0';
                content.style.transition = 'opacity 0.5s ease';
                requestAnimationFrame(function() { content.style.opacity = '1'; });
            }, 300);
        }
    });
</script>
@endsection
