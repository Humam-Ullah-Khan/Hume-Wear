<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Hume Wear')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Roba';
            src: url('/fonts/roba/Roba-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; font-weight: 400; background: #f5f5f4; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; font-weight: 700; }
        .font-logo { font-family: 'Roba', sans-serif; text-transform: capitalize; }
    </style>
</head>
<body>
    <div class="min-h-screen flex">
        <aside class="w-64 bg-stone-900 text-stone-300 p-6">
            <h2 class="text-2xl font-bold text-white mb-8 font-logo">HUME WEAR</h2>
            <p class="text-xs uppercase tracking-widest text-stone-500 mb-4">Admin Panel</p>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-stone-800 transition">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded hover:bg-stone-800 transition">Products</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded hover:bg-stone-800 transition">Site Settings</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-stone-800 transition text-stone-500">Logout</button>
                </form>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
