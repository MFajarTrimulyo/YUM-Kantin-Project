@extends('layouts.user_layout')
@section('content')
{{-- Hai Section --}}
<div class="relative h-lvh bg-cover bg-center overflow-hidden flex items-center justify-center" style="background-image: url({{ asset('pictures/background-um.png') }});">
    <div class="absolute inset-0 opacity-25 bg-yum-primary"></div>
    
    <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center relative z-10">
        <div class="text-white max-w-lg text-center md:text-left">
            <h1 class="text-5xl font-bold mb-2 tracking-tight">
                HAI!
                @if (Auth::check())
                    <span class="text-yum-yellow uppercase">{{ auth()->user()->nama }}</span>
                @else
                    SOBAT!
                @endif
            </h1>
            
            <p class="text-xl mb-6 font-light leading-relaxed text-white/90">
                LAPER TAPI BINGUNG MAU MAKAN APA?<br>
                TEMUKAN MENU FAVORITMU
                <button id="here-button"
                    class="ml-1 inline-block border-2 border-white text-white hover:bg-yum-primary hover:border-yum-primary hover:text-white transition-all duration-300 text-md px-4 py-1 rounded-lg font-bold">
                    DISINI!
                </button>
            </p>
        </div>
        <div class="hidden md:block w-1/3">
            <img src="{{ asset('pictures/happy-cakra.png') }}" alt="YUM Mascot" class="h-lvh object-contain drop-shadow-2xl hover:scale-105 transition duration-500 ease-in-out">
        </div>
    </div>
</div>

{{-- Search Section --}}
<div id="search-food" class="text-center py-20 bg-white border-b border-gray-100">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Enaknya makan apa yaa?</h2>
    
    <form action="{{ route('menu.index') }}" method="GET" class="flex justify-center mb-6 max-w-2xl mx-auto px-4">
        <div class="flex w-full shadow-sm group">
            <input type="text" name="search" placeholder="Cari menu favoritmu disini..." class="border-2 border-r-0 border-gray-300 rounded-l-lg px-6 py-3 w-full focus:outline-none focus:border-yum-primary focus:ring-0 transition text-gray-600 placeholder-gray-400">
            <button type="submit" class="bg-yum-primary text-white px-8 py-3 rounded-r-lg font-bold hover:bg-yum-dark transition duration-200 border-2 border-l-0 border-yum-primary">Search</button>
        </div>
    </form>

    {{-- Static Categories for Quick Link --}}
    <div class="flex flex-wrap justify-center gap-3 mt-4 px-4">
        <span class="font-bold self-center mr-2 text-gray-600">Kategori:</span>
        <a href="{{ route('menu.index', ['category' => 'Makanan']) }}" class="bg-blue-50 text-blue-800 px-5 py-1.5 rounded-full text-sm font-bold hover:bg-blue-100 transition">Makanan</a>
        <a href="{{ route('menu.index', ['category' => 'Minuman']) }}" class="bg-yellow-50 text-yellow-800 px-5 py-1.5 rounded-full text-sm font-bold hover:bg-yellow-100 transition">Minuman</a>
        <a href="{{ route('menu.index', ['category' => 'Snack']) }}" class="bg-gray-50 border border-gray-200 text-gray-600 px-5 py-1.5 rounded-full text-sm font-bold hover:bg-gray-100 transition">Snack</a>
    </div>
</div>

