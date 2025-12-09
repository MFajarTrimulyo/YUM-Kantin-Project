@extends('layouts.admin_layout')
@section('title', 'Monitoring Pesanan')
@section('content')

<div class="container mx-auto">
    
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Pesanan</h1>
            <p class="text-gray-500 text-sm">Pantau transaksi dari seluruh gerai kantin.</p>
        </div>

        {{-- FILTER GERAI --}}
        <form action="{{ route('admin.pemesanans.index') }}" method="GET" class="flex items-center gap-2">
            {{-- Keep status param if exists --}}
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <select name="gerai_id" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-yum-primary focus:border-yum-primary block p-2.5 min-w-[200px]">
                <option value="">Semua Gerai</option>
                @foreach($gerais as $gerai)
                    <option value="{{ $gerai->id }}" {{ $geraiId == $gerai->id ? 'selected' : '' }}>
                        {{ $gerai->nama }} ({{ $gerai->kantin->nama_kantin ?? '-' }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- TAB NAVIGASI --}}
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl mb-6 overflow-x-auto">
        @php
            $tabs = [
                'all' => 'Semua',
                'pending' => 'Pending',
                'cooking' => 'Diproses',
                'ready' => 'Siap',
                'completed' => 'Selesai',
                'cancelled' => 'Batal'
            ];
        @endphp

        @foreach($tabs as $key => $label)
            <a href="{{ route('admin.pemesanans.index', ['status' => $key, 'gerai_id' => $geraiId]) }}" 
               class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition whitespace-nowrap
               {{ $status == $key ? 'bg-white text-yum-primary shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                {{ $label }}
                @if(isset($counts[$key]) && $counts[$key] > 0)
                    <span class="ml-1 bg-gray-200 text-gray-600 text-[10px] px-1.5 py-0.5 rounded-full">{{ $counts[$key] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- TABEL PESANAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">ID & Waktu</th>
                        <th class="px-6 py-4">Gerai & Pembeli</th>
                        <th class="px-6 py-4">Detail Item</th>
                        <th class="px-6 py-4">Total & Pembayaran</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        
                        {{-- ID & Waktu --}}
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-gray-800">#{{ substr($order->id, -6) }}</span>
                            <div class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </td>

                        {{-- Gerai & User --}}
                        <td class="px-6 py-4">
                            <div class="font-bold text-yum-primary">{{ $order->gerai->nama ?? 'Unknown' }}</div>
                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $order->user->nama }}
                            </div>
                        </td>

                        {{-- Item Detail (Ringkas) --}}
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @foreach($order->detail_pemesanans->take(2) as $detail)
                                    <div class="text-xs text-gray-700">
                                        <span class="font-bold">{{ $detail->qty }}x</span> {{ $detail->produk->nama ?? '-' }}
                                    </div>
                                @endforeach
                                @if($order->detail_pemesanans->count() > 2)
                                    <div class="text-[10px] text-gray-400 italic">+{{ $order->detail_pemesanans->count() - 2 }} menu lainnya</div>
                                @endif
                            </div>
                        </td>

                        {{-- Total & Bukti --}}
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            @if($order->bukti_bayar)
                                <button onclick="showBukti('{{ asset('storage/' . $order->bukti_bayar) }}')" class="mt-1 text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100 hover:bg-blue-100 flex items-center gap-1 w-fit">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Cek Bukti
                                </button>
                            @else
                                <span class="text-[10px] text-gray-400 italic">Tanpa Bukti</span>
                            @endif
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4">
                            @php
                                $badges = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'cooking' => 'bg-blue-100 text-blue-800',
                                    'ready' => 'bg-green-100 text-green-800',
                                    'completed' => 'bg-gray-100 text-gray-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="{{ $badges[$order->status] ?? 'bg-gray-100' }} text-xs font-bold px-2.5 py-0.5 rounded-full uppercase">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                {{-- TOMBOL CETAK STRUK --}}
                                <a href="{{ route('struk.show', $order->id) }}" target="_blank" 
                                class="group relative flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition border border-transparent hover:border-blue-200" 
                                title="Cetak Struk">
                                    
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    
                                    <span class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap z-10">
                                        Cetak Struk
                                    </span>
                                </a>

                                {{-- TOMBOL BATALKAN (Opsional: Hanya muncul jika status pending/cooking) --}}
                                @if($order->status == 'pending' || $order->status == 'cooking')
                                    <form action="{{ route('admin.pemesanans.update', $order->id) }}" method="POST" onsubmit="return confirm('Admin: Batalkan pesanan ini secara paksa?')">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Batalkan Paksa">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                            Belum ada data pesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->append(['status' => $status, 'gerai_id' => $geraiId])->links() }}
        </div> --}}
    </div>
</div>

{{-- MODAL BUKTI PEMBAYARAN --}}
@include('penjual_page.data_pesanans.modal_bukti_bayar')

@endsection