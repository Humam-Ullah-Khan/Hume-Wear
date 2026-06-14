<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hume Wear - Fashion & Accessories')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'hago-demo';
            src: url('/fonts/hago-demo/Hago DEMO.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; font-weight: 400; background: #fafaf9; color: #1c1917; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; font-weight: 700; }
        .font-logo { font-family: 'hago-demo', sans-serif; text-transform: capitalize; }

        .hero-slide { position: absolute; inset: 0; opacity: 0; transition: opacity 1s ease-in-out; }
        .hero-slide.active { opacity: 1; }

        .carousel-dot { width: 40px; height: 3px; background: rgba(255,255,255,0.4); transition: all 0.3s; cursor: pointer; }
        .carousel-dot.active { background: #fff; width: 60px; }

        .hero-text { animation: fadeUp 1s ease-out 0.3s both; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Top Bar */
        .top-bar { transition: opacity 0.3s, max-height 0.3s, padding 0.3s; overflow: hidden; }
        .top-bar.hidden-bar { max-height: 0; padding-top: 0; padding-bottom: 0; opacity: 0; }

        /* Navbar */
        .navbar {
            position: fixed; left: 0; right: 0; z-index: 50;
            transition: background 0.3s, box-shadow 0.3s, top 0.3s;
        }
        .navbar.at-top { top: 36px; background: transparent; }
        .navbar.scrolled { top: 0; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

        /* Mobile Menu Panel */
        .menu-panel { transform: translateX(-100%); transition: transform 0.4s ease; }
        .menu-panel.open { transform: translateX(0); }
        .panel-overlay { opacity: 0; visibility: hidden; transition: opacity 0.3s, visibility 0.3s; }
        .panel-overlay.open { opacity: 1; visibility: visible; }

        /* Search Panel */
        .search-panel { transform: translateX(100%); transition: transform 0.4s ease; }
        .search-panel.open { transform: translateX(0); }

        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>
    {{-- Top Bar --}}
    <div class="top-bar bg-stone-950 text-stone-400 text-xs tracking-wider" id="top-bar">
        <div class="max-w-[1400px] mx-auto px-6 py-2.5 flex justify-between items-center">
            <div class="hidden sm:flex items-center gap-4">
                <a href="#" class="hover:text-white transition uppercase">Order Tracking</a>
                <span class="text-stone-600">|</span>
                <a href="#" class="hover:text-white transition uppercase">Store Locations</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-white transition uppercase">Instagram</a>
                <span class="text-stone-600">|</span>
                <a href="#" class="hover:text-white transition uppercase">Facebook</a>
                <span class="text-stone-600">|</span>
                <a href="#" class="hover:text-white transition uppercase">Youtube</a>
            </div>
        </div>
    </div>

    {{-- Navbar --}}
    <nav class="navbar at-top" id="main-nav">
        <div class="max-w-[1400px] mx-auto px-6 py-5">
            <div class="flex justify-between items-center">
                <button class="nav-icon p-2" onclick="openMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <a href="{{ url('/') }}">
                    <span class="text-2xl md:text-3xl font-bold tracking-[0.15em] font-logo nav-text">HUME WEAR</span>
                </a>

                <button class="nav-icon p-2" onclick="openSearch()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu Panel --}}
    <div class="panel-overlay fixed inset-0 bg-black/40 z-[70]" id="menu-overlay" onclick="closeMenu()"></div>
    <div class="menu-panel fixed top-0 left-0 w-full max-w-sm h-full bg-white z-[71] shadow-2xl" id="menu-panel">
        <div class="p-8">
            <div class="flex items-center justify-between mb-10">
                <span class="text-xl font-bold tracking-[0.15em] font-logo text-stone-900">HUME WEAR</span>
                <button onclick="closeMenu()" class="text-stone-400 hover:text-stone-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="space-y-6">
                <a href="{{ url('/') }}" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Home</a>
                <a href="{{ url('/products') }}" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Shop</a>
                <a href="#" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Collections</a>
                <a href="#" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">About</a>
                <a href="#" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Contact</a>
            </nav>
            <div class="mt-16 pt-8 border-t border-stone-100">
                <h4 class="text-xs font-bold tracking-wider text-stone-400 mb-4">FOLLOW US</h4>
                <div class="flex gap-4">
                    <a href="#" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Panel --}}
    <div class="panel-overlay fixed inset-0 bg-black/40 z-[70]" id="search-overlay" onclick="closeSearch()"></div>
    <div class="search-panel fixed top-0 right-0 w-full max-w-md h-full bg-white z-[71] shadow-2xl overflow-y-auto" id="search-panel">
        <div class="p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-lg font-bold tracking-wider">SEARCH YOUR FAVOURITE</h2>
                <button onclick="closeSearch()" class="text-stone-400 hover:text-stone-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="relative mb-6">
                <input type="text" id="search-input" placeholder="Search by name, brand, code..." class="w-full px-5 py-3 pr-12 border border-stone-200 rounded-lg focus:outline-none focus:border-stone-400 text-sm" oninput="handleSearch(this.value)">
                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>

            <div id="search-loading" class="hidden text-center py-4 text-stone-400 text-sm">Searching...</div>
            <div id="search-results"></div>

            <div id="search-suggestions">
                <h3 class="text-xs font-bold tracking-wider text-stone-800 mb-4">SUGGESTIONS FOR YOU</h3>
                <ul class="space-y-4">
                    <li><a href="/products?category=Fall+Winter" class="text-sm text-stone-600 hover:text-stone-900 transition tracking-wide">FALL WINTER'25</a></li>
                    <li><a href="/products?category=Signature" class="text-sm text-stone-600 hover:text-stone-900 transition tracking-wide">SIGNATURE</a></li>
                    <li><a href="/products?category=Luxury" class="text-sm text-stone-600 hover:text-stone-900 transition tracking-wide">LUXURY</a></li>
                    <li><a href="/products?category=Ready+to+Wear" class="text-sm text-stone-600 hover:text-stone-900 transition tracking-wide">READY TO WEAR</a></li>
                    <li><a href="/products?category=Accessories" class="text-sm text-stone-600 hover:text-stone-900 transition tracking-wide">ACCESSORIES</a></li>
                </ul>
            </div>
        </div>
    </div>

    @yield('hero')

    <main>
        @yield('content')
    </main>

    <footer class="bg-stone-950 text-stone-400 py-16">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <h3 class="text-xl font-bold text-white mb-4 font-logo tracking-wider">HUME WEAR</h3>
                    <p class="text-sm leading-relaxed">Premium quality fabrics and handcrafted accessories for the modern woman.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ url('/products') }}" class="hover:text-white transition">Shop</a></li>
                        <li><a href="#" class="hover:text-white transition">Collections</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Help</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Order Tracking</a></li>
                        <li><a href="#" class="hover:text-white transition">Store Locations</a></li>
                        <li><a href="#" class="hover:text-white transition">Returns & Exchanges</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Follow Us</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 border border-stone-700 rounded-full flex items-center justify-center hover:bg-white hover:text-stone-950 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 border border-stone-700 rounded-full flex items-center justify-center hover:bg-white hover:text-stone-950 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 border border-stone-700 rounded-full flex items-center justify-center hover:bg-white hover:text-stone-950 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-stone-800 pt-8 text-center text-xs">
                <p>&copy; {{ date('Y') }} HUME WEAR. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function openMenu() {
            document.getElementById('menu-overlay').classList.add('open');
            document.getElementById('menu-panel').classList.add('open');
        }
        function closeMenu() {
            document.getElementById('menu-overlay').classList.remove('open');
            document.getElementById('menu-panel').classList.remove('open');
        }
        function openSearch() {
            document.getElementById('search-overlay').classList.add('open');
            document.getElementById('search-panel').classList.add('open');
            setTimeout(() => document.getElementById('search-input').focus(), 300);
        }
        function closeSearch() {
            document.getElementById('search-overlay').classList.remove('open');
            document.getElementById('search-panel').classList.remove('open');
        }

        let searchTimeout = null;
        function handleSearch(value) {
            clearTimeout(searchTimeout);
            const resultsDiv = document.getElementById('search-results');
            const loadingDiv = document.getElementById('search-loading');
            const suggestionsDiv = document.getElementById('search-suggestions');

            if (value.trim().length < 2) {
                resultsDiv.innerHTML = '';
                loadingDiv.classList.add('hidden');
                suggestionsDiv.classList.remove('hidden');
                return;
            }

            suggestionsDiv.classList.add('hidden');
            loadingDiv.classList.remove('hidden');

            searchTimeout = setTimeout(function() {
                fetch('/search?q=' + encodeURIComponent(value.trim()))
                    .then(res => res.json())
                    .then(products => {
                        loadingDiv.classList.add('hidden');
                        if (products.length === 0) {
                            resultsDiv.innerHTML = '<p class="text-sm text-stone-400 text-center py-4">No products found</p>';
                            return;
                        }
                        let html = '';
                        products.forEach(function(p) {
                            let priceHtml = 'PKR ' + Number(p.price).toLocaleString();
                            if (p.discount && p.discount > 0) {
                                let discountPrice = p.discount_type === 'percent'
                                    ? p.price - (p.price * p.discount / 100)
                                    : p.price - p.discount;
                                priceHtml = '<span class="text-red-600 font-semibold">PKR ' + Number(Math.round(discountPrice)).toLocaleString() + '</span> <span class="line-through text-stone-400 ml-1">PKR ' + Number(p.price).toLocaleString() + '</span>';
                            }
                            html += '<a href="' + p.url + '" class="flex items-center gap-4 py-3 border-b border-stone-100 hover:bg-stone-50 transition rounded-lg px-2 -mx-2">' +
                                '<img src="' + p.image + '" class="w-14 h-18 object-cover rounded">' +
                                '<div class="flex-1 min-w-0">' +
                                    '<p class="text-sm font-medium text-stone-800 truncate">' + p.title + '</p>' +
                                    (p.unique_code ? '<p class="text-xs text-stone-400 mt-0.5">' + p.unique_code + '</p>' : '') +
                                    '<p class="text-sm mt-1">' + priceHtml + '</p>' +
                                '</div>' +
                                '</a>';
                        });
                        resultsDiv.innerHTML = html;
                    })
                    .catch(function() {
                        loadingDiv.classList.add('hidden');
                        resultsDiv.innerHTML = '<p class="text-sm text-stone-400 text-center py-4">Search failed. Try again.</p>';
                    });
            }, 300);
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { closeMenu(); closeSearch(); }
        });

        const nav = document.getElementById('main-nav');
        const topBar = document.getElementById('top-bar');
        const navTexts = document.querySelectorAll('.nav-text');
        const navIcons = document.querySelectorAll('.nav-icon');

        function updateNav() {
            if (window.scrollY > 50 || nav.dataset.alwaysScrolled !== undefined) {
                topBar.classList.add('hidden-bar');
                nav.classList.add('scrolled');
                nav.classList.remove('at-top');
                navTexts.forEach(el => { el.classList.remove('text-white'); el.classList.add('text-stone-900'); });
                navIcons.forEach(el => { el.classList.remove('text-white'); el.classList.add('text-stone-900'); });
            } else {
                topBar.classList.remove('hidden-bar');
                nav.classList.remove('scrolled');
                nav.classList.add('at-top');
                navTexts.forEach(el => { el.classList.add('text-white'); el.classList.remove('text-stone-900'); });
                navIcons.forEach(el => { el.classList.add('text-white'); el.classList.remove('text-stone-900'); });
            }
        }

        window.addEventListener('scroll', updateNav);
        window.addEventListener('load', updateNav);
    </script>
    @yield('scripts')
</body>
</html>
