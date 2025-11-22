@extends('layouts.admin_layout')
@section('title', 'Dashboard Overview')
@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    {{-- CARD 1: TOTAL PENDAPATAN --}}
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- CARD 2: TOTAL TRANSAKSI --}}
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-yum-primary/10 text-yum-primary mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Transaksi</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($data['orders_count']) }}</p>
        </div>
    </div>

    {{-- CARD 3: DINAMIS (Admin: Total Gerai | Penjual: Menu Aktif) --}}
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-yum-yellow/20 text-yum-action mr-4">
            @if($data['card3_type'] == 'gerai')
                {{-- Icon Toko (Admin) --}}
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            @else
                {{-- Icon Menu (Penjual) --}}
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            @endif
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">{{ $data['card3_label'] }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $data['card3_value'] }}</p>
        </div>
    </div>

    {{-- CARD 4: DINAMIS (Admin: Total User | Penjual: Pesanan Pending) --}}
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        @if($data['card4_type'] == 'pending')
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4 animate-pulse">
                {{-- Icon Lonceng (Penjual) --}}
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
        @else
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                {{-- Icon User (Admin) --}}
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        @endif
        <div>
            <p class="text-gray-500 text-sm font-medium">{{ $data['card4_label'] }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $data['card4_value'] }}</p>
        </div>
    </div>

</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-lg text-gray-800">Pesanan Terbaru</h3>
        <a href="{{ Auth::user()->role == 'admin' ? route('admin.pemesanans.index') : route('penjual.pemesanan.index') }}" class="text-sm text-yum-primary hover:underline font-medium">
            Lihat Semua
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID Pesanan</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    
                    {{-- Kolom Dinamis: Admin lihat Gerai, Penjual lihat Ringkasan Menu --}}
                    @if(Auth::user()->role == 'admin')
                        <th class="px-6 py-3">Gerai</th>
                    @else
                        <th class="px-6 py-3">Item</th>
                    @endif

                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data['recent_orders'] as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 font-mono">#{{ substr($order->id, -5) }}</td>
                    <td class="px-6 py-4">{{ $order->user->nama }}</td>
                    
                    @if(Auth::user()->role == 'admin')
                        <td class="px-6 py-4 text-yum-primary font-bold">{{ $order->gerai->nama ?? '-' }}</td>
                    @else
                        <td class="px-6 py-4">
                            @php
                                $itemCount = $order->detail_pemesanans->count();
                                $firstItem = $order->detail_pemesanans->first()->produk->nama ?? 'Item dihapus';
                            @endphp
                            {{ $firstItem }} 
                            @if($itemCount > 1) <span class="text-xs text-gray-400 italic">(+{{ $itemCount - 1 }} lainnya)</span> @endif
                        </td>
                    @endif

                    <td class="px-6 py-4 font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    
                    <td class="px-6 py-4">
                        @php
                            $statusClass = match($order->status) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'cooking' => 'bg-blue-100 text-blue-700',
                                'ready' => 'bg-green-100 text-green-700',
                                'completed' => 'bg-gray-100 text-gray-600',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="{{ $statusClass }} px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $order->status }}</span>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        {{-- Link ke halaman detail pesanan (Tab Monitoring Admin atau Tab Penjual) --}}
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.pemesanans.index') }}" class="text-yum-primary hover:text-yum-dark transition" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        @else
                            {{-- Penjual diarahkan ke tab status yang sesuai --}}
                            <a href="{{ route('penjual.pemesanan.index', ['status' => $order->status]) }}" class="text-yum-primary hover:text-yum-dark transition" title="Proses Pesanan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pesanan terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection