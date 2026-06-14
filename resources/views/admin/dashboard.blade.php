@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-stone-800">Dashboard</h1>
    <p class="text-stone-500 mt-1">Welcome back, {{ auth()->user()->name }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-stone-200">
        <p class="text-sm text-stone-500 uppercase tracking-wider">Total Products</p>
        <p class="text-4xl font-bold text-stone-900 mt-2">{{ $productCount }}</p>
    </div>
</div>

<div class="flex flex-wrap gap-4">
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-stone-900 text-white px-6 py-3 rounded-lg hover:bg-stone-800 transition font-medium text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add New Product
    </a>
    <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 bg-white text-stone-700 px-6 py-3 rounded-lg border border-stone-200 hover:bg-stone-50 transition font-medium text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Site Settings
    </a>
</div>
@endsection
