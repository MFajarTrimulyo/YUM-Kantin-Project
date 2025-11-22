@extends('layouts.admin_layout')
@section('title', 'Laporan Penjualan')
@section('content')

<div class="container mx-auto px-4">
    
    {{-- Header & Print --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h1>
            <p class="text-gray-500 text-sm">Ringkasan pendapatan dan transaksi.</p>
        </div>
        <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center gap-2 text-sm shadow-lg no-print">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Laporan
        </button>
    </div>

    {{-- Filter Tanggal --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 no-print">
        <form action="{{ route('laporan.index', Auth::user()->role) }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded-lg text-sm focus:ring-yum-primary focus:border-yum-primary">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded-lg text-sm focus:ring-yum-primary focus:border-yum-primary">
            </div>
            <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-yum-dark transition shadow-md">
                Filter Data
            </button>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-bold uppercase">Total Pendapatan</h3>
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
            <p class="text-xs text-green-500 mt-1 font-bold">+ Penjualan Selesai</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-bold uppercase">Total Transaksi</h3>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }}</p>
            <p class="text-xs text-gray-400 mt-1">Pesanan berhasil</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-bold uppercase">Produk Terjual</h3>
                <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalItemTerjual }}</p>
            <p class="text-xs text-gray-400 mt-1">Porsi makanan/minuman</p>
        </div>
    </div>

    {{-- Grafik Chart --}}
    <div class="bg-white p-6 rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Pendapatan</h3>
        <div class="w-full h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Tabel Detail --}}
    <div class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Rincian Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">ID Order</th>
                        <th class="px-6 py-3">Tanggal</th>
                        @if(Auth::user()->role == 'admin') <th class="px-6 py-3">Gerai</th> @endif
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3 text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporan as $data)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-mono font-bold">#{{ substr($data->id, -6) }}</td>
                        <td class="px-6 py-3">{{ $data->created_at->format('d/m/Y H:i') }}</td>
                        
                        @if(Auth::user()->role == 'admin') 
                            <td class="px-6 py-3">
                                <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-bold">{{ $data->gerai->nama }}</span>
                            </td> 
                        @endif
                        
                        <td class="px-6 py-3">{{ $data->user->nama }}</td>
                        <td class="px-6 py-3 text-right font-bold text-gray-800">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Chart.js Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        const labels = {!! json_encode($chartDates) !!};
        const data = {!! json_encode($chartTotals) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: data,
                    borderColor: '#0075FF',
                    backgroundColor: 'rgba(0, 117, 255, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>

{{-- CSS Khusus Print --}}
<style>
    @media print {
        .no-print, aside, header { display: none !important; }
        .container { width: 100% !important; max-width: none !important; padding: 0 !important; }
        .shadow-lg, .shadow-sm { box-shadow: none !important; }
        body { bg-white; }
    }
</style>

@endsection