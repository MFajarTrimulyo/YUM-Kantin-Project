@extends('layouts.user_layout')
@section('content')
<div class="relative h-lvh bg-cover bg-center overflow-hidden flex items-center justify-center" style="background-image: url({{ asset('pictures/background-um.png') }});">
    <div class="absolute inset-0 opacity-25 bg-yum-primary"></div>
    
    <div class="container mx-auto  px-6 flex flex-col md:flex-row justify-between items-center relative z-10">
        <div class="text-white max-w-lg text-center md:text-left">
            <h1 class="text-5xl font-bold mb-2 tracking-tight">HAI! <span class="text-white">{{ auth()->user()->nama }}</span></h1>
            <p class="text-xl mb-6 font-light leading-relaxed">
                LAGI CARI MAKAN NIH?<br>
                CARI MENU FAVORITMU <span id="here-button" onclick="searchFood()" class="border-2 border-white text-white text-md px-2 py-0.5 ml-2 rounded font-medium">DISINI!</span>
            </p>
        </div>
        <div class="hidden md:block w-1/3">
            <img src="{{ asset('pictures/happy-cakra.png') }}" alt="YUM Mascot" class="h-lvh object-contain drop-shadow-2xl hover:scale-105 transition duration-500 ease-in-out">
        </div>
    </div>
</div>

<div id="search-food" class="text-center py-30 bg-white border-b border-gray-100">
    <h2 class="text-3xl font-bold mb-6">Enaknya makan apa yaa?</h2>
    
    <div class="flex justify-center mb-6 max-w-2xl mx-auto px-4">
        <div class="flex w-full shadow-sm">
            <input type="text" placeholder="Cari menu favoritmu disini" class="border-2 border-r-0 border-gray-300 rounded-l-lg px-6 py-3 w-full focus:outline-none focus:border-yum-primary focus:ring-0 transition text-gray-600 placeholder-gray-400">
            <button class="bg-yum-primary text-white px-8 py-3 rounded-r-lg font-bold hover:bg-yum-dark transition duration-200">Search</button>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-3 mt-4 px-4">
        <span class="font-bold self-center mr-2">Kategori Menu:</span>
        <button class="bg-blue-100 text-blue-800 px-5 py-1.5 rounded-full text-sm font-bold hover:bg-blue-200 transition">Makanan</button>
        <button class="bg-yellow-100 text-yellow-800 px-5 py-1.5 rounded-full text-sm font-bold border-2 border-yellow-800/10 hover:bg-yellow-200 transition">Minuman</button>
        <button class="bg-white border border-gray-300 text-gray-600 px-5 py-1.5 rounded-full text-sm font-bold hover:bg-gray-50 transition">Snack</button>
        <button class="bg-yum-primary text-white px-5 py-1.5 rounded-full text-sm font-bold hover:bg-yum-dark transition">Manis-manis</button>
    </div>
</div>

<div class="bg-yum-primary py-10">
    <div class="container mx-auto px-6 relative group">
        <h2 class="text-center text-white text-3xl font-bold mb-8">Lagi ada <span class="text-yum-yellow">diskon</span> khusus buat kamu!</h2>
        
        <button id="discount-scroll-left" class="absolute left-2 top-1/2 z-10 bg-white/90 text-yum-primary p-2 rounded-full shadow-lg hover:bg-yum-dark hover:text-white transition hidden md:group-hover:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <button id="discount-scroll-right" class="absolute right-2 top-1/2 z-10 bg-white/90 text-yum-primary p-2 rounded-full shadow-lg hover:bg-yum-dark hover:text-white transition hidden md:group-hover:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <div id="discount-slider" class="flex overflow-x-auto space-x-6 pb-4 snap-x snap-mandatory scroll-smooth no-scrollbar">
            
            @for ($i = 0; $i < 8; $i++)
            <div class="snap-start shrink-0 w-48 md:w-56"> <div class="bg-white rounded-xl p-3 m-2 shadow-lg hover:-translate-y-1 transition duration-300 h-full flex flex-col">
                    <div class="relative rounded-lg overflow-hidden mb-3">
                        <img src="{{ asset('pictures/example-food.png') }}" alt="Takoyaki" class="w-full h-32 object-cover">
                        {{-- <span class="absolute top-2 right-2 bg-white/90 px-1.5 py-0.5 rounded text-xs font-bold flex items-center text-yum-action">
                            ★ 4.5
                        </span> --}}
                    </div>

                    <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                        <span>100+ terjual</span>
                        <span>Toko Toko</span>
                    </div>
                    
                    <h3 class="font-bold text-gray-800 text-sm mb-2 line-clamp-2">Takoyaki Spesial Lezat</h3>
                    
                    <div class="mt-auto flex items-end justify-between">
                        <div>
                            <div class="text-[10px] text-gray-400 line-through">Rp 15.000</div>
                            <div class="text-sm font-bold text-black">Rp 10.000</div>
                        </div>
                        <button class="bg-yum-primary text-white p-1.5 rounded-md hover:bg-blue-700 transition shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<div class="bg-white py-16 overflow-hidden">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-start md:items-center">
        <div class="md:w-1/4 mb-8 md:mb-0 md:pr-8">
            <h2 class="text-4xl font-bold text-yum-primary leading-tight">
                Banyak yang <span class="text-green-500">suka</span> nih!
            </h2>
            <p class="text-gray-500 mt-4 text-sm">Menu-menu best seller yang wajib kamu coba minggu ini di kantin UM.</p>
        </div>
        
        <div class="md:w-3/4 relative group w-full min-w-0">
            <button id="popular-scroll-left" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white text-yum-primary p-2 rounded-full shadow-md border border-gray-100 hover:bg-yum-dark hover:text-white transition hidden md:group-hover:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button id="popular-scroll-right" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white text-yum-primary p-2 rounded-full shadow-md border border-gray-100 hover:bg-yum-dark hover:text-white transition hidden md:group-hover:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div id="popular-slider" class="flex overflow-x-auto space-x-6 pb-4 snap-x snap-mandatory scroll-smooth no-scrollbar">
                
                @for ($i = 0; $i < 8; $i++) <div class="snap-start shrink-0 w-48 md:w-52">
                    <div class="bg-white rounded-xl p-3 border border-gray-200 hover:border-yum-primary transition duration-300 group h-full flex flex-col">
                        
                        <div class="overflow-hidden rounded-lg mb-3 relative">
                            <img src="{{ asset('pictures/example-food.png') }}" class="w-full h-32 object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        
                        <h3 class="font-bold text-sm mb-1 line-clamp-2">Takoyaki</h3>
                        
                        <div class="mb-2">
                            <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded">Terlaris</span>
                        </div>
                        
                        <div class="mt-auto flex justify-between items-center">
                            <span class="text-xs line-through text-gray-400">Rp 10.000</span>
                            <span class="font-bold text-sm">Rp 5.000</span>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection