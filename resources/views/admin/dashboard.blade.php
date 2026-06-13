@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-stone-800">Dashboard</h1>
    <p class="text-stone-500 mt-1">Welcome back, {{ auth()->user()->name }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-stone-200">
        <p class="text-sm text-stone-500 uppercase tracking-wider">Total Products</p>
        <p class="text-4xl font-bold text-stone-900 mt-2">{{ $productCount }}</p>
    </div>
</div>

<div class="mt-8">
    <a href="{{ route('admin.products.create') }}" class="inline-block bg-stone-900 text-white px-6 py-3 rounded hover:bg-stone-800 transition font-medium">+ Add New Product</a>
</div>
@endsection