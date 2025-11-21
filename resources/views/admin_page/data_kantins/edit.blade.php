@extends('layouts.admin_layout')

@section('title', 'Edit Kantin')

@section('content')

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-lg font-bold text-gray-800">Edit Kantin: {{ $kantin->nama }}</h2>
        <a href="{{ route('kantins.index') }}" class="text-sm text-gray-500 hover:text-yum-primary">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('kantins.update', $kantin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Kantin</label>
            @if($kantin->photo && file_exists(storage_path('app/public/' . $kantin->photo)))
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $kantin->photo) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                </div>
            @elseif($kantin->photo)
                <div class="mb-4">
                    <img src="{{ asset($kantin->photo) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                </div>
            @endif
            
            <input type="file" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yum-primary/10 file:text-yum-primary hover:file:bg-yum-primary/20">
            @error('photo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama Kantin --}}
        <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Kantin</label>
            <input type="text" name="nama" id="nama" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yum-primary focus:border-yum-primary transition text-sm"
                value="{{ old('nama', $kantin->nama) }}">
            @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lokasi Kantin --}}
        <div class="mb-6">
            <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi Kantin</label>
            <input type="text" name="lokasi" id="lokasi" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yum-primary focus:border-yum-primary transition text-sm"
                value="{{ old('lokasi', $kantin->lokasi) }}">
            @error('lokasi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition shadow-md">
                Update Kantin
            </button>
        </div>
    </form>
</div>

@endsection