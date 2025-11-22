@extends('layouts.admin_layout')
@section('title', 'Kelola Rekening')
@section('content')

<div class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-gray-800">Daftar Rekening Pembayaran</h2>
        <a href="{{ route('admin.rekenings.create') }}" class="bg-yum-primary text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-yum-dark transition shadow-md flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Rekening
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-100 text-green-600 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Nama Bank</th>
                    <th class="px-6 py-3">Nomor Rekening</th>
                    <th class="px-6 py-3">Atas Nama</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rekenings as $rek)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $rek->nama_bank }}</td>
                    <td class="px-6 py-4 font-mono">{{ $rek->nomor_rekening }}</td>
                    <td class="px-6 py-4">{{ $rek->atas_nama }}</td>
                    <td class="px-6 py-4">
                        @if($rek->is_active)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">Aktif</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-full text-xs font-bold">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <a href="{{ route('admin.rekenings.edit', $rek->id) }}" class="text-blue-500 hover:bg-blue-50 p-2 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.rekenings.destroy', $rek->id) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data rekening.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection