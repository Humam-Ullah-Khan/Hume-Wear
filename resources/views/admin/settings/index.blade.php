@extends('layouts.admin')

@section('title', 'Site Settings - Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-stone-800">Site Settings</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-stone-500 hover:text-stone-900 transition">← Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Hero Section Settings --}}
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-stone-800 mb-6">Hero Section</h2>

            {{-- Slide 1 --}}
            <div class="mb-8 pb-8 border-b border-stone-100">
                <h3 class="text-sm font-semibold text-stone-600 mb-4">Slide 1</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5">Image</label>
                        <input type="file" name="hero_image_1" accept="image/*" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        @if($settings['hero_image_1'])
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $settings['hero_image_1']) }}" class="h-20 rounded-lg object-cover">
                                <p class="text-xs text-stone-400 mt-1">Current image</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Title</label>
                            <input type="text" name="hero_title_1" value="{{ $settings['hero_title_1'] }}" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Subtitle</label>
                            <input type="text" name="hero_subtitle_1" value="{{ $settings['hero_subtitle_1'] }}" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="mb-8 pb-8 border-b border-stone-100">
                <h3 class="text-sm font-semibold text-stone-600 mb-4">Slide 2</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5">Image</label>
                        <input type="file" name="hero_image_2" accept="image/*" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        @if($settings['hero_image_2'])
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $settings['hero_image_2']) }}" class="h-20 rounded-lg object-cover">
                                <p class="text-xs text-stone-400 mt-1">Current image</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Title</label>
                            <input type="text" name="hero_title_2" value="{{ $settings['hero_title_2'] }}" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Subtitle</label>
                            <input type="text" name="hero_subtitle_2" value="{{ $settings['hero_subtitle_2'] }}" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div>
                <h3 class="text-sm font-semibold text-stone-600 mb-4">Slide 3</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-stone-600 mb-1.5">Image</label>
                        <input type="file" name="hero_image_3" accept="image/*" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        @if($settings['hero_image_3'])
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $settings['hero_image_3']) }}" class="h-20 rounded-lg object-cover">
                                <p class="text-xs text-stone-400 mt-1">Current image</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Title</label>
                            <input type="text" name="hero_title_3" value="{{ $settings['hero_title_3'] }}" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1.5">Subtitle</label>
                            <input type="text" name="hero_subtitle_3" value="{{ $settings['hero_subtitle_3'] }}" class="w-full px-4 py-2.5 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium">Save Settings</button>
        </div>
    </form>
</div>
@endsection