{{-- Promo / Discount Section --}}
@if(isset($promoProduks) && count($promoProduks) > 0)
<div class="bg-yum-primary py-12">
    <div class="container mx-auto px-6 relative group">
        <h2 class="text-center text-white text-3xl font-bold mb-10">Lagi ada <span class="text-yum-yellow">diskon</span> khusus buat kamu!</h2>
        
        {{-- Slider Container --}}
        <div class="flex overflow-x-auto space-x-6 pb-8 snap-x snap-mandatory scroll-smooth no-scrollbar px-4">
            
            @foreach ($promoProduks as $product)
            <div class="snap-start shrink-0 w-48 md:w-56"> 
                <div class="bg-white rounded-xl p-3 shadow-lg hover:-translate-y-1 transition duration-300 h-full flex flex-col">
                    <div class="relative rounded-lg overflow-hidden mb-3 aspect-auto bg-gray-100">
                        @if($product->photo)
                            <img src="{{ asset('storage/' . $product->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                        @endif
                        <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-0.5 rounded text-[10px] font-bold">
                           Diskon {{ round(($product->harga_diskon / $product->harga) * 100) }}%
                        </span>
                    </div>

                    <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                        <span>{{ $product->gerai->nama ?? 'Gerai' }}</span>
                    </div>
                    
                    <h3 class="font-bold text-gray-800 text-sm mb-2 line-clamp-2">{{ $product->nama }}</h3>
                    
                    <div class="mt-auto flex items-end justify-between">
                        <div>
                            <div class="text-[10px] text-gray-400 line-through">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                            <div class="text-sm font-bold text-black">Rp {{ number_format($product->harga - $product->harga_diskon, 0, ',', '.') }}</div>
                        </div>
                        <button class="bg-yum-primary text-white p-1.5 rounded-md hover:bg-yum-dark transition shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Popular Section --}}
@if(isset($popularProduks) && count($popularProduks) > 0)
<div class="bg-white py-16 overflow-hidden">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-start md:items-center">
        <div class="md:w-1/4 mb-8 md:mb-0 md:pr-8">
            <h2 class="text-4xl font-bold text-yum-primary leading-tight">
                Banyak yang <span class="text-green-500">suka</span> nih!
            </h2>
            <p class="text-gray-500 mt-4 text-sm">Menu-menu pilihan yang wajib kamu coba minggu ini di kantin UM.</p>
            <a href="{{ route('menu.index') }}" class="mt-6 inline-block text-yum-primary font-bold hover:underline">Lihat Semua →</a>
        </div>
        
        <div class="md:w-3/4 relative w-full min-w-0">
            <div class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory scroll-smooth no-scrollbar">
                @foreach ($popularProduks as $product) 
                <div class="snap-start shrink-0 w-48 md:w-52">
                    <div class="bg-white rounded-xl p-3 border border-gray-200 hover:border-yum-primary transition duration-300 group h-full flex flex-col">
                        
                        <div class="overflow-hidden rounded-lg mb-3 relative aspect-auto bg-gray-50">
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-sm mb-1 line-clamp-2 text-gray-800">{{ $product->nama }}</h3>
                        
                        <div class="mb-2">
                            <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded">Terlaris</span>
                        </div>

                        <div class="mt-auto flex justify-between items-center pt-2">
                            <div class="flex flex-col">
                                @if($product->harga_diskon > 0)
                                    <span class="text-[10px] line-through text-gray-400">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    <span class="font-bold text-sm text-red-500">Rp {{ number_format($product->harga - $product->harga_diskon, 0, ',', '.') }}</span>
                                @else
                                    <span class="font-bold text-sm text-gray-800">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('footer-feedback')
    {{-- Footer Feedback Section Remains the Same --}}
    <h2 class="text-white text-2xl font-bold mb-8 relative z-10">Berikan <span class="text-yum-yellow">ulasanmu</span> disini!</h2>
    <div class="max-w-2xl mx-auto px-6 relative z-10">
        <div class="flex gap-3 mb-4">
            <input type="email" placeholder="Masukkan email kamu" class="flex-1 rounded-lg px-5 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-yum-yellow border-none shadow-lg text-sm">
            <button class="bg-yum-yellow text-black font-bold px-8 py-3 rounded-lg hover:bg-yellow-300 shadow-lg transition transform hover:-translate-y-0.5">Kirim</button>
        </div>
        <textarea class="w-full rounded-lg px-5 py-4 h-32 bg-white focus:outline-none focus:ring-2 focus:ring-yum-yellow border-none shadow-lg text-sm resize-none" placeholder="Tulis kritik dan saran disini..."></textarea>
    </div>
@endsection