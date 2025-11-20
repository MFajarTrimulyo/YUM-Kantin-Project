<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YUM - Kantin UM</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-50 text-gray-800 antialiased"
        data-success-message="{{ session('success') }}"
        data-error-message="{{ session('error') }}">

    <div id="page-loader" class="fixed inset-0 z-9999 bg-white/90 hidden flex-col items-center justify-center transition-opacity duration-300">
        <svg class="animate-spin h-8 w-8 text-yum-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
    </div>

    <nav class="bg-white py-4 px-6 shadow-sm flex justify-between items-center sticky top-0 z-50 rounded-b-xl">
        <!-- Logo -->
        <a href="/" class="text-2xl select-none font-bold">
            <span class="font-fredoka text-yum-primary">Y</span><span class="font-fredoka text-yum-yellow">U</span><span class="font-fredoka text-black">M</span>
        </a>
        
        <!-- Nav Icons -->
        <div class="flex items-center space-x-6 text-gray-700">

            @auth
            {{-- Cart --}}
            <button class="hover:text-yum-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>

            {{-- Notification Dropdown --}}
            {{-- <div class="relative">
                <button id="notification-button" class="relative hover:text-yum-primary transition flex items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>

                <div id="notification-dropdown" 
                     class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl ring-1 ring-slate-300 ring-opacity-5 z-50 overflow-hidden origin-top-right">
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                        <span class="text-[10px] bg-yum-primary/10 text-yum-primary px-2 py-0.5 rounded-full font-bold">2 Baru</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 group">
                            <div class="flex items-start">
                                <div class="bg-green-100 text-green-600 p-1.5 rounded-full mr-3 shrink-0 group-hover:bg-green-200 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Pesanan Selesai!</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Takoyaki kamu sudah siap diambil.</p>
                                    <p class="text-[10px] text-gray-400 mt-1">2 menit yang lalu</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <a href="#" class="block bg-gray-50 py-2 text-center text-xs font-bold text-yum-primary hover:text-yum-dark transition">
                        Lihat Semua
                    </a>
                </div>
            </div> --}}
        
            {{-- User Menu --}}
            <div class="relative">
                <button id="user-menu-button" class="flex items-center font-bold cursor-pointer hover:text-yum-primary transition">
                    @if(Auth::user()->photo == null)
                        <span class="border border-gray-200 rounded-full w-8 h-8 flex items-center justify-center">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </span>
                    @else
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-8 h-8 border border-gray-200 object-cover rounded-full">
                    @endif
                </button>

                <div id="user-menu-dropdown" 
                        class="hidden absolute right-0 mt-3 w-48 bg-white rounded-lg shadow-xl ring-1 ring-slate-300 ring-opacity-5 z-50 overflow-hidden origin-top-right">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                        <a href="{{ route('profile.edit', ['username' => Auth::user()->username]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yum-primary" role="menuitem">
                            My Profile
                        </a>
                        
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yum-primary" role="menuitem">
                            Order History
                        </a>

                        <hr class="text-gray-300">

                        {{-- ADMIN & GERAI PAGE --}}
                        @if (auth()->user()->role == 'penjual')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yum-primary" role="menuitem">
                                Kelola Gerai
                            </a>
                        @elseif (auth()->user()->role == 'admin')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yum-primary" role="menuitem">
                                Kelola Admin
                            </a>
                        @endif

                        {{-- LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:font-bold" role="menuitem">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @else
            <a href="{{ route('login') }}" class="text-sm font-bold hover:text-yum-primary transition">Login</a>
            <a href="{{ route('register') }}" class="text-sm font-bold bg-yum-primary text-white px-4 py-2 rounded-md hover:bg-yum-dark transition">
                Register
            </a>
            @endauth
        </div>
    </nav>

    <main class="min-h-[70vh]">
        @yield('content')
    </main>

    <footer class="bg-yum-primary py-16 text-center relative overflow-hidden">
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[120%] h-32 bg-white/10 rounded-b-[100%]"></div>

        @yield('footer-feedback')

        <div class="container mx-auto px-6">
            <hr class="border-white/20 mt-12 mb-12">
        </div>

        <div class="relative z-10 container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
            
            <div class="md:col-span-1">
                <div class="text-3xl font-bold mb-4">
                    <span class="font-fredoka text-white">Y</span><span class="font-fredoka text-yum-yellow">U</span><span class="font-fredoka text-black">M</span>
                </div>
                <p class="text-white/80 leading-relaxed mb-6">
                    Solusi kantin digital Universitas Negeri Malang. Pesan makan tanpa antre, kenyang tanpa ribet.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4 text-yum-yellow">Navigasi</h3>
                <ul class="space-y-2 text-white/80">
                    <li><a href="{{ route('home') }}" class="hover:text-white hover:underline">Home</a></li>
                    <li><a href="{{ route('menu.index') }}" class="hover:text-white hover:underline">List Menu</a></li>
                    <li><a href="#" class="hover:text-white hover:underline">List Kantin</a></li>
                    <li><a href="#" class="hover:text-white hover:underline">Tentang Kami</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h3 class="text-lg font-bold mb-4 text-yum-yellow">Kontak Kami</h3>
                <ul class="space-y-3 text-white/80">
                    <li class="flex items-start justify-center md:justify-start">
                        <svg class="w-5 h-5 mr-2 text-yum-yellow shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Universitas Negeri Malang, Jl. Semarang No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145</span>
                    </li>
                    <li class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 mr-2 text-yum-yellow shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>muhammad.fajar.2405336@students.um.ac.id</span>
                    </li>
                    <li class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 mr-2 text-yum-yellow shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>+62 881-0363-35536</span>
                    </li>
                </ul>
            </div>
    </footer>
    
    <div class="bg-white py-6 text-center text-gray-500 text-xs border-t border-gray-100">
        <div class="flex items-center justify-center gap-1">
            <span class="font-fredoka text-lg font-bold text-yum-primary">Y</span><span class="font-fredoka text-lg font-bold text-yum-yellow">U</span><span class="font-fredoka text-lg font-bold text-black">M</span> 
            <span>&copy; {{ now()->year }} All Rights Reserved.</span>
        </div>
    </div>

</body>
</html>