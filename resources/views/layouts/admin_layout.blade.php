<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YUM</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

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

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col z-10">
            
            <!-- Logo Area -->
            <div class="h-16 flex items-center justify-center border-b border-gray-100">
                <a href="/" class="text-3xl select-none font-bold">
                    <span class="font-fredoka text-yum-primary">Y</span><span class="font-fredoka text-yum-yellow">U</span><span class="font-fredoka text-black">M</span>
                    <span class="text-xs text-gray-400 font-normal ml-1 tracking-wider">
                        @if (Auth::user()->role == 'admin')
                                ADMIN
                            @elseif(Auth::user()->role == 'penjual')
                                GERAI
                            @endif
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-3">
                    
                    @if (Auth::user()->role == 'penjual' || Auth::user()->role == 'admin')
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3
                            {{ request()->routeIs('dashboard') 
                            ? 'bg-yum-primary/10 text-yum-primary font-bold' 
                            : 'text-gray-600 hover:bg-gray-50 hover:text-yum-primary font-medium'}} rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Dashboard
                            </a>
                        </li>

                        @if (Auth::user()->role == 'admin')
                            <!-- Kelola Kategori Menu -->
                            <li>
                                <a href="{{ route('kategoris.index') }}" class="flex items-center px-4 py-3 
                                {{ request()->routeIs('kategoris.index') 
                                ? 'bg-yum-primary/10 text-yum-primary font-bold' 
                                : 'text-gray-600 hover:bg-gray-50 hover:text-yum-primary font-medium'}} rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Kelola Kategori Menu
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->role == 'penjual')
                            <!-- Profile Gerai -->
                            <li>
                                <a href="{{ route('gerai.create') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-yum-primary rounded-lg font-medium transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                    </svg>
                                    Profile Gerai
                                </a>
                            </li>
                        @endif

                        <!-- Kelola Menu -->
                        <li>
                            <a href="{{ route('produk.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-yum-primary rounded-lg font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Kelola Menu
                            </a>
                        </li>

                        @if (Auth::user()->role == 'admin')
                            <!-- Users -->
                            <li>
                                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-yum-primary rounded-lg font-medium transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Data User
                                </a>
                            </li>
                            
                            <!-- Kantin -->
                            <li>
                                <a href="{{ route('kantins.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-yum-primary rounded-lg font-medium transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Data Kantin
                                </a>
                            </li>

                            <!-- Gerai -->
                            <li>
                                <a href="{{ route('admin.gerai.index') }}" class="flex items-center px-4 py-3 
                                {{ request()->routeIs('admin.gerai.index') ? 'bg-yum-primary/10 text-yum-primary font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-yum-primary font-medium' }} 
                                rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Data Gerai
                                </a>
                            </li>
                        @endif

                        <hr class="text-gray-300">

                        <!-- Pesanan Masuk -->
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-yum-primary rounded-lg font-medium transition-colors justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Pesanan
                                </div>
                                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3</span>
                            </a>
                        </li>

                        <!-- Laporan -->
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-yum-primary rounded-lg font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                                Laporan
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <!-- Logout Area -->
            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('profile.edit', Auth::user()->username) }}" class="w-full flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    My Profile
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 md:px-8">
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-500 hover:text-yum-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <!-- Page Title (Dynamic) -->
                <h2 class="text-xl font-bold text-gray-800 hidden md:block">@yield('title', 'Dashboard')</h2>

                <!-- Right Side: User Profile -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-gray-800">{{ Auth::user()->nama }}</div>
                        <div class="text-xs text-gray-500">
                            @if (Auth::user()->role == 'admin')
                                Admin
                            @elseif(Auth::user()->role == 'penjual')
                                Penjual
                            @endif
                        </div>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-yum-primary/10 flex items-center justify-center text-yum-primary font-bold text-lg">
                        @if(Auth::user()->photo == null)
                        <span class="border border-gray-200 rounded-full w-8 h-8 flex items-center justify-center">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </span>
                        @else
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-8 h-8 border border-gray-200 object-cover rounded-full">
                        @endif
                    </div>
                </div>
            </header>

            <!-- Content Scrollable -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
                @yield('content')
            </main>
            
        </div>
    </div>
</body>
</html>