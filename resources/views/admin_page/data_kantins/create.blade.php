@extends('layouts.admin_layout')

@section('title', 'Tambah Kantin')

@section('content')

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-lg font-bold text-gray-800">Tambah Kantin Baru</h2>
        <a href="{{ route('kantins.index') }}" class="text-sm text-gray-500 hover:text-yum-primary">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('kantins.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Kantin</label>
            <input type="text" name="nama" id="nama" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yum-primary focus:border-yum-primary transition text-sm"
                placeholder="Contoh: Kantin A"
                value="{{ old('nama') }}">
            @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition shadow-md">
                Simpan Kantin
            </button>
        </div>
    </form>
</div>

@endsection