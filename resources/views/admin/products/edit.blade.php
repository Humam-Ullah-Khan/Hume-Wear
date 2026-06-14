@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-stone-800">Edit Product</h1>
        <p class="text-stone-500 mt-1">Update product information</p>
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

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="product-form">
        @csrf @method('PUT')

        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-stone-800 mb-6">General Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Product Name</label>
                            <input type="text" name="title" required value="{{ old('title', $product->title) }}" placeholder="Enter product name" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="Enter brand name" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-stone-600 mb-1.5">Description</label>
                        <textarea name="description" required rows="6" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Price (PKR)</label>
                            <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}" placeholder="PKR 0.00" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Discount</label>
                            <div class="flex items-center gap-0">
                                <input type="number" step="0.01" name="discount" value="{{ old('discount', $product->discount) }}" placeholder="PKR 0" class="w-full px-4 py-2.5 border border-stone-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <div class="flex border border-l-0 border-stone-200 rounded-r-lg overflow-hidden">
                                    <button type="button" onclick="setDiscountType('percent')" id="btn-percent" class="discount-type-btn px-3 py-2.5 text-sm {{ old('discount_type', $product->discount_type) === 'percent' ? 'bg-blue-500 text-white' : 'bg-stone-100 text-stone-600' }} border-r border-stone-200">%</button>
                                    <button type="button" onclick="setDiscountType('fixed')" id="btn-fixed" class="discount-type-btn px-3 py-2.5 text-sm {{ old('discount_type', $product->discount_type) !== 'percent' ? 'bg-blue-500 text-white' : 'bg-stone-100 text-stone-600' }}">PKR</button>
                                </div>
                                <input type="hidden" name="discount_type" id="discount_type" value="{{ old('discount_type', $product->discount_type ?? 'fixed') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-stone-600 mb-2">Size</label>
                        <input type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="e.g. S, M, L, XL" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 border border-stone-200 rounded-lg text-stone-600 hover:bg-stone-50 transition text-sm font-medium">Cancel</a>
                    <div class="flex-1"></div>
                    <button type="submit" class="px-8 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium">Update Product</button>
                </div>
            </div>

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
                    <div class="grid grid-cols-3 gap-2" id="image-preview-container">
                        @php
                            $existingImages = is_array($product->images) ? $product->images : [];
                            $currentPrimary = $product->primary_image ?? $product->image ?? '';
                        @endphp
                        @foreach($existingImages as $idx => $img)
                        <div class="col-span-1 aspect-square rounded-lg overflow-hidden relative group" data-existing="{{ $idx }}">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                            <button type="button" onclick="removeExistingImage('{{ $img }}', this)" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition flex items-center justify-center">&times;</button>
                            <button type="button" onclick="setExistingPrimary('{{ $img }}', this)" class="absolute bottom-1 left-1 w-6 h-6 {{ $img === $currentPrimary ? 'bg-blue-500 text-white' : 'bg-white/80 text-stone-600' }} rounded-full text-sm flex items-center justify-center transition hover:bg-blue-500 hover:text-white">
                                {{ $img === $currentPrimary ? '★' : '☆' }}
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="primary_image" id="primary-image-input" value="{{ $currentPrimary }}">
                    <input type="hidden" name="remove_images" id="remove-images-input" value="">
                </div>

                {{-- Category --}}
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <label class="block text-sm font-medium text-stone-800 mb-3">Category</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}" placeholder="Enter category name" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let newUploadedCount = 0;
    let removedImages = [];

    function setDiscountType(type) {
        document.getElementById('discount_type').value = type;
        document.querySelectorAll('.discount-type-btn').forEach(btn => {
            btn.classList.remove('bg-blue-500', 'text-white');
            btn.classList.add('bg-stone-100', 'text-stone-600');
        });
        const btn = document.getElementById('btn-' + type);
        btn.classList.add('bg-blue-500', 'text-white');
        btn.classList.remove('bg-stone-100', 'text-stone-600');
    }

    function previewImages(input) {
        const container = document.getElementById('image-preview-container');

        Array.from(input.files).forEach((file) => {
            const idx = newUploadedCount++;
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-span-1 aspect-square rounded-lg overflow-hidden relative group';
                div.setAttribute('data-new', idx);
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <button type="button" onclick="removeNewImage(this)" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition flex items-center justify-center">&times;</button>
                    <button type="button" onclick="setNewPrimary(this)" class="absolute bottom-1 left-1 w-6 h-6 bg-white/80 text-stone-600 rounded-full text-sm flex items-center justify-center transition hover:bg-blue-500 hover:text-white">☆</button>
                `;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function setExistingPrimary(imgPath, btn) {
        document.querySelectorAll('#image-preview-container > div').forEach(div => {
            const star = div.querySelector('button:last-child');
            if (star) {
                star.innerHTML = '☆';
                star.className = 'absolute bottom-1 left-1 w-6 h-6 bg-white/80 text-stone-600 rounded-full text-sm flex items-center justify-center transition hover:bg-blue-500 hover:text-white';
            }
        });
        btn.innerHTML = '★';
        btn.className = 'absolute bottom-1 left-1 w-6 h-6 bg-blue-500 text-white rounded-full text-sm flex items-center justify-center transition';
        document.getElementById('primary-image-input').value = imgPath;
    }

    function setNewPrimary(btn) {
        document.querySelectorAll('#image-preview-container > div').forEach(div => {
            const star = div.querySelector('button:last-child');
            if (star) {
                star.innerHTML = '☆';
                star.className = 'absolute bottom-1 left-1 w-6 h-6 bg-white/80 text-stone-600 rounded-full text-sm flex items-center justify-center transition hover:bg-blue-500 hover:text-white';
            }
        });
        btn.innerHTML = '★';
        btn.className = 'absolute bottom-1 left-1 w-6 h-6 bg-blue-500 text-white rounded-full text-sm flex items-center justify-center transition';
        document.getElementById('primary-image-input').value = 'new_' + btn.closest('div[data-new]').dataset.new;
    }

    function removeExistingImage(imgPath, btn) {
        const div = btn.closest('div[data-existing]');
        if (div) {
            const wasPrimary = document.getElementById('primary-image-input').value === imgPath;
            div.remove();
            removedImages.push(imgPath);
            document.getElementById('remove-images-input').value = JSON.stringify(removedImages);
            if (wasPrimary) {
                const firstRemaining = document.querySelector('#image-preview-container > div[data-existing] button:last-child');
                const firstNew = document.querySelector('#image-preview-container > div[data-new] button:last-child');
                if (firstRemaining) firstRemaining.click();
                else if (firstNew) firstNew.click();
                else document.getElementById('primary-image-input').value = '';
            }
        }
    }

    function removeNewImage(btn) {
        const div = btn.closest('div[data-new]');
        if (div) div.remove();
    }
</script>
@endsection
