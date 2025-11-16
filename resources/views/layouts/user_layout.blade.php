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
<body class="font-sans bg-gray-50 text-gray-800 antialiased">

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
                    {{ Auth::user()->name }}
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </button>

                <div id="user-menu-dropdown" 
                     class="hidden absolute right-0 mt-3 w-48 bg-white rounded-lg shadow-xl ring-1 ring-slate-300 ring-opacity-5 z-50 overflow-hidden origin-top-right">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yum-primary" role="menuitem">
                            My Profile
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yum-primary" role="menuitem">
                            Order History
                        </a>
                        
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

        <h2 class="text-white text-2xl font-bold mb-8 relative z-10">Berikan <span class="text-yum-yellow">ulasanmu</span> disini!</h2>
        
        <div class="max-w-2xl mx-auto px-6 relative z-10">
            <div class="flex gap-3 mb-4">
                <input type="email" placeholder="Masukkan email kamu" class="flex-1 rounded-lg px-5 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-yum-yellow border-none shadow-lg text-sm">
                <button class="bg-yum-yellow text-black font-bold px-8 py-3 rounded-lg hover:bg-yellow-300 shadow-lg transition transform hover:-translate-y-0.5">Kirim</button>
            </div>
            <textarea class="w-full rounded-lg px-5 py-4 h-32 bg-white focus:outline-none focus:ring-2 focus:ring-yum-yellow border-none shadow-lg text-sm resize-none" placeholder="Tulis kritik dan saran disini..."></textarea>
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