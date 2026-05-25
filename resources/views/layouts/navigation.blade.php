<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a wire:navigate href="{{ route('home') }}" class="text-xl font-bold text-amber-500">
                    Phantom 5
                </a>

                <div class="hidden sm:flex sm:ml-10 sm:space-x-6">
                    <a wire:navigate href="{{ route('home') }}" class="text-sm text-gray-300 hover:text-white transition {{ request()->routeIs('home') ? 'text-white' : '' }}">Home</a>
                    <a wire:navigate href="{{ route('properties.index') }}" class="text-sm text-gray-300 hover:text-white transition {{ request()->routeIs('properties.*') ? 'text-white' : '' }}">Properties</a>
                    <a wire:navigate href="{{ route('products.index') }}" class="text-sm text-gray-300 hover:text-white transition {{ request()->routeIs('products.*') ? 'text-white' : '' }}">Products</a>
                    <a wire:navigate href="{{ route('services.index') }}" class="text-sm text-gray-300 hover:text-white transition {{ request()->routeIs('services.*') ? 'text-white' : '' }}">Services</a>
                    <a wire:navigate href="{{ route('about') }}" class="text-sm text-gray-300 hover:text-white transition {{ request()->routeIs('about') ? 'text-white' : '' }}">About</a>
                    <a wire:navigate href="{{ route('contact') }}" class="text-sm text-gray-300 hover:text-white transition {{ request()->routeIs('contact') ? 'text-white' : '' }}">Contact</a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                @auth
                    @if(Auth::user()->isCustomer() || Auth::user()->isMerchant())
                    <a wire:navigate href="{{ route('customer.orders.index') }}" class="relative p-2 text-gray-300 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        @php $pendingOrdersCount = Auth::user()->orders()->whereIn('status', ['pending'])->count(); @endphp
                        @if($pendingOrdersCount > 0)
                        <span class="absolute -top-1 -right-1 bg-amber-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">{{ $pendingOrdersCount }}</span>
                        @endif
                    </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-white rounded-lg hover:bg-slate-800 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->isAdmin())
                                <x-dropdown-link wire:navigate :href="route('admin.dashboard')">Admin Dashboard</x-dropdown-link>
                                <x-dropdown-link wire:navigate :href="route('admin.settings.index')">Site Settings</x-dropdown-link>
                            @endif

                            @if(Auth::user()->isMerchant())
                                <x-dropdown-link wire:navigate :href="route('merchant.dashboard')">Merchant Dashboard</x-dropdown-link>
                                <x-dropdown-link wire:navigate :href="route('merchant.subscription.index')">Subscription</x-dropdown-link>
                            @endif

                            @if(Auth::user()->isCustomer() || Auth::user()->isMerchant())
                                <x-dropdown-link wire:navigate :href="route('customer.orders.index')">My Orders</x-dropdown-link>
                            @endif

                            @if(Auth::user()->isCustomer())
                                <x-dropdown-link wire:navigate :href="route('become-seller')">Become a Seller</x-dropdown-link>
                            @endif

                            <x-dropdown-link wire:navigate :href="route('profile.edit')">Profile</x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a wire:navigate href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white transition">Log in</a>
                    <a wire:navigate href="{{ route('register') }}" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">Register</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-400 hover:text-white rounded-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-slate-800">
        <div class="px-4 py-3 space-y-2">
            <a wire:navigate href="{{ route('home') }}" class="block text-sm text-gray-300 hover:text-white py-1">Home</a>
            <a wire:navigate href="{{ route('properties.index') }}" class="block text-sm text-gray-300 hover:text-white py-1">Properties</a>
            <a wire:navigate href="{{ route('products.index') }}" class="block text-sm text-gray-300 hover:text-white py-1">Products</a>
            <a wire:navigate href="{{ route('services.index') }}" class="block text-sm text-gray-300 hover:text-white py-1">Services</a>
            <a wire:navigate href="{{ route('about') }}" class="block text-sm text-gray-300 hover:text-white py-1">About</a>
            <a wire:navigate href="{{ route('contact') }}" class="block text-sm text-gray-300 hover:text-white py-1">Contact</a>
        </div>
        <div class="px-4 py-3 border-t border-slate-700">
            @auth
                <p class="text-sm text-gray-400 mb-2">{{ Auth::user()->name }}</p>
                @if(Auth::user()->isAdmin())
                    <a wire:navigate href="{{ route('admin.dashboard') }}" class="block text-sm text-gray-300 hover:text-white py-1">Admin Dashboard</a>
                    <a wire:navigate href="{{ route('admin.settings.index') }}" class="block text-sm text-gray-300 hover:text-white py-1">Site Settings</a>
                @endif
                @if(Auth::user()->isMerchant())
                    <a wire:navigate href="{{ route('merchant.dashboard') }}" class="block text-sm text-gray-300 hover:text-white py-1">Merchant Dashboard</a>
                    <a wire:navigate href="{{ route('merchant.subscription.index') }}" class="block text-sm text-gray-300 hover:text-white py-1">Subscription</a>
                @endif
                @if(Auth::user()->isCustomer())
                    <a wire:navigate href="{{ route('customer.orders.index') }}" class="block text-sm text-gray-300 hover:text-white py-1">My Orders</a>
                    <a wire:navigate href="{{ route('become-seller') }}" class="block text-sm text-amber-500 hover:text-amber-400 py-1">Become a Seller</a>
                @endif
                <a wire:navigate href="{{ route('profile.edit') }}" class="block text-sm text-gray-300 hover:text-white py-1">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-sm text-gray-300 hover:text-white py-1">Log Out</button>
                </form>
            @else
                <a wire:navigate href="{{ route('login') }}" class="block text-sm text-gray-300 hover:text-white py-1">Log in</a>
                <a wire:navigate href="{{ route('register') }}" class="block text-sm text-amber-500 hover:text-amber-400 py-1 font-medium">Register</a>
            @endauth
        </div>
    </div>
</nav>
