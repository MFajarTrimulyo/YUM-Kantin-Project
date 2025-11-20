@extends('layouts.admin_layout')
@section('title', 'Edit Menu')
@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Menu</h2>
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            
            {{-- Foto --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Menu</label>
                @if($produk->photo)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $produk->photo) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
                <input type="file" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yum-primary/10 file:text-yum-primary hover:file:bg-yum-primary/20">
            </div>

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Menu</label>
                <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none" placeholder="Contoh: Nasi Goreng Spesial">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <select name="fk_kategori" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none">
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach($kategoris as $kat)
                            @if ($kat->nama == 'Semua')
                                @continue
                            @endif
                            <option value="{{ $kat->id }}" {{ old('fk_kategori', $produk->fk_kategori) == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                    @error('fk_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Stok Harian</label>
                    <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none">
                    @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none" placeholder="0">
                    @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Diskon (Opsional) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Potongan Diskon (Rp)</label>
                    <input type="number" name="harga_diskon" value="{{ old('harga_diskon', $produk->harga_diskon) }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none" placeholder="0 jika tidak ada">
                    <p class="text-xs text-gray-400 mt-1">Isi 0 jika tidak ada diskon.</p>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>

            {{-- Pilihan Rasa --}}
            <div class="col-span-1">
                <label class="block text-sm font-bold text-gray-700 mb-2">Varian Rasa / Toping</label>
                <input type="text" name="pilihan_rasa" value="{{ old('pilihan_rasa', $produk->pilihan_rasa) }}" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 outline-none" 
                    placeholder="Pisahkan dengan koma. Contoh: Pedas, Manis, Original">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ada varian.</p>
            </div>

        </div>

        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('produk.index') }}" class="px-6 py-2 rounded-lg text-gray-500 font-bold hover:bg-gray-100">Batal</a>
            <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold shadow hover:bg-yum-dark">Simpan Menu</button>
        </div>
    </form>
</div>
@endsection