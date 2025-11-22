@extends('layouts.admin_layout')
@section('title', 'Tambah Rekening')
@section('content')

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-6">Tambah Rekening Baru</h2>

    <form action="{{ route('admin.rekenings.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Bank / E-Wallet</label>
            <input type="text" name="nama_bank" value="{{ old('nama_bank') }}" placeholder="Contoh: BCA, BRI, DANA" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-yum-primary focus:border-yum-primary">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Rekening</label>
            <input type="number" name="nomor_rekening" value="{{ old('nomor_rekening') }}" placeholder="Contoh: 1234567890" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-yum-primary focus:border-yum-primary">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Atas Nama</label>
            <input type="text" name="atas_nama" value="{{ old('atas_nama') }}" placeholder="Contoh: YUM Official" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-yum-primary focus:border-yum-primary">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.rekenings.index') }}" class="px-4 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-lg transition">Batal</a>
            <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition shadow-md">Simpan</button>
        </div>
    </form>
</div>
@endsection