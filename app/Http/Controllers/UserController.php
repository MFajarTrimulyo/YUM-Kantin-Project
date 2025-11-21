<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function home()
    {
        // 1. Promo Products (Price Discount > 0)
        $promoProduks = Produk::with('gerai')
                        ->where('harga_diskon', '>', 0)
                        ->where('stok', '>', 0)
                        ->latest()
                        ->take(8)
                        ->get();

        // 2. Popular/Latest Products (Fallback to latest for now)
        $popularProduks = Produk::with('gerai')
                        ->where('stok', '>', 0)
                        ->inRandomOrder()
                        ->take(8)
                        ->get();

        return view('home', [
            'promoProduks' => $promoProduks,
            'popularProduks' => $popularProduks,
        ]);
    }

    public function edit_profile()
    {
        $gerai = auth()->user()->gerai;
        return view('user_page.profile.index', [
            'user' => auth()->user(),
            'username' => auth()->user()->username,
            'gerai' => $gerai
        ]);
    }

    public function update_profile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:20',
            'current_password' => 'nullable|string|min:6|required_with:new_password',
            'new_password' => 'nullable|string|min:6|confirmed|required_with:current_password',
        ]);

        if ($request->hasFile('photo')) {
        
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }

            $path = $request->file('photo')->store('profile_photos', 'public');
            
            $user->photo = $path;
        }

        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->alamat = $request->input('alamat');
        $user->no_telp = $request->input('no_telp');
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (password_verify($request->input('current_password'), $user->password)) {
                $user->password = bcrypt($request->input('new_password'));
            } else {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
        }
        $user->save();

        return redirect()->route('profile.edit', ['username' => $user->username])->with('success', 'Profil berhasil diperbarui.');
    }

    // Jadi Penjual
    public function jadi_penjual(Request $request)
    {
        $user = auth()->user();
        $user->role = 'penjual';
        $user->save();

        return redirect()->route('gerai.create', ['username' => $user->username])->with('success', 'Anda sekarang telah menjadi penjual.');
    }

    // Menu Page with Filters and AJAX Load More
    public function menu(Request $request)
    {
        $query = Produk::with(['gerai', 'kategori'])->where('stok', '>', 0);

        // 1. Filter Search
        if ($request->has('search') && $request->search != null) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Category
        if ($request->has('category') && $request->category != 'Semua') {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('nama', $request->category);
            });
        }

        // 3. Filter Kantin
        if ($request->has('kantin') && $request->kantin != null) {
            $query->whereHas('gerai', function($q) use ($request) {
                $q->where('fk_kantin', $request->kantin);
            });
        }

        $products = $query->latest()->paginate(8);
        $kategoris = Kategori::all();

        // Ambil Nama Kantin (Jika sedang difilter) untuk judul halaman
        $currentKantin = null;
        if($request->has('kantin')){
            $kantinModel = Kantin::find($request->kantin);
            if($kantinModel) $currentKantin = $kantinModel->nama_kantin; // Pastikan kolom di DB 'nama_kantin' atau 'nama'
        }
        
        // Handle AJAX Load More
        if ($request->ajax()) {
            return view('user_page.menu.product-list', compact('products'))->render();
        }

        return view('user_page.menu.index', compact('products', 'kategoris', 'currentKantin'));
    }

    public function listKantin()
    {
        $kantins = Kantin::withCount('gerais')->get();
        return view('user_page.kantin_list.index', compact('kantins'));
    }

    public function about()
    {
        return view('about_us');
    }
}
