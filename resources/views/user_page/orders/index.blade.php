@extends('layouts.user_layout')
@section('content')

<div class="container mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-l-4 border-yum-primary pl-4">Riwayat Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(count($orders) > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                
                {{-- Header Card: Info Order --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800 text-lg">{{ $order->gerai->nama ?? 'Gerai Tidak Ditemukan' }}</span>
                            <span class="text-xs text-gray-400">#{{ substr($order->id, -5) }}</span>
                        </div>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Badge Status Pesanan --}}
                        @php
                            $statusColor = match($order->status) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'cooking' => 'bg-blue-100 text-blue-700',
                                'ready' => 'bg-green-100 text-green-700',
                                'completed' => 'bg-gray-100 text-gray-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-600'
                            };
                            $statusLabel = match($order->status) {
                                'pending' => 'Menunggu Konfirmasi',
                                'cooking' => 'Sedang Dimasak',
                                'ready' => 'Siap Diambil',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                default => $order->status
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>

                        {{-- Badge Status Bayar & Tombol Bukti --}}
                        <div class="flex items-center gap-2">
                            @if($order->status_bayar == 'paid')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Lunas</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">Unpaid</span>
                            @endif

                            {{-- TOMBOL LIHAT BUKTI (BARU) --}}
                            @if($order->bukti_bayar)
                                <button onclick="showBukti('{{ asset('storage/' . $order->bukti_bayar) }}')" 
                                    class="text-[10px] bg-white text-gray-600 px-2 py-1 rounded border border-gray-300 hover:bg-gray-50 transition flex items-center gap-1"
                                    title="Lihat Bukti Transfer">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Bukti
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Body Card: List Item --}}
                <div class="p-6">
                    <ul class="space-y-4">
                        @foreach($order->detail_pemesanans as $detail)
                        <li class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                {{-- Foto Kecil --}}
                                <div class="w-12 h-12 rounded bg-gray-100 overflow-hidden border border-gray-200 shrink-0">
                                    @if($detail->produk && $detail->produk->photo)
                                        <img src="{{ asset('storage/' . $detail->produk->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400">No Pic</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</p>
                                    <p class="text-xs text-gray-500">{{ $detail->qty }} x Rp {{ number_format($detail->harga_satuan_saat_beli, 0, ',', '.') }}</p>
                                    @if($detail->catatan)
                                        <p class="text-[10px] text-gray-400 italic">Catatan: {{ $detail->catatan }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="font-semibold text-gray-700 text-sm">
                                Rp {{ number_format($detail->harga_satuan_saat_beli * $detail->qty, 0, ',', '.') }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Footer Card: Total --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                    
                    {{-- Kiri: Total Harga --}}
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-500">Total Pesanan</span>
                        <span class="text-xl font-bold text-yum-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>

                    {{-- Kanan: Tombol Aksi (Hanya jika Pending) --}}
                    <div class="flex items-center gap-3">
                        {{-- TOMBOL CETAK STRUK (BARU) --}}
                        <a href="{{ route('struk.show', $order->id) }}" target="_blank" 
                        class="flex items-center gap-1 text-gray-500 hover:text-yum-primary font-bold text-sm bg-white border border-gray-200 hover:border-yum-primary px-3 py-2 rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            <span>Nota</span>
                        </a>

                        {{-- Tombol Batalkan (Logika Lama) --}}
                        @if($order->status == 'pending')
                        <form action="{{ route('pemesanan.user.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-100 transition shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Batalkan Pesanan
                            </button>
                        </form>
                        @elseif($order->status == 'cancelled')
                            <span class="text-xs font-bold text-red-400 italic">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-xl border border-gray-100">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mt-2 mb-6">Kamu belum pernah memesan makanan.</p>
            <a href="{{ route('menu.index') }}" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition">
                Pesan Sekarang
            </a>
        </div>
    @endif
</div>

{{-- MODAL BUKTI BAYAR (Hidden by default) --}}
<div id="modal-bukti" class="fixed inset-0 z-9999 hidden items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeBukti()">
    <div class="relative max-w-lg w-full p-4 transform transition-all scale-100">
        <button onclick="closeBukti()" class="absolute -top-2 -right-2 bg-white rounded-full p-2 text-gray-800 hover:bg-gray-200 shadow-lg z-10 border border-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <img id="img-bukti" src="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg shadow-2xl border border-white/20 bg-black">
        <p class="text-center text-white/80 mt-2 text-sm">Bukti Pembayaran Anda</p>
    </div>
</div>

{{-- SCRIPT UNTUK MODAL --}}
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