@extends('layouts.user_layout')
@section('content')

<div class="bg-yum-primary pt-12 pb-16 rounded-b-[3rem] relative overflow-hidden shadow-lg">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('/pictures/pattern.png')]"></div>
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">Mau Makan Apa Hari Ini?</h1>
        <p class="text-white/80 mb-8 text-sm md:text-base">Temukan jajanan kantin favoritmu di sini.</p>

        <form action="{{ route('menu.index') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="flex w-full bg-white rounded-xl p-1.5 shadow-xl transform transition-all hover:scale-[1.01]">
                <input type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari menu (misal: Nasi Goreng...)" 
                    class="flex-1 px-5 py-3 rounded-lg focus:outline-none text-gray-700 placeholder-gray-400">
                <button type="submit" class="bg-yum-yellow text-black font-bold px-6 py-2.5 rounded-lg hover:bg-yellow-400 transition shadow-sm">
                    Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="container mx-auto px-6 -mt-8 relative z-20">
    <div class="bg-white rounded-2xl shadow-md p-4 flex flex-wrap justify-center gap-3 border border-gray-100">
        {{-- Dumy Kategori --}}
        @php
            $categories = ['Semua', 'Makanan', 'Minuman', 'Snack', 'Manis-manis'];
            $currentCat = request('category') ?? 'Semua';
        @endphp

        @foreach($categories as $kategori)
            <a href="{{ route('menu.index', ['category' => $kategori == 'Semua' ? null : $kategori]) }}" 
                class="px-5 py-2 rounded-full text-sm font-bold transition duration-200 border 
                {{ $currentCat == $kategori 
                    ? 'bg-yum-primary text-white border-yum-primary shadow-md' 
                    : 'bg-gray-50 text-gray-600 border-transparent hover:bg-blue-50 hover:text-yum-primary' }}">
                {{ $kategori }}
            </a>
        @endforeach
    </div>
</div>

<div class="container mx-auto px-6 py-12">
    
    <div class="flex justify-between items-end mb-6">
        <h2 class="text-xl font-bold text-gray-800 border-l-4 border-yum-yellow pl-3">
            Daftar Menu {{ $currentCat != 'Semua' ? '- ' . $currentCat : '' }}
        </h2>
        <span class="text-xs text-gray-500">Menampilkan {{ $products->count() }} Menu</span>
    </div>

    @if($products->count() > 0)
        <!-- Product List -->
        <div id="product-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @include('user_page.menu.product-list', ['products' => $products])
        </div>

        @if($products->hasMorePages())
        <div class="mt-12 flex justify-center" id="load-more-container">
            <button id="load-more-btn" 
                data-page="2" 
                data-url="{{ route('menu.index') }}"
                data-category="{{ request('category') }}"
                data-search="{{ request('search') }}"
                class="bg-white border-2 border-yum-primary text-yum-primary font-bold px-8 py-3 rounded-full hover:bg-yum-primary hover:text-white transition-all duration-300 shadow-md flex items-center gap-2">
                <span>Muat Lebih Banyak</span>
                <!-- Spinner Icon (Hidden by default) -->
                <svg id="loading-spinner" class="animate-spin h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
        @endif
    @else
        <div class="text-center py-20">
            <div class="bg-gray-100 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Yah, menu tidak ditemukan!</h3>
            <p class="text-gray-500 mt-2">Coba cari dengan kata kunci lain atau reset filter.</p>
            <a href="{{ route('menu.index') }}" class="mt-6 inline-block bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                Lihat Semua Menu
            </a>
        </div>
    @endif
</div>

@endsection