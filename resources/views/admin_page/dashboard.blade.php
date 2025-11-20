@extends('layouts.admin_layout')
@section('title', 'Dashboard Overview')
@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Card 1: Total Pendapatan -->
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
            <p class="text-2xl font-bold text-gray-800">Rp 4.2M</p>
        </div>
    </div>

    <!-- Card 2: Total Pesanan -->
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-yum-primary/10 text-yum-primary mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
            <p class="text-2xl font-bold text-gray-800">1,240</p>
        </div>
    </div>

    <!-- Card 3: Menu Aktif -->
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-yum-yellow/20 text-yum-action mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Menu Aktif</p>
            <p class="text-2xl font-bold text-gray-800">86</p>
        </div>
    </div>

    <!-- Card 4: User Baru -->
    <div class="bg-white rounded-xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center">
        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">User Baru</p>
            <p class="text-2xl font-bold text-gray-800">128</p>
        </div>
    </div>

</div>

<!-- RECENT ORDERS TABLE -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-lg text-gray-800">Pesanan Terbaru</h3>
        <button class="text-sm text-yum-primary hover:underline font-medium">Lihat Semua</button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID Pesanan</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Menu</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    // Dummy data for preview
                    $orders = [
                        ['id' => '#ORD-001', 'name' => 'Fajar Gumilang', 'menu' => 'Nasi Goreng Mawut (x2)', 'price' => 'Rp 24.000', 'status' => 'pending'],
                        ['id' => '#ORD-002', 'name' => 'Siti Aminah', 'menu' => 'Es Teh Jumbo', 'price' => 'Rp 5.000', 'status' => 'cooking'],
                        ['id' => '#ORD-003', 'name' => 'Budi Santoso', 'menu' => 'Ayam Geprek Level 5', 'price' => 'Rp 18.000', 'status' => 'ready'],
                        ['id' => '#ORD-004', 'name' => 'Dewi Persik', 'menu' => 'Soto Ayam Lamongan', 'price' => 'Rp 15.000', 'status' => 'completed'],
                    ];
                @endphp

                @foreach($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $order['id'] }}</td>
                    <td class="px-6 py-4">{{ $order['name'] }}</td>
                    <td class="px-6 py-4">{{ $order['menu'] }}</td>
                    <td class="px-6 py-4 font-bold">{{ $order['price'] }}</td>
                    <td class="px-6 py-4">
                        @if($order['status'] == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                        @elseif($order['status'] == 'cooking')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Dimasak</span>
                        @elseif($order['status'] == 'ready')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Siap Diambil</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-yum-primary hover:text-yum-dark transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection