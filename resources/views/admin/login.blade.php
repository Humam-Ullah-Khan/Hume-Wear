<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hume Wear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex">
    <div class="hidden md:block w-1/2 bg-stone-100">
        <img src="{{ asset('images/Login-Page.webp') }}" alt="Women Fashion" class="w-full h-screen object-cover">
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-sm">
            <h1 class="text-4xl font-bold text-stone-900 mb-1" style="font-family: 'Playfair Display', serif;">HUME WEAR</h1>
            <p class="text-stone-400 text-sm mb-10">Admin Panel</p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-2.5 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900 focus:border-transparent text-sm">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900 focus:border-transparent text-sm">
                </div>
                <button type="submit" class="w-full bg-stone-900 text-white py-2.5 rounded hover:bg-stone-800 transition font-medium text-sm">Sign In</button>
            </form>

            <p class="text-center text-xs text-stone-400 mt-8">Hume Wear &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>