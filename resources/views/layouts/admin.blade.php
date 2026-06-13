<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Mariab')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f5f4; }
    </style>
</head>
<body>
    <div class="min-h-screen flex">
        <aside class="w-64 bg-stone-900 text-stone-300 p-6">
            <h2 class="text-2xl font-bold text-white mb-8">MARIAB</h2>
            <p class="text-xs uppercase tracking-widest text-stone-500 mb-4">Admin Panel</p>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-stone-800 transition">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded hover:bg-stone-800 transition">Products</a>
                <a href="{{ route('admin.logout') }}" class="block px-3 py-2 rounded hover:bg-stone-800 transition text-stone-500">Logout</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>