<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function home()
    {
        return view('home');
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

            $path = $request->file('photo')->store('photos', 'public');
            
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

    public function jadi_penjual(Request $request)
    {
        $user = auth()->user();
        $user->role = 'penjual';
        $user->save();

        return redirect()->route('profile.edit', ['username' => $user->username])->with('success', 'Anda sekarang telah menjadi penjual.');
    }

    public function menu(Request $request)
    {
        // Simulasi Pencarian
        $search = $request->input('search');
        $category = $request->input('category');

        // $products = Produk::with('gerai', 'kategori')
        //     ->where(function ($query) use ($search, $category) {
        //         if ($search) {
        //             $query->where('nama', 'like', '%' . $search . '%');
        //         }
        //         if ($category) {
        //             $query->whereHas('kategori', function ($q) use ($category) {
        //                 $q->where('nama', $category);
        //             });
        //         }
        //     })
        //     ->paginate(12);

        // Data Dummy untuk Tampilan
        $products = collect([]);
        for ($i = 1; $i <= 12; $i++) {
            $products->push((object)[
                'id' => $i,
                'name' => 'Takoyaki Spesial Lezat ' . $i,
                'store_name' => 'Toko Toko',
                'category' => 'Makanan',
                'price' => 10000,
                'original_price' => 15000,
                'sold' => 100 + $i,
                'image' => 'pictures/example-food.png'
            ]);
        }

        // Jika menggunakan Database asli, gunakan ->paginate(12);
        // Disini kita pakai manual paginator untuk array dummy
        $perPage = 8;
        $page = request()->get('page', 1);
        $paginatedProducts = new LengthAwarePaginator(
            $products->forPage($page, $perPage),
            $products->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        if ($request->ajax()) {
            $view = view('user_page.menu.product-list', ['products' => $paginatedProducts])->render();
            return response()->json([
                'html' => $view,
                'next_page' => $paginatedProducts->nextPageUrl() ? $page + 1 : null
            ]);
        }

        return view('user_page.menu.index', [
            'products' => $paginatedProducts,
            'search' => $search,
            'currentCategory' => $category ?? 'Semua'
        ]);
    }
}
