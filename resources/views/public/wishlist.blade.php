@extends('layouts.app')

@section('title', 'Wishlist - Hume Wear')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 pt-32 pb-12">
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-stone-900">My Wishlist</h1>
        <p class="text-stone-500 mt-2" id="wishlist-count"></p>
    </div>

    <div id="wishlist-loading" class="text-center py-20">
        <div class="inline-block w-8 h-8 border-2 border-stone-200 border-t-stone-900 rounded-full animate-spin"></div>
        <p class="text-sm text-stone-400 mt-3">Loading your wishlist...</p>
    </div>

    <div id="wishlist-empty" class="text-center py-20 hidden">
        <svg class="w-16 h-16 text-stone-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        <h2 class="text-xl font-bold text-stone-900">Your wishlist is empty</h2>
        <p class="text-stone-500 mt-2 mb-6">Save your favourite items to revisit them later.</p>
        <a href="{{ url('/products') }}" class="btn-hover inline-block bg-stone-900 hover:bg-stone-800 text-white px-8 py-3 rounded-xl text-sm font-semibold tracking-wide transition">
            Start Shopping
        </a>
    </div>

    <div id="wishlist-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 hidden">
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

    var ids = JSON.parse(localStorage.getItem('hw_wishlist') || '[]');
    var loading = document.getElementById('wishlist-loading');
    var empty = document.getElementById('wishlist-empty');
    var grid = document.getElementById('wishlist-grid');
    var countEl = document.getElementById('wishlist-count');

    if (ids.length === 0) {
        loading.classList.add('hidden');
        empty.classList.remove('hidden');
        countEl.textContent = '0 items';
        return;
    }

    fetch('{{ route("wishlist.products") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ ids: ids })
    })
    .then(function(res) { return res.json(); })
    .then(function(products) {
        loading.classList.add('hidden');
        countEl.textContent = products.length + ' item' + (products.length !== 1 ? 's' : '');

        if (products.length === 0) {
            empty.classList.remove('hidden');
            return;
        }

        grid.classList.remove('hidden');
        var html = '';
        products.forEach(function(p) {
            var priceHtml = '';
            if (p.discount_price !== null) {
                priceHtml = '<p class="text-stone-500 text-sm mt-1"><span class="text-red-600 font-semibold">PKR ' + Number(Math.round(p.discount_price)).toLocaleString() + '</span> <span class="line-through ml-1">PKR ' + Number(p.price).toLocaleString() + '</span></p>';
            } else {
                priceHtml = '<p class="text-stone-500 text-sm mt-1">PKR ' + Number(p.price).toLocaleString() + '</p>';
            }
            html += '<div class="group relative" data-product-id="' + p.id + '">' +
                '<a href="' + p.url + '">' +
                    '<div class="aspect-[3/4] bg-[#f5f0eb] overflow-hidden rounded-xl relative">' +
                        '<img src="' + p.image + '" alt="' + p.title + '" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">' +
                        (p.discount_percent ? '<div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-600 text-white text-xs font-bold px-2 py-0.5 sm:px-2.5 sm:py-1 uppercase tracking-wider rounded-sm z-10">-' + p.discount_percent + '%</div>' : '') +
                    '</div>' +
                '</a>' +
                '<button onclick="removeFromWishlist(' + p.id + ')" class="btn-hover absolute top-2 right-2 sm:top-3 sm:right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm text-red-500 hover:bg-red-50 transition z-10">' +
                    '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>' +
                '</button>' +
                '<div class="mt-3">' +
                    '<h3 class="text-sm text-stone-800 leading-snug">' + p.title + '</h3>' +
                    priceHtml +
                '</div>' +
            '</div>';
        });
        grid.innerHTML = html;
    })
    .catch(function() {
        loading.classList.add('hidden');
        empty.classList.remove('hidden');
    });
})();

function removeFromWishlist(productId) {
    var ids = JSON.parse(localStorage.getItem('hw_wishlist') || '[]');
    ids = ids.filter(function(id) { return id !== productId; });
    localStorage.setItem('hw_wishlist', JSON.stringify(ids));

    var card = document.querySelector('[data-product-id="' + productId + '"]');
    if (card) {
        card.style.transition = 'opacity 0.3s, transform 0.3s';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';
        setTimeout(function() {
            card.remove();
            var grid = document.getElementById('wishlist-grid');
            var countEl = document.getElementById('wishlist-count');
            var remaining = grid.children.length;
            countEl.textContent = remaining + ' item' + (remaining !== 1 ? 's' : '');
            if (remaining === 0) {
                grid.classList.add('hidden');
                document.getElementById('wishlist-empty').classList.remove('hidden');
            }
        }, 300);
    }
}
</script>
@endsection
