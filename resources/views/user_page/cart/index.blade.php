@extends('layouts.user_layout')
@section('content')

<div class="container mx-auto px-6 py-12">
    <a href="{{ route('menu.index') }}" class="mb-8 text-yum-primary font-bold hover:underline">
        
        Kembali ke menu
    </a>

    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-l-4 border-yum-primary pl-4">Keranjang Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- List Produk --}}
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold text-sm uppercase">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4 text-center">Qty</th>
                                <th class="px-6 py-4 text-right">Harga</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($cart as $id => $details)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        {{-- Gambar --}}
                                        <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden border border-gray-200 shrink-0">
                                            @if($details['photo'])
                                                <img src="{{ asset('storage/' . $details['photo']) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-full text-xs text-gray-400">No Pic</div>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <h3 class="font-bold text-gray-800">{{ $details['name'] }}</h3>
                                            
                                            {{-- TAMPILKAN RASA --}}
                                            @if(isset($details['rasa']) && $details['rasa'])
                                                <span class="bg-yum-primary/10 text-yum-primary text-[10px] px-2 py-0.5 rounded font-bold border border-yum-primary/20">
                                                    Varian: {{ $details['rasa'] }}
                                                </span>
                                            @endif

                                            {{-- TAMPILKAN CATATAN --}}
                                            @if(isset($details['note']) && $details['note'])
                                                <p class="text-xs text-gray-500 italic mt-1">"{{ $details['note'] }}"</p>
                                            @endif
                                            
                                            <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($details['harga'], 0, ',', '.') }} / porsi</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-100 text-gray-700 font-bold px-3 py-1 rounded-lg border border-gray-200">
                                        {{ $details['qty'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-yum-primary">
                                    Rp {{ number_format($details['harga'] * $details['qty'], 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Ringkasan Belanja --}}
            <div class="lg:w-1/3">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                    
                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="border-t border-gray-100 my-4 pt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total</span>
                        <span class="text-xl font-bold text-yum-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-yum-primary text-white font-bold py-3 px-4 rounded-xl shadow-md hover:bg-yum-dark transition transform hover:-translate-y-1">
                            Checkout Sekarang
                        </button>
                    </form>
                    
                    <p class="text-xs text-gray-400 text-center mt-4">
                        Dengan checkout, pesanan akan diteruskan ke masing-masing gerai.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-xl border border-gray-100">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Keranjang Kosong</h3>
            <p class="text-gray-500 mt-2 mb-6">Sepertinya kamu belum memesan makanan apapun.</p>
            <a href="{{ route('menu.index') }}" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition">
                Cari Makanan
            </a>
        </div>
    @endif
</div>
@endsection