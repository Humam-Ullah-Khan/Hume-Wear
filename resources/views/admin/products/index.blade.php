@extends('layouts.admin')

@section('title', 'Products - Admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-stone-800">Products</h1>
        <p class="text-stone-500 mt-1">Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-hover bg-stone-900 text-white px-6 py-2 rounded hover:bg-stone-800 transition font-medium text-sm whitespace-nowrap">+ Add Product</a>
</div>

{{-- Desktop Table --}}
<div class="hidden sm:block bg-white rounded-lg shadow-sm border border-stone-200 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-stone-50 border-b border-stone-200">
            <tr>
                <th class="px-6 py-3 text-xs uppercase tracking-wider text-stone-500">Image</th>
                <th class="px-6 py-3 text-xs uppercase tracking-wider text-stone-500">Title</th>
                <th class="px-6 py-3 text-xs uppercase tracking-wider text-stone-500">Price</th>
                <th class="px-6 py-3 text-xs uppercase tracking-wider text-stone-500">Category</th>
                <th class="px-6 py-3 text-xs uppercase tracking-wider text-stone-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-200">
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-4">
                    <img src="{{ $product->primary_image ? asset('storage/' . $product->primary_image) : ($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/60x60/eee/999?text=N/A') }}" class="w-12 h-12 object-cover rounded">
                </td>
                <td class="px-6 py-4 font-medium">{{ $product->title }}</td>
                <td class="px-6 py-4">PKR {{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4 text-stone-500">{{ $product->category ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-stone-600 hover:text-stone-900 mr-3">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" data-no-loading>
                        @csrf @method('DELETE')
                        <button type="button" onclick="event.preventDefault(); showConfirmModal('Delete this product permanently? This cannot be undone.', function() { this.closest('form').submit(); }.bind(this))" class="text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-stone-400">No products yet. <a href="{{ route('admin.products.create') }}" class="text-stone-900 underline">Add your first product</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile Cards --}}
<div class="sm:hidden space-y-4">
    @forelse($products as $product)
    <div class="bg-white rounded-lg shadow-sm border border-stone-200 p-4">
        <div class="flex gap-4">
            <img src="{{ $product->primary_image ? asset('storage/' . $product->primary_image) : ($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/60x60/eee/999?text=N/A') }}" class="w-16 h-16 object-cover rounded flex-shrink-0">
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-stone-800 text-sm truncate">{{ $product->title }}</h3>
                <p class="text-xs text-stone-400 mt-0.5">{{ $product->category ?? 'N/A' }}</p>
                <p class="text-sm font-semibold text-stone-900 mt-1">PKR {{ number_format($product->price, 2) }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 mt-3 pt-3 border-t border-stone-100">
            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 text-center px-4 py-2 border border-stone-200 rounded-lg text-sm text-stone-600 hover:bg-stone-50 transition">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="flex-1" data-no-loading>
                @csrf @method('DELETE')
                <button type="button" onclick="event.preventDefault(); showConfirmModal('Delete this product permanently? This cannot be undone.', function() { this.closest('form').submit(); }.bind(this))" class="w-full px-4 py-2 border border-red-200 rounded-lg text-sm text-red-500 hover:bg-red-50 transition">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-stone-400 bg-white rounded-lg border border-stone-200">
        <p>No products yet.</p>
        <a href="{{ route('admin.products.create') }}" class="text-stone-900 underline text-sm mt-1 inline-block">Add your first product</a>
    </div>
    @endforelse
</div>
@endsection