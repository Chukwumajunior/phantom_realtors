<footer class="bg-slate-900 text-gray-400 py-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h4 class="text-amber-500 text-lg font-bold mb-4">Phantom 5</h4>
                <p class="text-sm">Your one-stop destination for quality homes, building solutions, and modern living.</p>
            </div>
            <div>
                <h4 class="text-white text-sm font-semibold uppercase mb-4">Explore</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('properties.index') }}" class="hover:text-white transition">Properties</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Products</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-white transition">Services</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white text-sm font-semibold uppercase mb-4">Contact</h4>
                <ul class="space-y-2 text-sm">
                    <li>Phone: 07019449840</li>
                    <li>Email: phantom5realt@gmail.com</li>
                    <li>No.9 Ireku Street, Oworoshoki, Kosofe, Lagos.</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white text-sm font-semibold uppercase mb-4">For Merchants</h4>
                <p class="text-sm mb-3">Register as a merchant to list your properties, products, and services on our platform.</p>
                <a href="{{ route('register') }}" class="inline-block px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">
                    Get Started
                </a>
            </div>
        </div>

        {{-- User Guide - only for logged in users --}}
        @auth
        <div class="mt-10 pt-6 border-t border-slate-800" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-amber-500 hover:text-amber-400 transition text-sm font-semibold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                How to Use Phantom 5
                <svg class="w-4 h-4 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="open" x-collapse>
                @if(Auth::user()->isAdmin())
                {{-- Admin Guide --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Admin Dashboard
                        </h5>
                        <p class="text-gray-400 leading-relaxed">View platform statistics, pending merchant applications, payment confirmations, and recent orders all in one place. Access it from your profile dropdown.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Merchant Applications
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Review and approve or reject merchant applications from the Merchants section. You can view their passport photo, business details, and payment proof before making a decision.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700 md:col-span-2 lg:col-span-3">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Site Settings
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                            <div>
                                <h6 class="text-gray-300 font-medium mb-1">Bank Details</h6>
                                <p class="text-gray-400 leading-relaxed">Set the bank name, account name, and account number displayed to merchants when paying for subscriptions and to customers when paying for orders.</p>
                            </div>
                            <div>
                                <h6 class="text-gray-300 font-medium mb-1">Subscription Plans</h6>
                                <p class="text-gray-400 leading-relaxed">Create, edit, or delete plans. Each plan has a name, price (NGN), and duration (days). Toggle "Active" to show/hide a plan. Check "Premium" to grant home page featured listing benefits to subscribers of that plan.</p>
                            </div>
                            <div>
                                <h6 class="text-gray-300 font-medium mb-1">Featured Listings</h6>
                                <p class="text-gray-400 leading-relaxed">Control the home page carousel. "Max Per Merchant" limits how many listings are pulled from each premium merchant. "Rotation Interval" sets seconds between slides. "Per Slide" controls total items shown, and "Per Row" sets columns per row (e.g., 8 per slide with 4 per row = 2 rows of 4).</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Post Listings
                        </h5>
                        <p class="text-gray-400 leading-relaxed">As admin, you can post properties, products, and services directly from the Merchant Dashboard. Your listings are automatically featured on the home page without needing a subscription.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Payments & Orders
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Confirm or reject payment proofs submitted by customers. Manage all orders across the platform and update order statuses from the Orders section.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            User Management
                        </h5>
                        <p class="text-gray-400 leading-relaxed">View all registered users, suspend or unsuspend accounts, and manage subscriptions. Monitor active and expiring subscriptions from the admin dashboard.</p>
                    </div>
                </div>

                @elseif(Auth::user()->isMerchant())
                {{-- Merchant Guide --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Merchant Dashboard
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Your central hub for managing listings, viewing order statistics, and tracking your subscription status. Access it from the profile dropdown menu.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Create Listings
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Add properties, products, or services from your Merchant Dashboard. Upload images, set prices, and provide descriptions. An active subscription is required to create or edit listings.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            Subscription
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Choose a plan: Monthly, Yearly, or Premium Yearly. Premium subscribers get their listings featured on the home page. Renew before expiry to keep your listings active and visible.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Manage Orders
                        </h5>
                        <p class="text-gray-400 leading-relaxed">View and manage orders placed by customers for your listings. Track order statuses and coordinate with buyers from the Orders section in your Merchant Dashboard.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            Premium Featured
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Upgrade to the Premium Yearly plan to get your listings automatically rotated on the home page. Your latest listings will be showcased to all visitors, giving you maximum visibility.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Business Profile
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Keep your business profile up to date with your business name, description, and contact details. Customers see this information when viewing your listings.</p>
                    </div>
                </div>

                @else
                {{-- Customer/Buyer Guide --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Browse Listings
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Explore properties for sale or rent, building products, and professional services. Use the category filters and search to find exactly what you need.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Place Orders
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Found something you like? Place an order directly from the listing page. Specify the quantity, add any notes, and submit your order to the merchant.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Make Payment
                        </h5>
                        <p class="text-gray-400 leading-relaxed">After placing an order, transfer payment to the provided bank account and upload your payment proof. The admin will verify and confirm your payment.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Track Orders
                        </h5>
                        <p class="text-gray-400 leading-relaxed">View all your orders and their current status from "My Orders" in the profile dropdown. You can see payment status, order details, and cancel pending orders if needed.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Contact Merchants
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Have questions about a listing? Use the inquiry form on any listing page to send a message directly to the merchant. You can also reach us through the Contact page.</p>
                    </div>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Become a Seller
                        </h5>
                        <p class="text-gray-400 leading-relaxed">Want to sell on Phantom 5? Click "Become a Seller" in the profile dropdown, fill in your business details, upload your passport photo, and submit your application for approval.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endauth

        <div class="mt-10 pt-6 border-t border-slate-800 text-center text-sm">
            <p>&copy; {{ date('Y') }} Phantom 5. All rights reserved.</p>
        </div>
    </div>
</footer>
