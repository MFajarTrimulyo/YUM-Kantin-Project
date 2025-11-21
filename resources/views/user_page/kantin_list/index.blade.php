@extends('layouts.user_layout')
@section('title', 'Daftar Kantin')
@section('content')

{{-- Header --}}
<div class="bg-yum-primary pt-12 pb-16 rounded-b-[3rem] relative overflow-hidden shadow-lg">
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">Jelajahi Kantin UM</h1>
        <p class="text-white/80 text-sm md:text-base">Temukan spot kuliner terbaik di setiap sudut kampus Universitas Negeri Malang.</p>
    </div>
</div>

{{-- Content --}}
<div class="container mx-auto px-6 py-12 -mt-16 relative z-20">
    
    @if($kantins->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($kantins as $kantin)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-1 hover:shadow-xl transition duration-300 group flex flex-col h-full">
                
                {{-- Ilustrasi Kantin (Placeholder Pattern) --}}
                <div class="h-40 bg-gray-100 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/food.png')]"></div>
                    @if($kantin->photo && file_exists(storage_path('app/public/' . $kantin->photo)))
                        <img src="{{ asset('storage/' . $kantin->photo) }}" class="w-full h-full object-cover">
                    @elseif($kantin->photo)
                        <img src="{{ asset($kantin->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Pic</div>
                    @endif
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-yum-primary transition">
                            {{ $kantin->nama }}
                        </h3>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">
                        {{ $kantin->lokasi ?? 'Lokasi nyaman untuk makan siang dan bersantai bersama teman.' }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            {{ $kantin->gerai_count }} Gerai Tersedia
                        </span>
                        
                        {{-- Tombol Lihat Menu --}}
                        <a href="{{ route('menu.index', ['kantin' => $kantin->id]) }}" class="text-yum-primary text-sm font-bold hover:underline flex items-center">
                            Lihat Menu <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-gray-800">Belum ada data kantin.</h3>
            <p class="text-gray-500 mt-2">Admin belum menambahkan lokasi kantin.</p>
        </div>
    @endif

</div>
@endsection