@extends('layouts.admin')

@section('title', 'Create a New Product - Admin')

@section('content')
<div class="max-w-7xl mx-auto pb-24 lg:pb-0">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-stone-800">Create a New Product</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="bg-stone-900 text-white text-sm px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-stone-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Product
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="product-form">
        @csrf

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Left Column: General Information --}}
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-stone-800 mb-6">General Information</h2>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-stone-600 mb-1.5">Product Name</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter product name" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Unique Code</label>
                            <input type="text" name="unique_code" value="{{ old('unique_code') }}" placeholder="e.g. HE-001 (auto-generated if empty)" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Enter brand name" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium text-stone-600">Description</label>
                        </div>
                        <textarea name="description" rows="6" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Sale Price</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="PKR 0.00" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Discount</label>
                            <div class="flex items-center">
                                <input type="number" step="0.01" name="discount" value="{{ old('discount') }}" placeholder="0" class="flex-1 min-w-0 px-4 py-2.5 border border-stone-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <div class="flex flex-shrink-0 border border-l-0 border-stone-200 rounded-r-lg overflow-hidden">
                                    <button type="button" onclick="setDiscountType('percent')" id="btn-percent" class="discount-type-btn px-3 py-2.5 text-sm font-medium whitespace-nowrap bg-blue-500 text-white">%</button>
                                    <button type="button" onclick="setDiscountType('fixed')" id="btn-fixed" class="discount-type-btn px-3 py-2.5 text-sm font-medium whitespace-nowrap bg-stone-100 text-stone-600 border-l border-stone-200">PKR</button>
                                </div>
                                <input type="hidden" name="discount_type" id="discount_type" value="{{ old('discount_type', 'fixed') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Colors --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-stone-600 mb-2">Colors</label>
                        <div class="flex gap-2 mb-3">
                            <input type="text" id="color-input" placeholder="Enter color name (e.g. Red)" class="flex-1 px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <button type="button" onclick="addColor()" class="px-4 py-2.5 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition">Add</button>
                        </div>
                        <div class="flex flex-wrap gap-2" id="colors-container"></div>
                        <input type="hidden" name="colors" id="colors-input" value="{{ old('colors') }}">
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="w-full lg:w-80 space-y-6">
                {{-- Product Images --}}
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <label class="block text-sm font-medium text-stone-800 mb-3">Product Images</label>
                    <p class="text-xs text-stone-400 mb-3">Click star ★ to set primary image</p>
                    <div class="mb-3">
                        <input type="file" name="images[]" id="image-upload" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                        <button type="button" onclick="document.getElementById('image-upload').click()" class="w-full px-4 py-8 border-2 border-dashed border-stone-200 rounded-lg text-stone-400 hover:border-blue-400 hover:text-blue-500 transition text-sm text-center cursor-pointer">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Click to upload images
                        </button>
                    </div>
                    <div class="grid grid-cols-3 gap-2" id="image-preview-container"></div>
                    <input type="hidden" name="primary_image" id="primary-image-input" value="0">
                </div>

                {{-- Category --}}
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <label class="block text-sm font-medium text-stone-800 mb-3">Category</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="e.g. Unstitched, Ready to Wear" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>

                {{-- Fabric --}}
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <label class="block text-sm font-medium text-stone-800 mb-3">Fabric</label>
                    <input type="text" name="fabric" value="{{ old('fabric') }}" placeholder="e.g. Cotton, Linen, Silk, Lawn, Chiffon" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>

                {{-- Product Video --}}
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <label class="block text-sm font-medium text-stone-800 mb-3">Product Video</label>
                    <p class="text-xs text-stone-400 mb-2">Upload a video file (MP4, WebM, MOV — max 50MB)</p>
                    <div>
                        <input type="file" name="video" accept="video/mp4,video/webm,video/quicktime" class="w-full text-sm text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition">
                    </div>
                </div>

                {{-- Admin Notes --}}
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <label class="block text-sm font-medium text-stone-800 mb-3">Admin Notes</label>
                    <p class="text-xs text-stone-400 mb-2">Private notes — not visible to customers</p>
                    <textarea name="notes" rows="4" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm resize-none">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Mobile Bottom Bar --}}
        <div class="fixed bottom-0 left-0 right-0 lg:hidden z-20 bg-white border-t border-stone-200 p-4 flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="flex-1 text-center px-4 py-3 border border-stone-200 rounded-lg text-stone-600 hover:bg-stone-50 transition text-sm font-medium">Cancel</a>
            <button type="submit" class="flex-1 text-center px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold">Save</button>
        </div>

        {{-- Desktop Buttons --}}
        <div class="hidden lg:flex items-center gap-4 mt-8">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 border border-stone-200 rounded-lg text-stone-600 hover:bg-stone-50 transition text-sm font-medium">Cancel</a>
            <div class="flex-1"></div>
            <button type="submit" class="px-8 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium">Save</button>
        </div>
    </form>
