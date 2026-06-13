<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mariab - Fashion & Accessories')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #fafaf9; color: #1c1917; }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body>
    <nav class="bg-white shadow-sm border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="text-3xl font-bold text-stone-800" style="font-family: 'Playfair Display', serif;">MARIAB</a>
                <div class="flex space-x-8 text-sm uppercase tracking-widest text-stone-600">
                    <a href="{{ url('/') }}" class="hover:text-stone-900 transition">Home</a>
                    <a href="{{ url('/products') }}" class="hover:text-stone-900 transition">Shop</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-stone-900 text-stone-400 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-2xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">MARIAB</p>
            <p class="text-sm">Women's Fashion & Accessories</p>
            <p class="text-xs mt-6">&copy; {{ date('Y') }} Mariab. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>