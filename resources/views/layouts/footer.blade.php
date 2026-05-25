<footer class="bg-slate-900 text-gray-400 py-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h4 class="text-amber-500 text-lg font-bold mb-4">Phantom 5</h4>
                <p class="text-sm">Your one-stop destination for quality homes, building solutions, and modern living.</p>
                <div class="mt-5 pt-3 border-t border-slate-800 text-sm">
                    @auth
                        <a href="{{ route('user-guide') }}" class="text-gray-500 hover:text-amber-500 transition mt-1 inline-block">How to use Phantom 5</a>
                    @endauth
                </div>
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
                    <li>Email: info@phantom5.com.ng</li>
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
        <div class="mt-10 pt-6 border-t border-slate-800 text-center text-sm">
            <p>&copy; {{ date('Y') }} Phantom 5. All rights reserved.</p>
        </div>
    </div>
</footer>
