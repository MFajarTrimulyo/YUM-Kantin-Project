@extends('layouts.user_layout')
@section('title', $product->nama . ' - YUM')

@section('content')
<div class="container mx-auto px-6 py-8">
    {{-- Breadcrumb / Tombol Kembali --}}
    <a href="{{ route('menu.index') }}" class="inline-flex items-center text-gray-500 hover:text-yum-primary mb-6 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Menu
    </a>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            
            {{-- KOLOM KIRI: GAMBAR UTAMA & THUMBNAIL --}}
            <div class="md:w-1/2 p-6 bg-gray-50 flex flex-col items-center justify-center">
                <div class="relative w-full max-w-md aspect-square rounded-2xl overflow-hidden shadow-md mb-4">
                    @if($product->photo)
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    {{-- Badge Diskon (Jika ada) --}}
                    @if($product->harga_diskon > 0 && $product->harga > $product->harga_diskon)
                        @php
                            $discount = round((($product->harga - $product->harga_diskon) / $product->harga) * 100);
                        @endphp
                        <span class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                            Hemat {{ $discount }}%
                        </span>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL & AKSI --}}
            <div class="md:w-1/2 p-8 md:p-10 flex flex-col">
                
                {{-- Info Toko Kecil --}}
                @php
                    $isStoreOpen = $product->gerai->is_open ?? true;
                @endphp
                <div class="flex items-center gap-3 mb-6 p-3 bg-gray-50 rounded-xl w-fit">
                    <div class="w-8 h-8 rounded-full bg-yum-primary/20 flex items-center justify-center text-yum-primary font-bold">
                        @if($product->gerai->photo)
                            <img src="{{ asset('storage/' . ($product->gerai->photo ?? 'default-logo.png')) }}" alt="{{ $product->gerai->nama ?? 'Nama Kantin' }}">
                        @else
                            {{ strtoupper(substr($product->gerai->nama, 0, 1)) }}
                        @endif
                    </div>
                    {{-- NAMA & STATUS --}}
                    <div class="flex flex-col">
                        <a href="#" class="text-sm font-bold transition {{ $isStoreOpen ? 'text-gray-700 hover:text-yum-primary' : 'text-gray-500 cursor-not-allowed' }}">
                            {{ $product->gerai->nama ?? 'Nama Kantin' }}
                        </a>

                        {{-- Indikator Status --}}
                        @if($isStoreOpen)
                            <div class="flex items-center gap-1">
                                <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-[10px] font-bold text-green-600 uppercase tracking-wide">Buka</span>
                            </div>
                        @else
                            <div class="flex items-center gap-1">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                <span class="text-[10px] font-bold text-red-500 uppercase tracking-wide">Sedang Tutup</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Judul Produk --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $product->nama }}</h1>
                
                {{-- Harga --}}
                <div class="mb-8">
                    @if($product->harga > $product->harga_diskon && $product->harga_diskon > 0)
                        <div class="flex items-end gap-3">
                            <span class="text-4xl font-bold text-yum-primary">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                            <span class="text-xl text-gray-400 line-through mb-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <span class="text-4xl font-bold text-yum-primary">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf

                    {{-- Pilihan Varian --}}
                    @if($product->pilihan_rasa)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Pilih Varian:</h3>
                        <div class="flex flex-wrap gap-3">
                            @php
                                // Pecah string database "Coklat, Keju" jadi array
                                $varians = explode(',', $product->pilihan_rasa);
                            @endphp

                            @foreach($varians as $index => $varian)
                                @php $varian = trim($varian); @endphp
                                <div class="relative">
                                    {{-- Radio Button (Sembunyi) --}}
                                    <input type="radio" 
                                        name="rasa" 
                                        id="rasa_{{ $index }}" 
                                        value="{{ $varian }}" 
                                        class="peer sr-only" 
                                        {{ $index === 0 ? 'checked' : '' }} required>
                                    
                                    {{-- Label (Tampilan Tombol Pill) --}}
                                    <label for="rasa_{{ $index }}" 
                                        class="cursor-pointer px-6 py-2 rounded-full border-2 border-gray-200 bg-white text-gray-600 font-bold text-sm transition select-none
                                                hover:border-yum-primary hover:text-yum-primary
                                                peer-checked:bg-yum-primary peer-checked:text-white peer-checked:border-yum-primary peer-checked:shadow-md">
                                        {{ $varian }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Deskripsi Produk (Menggunakan style card seperti mockup tapi lebih simpel) --}}
                    <div class="mb-8 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <span class="bg-yum-primary/10 text-yum-primary p-1 rounded mr-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            </span>
                            Deskripsi
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    {{-- FORM ADD TO CART & QTY --}}
                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-6">
                            <label class="font-bold text-gray-800">Jumlah Pesanan:</label>
                            
                            {{-- Quantity Picker --}}
                            <div class="flex items-center border-2 border-gray-200 rounded-full w-fit shadow-sm bg-gray-50">
                                <button type="button" onclick="decrementQty()" class="p-2 text-gray-500 hover:text-yum-primary transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                                <input type="number" id="qty-input" name="qty" value="1" min="1" max="{{ $product->stok > 0 ? $product->stok : 1 }}" class="w-fit pl-4 text-center bg-transparent border-none focus:ring-0 font-bold text-lg text-gray-800 appearance-none m-0 font-mono" readonly>
                                <button type="button" onclick="incrementQty()" class="p-2 text-gray-500 hover:text-yum-primary transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            @if($isStoreOpen && $product->stok > 0)
                                {{-- JIKA BUKA: Tombol Normal --}}
                                <button type="submit" name="action" value="checkout" class="flex-1 bg-blue-600 text-white font-bold text-lg py-4 px-6 rounded-full hover:bg-blue-700 transition transform hover:-translate-y-1 shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Pesan Sekarang
                                </button>

                                <button type="submit" name="action" value="add" class="flex-1 bg-yum-primary text-white font-bold text-lg py-4 px-6 rounded-full hover:bg-yum-dark transition transform hover:-translate-y-1 shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    + Keranjang
                                </button>
                            @else
                                {{-- JIKA TUTUP atau STOK HABIS --}}
                                <button type="button" disabled class="flex-1 bg-gray-300 text-gray-500 font-bold text-lg py-4 px-6 rounded-full cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Pesan Sekarang
                                </button>

                                <button type="button" disabled class="flex-1 bg-gray-300 text-gray-500 font-bold text-lg py-4 px-6 rounded-full cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    + Keranjang
                                </button>
                            @endif
                        </div>
                        @if(!$isStoreOpen)
                            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                                <p class="text-red-600 font-bold">Gerai Sedang Tutup</p>
                                <p class="text-red-500 text-xs">Silakan pesan saat gerai sudah buka kembali.</p>
                            </div>
                        @elseif($product->stok <= 0)
                            <p class="text-red-500 text-sm mt-3 text-center font-bold">Maaf, Stok Habis!</p>
                        @else
                            <p class="text-gray-500 text-sm mt-3 text-center">Sisa stok: {{ $product->stok }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Quantity Picker --}}
<script>
    const qtyInput = document.getElementById('qty-input');
    const maxStok = {{ $product->stok }};

    function decrementQty() {
        let currentQty = parseInt(qtyInput.value);
        if (currentQty > 1) {
            qtyInput.value = currentQty - 1;
        }
    }

    function incrementQty() {
        let currentQty = parseInt(qtyInput.value);
        // Cek stok jika ada batasnya
        if (maxStok > 0 && currentQty < maxStok) {
             qtyInput.value = currentQty + 1;
        } else if (maxStok <= 0) {
             // Jika stok 0 atau habis, jangan biarkan nambah
        }
         else {
            // Jika tidak ada info stok ketat, biarkan nambah terus (opsional)
            // qtyInput.value = currentQty + 1;
            alert('Maksimal stok tersedia: ' + maxStok);
        }
    }
    
    // Disable inputs jika tutup atau stok habis
    @if($product->stok <= 0 || !$isStoreOpen)
        document.addEventListener("DOMContentLoaded", function() {
            qtyInput.value = 0;
            // Input field juga didisable
            qtyInput.disabled = true;
        });
    @endif
</script>
@endsection