@extends('layouts.admin_layout') 
@section('title', 'Profile Gerai')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Warning Alert if redirected --}}
    @if(session('warning'))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
        <div class="flex">
            <div class="shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    {{ session('warning') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Profil Gerai</h1>
            <p class="text-gray-500 mt-1">
                @if($gerai)
                    Kelola informasi gerai anda agar pembeli dapat mengenali toko anda.
                @else
                    Halo Penjual Baru! Silakan lengkapi data gerai anda sebelum mulai berjualan.
                @endif
            </p>
        </div>

        <form action="{{ route('gerai.store') }}" method="POST">
            @csrf

            {{-- Section: Informasi Gerai --}}
            <div class="space-y-6">
                
                {{-- Nama Gerai --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Gerai</label>
                    <input type="text" name="nama" value="{{ old('nama', $gerai->nama ?? '') }}" 
                        placeholder="Contoh: Warung Bu Siti"
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('nama') border-red-500 @enderror">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Lokasi Kantin (FK) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Kantin</label>
                    <div class="relative">
                        <select name="fk_kantin" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none appearance-none @error('fk_kantin') border-red-500 @enderror">
                            <option value="" disabled {{ !isset($gerai) ? 'selected' : '' }}>Pilih Lokasi Kantin</option>
                            @foreach($kantins as $kantin)
                                <option value="{{ $kantin->id }}" 
                                    {{ (old('fk_kantin') == $kantin->id || (isset($gerai) && $gerai->fk_kantin == $kantin->id)) ? 'selected' : '' }}>
                                    {{ $kantin->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    @error('fk_kantin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3"
                        placeholder="Jelaskan makanan spesial apa yang anda jual..."
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $gerai->deskripsi ?? '') }}</textarea>
                    @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Status Buka/Tutup (Only show if editing, or default to true/hidden for new) --}}
                @if($gerai)
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div>
                        <span class="block text-sm font-bold text-gray-700">Status Toko</span>
                        <span class="text-xs text-gray-500">Matikan jika anda sedang libur.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_open" class="sr-only peer" {{ ($gerai->is_open ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yum-primary"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 peer-checked:text-yum-primary">
                            {{ ($gerai->is_open ?? true) ? 'Buka' : 'Tutup' }}
                        </span>
                    </label>
                </div>
                @else
                    <input type="hidden" name="is_open" value="1">
                @endif

            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end items-center gap-4 pt-8 border-t border-gray-100 mt-6">
                <button type="reset" class="px-6 py-2.5 rounded-lg text-gray-500 font-bold hover:bg-gray-100 transition">
                    Reset
                </button>
                <button type="submit" class="bg-yum-primary text-white px-8 py-2.5 rounded-lg font-bold shadow-md hover:bg-yum-dark hover:shadow-lg transition transform hover:-translate-y-0.5">
                    {{ $gerai ? 'Simpan Perubahan' : 'Buka Gerai' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection