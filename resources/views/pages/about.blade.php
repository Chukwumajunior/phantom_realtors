<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-900">About Us</h2>
    </x-slot>

    <!-- Hero Section -->
    <section class="relative py-12 sm:py-20 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=2070" class="w-full h-full object-cover" alt="About">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">About <span class="whitespace-nowrap">Phantom 5</span></h1>
            <p class="text-base sm:text-xl text-gray-300 max-w-2xl mx-auto">Building dreams, delivering excellence since day one.</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-10 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000" class="rounded-2xl shadow-xl w-full" alt="Interior">
                </div>
                <div>
                    <span class="text-amber-600 font-bold uppercase tracking-widest text-xs">Who We Are</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-4 mb-6">We specialize in connecting people with quality spaces</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Phantom 5 is a leading real estate and lifestyle company specializing in buying, selling, and renting quality homes. We also provide top-notch building products and professional services to help you create your perfect living space.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Our marketplace connects verified merchants with customers, ensuring quality products from electricals to furniture, and professional services from painting to full renovation work.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Based in Lagos, Nigeria, we are committed to transforming the real estate experience with transparency, quality, and exceptional customer service.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-10 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-amber-600">500+</div>
                    <p class="text-gray-600 mt-2 font-medium">Properties Listed</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-amber-600">200+</div>
                    <p class="text-gray-600 mt-2 font-medium">Happy Clients</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-amber-600">50+</div>
                    <p class="text-gray-600 mt-2 font-medium">Verified Merchants</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-amber-600">100%</div>
                    <p class="text-gray-600 mt-2 font-medium">Client Satisfaction</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-10 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Our Core Values</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">Guiding principles that drive everything we do</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-8 rounded-2xl bg-gray-50">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Trust & Transparency</h3>
                    <p class="text-gray-600">We verify all merchants and listings to ensure you get exactly what you see. No hidden fees, no surprises.</p>
                </div>

                <div class="text-center p-8 rounded-2xl bg-gray-50">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Quality First</h3>
                    <p class="text-gray-600">From properties to products, we curate only the best options to ensure lasting value and satisfaction.</p>
                </div>

                <div class="text-center p-8 rounded-2xl bg-gray-50">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Customer Focused</h3>
                    <p class="text-gray-600">Your satisfaction is our priority. Our team is dedicated to helping you find the perfect solution for your needs.</p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
