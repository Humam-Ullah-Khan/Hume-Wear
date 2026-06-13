<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mariab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f5f4; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-center mb-2" style="font-family: 'Playfair Display', serif;">MARIAB</h1>
        <p class="text-center text-stone-500 text-sm mb-8">Admin Login</p>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900" value="{{ old('email') }}">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border border-stone-300 rounded focus:outline-none focus:ring-2 focus:ring-stone-900">
            </div>
            <button type="submit" class="w-full bg-stone-900 text-white py-2 rounded hover:bg-stone-800 transition font-medium">Login</button>
        </form>
    </div>
</body>
</html>