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

        /* === Global Hover Effects === */
        .btn-hover {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative;
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(28, 25, 23, 0.1);
        }
        .btn-hover:active {
            transform: translateY(0);
        }

        .btn-hover-outline {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .btn-hover-outline:hover {
            outline: 2px solid rgba(28, 25, 23, 0.25);
            outline-offset: 2px;
        }

        .btn-hover-light {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .btn-hover-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            outline: 2px solid rgba(255, 255, 255, 0.3);
            outline-offset: 2px;
        }

        /* Accordion Smooth Animation */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .accordion-content.open {
            max-height: 600px;
        }
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

                <div class="flex items-center gap-1">
                    <button class="nav-icon p-2" onclick="openSearch()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    <a href="{{ url('/wishlist') }}" class="nav-icon p-2 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span id="wishlist-badge" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center hidden">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu Panel --}}
    <div class="panel-overlay fixed inset-0 bg-black/40 z-[70]" id="menu-overlay" onclick="closeMenu()"></div>
    <div class="menu-panel fixed top-0 left-0 w-full max-w-sm h-full bg-white z-[71] shadow-2xl" id="menu-panel">
        <div class="p-8">
            <div class="flex items-center justify-between mb-10">
                <span class="text-xl font-bold tracking-[0.15em] font-logo text-stone-900">HUME WEAR</span>
                <button onclick="closeMenu()" class="btn-hover text-stone-400 hover:text-stone-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="space-y-6">
                <a href="{{ url('/') }}" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Home</a>
                <a href="{{ url('/products') }}" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Shop</a>
                <a href="{{ url('/wishlist') }}" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Wishlist</a>
                <a href="#" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Collections</a>
                <a href="{{ url('/contact') }}" class="block text-stone-900 text-lg tracking-wider uppercase hover:text-stone-600 transition">Contact</a>
            </nav>
            <div class="mt-16 pt-8 border-t border-stone-100">
                <h4 class="text-xs font-bold tracking-wider text-stone-400 mb-4">FOLLOW US</h4>
                <div class="flex gap-4">
                    @if($siteSettings['instagram'])
                    <a href="{{ $siteSettings['instagram'] }}" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    @endif
                    @if($siteSettings['facebook'])
                    <a href="{{ $siteSettings['facebook'] }}" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if($siteSettings['youtube'])
                    <a href="{{ $siteSettings['youtube'] }}" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Search Panel --}}
    <div class="panel-overlay fixed inset-0 bg-black/40 z-[70]" id="search-overlay" onclick="closeSearch()"></div>
    <div class="search-panel fixed top-0 right-0 w-full max-w-sm h-full bg-white z-[71] shadow-2xl" id="search-panel">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <span class="text-lg font-bold tracking-[0.15em] font-logo text-stone-900">Search</span>
                <button onclick="closeSearch()" class="btn-hover text-stone-400 hover:text-stone-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="relative">
                <input id="search-input" type="text" placeholder="Search products..." oninput="handleSearch(this.value)" class="w-full px-4 py-3 pr-10 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-stone-900 text-sm">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <div id="search-suggestions" class="mt-4">
                <p class="text-xs text-stone-400 uppercase tracking-wider font-medium">Start typing to search...</p>
            </div>
            <div id="search-loading" class="hidden mt-4 text-center py-8">
                <div class="inline-block w-6 h-6 border-2 border-stone-200 border-t-stone-900 rounded-full animate-spin"></div>
            </div>
            <div id="search-results" class="mt-2 space-y-2 max-h-[60vh] overflow-y-auto"></div>
        </div>
    </div>

    {{-- Hero Section (home page only) --}}
    @yield('hero')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-stone-200">
        <div class="max-w-[1400px] mx-auto px-8 md:px-12 py-14 md:py-20">
            <div class="flex flex-col md:flex-row md:justify-between gap-12">
                {{-- Left: Logo + Contact --}}
                <div class="max-w-md">
                    <span class="text-4xl md:text-5xl font-bold tracking-[0.25em] font-logo text-stone-900">HUME WEAR</span>
                    <div class="mt-8 space-y-2 text-sm text-stone-400 leading-relaxed">
                        <p>Location: {{ $siteSettings['address'] }}</p>
                        <p>Call: {{ $siteSettings['phone'] }}</p>
                        <p>WhatsApp: {{ $siteSettings['whatsapp'] }}</p>
                        <p>Email: {{ $siteSettings['email'] }}</p>
                    </div>
                </div>

                {{-- Right: Customer Care --}}
                <div class="md:mr-12">
                    <h4 class="text-sm font-bold tracking-wide text-stone-900 mb-5">Customer Care</h4>
                    <nav class="space-y-3">
                        <a href="#" class="block text-sm text-stone-500 hover:text-stone-900 transition">About Us</a>
                        <a href="{{ url('/contact') }}" class="block text-sm text-stone-500 hover:text-stone-900 transition">Contact Us</a>
                        <a href="#" class="block text-sm text-stone-500 hover:text-stone-900 transition">Track Your Order</a>
                        <a href="#" class="block text-sm text-stone-500 hover:text-stone-900 transition">FAQs</a>
                    </nav>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="mt-14 pt-6 border-t border-stone-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-stone-400">&copy; {{ date('Y') }} HUME WEAR. All rights reserved.</p>
                <div class="flex gap-4">
                    @if($siteSettings['youtube'])
                    <a href="{{ $siteSettings['youtube'] }}" target="_blank" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    @endif
                    @if($siteSettings['instagram'])
                    <a href="{{ $siteSettings['instagram'] }}" target="_blank" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    @endif
                    @if($siteSettings['facebook'])
                    <a href="{{ $siteSettings['facebook'] }}" target="_blank" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if($siteSettings['tiktok'])
                    <a href="{{ $siteSettings['tiktok'] }}" target="_blank" class="text-stone-400 hover:text-stone-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    {{-- Welcome Popup --}}
    <div id="welcome-popup" class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display:none; opacity:0; transition: opacity 0.3s ease;">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeWelcomePopup()"></div>
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden" style="transform: scale(0.9) translateY(20px); transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);">
            {{-- Close button --}}
            <button onclick="closeWelcomePopup()" class="absolute top-4 right-4 z-10 w-8 h-8 bg-stone-100 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-600 hover:bg-stone-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            {{-- Content --}}
            <div class="p-8 text-center">
                <img src="{{ asset('images/logo-transparent.png') }}" alt="Hume Wear" class="w-20 h-20 object-contain mx-auto">
                <p class="text-stone-500 text-sm mt-5 leading-relaxed">Welcome to HUME WEAR — discover premium fashion and accessories crafted for the modern woman.</p>
                <button onclick="closeWelcomePopup()" class="btn-hover mt-7 w-full bg-stone-900 hover:bg-stone-800 text-white py-3.5 rounded-xl text-sm font-semibold tracking-wide transition">
                    Start Shopping
                </button>
            </div>
        </div>
    </div>

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

        // Wishlist badge
        function updateWishlistCount() {
            var badge = document.getElementById('wishlist-badge');
            if (!badge) return;
            try {
                var ids = JSON.parse(localStorage.getItem('hw_wishlist') || '[]');
                if (ids.length > 0) {
                    badge.textContent = ids.length;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            } catch(e) {}
        }
        updateWishlistCount();
        window.addEventListener('storage', updateWishlistCount);

        // Welcome popup
        (function() {
            var popup = document.getElementById('welcome-popup');
            if (!popup || localStorage.getItem('hw_welcome_seen')) return;
            setTimeout(function() {
                popup.style.display = 'flex';
                requestAnimationFrame(function() {
                    popup.style.opacity = '1';
                    popup.querySelector('.relative').style.transform = 'scale(1) translateY(0)';
                });
                localStorage.setItem('hw_welcome_seen', 'true');
            }, 1500);
        })();

        function closeWelcomePopup() {
            var popup = document.getElementById('welcome-popup');
            if (!popup) return;
            popup.style.opacity = '0';
            popup.querySelector('.relative').style.transform = 'scale(0.9) translateY(20px)';
            setTimeout(function() { popup.style.display = 'none'; }, 400);
        }

        window.addEventListener('scroll', updateNav);
        window.addEventListener('load', updateNav);
    </script>
    @yield('scripts')
</body>
</html>
