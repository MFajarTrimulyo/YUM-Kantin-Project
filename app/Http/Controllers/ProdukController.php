<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // Tampilkan Daftar Menu
    public function index()
    {
        // Ambil produk HANYA milik gerai yang sedang login
        $gerai_id = Auth::user()->gerai->id;
        
        $produks = Produk::where('fk_gerai', $gerai_id)
                        ->with('kategori')
                        ->latest()
                        ->paginate(10);

        return view('penjual_page.data_produks.index', compact('produks'));
    }

    // Form Tambah
    public function create()
    {
        $kategoris = Kategori::all();
        return view('penjual_page.data_produks.create', compact('kategoris'));
    }

    // Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'fk_kategori' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:2048', // Max 2MB
            'deskripsi' => 'nullable|string',
            'pilihan_rasa' => 'nullable|string',
        ]);

        // Handle Upload Foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('produk_photos', 'public');
        }

        Produk::create([
            'fk_gerai' => Auth::user()->gerai->id, // Ambil otomatis dari user login
            'fk_kategori' => $request->fk_kategori,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'pilihan_rasa' => $request->pilihan_rasa,
            'harga' => $request->harga,
            'harga_diskon' => $request->harga_diskon ?? 0, // Default 0 jika kosong
            'stok' => $request->stok,
            'photo' => $photoPath,
        ]);

        return redirect()->route('produk.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Form Edit
    public function edit($id)
    {
        // Pastikan user hanya bisa edit produk miliknya sendiri
        $produk = Produk::where('id', $id)->where('fk_gerai', Auth::user()->gerai->id)->firstOrFail();
        $kategoris = Kategori::all();
        
        return view('penjual_page.data_produks.edit', compact('produk', 'kategoris'));
    }

    // Proses Update
    public function update(Request $request, $id)
    {
        $produk = Produk::where('id', $id)->where('fk_gerai', Auth::user()->gerai->id)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'fk_kategori' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'fk_kategori' => $request->fk_kategori,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'harga_diskon' => $request->harga_diskon ?? 0,
            'stok' => $request->stok,
        ];

        // Cek jika ada foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($produk->photo) {
                Storage::disk('public')->delete($produk->photo);
            }
            $data['photo'] = $request->file('photo')->store('produk_photos', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // Proses Hapus
    public function destroy($id)
    {
        $produk = Produk::where('id', $id)->where('fk_gerai', Auth::user()->gerai->id)->firstOrFail();
        
        if ($produk->photo) {
            Storage::disk('public')->delete($produk->photo);
        }
        
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Menu berhasil dihapus.');
    }
}
