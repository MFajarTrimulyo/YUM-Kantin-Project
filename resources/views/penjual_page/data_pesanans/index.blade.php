@extends('layouts.admin_layout')
@section('title', 'Kelola Pesanan')
@section('content')

<div class="container mx-auto">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
            <p class="text-gray-500 text-sm">Pantau dan proses pesanan pelanggan.</p>
        </div>
    </div>

    {{-- TAB NAVIGASI --}}
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl mb-6 overflow-x-auto">
        <a href="{{ route('penjual.pemesanan.index', ['status' => 'pending']) }}" 
           class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition {{ $status == 'pending' ? 'bg-white text-yum-primary shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Pesanan Baru 
            @if($counts['pending'] > 0) <span class="ml-1 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $counts['pending'] }}</span> @endif
        </a>
        <a href="{{ route('penjual.pemesanan.index', ['status' => 'cooking']) }}" 
           class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition {{ $status == 'cooking' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Dapur 
            @if($counts['cooking'] > 0) <span class="ml-1 bg-blue-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $counts['cooking'] }}</span> @endif
        </a>
        <a href="{{ route('penjual.pemesanan.index', ['status' => 'ready']) }}" 
           class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition {{ $status == 'ready' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Siap Diambil
            @if($counts['ready'] > 0) <span class="ml-1 bg-green-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $counts['ready'] }}</span> @endif
        </a>
        <a href="{{ route('penjual.pemesanan.index', ['status' => 'history']) }}" 
           class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition {{ $status == 'history' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Riwayat
        </a>
    </div>

    {{-- LIST PESANAN --}}
    @if($orders)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                
                {{-- Header Card --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-gray-800">{{ $order->user->nama }}</h3>
                            <span class="text-xs text-gray-400 bg-white px-2 py-0.5 rounded border">#{{ substr($order->id, -6) }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-yum-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                        
                        <div class="flex items-center justify-end gap-2 mt-1">
                            <div class="text-[10px] uppercase font-bold tracking-wide {{ $order->status_bayar == 'paid' ? 'text-green-600' : 'text-red-500' }}">
                                {{ $order->status_bayar == 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}
                            </div>

                            {{-- TOMBOL LIHAT BUKTI --}}
                            @if($order->bukti_bayar)
                                <button onclick="showBukti('{{ asset('storage/' . $order->bukti_bayar) }}')" 
                                    class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100 hover:bg-blue-100 transition flex items-center gap-1 cursor-pointer">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Cek Bukti
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Body: List Item --}}
                <div class="p-6 flex-1">
                    <ul class="space-y-3">
                        @foreach($order->detail_pemesanans as $detail)
                        <li class="flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <span class="font-bold text-gray-700 whitespace-nowrap">{{ $detail->qty }}x</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $detail->produk->nama }}</p>
                                    @if($detail->catatan)
                                        <p class="text-xs text-red-500 italic">"{{ $detail->catatan }}"</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Footer: Action Buttons --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                    
                    @if($order->status == 'pending')
                        <form action="{{ route('penjual.pemesanan.update', $order->id) }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cooking">
                            <button type="submit" class="w-full bg-blue-600 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Terima & Masak
                            </button>
                        </form>
                        
                        <form action="{{ route('penjual.pemesanan.update', $order->id) }}" method="POST" onsubmit="return confirm('Tolak pesanan ini? Stok akan dikembalikan.')">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="bg-red-100 text-red-600 text-sm font-bold py-2.5 px-4 rounded-lg hover:bg-red-200 transition">
                                Tolak
                            </button>
                        </form>

                    @elseif($order->status == 'cooking')
                        <form action="{{ route('penjual.pemesanan.update', $order->id) }}" method="POST" class="w-full">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="ready">
                            <button type="submit" class="w-full bg-yellow-500 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-yellow-600 transition shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                Pesanan Siap
                            </button>
                        </form>

                    @elseif($order->status == 'ready')
                        <form action="{{ route('penjual.pemesanan.update', $order->id) }}" method="POST" class="w-full">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="w-full bg-green-600 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-green-700 transition shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Selesai (Sudah Diambil)
                            </button>
                        </form>
                    
                    @else
                        <div class="w-full text-center text-sm text-gray-400 font-bold py-2">
                            {{ $order->status == 'completed' ? 'Pesanan Selesai' : 'Pesanan Dibatalkan' }}
                        </div>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20">
            <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Tidak ada pesanan</h3>
            <p class="text-gray-500 text-sm">Belum ada pesanan dengan status ini.</p>
        </div>
    @endif
</div>

{{-- MODAL BUKTI BAYAR --}}
<div id="modal-bukti" class="fixed inset-0 z-9999 hidden items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeBukti()">
    <div class="relative max-w-lg w-full p-4 transform transition-all scale-100">
        <button onclick="closeBukti()" class="absolute -top-2 -right-2 bg-white rounded-full p-2 text-gray-800 hover:bg-gray-200 shadow-lg z-10 border border-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <img id="img-bukti" src="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg shadow-2xl border border-white/20 bg-black">
        <p class="text-center text-white/80 mt-2 text-sm font-medium">Bukti Pembayaran Pembeli</p>
    </div>
</div>

<script>
    function showBukti(url) {
        document.getElementById('img-bukti').src = url;
        const modal = document.getElementById('modal-bukti');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBukti() {
        const modal = document.getElementById('modal-bukti');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection