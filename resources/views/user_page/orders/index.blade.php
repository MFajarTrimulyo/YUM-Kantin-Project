@extends('layouts.user_layout')
@section('content')

<div class="container mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-l-4 border-yum-primary pl-4">Riwayat Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($orders)
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                
                {{-- Header Card: Info Order --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800 text-lg">{{ $order->gerai->nama ?? 'Gerai Tidak Ditemukan' }}</span>
                            <span class="text-xs text-gray-400">#{{ $order->id }}</span>
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

                        {{-- Badge Status Bayar --}}
                        @if($order->status_bayar == 'paid')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Lunas</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">Belum Bayar</span>
                        @endif
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
                    <span class="text-sm font-bold text-gray-500">Total Pesanan</span>
                    <span class="text-xl font-bold text-yum-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
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
@endsection