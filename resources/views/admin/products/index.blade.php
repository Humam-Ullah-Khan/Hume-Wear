@extends('layouts.admin')

@section('title', 'Products - Admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-stone-800">Products</h1>
        <p class="text-stone-500 mt-1">Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-stone-900 text-white px-6 py-2 rounded hover:bg-stone-800 transition font-medium">+ Add Product</a>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-stone-200 overflow-hidden">
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
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/60x60/eee/999?text=N/A' }}" class="w-12 h-12 object-cover rounded">
                </td>
                <td class="px-6 py-4 font-medium">{{ $product->title }}</td>
                <td class="px-6 py-4">PKR {{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4 text-stone-500">{{ $product->category ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-stone-600 hover:text-stone-900 mr-3">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700">Delete</button>
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
@endsection