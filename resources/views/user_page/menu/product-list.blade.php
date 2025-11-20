@foreach ($products as $product)
<div class="bg-white rounded-2xl p-3 border border-gray-100 hover:border-yum-primary hover:shadow-xl transition duration-300 group h-full flex flex-col">
    
    <!-- Image Wrapper -->
    <div class="relative overflow-hidden rounded-xl mb-3 aspect-4/3">
        {{-- <!-- Badge Rating -->
        <span class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-md text-[10px] font-bold flex items-center shadow-sm z-10 text-yum-action">
            ★ {{ $product->rating }}
        </span> --}}
        
        <!-- Image -->
        <img src="{{ asset($product->image) }}" 
            alt="{{ $product->name }}" 
            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
        
        <!-- Quick Add Button -->
        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
            <button class="bg-white text-yum-primary font-bold py-2 px-4 rounded-full shadow-lg text-xs transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                Lihat Detail
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
        <div class="flex justify-between text-[10px] text-gray-400 mb-1.5">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                {{ $product->sold }}+ Terjual
            </span>
            <span class="bg-gray-100 px-1.5 rounded text-gray-500">{{ $product->store_name }}</span>
        </div>
        
        <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 leading-tight group-hover:text-yum-primary transition">
            {{ $product->name }}
        </h3>
        
        <!-- Footer Card: Price & Button -->
        <div class="mt-auto pt-3 flex items-end justify-between">
            <div>
                @if($product->original_price > $product->price)
                    <div class="text-[10px] text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</div>
                @endif
                <div class="text-sm md:text-base font-bold text-yum-primary">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
            
            <!-- Add Button -->
            <button class="bg-yum-primary/10 text-yum-primary p-2 rounded-lg hover:bg-yum-primary hover:text-white transition shadow-sm border border-yum-primary/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
        </div>
    </div>
</div>
@endforeach