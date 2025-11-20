@extends('layouts.admin_layout')
@section('title', 'Data Gerai')
@section('content')

<div class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Daftar Permintaan & Gerai Aktif</h2>
            <p class="text-xs text-gray-500">Kelola verifikasi dan data gerai mitra.</p>
        </div>
        
        {{-- Search placeholder or filter can go here if needed --}}
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
                    <th class="px-4 py-3 font-semibold rounded-tl-lg">Nama Gerai</th>
                    <th class="px-4 py-3 font-semibold">Pemilik</th>
                    <th class="px-4 py-3 font-semibold">Lokasi</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Verifikasi</th>
                    <th class="px-4 py-3 font-semibold text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                
                @forelse($gerais as $gerai)
                <tr class="hover:bg-gray-50/50 transition group">
                    {{-- Nama Gerai --}}
                    <td class="px-4 py-3">
                        <div class="font-semibold text-gray-800">{{ $gerai->nama }}</div>
                        <div class="text-xs text-gray-400">ID: {{ $gerai->id }}</div>
                    </td>

                    {{-- Pemilik --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 mr-2">
                                {{ substr($gerai->user->nama, 0, 1) }}
                            </div>
                            <div class="text-gray-600">{{ $gerai->user->nama }}</div>
                        </div>
                    </td>

                    {{-- Lokasi --}}
                    <td class="px-4 py-3 text-gray-600">
                        {{ $gerai->kantin->nama ?? '-' }}
                    </td>

                    {{-- Status Toko (Buka/Tutup) --}}
                    <td class="px-4 py-3">
                        @if($gerai->is_open)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                Buka
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                Tutup
                            </span>
                        @endif
                    </td>

                    {{-- Status Verifikasi --}}
                    <td class="px-4 py-3">
                        @if($gerai->is_verified)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 animate-pulse">
                                Pending
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            
                            @if(!$gerai->is_verified)
                                {{-- Tombol Approve (Hijau) --}}
                                <form action="{{ route('admin.gerai.verify', $gerai->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition" title="Setujui / Verifikasi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            @else
                                {{-- Indikator Sudah Verify (Abu-abu non-clickable) --}}
                                <div class="p-2 text-gray-300" title="Sudah Terverifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @endif

                            {{-- Tombol Hapus (Merah) --}}
                            <form action="{{ route('admin.gerai.destroy', $gerai->id) }}" method="POST" onsubmit="return confirm('Hapus gerai ini? User akan kehilangan akses penjual.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus Gerai">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400 bg-gray-50/50 rounded-lg">
                        Belum ada data gerai.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $gerais->links() }}
    </div>
</div>

@endsection