</div>

<script>
    let uploadedFiles = [];
    let uploadedPaths = [];
    let primaryImageIndex = 0;
    let colors = [];

    document.getElementById('color-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); addColor(); }
    });

    function setDiscountType(type) {
        document.getElementById('discount_type').value = type;
        document.querySelectorAll('.discount-type-btn').forEach(btn => {
            btn.classList.remove('bg-blue-500', 'text-white');
            btn.classList.add('bg-stone-100', 'text-stone-600');
        });
        if (type === 'percent') {
            document.getElementById('btn-percent').classList.add('bg-blue-500', 'text-white');
            document.getElementById('btn-percent').classList.remove('bg-stone-100', 'text-stone-600');
        } else {
            document.getElementById('btn-fixed').classList.add('bg-blue-500', 'text-white');
            document.getElementById('btn-fixed').classList.remove('bg-stone-100', 'text-stone-600');
        }
    }

    function addColor() {
        var input = document.getElementById('color-input');
        var val = input.value.trim();
        if (!val || colors.indexOf(val) !== -1) { input.value = ''; return; }
        colors.push(val);
        input.value = '';
        renderColors();
    }

    function removeColor(color) {
        colors = colors.filter(function(c) { return c !== color; });
        renderColors();
    }

    function renderColors() {
        var container = document.getElementById('colors-container');
        container.innerHTML = '';
        colors.forEach(function(color) {
            var tag = document.createElement('span');
            tag.className = 'inline-flex items-center gap-1 px-3 py-1.5 bg-stone-900 text-white rounded-lg text-sm';
            tag.innerHTML = color + ' <button type="button" onclick="removeColor(\'' + color.replace(/'/g, "\\'") + '\')" class="ml-1 hover:text-red-300">&times;</button>';
            container.appendChild(tag);
        });
        document.getElementById('colors-input').value = colors.join(',');
    }

    function previewImages(input) {
        const container = document.getElementById('image-preview-container');

        Array.from(input.files).forEach((file) => {
            const idx = uploadedFiles.length;
            uploadedFiles.push(file);
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-span-1 aspect-square rounded-lg overflow-hidden relative group';
                div.setAttribute('data-index', idx);

                const isPrimary = idx === primaryImageIndex;
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <button type="button" onclick="removeImage(${idx}, this)" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition flex items-center justify-center">&times;</button>
                    <button type="button" onclick="setPrimary(${idx}, this)" class="absolute bottom-1 left-1 w-6 h-6 ${isPrimary ? 'bg-blue-500' : 'bg-white/80'} text-${isPrimary ? 'white' : 'stone-600'} rounded-full text-sm flex items-center justify-center transition hover:bg-blue-500 hover:text-white">${isPrimary ? '★' : '☆'}</button>
                `;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        updatePrimaryInput();
    }

    function setPrimary(index, btn) {
        primaryImageIndex = index;
        document.querySelectorAll('#image-preview-container > div').forEach(div => {
            const star = div.querySelector('button:last-child');
            if (star) {
                star.innerHTML = '☆';
                star.className = 'absolute bottom-1 left-1 w-6 h-6 bg-white/80 text-stone-600 rounded-full text-sm flex items-center justify-center transition hover:bg-blue-500 hover:text-white';
            }
        });
        btn.innerHTML = '★';
        btn.className = 'absolute bottom-1 left-1 w-6 h-6 bg-blue-500 text-white rounded-full text-sm flex items-center justify-center transition';
        updatePrimaryInput();
    }

    function removeImage(index, btn) {
        const el = btn.closest('div[data-index]');
        if (el) el.remove();
        if (primaryImageIndex === index) {
            const firstRemaining = document.querySelector('#image-preview-container > div[data-index]');
            if (firstRemaining) {
                const star = firstRemaining.querySelector('button:last-child');
                if (star) star.click();
            } else {
                primaryImageIndex = 0;
                updatePrimaryInput();
            }
        }
    }

    function updatePrimaryInput() {
        document.getElementById('primary-image-input').value = primaryImageIndex;
    }
</script>
@endsection
