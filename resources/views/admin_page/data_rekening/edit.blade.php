@extends('layouts.admin_layout')
@section('title', 'Edit Rekening')
@section('content')

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-6">Edit Rekening</h2>

    <form action="{{ route('admin.rekenings.update', $rekening->id) }}" method="POST">
        @csrf 
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Bank / E-Wallet</label>
            <input type="text" name="nama_bank" value="{{ old('nama_bank', $rekening->nama_bank) }}" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-yum-primary focus:border-yum-primary">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Rekening</label>
            <input type="number" name="nomor_rekening" value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-yum-primary focus:border-yum-primary">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Atas Nama</label>
            <input type="text" name="atas_nama" value="{{ old('atas_nama', $rekening->atas_nama) }}" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-yum-primary focus:border-yum-primary">
        </div>

        {{-- Switch Status Aktif --}}
        <div class="mb-6 flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200">
            <span class="font-bold text-gray-700 text-sm">Status Aktif</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $rekening->is_active) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yum-primary"></div>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.rekenings.index') }}" class="px-4 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-lg transition">Batal</a>
            <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition shadow-md">Update</button>
        </div>
    </form>
</div>
@endsection