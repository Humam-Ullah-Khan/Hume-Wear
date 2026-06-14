@extends('layouts.app')

@section('title', 'Contact Us - Hume Wear')

@section('content')
<section class="pt-32 pb-16 bg-[#fafaf9]">
    <div class="max-w-[1400px] mx-auto px-6">

        {{-- Page Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-stone-900 mb-4">Get In Touch</h1>
            <p class="text-stone-500 text-lg max-w-xl mx-auto">Have a question or want to place an order? We'd love to hear from you.</p>
        </div>

        {{-- Main Content --}}
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-start">

            {{-- Left Column: Image + Contact Info --}}
            <div class="w-full lg:w-5/12">

                {{-- Image Card --}}
                <div class="rounded-2xl overflow-hidden mb-8 shadow-sm">
                    <img src="{{ asset('images/contact-us-page-banner.jpg') }}" alt="Contact Hume Wear" class="w-full h-[320px] md:h-[400px] object-cover">
                </div>

                {{-- Contact Info Cards --}}
                <div class="space-y-4">

                    {{-- Email --}}
                    <div class="flex items-center gap-4 bg-white rounded-xl p-5 shadow-sm border border-stone-100 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-full bg-stone-100 flex items-center justify-center flex-shrink-0 group-hover:bg-stone-900 transition">
                            <svg class="w-5 h-5 text-stone-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-stone-400 uppercase tracking-wider mb-0.5">Email</p>
                            <a href="mailto:humamullahkhan001@gmail.com" class="text-sm font-semibold text-stone-800 hover:text-stone-900 transition">humamullahkhan001@gmail.com</a>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="flex items-center gap-4 bg-white rounded-xl p-5 shadow-sm border border-stone-100 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-full bg-stone-100 flex items-center justify-center flex-shrink-0 group-hover:bg-stone-900 transition">
                            <svg class="w-5 h-5 text-stone-600 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-stone-400 uppercase tracking-wider mb-0.5">WhatsApp</p>
                            <a href="https://wa.me/923231256645" target="_blank" class="text-sm font-semibold text-stone-800 hover:text-stone-900 transition">+92 323 12 56 645</a>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="flex items-center gap-4 bg-white rounded-xl p-5 shadow-sm border border-stone-100 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-full bg-stone-100 flex items-center justify-center flex-shrink-0 group-hover:bg-stone-900 transition">
                            <svg class="w-5 h-5 text-stone-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-stone-400 uppercase tracking-wider mb-0.5">Location</p>
                            <p class="text-sm font-semibold text-stone-800">Online Business</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Right Column: Contact Form --}}
            <div class="w-full lg:w-7/12">
                <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-stone-100">
                    <h2 class="text-2xl font-bold text-stone-900 mb-2">Send Us a Message</h2>
                    <p class="text-stone-500 mb-8">Fill out the form below and we'll get back to you shortly.</p>

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            {{-- First Name --}}
                            <div>
                                <label class="block text-sm font-medium text-stone-700 mb-1.5">First name</label>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="First name"
                                    class="w-full px-4 py-3 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-stone-900 focus:border-transparent text-sm transition placeholder:text-stone-400 @error('name') border-red-400 @enderror">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@company.com"
                                    class="w-full px-4 py-3 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-stone-900 focus:border-transparent text-sm transition placeholder:text-stone-400 @error('email') border-red-400 @enderror">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Phone number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+92 323 12 56 645"
                                class="w-full px-4 py-3 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-stone-900 focus:border-transparent text-sm transition placeholder:text-stone-400 @error('phone') border-red-400 @enderror">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Message</label>
                            <textarea name="message" rows="5" required placeholder="Leave us a message..."
                                class="w-full px-4 py-3 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-stone-900 focus:border-transparent text-sm transition resize-none placeholder:text-stone-400 @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full bg-stone-900 text-white py-3.5 rounded-xl hover:bg-stone-800 transition text-sm font-semibold tracking-wide">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    (function() {
        var nav = document.getElementById('main-nav');
        if (nav) {
            nav.dataset.alwaysScrolled = '';
            nav.classList.remove('at-top');
            nav.classList.add('scrolled');
            var topBar = document.getElementById('top-bar');
            if (topBar) topBar.classList.add('hidden-bar');
        }
        document.querySelectorAll('.nav-text').forEach(function(el) {
            el.classList.remove('text-white');
            el.classList.add('text-stone-900');
        });
        document.querySelectorAll('.nav-icon').forEach(function(el) {
            el.classList.remove('text-white');
            el.classList.add('text-stone-900');
        });
    })();
</script>
@endsection
