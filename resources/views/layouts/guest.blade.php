<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
        <title>{{ config('app.name', 'Phantom 5') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen flex">
            {{-- Left brand panel (hidden on mobile) --}}
            <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">
                {{-- Background pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                {{-- Gradient overlay --}}
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-amber-900/30"></div>

                {{-- Content --}}
                <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                    {{-- Logo --}}
                    <div>
                        <a href="/" class="flex items-center gap-3">
                            @if(file_exists(public_path('img/logo.png')))
                                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
                            @endif
                            <span class="text-2xl font-bold text-white">Phantom <span class="text-amber-500">5</span></span>
                        </a>
                    </div>

                    {{-- Center message --}}
                    <div class="space-y-6">
                        <h1 class="text-4xl font-extrabold text-white leading-tight">
                            Your trusted<br>
                            <span class="text-amber-500">real estate</span><br>
                            marketplace.
                        </h1>
                        <p class="text-lg text-slate-300 max-w-md leading-relaxed">
                            Buy, sell, and discover properties, products, and services with confidence on Nigeria's growing marketplace.
                        </p>
                        <div class="flex items-center gap-6 pt-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">500+</div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider">Properties</div>
                            </div>
                            <div class="w-px h-10 bg-slate-700"></div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">200+</div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider">Merchants</div>
                            </div>
                            <div class="w-px h-10 bg-slate-700"></div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">1k+</div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider">Clients</div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Phantom 5 Realtors. All rights reserved.</p>
                </div>
            </div>

            {{-- Right form panel --}}
            <div class="w-full lg:w-1/2 flex flex-col">
                {{-- Mobile header --}}
                <div class="lg:hidden px-6 pt-8 pb-4">
                    <a href="/" class="flex items-center gap-2">
                        @if(file_exists(public_path('img/logo.png')))
                            <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="h-8 w-auto">
                        @endif
                        <span class="text-xl font-bold text-slate-900">Phantom <span class="text-amber-600">5</span></span>
                    </a>
                </div>

                {{-- Form container --}}
                <div class="flex-1 flex items-center justify-center px-6 py-8 sm:px-12">
                    <div class="w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
