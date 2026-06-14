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
            font-family: 'hago-demo';
            src: url('/fonts/hago-demo/Hago DEMO.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; font-weight: 400; background: #f5f5f4; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; font-weight: 700; }
        .font-logo { font-family: 'hago-demo', sans-serif; text-transform: capitalize; }

        .popup-overlay { opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease; }
        .popup-overlay.active { opacity: 1; visibility: visible; }
        .popup-box { transform: scale(0.95) translateY(10px); transition: transform 0.3s ease; }
        .popup-overlay.active .popup-box { transform: scale(1) translateY(0); }

        .toast { transform: translateX(120%); opacity: 0; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); }
        .toast.show { transform: translateX(0); opacity: 1; }
        .toast.hide { transform: translateX(120%); opacity: 0; }

        .loading-spinner { border: 3px solid #e5e7eb; border-top-color: #1c1917; border-radius: 50%; width: 32px; height: 32px; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
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
                <button type="button" onclick="showConfirmModal('Are you sure you want to log out?', function() { document.getElementById('logout-form').submit(); })" class="w-full text-left px-3 py-2 rounded hover:bg-stone-800 transition text-stone-500">Logout</button>
                <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" class="hidden">@csrf</form>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

    {{-- Success Toast --}}
    @if(session('success'))
    <div id="success-toast" class="toast fixed top-6 right-6 z-[200] max-w-sm bg-white rounded-xl shadow-2xl border border-stone-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-stone-800">Success</p>
            <p class="text-xs text-stone-500 mt-0.5">{{ session('success') }}</p>
        </div>
        <button onclick="hideToast('success-toast')" class="text-stone-400 hover:text-stone-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif

    {{-- Error Toast --}}
    @if($errors->any())
    <div id="error-toast" class="toast fixed top-6 right-6 z-[200] max-w-sm bg-white rounded-xl shadow-2xl border border-stone-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-stone-800">Error</p>
            <p class="text-xs text-stone-500 mt-0.5">{{ $errors->first() }}</p>
        </div>
        <button onclick="hideToast('error-toast')" class="text-stone-400 hover:text-stone-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif

    {{-- Confirmation Modal --}}
    <div id="confirm-modal" class="popup-overlay fixed inset-0 z-[300] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
        <div class="popup-box relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-8 text-center">
            <div class="w-14 h-14 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-stone-900 mb-2">Are you sure?</h3>
            <p id="confirm-message" class="text-sm text-stone-500 mb-6">This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 border border-stone-200 rounded-xl text-sm font-medium text-stone-600 hover:bg-stone-50 transition">Cancel</button>
                <button id="confirm-btn" class="flex-1 px-4 py-2.5 bg-stone-900 text-white rounded-xl text-sm font-medium hover:bg-stone-800 transition">Confirm</button>
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="popup-overlay fixed inset-0 z-[400] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-white/80 backdrop-blur-sm"></div>
        <div class="popup-box relative bg-white rounded-2xl shadow-2xl px-10 py-8 text-center">
            <div class="loading-spinner mx-auto mb-4"></div>
            <p id="loading-text" class="text-sm font-medium text-stone-700">Saving...</p>
        </div>
    </div>

    <script>
        // Toast auto-dismiss
        document.addEventListener('DOMContentLoaded', function() {
            var successToast = document.getElementById('success-toast');
            var errorToast = document.getElementById('error-toast');
            if (successToast) {
                setTimeout(function() { successToast.classList.add('show'); }, 100);
                setTimeout(function() { hideToast('success-toast'); }, 4000);
            }
            if (errorToast) {
                setTimeout(function() { errorToast.classList.add('show'); }, 100);
                setTimeout(function() { hideToast('error-toast'); }, 5000);
            }
        });

        function hideToast(id) {
            var toast = document.getElementById(id);
            if (toast) {
                toast.classList.remove('show');
                toast.classList.add('hide');
            }
        }

        // Confirmation Modal
        var confirmCallback = null;
        function showConfirmModal(message, callback) {
            document.getElementById('confirm-message').textContent = message;
            confirmCallback = callback;
            document.getElementById('confirm-modal').classList.add('active');
        }
        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.remove('active');
            confirmCallback = null;
        }
        document.getElementById('confirm-btn').addEventListener('click', function() {
            if (confirmCallback) confirmCallback();
            closeConfirmModal();
        });

        // Loading Overlay
        function showLoading(text) {
            document.getElementById('loading-text').textContent = text || 'Saving...';
            document.getElementById('loading-overlay').classList.add('active');
        }
        function hideLoading() {
            document.getElementById('loading-overlay').classList.remove('active');
        }

        // Form submit loading
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                if (!form.dataset.noLoading) {
                    showLoading();
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
