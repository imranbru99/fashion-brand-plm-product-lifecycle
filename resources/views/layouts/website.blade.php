<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Fashion Brand PLM — From Design to Production. Enterprise multi-tenant SaaS platform for the global fashion and apparel industry.')">
    <title>@yield('title', 'Fashion Brand PLM') — Design to Production</title>

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Fashion Brand PLM')">
    <meta property="og:description" content="@yield('meta_description', 'Enterprise Fashion PLM & ERP Platform')">
    <meta property="og:type" content="website">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: 109 40 217; /* violet-700 */
        }
        .gradient-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4c1d95 60%, #6d28d9 100%);
        }
        .gradient-card {
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #7c3aed, #c026d3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-blur {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 nav-blur bg-white/90 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-violet-700 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gray-900">Fashion Brand <span class="text-violet-700">PLM</span></span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('features') }}" class="text-gray-600 hover:text-violet-700 transition text-sm font-medium">Features</a>
                    <a href="{{ route('modules') }}" class="text-gray-600 hover:text-violet-700 transition text-sm font-medium">Modules</a>
                    <a href="{{ route('solutions') }}" class="text-gray-600 hover:text-violet-700 transition text-sm font-medium">Solutions</a>
                    <a href="{{ route('pricing') }}" class="text-gray-600 hover:text-violet-700 transition text-sm font-medium">Pricing</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-violet-700 transition text-sm font-medium">About</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center space-x-3">
                    <a href="{{ route('filament.admin.auth.login') }}" class="text-sm font-medium text-gray-600 hover:text-violet-700 transition">Sign In</a>
                    <a href="{{ route('pricing') }}" class="bg-violet-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-violet-800 transition">
                        Get Started
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition" id="mobile-menu-btn">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div class="lg:hidden hidden pb-4" id="mobile-menu">
                <div class="pt-2 space-y-1">
                    <a href="{{ route('features') }}" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-violet-50 hover:text-violet-700">Features</a>
                    <a href="{{ route('modules') }}" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-violet-50 hover:text-violet-700">Modules</a>
                    <a href="{{ route('solutions') }}" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-violet-50 hover:text-violet-700">Solutions</a>
                    <a href="{{ route('pricing') }}" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-violet-50 hover:text-violet-700">Pricing</a>
                    <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-violet-50 hover:text-violet-700">About</a>
                    <div class="pt-2 border-t border-gray-100 mt-2">
                        <a href="{{ route('filament.admin.auth.login') }}" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-violet-50">Sign In</a>
                        <a href="{{ route('pricing') }}" class="block px-3 py-2 rounded-md bg-violet-700 text-white mt-1 text-center">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-violet-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-white">Fashion Brand PLM</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-4">
                        Enterprise multi-tenant SaaS platform for the global fashion and apparel industry. Design to Production — in one platform.
                    </p>
                    <p class="text-xs text-gray-500">Built by <a href="https://imrandev.bd" class="hover:text-violet-400 transition">Imran Ahmed</a></p>
                </div>

                <!-- Product -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Platform</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('features') }}" class="hover:text-violet-400 transition">Features</a></li>
                        <li><a href="{{ route('modules') }}" class="hover:text-violet-400 transition">All Modules</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-violet-400 transition">Pricing</a></li>
                        <li><a href="{{ route('solutions') }}" class="hover:text-violet-400 transition">Solutions</a></li>
                        <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="hover:text-violet-400 transition">Demo Dashboard</a></li>
                    </ul>
                </div>

                <!-- Solutions -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Solutions</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('solutions') }}#fashion-brands" class="hover:text-violet-400 transition">Fashion Brands</a></li>
                        <li><a href="{{ route('solutions') }}#manufacturers" class="hover:text-violet-400 transition">Garment Manufacturers</a></li>
                        <li><a href="{{ route('solutions') }}#startups" class="hover:text-violet-400 transition">Fashion Startups</a></li>
                        <li><a href="{{ route('solutions') }}#suppliers" class="hover:text-violet-400 transition">Textile Suppliers</a></li>
                        <li><a href="{{ route('solutions') }}#sourcing" class="hover:text-violet-400 transition">Sourcing Agencies</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Company</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-violet-400 transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-violet-400 transition">Contact</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-violet-400 transition">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-violet-400 transition">Terms of Service</a></li>
                        <li><a href="{{ route('security') }}" class="hover:text-violet-400 transition">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">© {{ date('Y') }} Fashion Brand PLM. All rights reserved.</p>
                <div class="flex items-center space-x-6 mt-4 md:mt-0">
                    <span class="text-xs text-gray-600">🌐 Multi-Tenant SaaS</span>
                    <span class="text-xs text-gray-600">🔒 Enterprise Security</span>
                    <span class="text-xs text-gray-600">🤖 AI-Powered</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
