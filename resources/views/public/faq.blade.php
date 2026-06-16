@extends('layouts.app')

@section('title', 'FAQs - Humam Élite')

@section('content')
<div class="max-w-[1000px] mx-auto px-6 pt-32 pb-20">

    {{-- Header --}}
    <div class="text-center mb-14">
        <h1 class="text-4xl md:text-5xl font-bold text-stone-900 mb-4">Frequently Asked Questions</h1>
        <p class="text-stone-500 text-lg max-w-xl mx-auto">Everything you need to know before placing your order.</p>
    </div>

    {{-- Categories --}}
    <div class="flex flex-wrap justify-center gap-2 mb-12">
        <button onclick="filterFaq('all')" class="faq-filter px-5 py-2 text-sm rounded-full border transition bg-stone-900 text-white border-stone-900" data-filter="all">All</button>
        <button onclick="filterFaq('orders')" class="faq-filter px-5 py-2 text-sm rounded-full border border-stone-200 text-stone-600 hover:border-stone-400 transition" data-filter="orders">Orders</button>
        <button onclick="filterFaq('shipping')" class="faq-filter px-5 py-2 text-sm rounded-full border border-stone-200 text-stone-600 hover:border-stone-400 transition" data-filter="shipping">Shipping</button>
        <button onclick="filterFaq('returns')" class="faq-filter px-5 py-2 text-sm rounded-full border border-stone-200 text-stone-600 hover:border-stone-400 transition" data-filter="returns">Returns</button>
        <button onclick="filterFaq('payment')" class="faq-filter px-5 py-2 text-sm rounded-full border border-stone-200 text-stone-600 hover:border-stone-400 transition" data-filter="payment">Payment</button>
        <button onclick="filterFaq('products')" class="faq-filter px-5 py-2 text-sm rounded-full border border-stone-200 text-stone-600 hover:border-stone-400 transition" data-filter="products">Products</button>
    </div>

    {{-- FAQ Items --}}
    <div class="space-y-3" id="faq-list">
        @php
            $faqs = [
                ['q' => 'How do I place an order?', 'a' => 'Simply browse our collection, select your desired product, choose your preferred size/color, and click "Order on WhatsApp". You\'ll be redirected to WhatsApp with a pre-filled message about your product.', 'cat' => 'orders'],
                ['q' => 'Can I modify or cancel my order after placing it?', 'a' => 'Please contact us via WhatsApp as soon as possible if you need to modify or cancel your order. We\'ll do our best to accommodate changes before the order is processed for shipping.', 'cat' => 'orders'],
                ['q' => 'How long does it take to process my order?', 'a' => 'Orders are typically processed within 1-2 business days. You will receive a confirmation message once your order has been processed.', 'cat' => 'orders'],
                ['q' => 'What payment methods do you accept?', 'a' => 'We accept Bank Transfer, EasyPaisa, and JazzCash. Payment details will be shared with you via WhatsApp after you place your order.', 'cat' => 'payment'],
                ['q' => 'Is there a minimum order value?', 'a' => 'No, there is no minimum order value. You can order any product regardless of the total amount.', 'cat' => 'payment'],
                ['q' => 'How much do you charge for delivery?', 'a' => 'Delivery charges vary depending on your location and the size of your order. The exact charges will be communicated to you after you place your order.', 'cat' => 'shipping'],
                ['q' => 'How long does delivery take?', 'a' => 'Delivery typically takes 3-7 business days depending on your location. We aim to deliver as quickly as possible.', 'cat' => 'shipping'],
                ['q' => 'Do you offer international shipping?', 'a' => 'Currently, we only deliver within Pakistan. We are working on expanding internationally in the future.', 'cat' => 'shipping'],
                ['q' => 'What is your return policy?', 'a' => 'We accept returns within 7 days of delivery, provided the product is unused and in its original packaging. Please contact us via WhatsApp to initiate a return.', 'cat' => 'returns'],
                ['q' => 'How do I initiate a return or exchange?', 'a' => 'Message us on WhatsApp with your order number and reason for return/exchange. Our team will guide you through the process.', 'cat' => 'returns'],
                ['q' => 'Will I get a refund if I return a product?', 'a' => 'Yes, once the returned product is received and inspected, we will process your refund within 3-5 business days. Shipping charges are non-refundable.', 'cat' => 'returns'],
                ['q' => 'Are the product colors accurate in photos?', 'a' => 'We strive to display product colors as accurately as possible. However, slight variations may occur due to screen settings and lighting conditions.', 'cat' => 'products'],
                ['q' => 'How do I know which size to choose?', 'a' => 'Each product page includes size details. If you are unsure about sizing, feel free to contact us on WhatsApp and we\'ll help you choose the perfect fit.', 'cat' => 'products'],
                ['q' => 'Can I pre-order sold-out items?', 'a' => 'Some items may be available for pre-order. Contact us on WhatsApp to check availability and estimated restock timelines.', 'cat' => 'products'],
            ];
        @endphp

        @foreach($faqs as $faq)
        <div class="faq-item bg-white border border-stone-200 rounded-xl overflow-hidden" data-category="{{ $faq['cat'] }}">
            <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-6 py-5 text-left transition hover:bg-stone-50">
                <span class="text-sm font-medium text-stone-800 pr-4">{{ $faq['q'] }}</span>
                <svg class="faq-chevron w-4 h-4 text-stone-400 shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                <div class="px-6 pb-5 text-sm text-stone-500 leading-relaxed">{{ $faq['a'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Still have questions --}}
    <div class="text-center mt-14 p-10 bg-stone-50 rounded-2xl border border-stone-100">
        <h2 class="text-xl font-bold text-stone-900 mb-2">Still have questions?</h2>
        <p class="text-stone-500 text-sm mb-6">We're here to help. Reach out to us anytime.</p>
        <a href="{{ url('/contact') }}" class="btn-hover inline-block bg-stone-900 hover:bg-stone-800 text-white px-8 py-3 rounded-xl text-sm font-semibold tracking-wide transition">Contact Us</a>
        @if($siteSettings['whatsapp'])
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp']) }}" target="_blank" class="btn-hover inline-block bg-[#25D366] hover:bg-[#20bd5a] text-white px-8 py-3 rounded-xl text-sm font-semibold tracking-wide transition ml-3">WhatsApp</a>
        @endif
    </div>
</div>

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

    function toggleFaq(btn) {
        var item = btn.parentElement;
        var answer = item.querySelector('.faq-answer');
        var chevron = item.querySelector('.faq-chevron');
        var isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

        // Close all
        document.querySelectorAll('.faq-item').forEach(function(el) {
            el.querySelector('.faq-answer').style.maxHeight = '0px';
            el.querySelector('.faq-chevron').classList.remove('rotate-180');
        });

        if (!isOpen) {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            chevron.classList.add('rotate-180');
        }
    }

    function filterFaq(category) {
        document.querySelectorAll('.faq-filter').forEach(function(btn) {
            var filter = btn.dataset.filter;
            if (filter === category) {
                btn.classList.add('bg-stone-900', 'text-white', 'border-stone-900');
                btn.classList.remove('text-stone-600', 'border-stone-200');
            } else {
                btn.classList.remove('bg-stone-900', 'text-white', 'border-stone-900');
                btn.classList.add('text-stone-600', 'border-stone-200');
            }
        });

        document.querySelectorAll('.faq-item').forEach(function(item) {
            var cat = item.dataset.category;
            if (category === 'all' || cat === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection
