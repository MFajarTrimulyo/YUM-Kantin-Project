@extends('layouts.admin_layout') {{-- Atau layout khusus penjual jika ada --}}
@section('title', 'Kelola Menu')
@section('content')

<div class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Daftar Menu Makanan</h2>
            <p class="text-xs text-gray-500">Kelola ketersediaan dan harga menu gerai anda.</p>
        </div>
        
        <a href="{{ route('produk.create') }}" class="bg-yum-primary text-white text-sm font-bold px-4 py-2 rounded-lg shadow hover:bg-yum-dark transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Menu
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-100 text-green-600 px-4 py-3 rounded-lg text-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="px-4 py-3 font-semibold rounded-tl-lg">Produk</th>
                    <th class="px-4 py-3 font-semibold">Kategori</th>
                    <th class="px-4 py-3 font-semibold">Harga</th>
                    <th class="px-4 py-3 font-semibold">Harga Diskon</th>
                    <th class="px-4 py-3 font-semibold">Stok</th>
                    <th class="px-4 py-3 font-semibold text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($produks as $produk)
                <tr class="hover:bg-gray-50/50 transition group">
                    {{-- Foto & Nama --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden shrink-0 border border-gray-200">
                                @if($produk->photo)
                                    <img src="{{ asset('storage/' . $produk->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Pic</div>
                                @endif
                            </div>
                            
                            <div>
                                <div class="font-bold text-gray-800">{{ $produk->nama }}</div>
                                
                                {{-- List Rasa --}}
                                @if($produk->pilihan_rasa)
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach(explode(',', $produk->pilihan_rasa) as $rasa)
                                            <span class="bg-gray-100 text-gray-600 text-[10px] px-1.5 py-0.5 rounded border border-gray-200">
                                                {{ trim($rasa) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-xs text-gray-400 line-clamp-1">{{ $produk->deskripsi }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td class="px-4 py-3">
                        <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded">
                            {{ $produk->kategori->nama ?? 'Uncategorized' }}
                        </span>
                    </td>

                    {{-- Harga --}}
                    <td class="px-4 py-3">
                        @if($produk->harga_diskon > 0)
                            <div class="text-xs text-gray-400 line-through">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                            <div class="font-bold text-red-500">Rp {{ number_format($produk->harga - $produk->harga_diskon, 0, ',', '.') }}</div>
                        @else
                            <div class="font-bold text-gray-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                        @endif
                    </td>

                    {{-- Harga Diskon --}}
                    <td class="px-4 py-3">
                        @if($produk->harga_diskon > 0)
                            <div class="font-bold text-red-500">Rp {{ number_format($produk->harga_diskon, 0, ',', '.') }}</div>
                        @else
                            <div class="text-gray-400">-</div>
                        @endif
                    </td>

                    {{-- Stok --}}
                    <td class="px-4 py-3">
                        @if($produk->stok > 5)
                            <span class="text-green-600 font-bold text-xs flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> {{ $produk->stok }} Porsi
                            </span>
                        @elseif($produk->stok > 0)
                            <span class="text-yellow-600 font-bold text-xs flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Sisa {{ $produk->stok }}
                            </span>
                        @else
                            <span class="text-red-500 font-bold text-xs flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Habis
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400 bg-gray-50/50 rounded-lg">
                        Belum ada menu makanan. Yuk tambah sekarang!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $produks->links() }}</div>
</div>
@endsection