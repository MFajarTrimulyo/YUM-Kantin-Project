@foreach ($products as $product)
<div class="bg-white rounded-2xl p-3 border border-gray-100 hover:border-yum-primary hover:shadow-xl transition duration-300 group h-full flex flex-col">
    
    <div class="relative overflow-hidden rounded-xl mb-3 aspect-square bg-gray-50">
        
        @if($product->harga_diskon > 0)
        <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-0.5 rounded-md text-[10px] font-bold shadow-sm z-10">
            Promo
        </span>
        @endif
        
        @if($product->photo)
            <img src="{{ asset('storage/' . $product->photo) }}" 
                alt="{{ $product->nama }}" 
                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        
        <a href="{{-- route('menu.show', $product->id) --}}" class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center cursor-pointer">
            <span class="bg-white text-yum-primary font-bold py-2 px-4 rounded-full shadow-lg text-xs transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                Lihat Detail
            </span>
        </a>
    </div>

    <div class="flex-1 flex flex-col">
        <div class="flex justify-between text-[10px] text-gray-400 mb-1.5">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                {{-- Random Sold Count for Demo, or 0 --}}
                {{ rand(10, 100) }}+ Terjual
            </span>
            <span class="bg-gray-100 px-1.5 rounded text-gray-500 truncate max-w-[50%]">
                {{ $product->gerai->nama ?? 'Gerai' }}
            </span>
        </div>
        
        <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 leading-tight group-hover:text-yum-primary transition" title="{{ $product->nama }}">
            {{ $product->nama }}
        </h3>
        
        <div class="mt-auto pt-3 flex items-end justify-between">
            <div>
                @if($product->harga_diskon > 0)
                    <div class="text-[10px] text-gray-400 line-through">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                    <div class="text-sm md:text-base font-bold text-red-500">
                        Rp {{ number_format($product->harga - $product->harga_diskon, 0, ',', '.') }}
                    </div>
                @else
                    <div class="text-sm md:text-base font-bold text-yum-primary">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            
            <button class="bg-yum-primary/10 text-yum-primary p-2 rounded-lg hover:bg-yum-primary hover:text-white transition shadow-sm border border-yum-primary/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
        </div>
    </div>
</div>
@endforeach