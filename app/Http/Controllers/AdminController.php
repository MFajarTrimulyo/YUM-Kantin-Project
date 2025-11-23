<?php

namespace App\Http\Controllers;

use App\Models\Gerai;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role == 'admin') {
            // --- ADMIN ---
            
            // Card 1: Total Pendapatan (Semua Gerai)
            $data['revenue'] = Pemesanan::where('status', 'completed')->sum('total_harga');
            
            // Card 2: Total Transaksi
            $data['orders_count'] = Pemesanan::count();

            // Card 3: Total Gerai (Admin Only)
            $data['card3_label'] = 'Total Gerai';
            $data['card3_value'] = Gerai::count();
            $data['card3_type']  = 'gerai'; // Untuk pembeda icon di view

            // Card 4: Total User Registered
            $data['card4_label'] = 'Total User';
            $data['card4_value'] = User::where('role', 'user')->count();
            $data['card4_type']  = 'user';

            // Tabel: 5 Pesanan Terakhir (Global)
            $data['recent_orders'] = Pemesanan::with(['user', 'gerai'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

        } else {
            // --- PENJUAL ---
            
            // Cek apakah sudah punya gerai
            if (!$user->gerai) {
                return redirect()->route('gerai.create')->with('warning', 'Silakan buat gerai terlebih dahulu.');
            }
            
            $geraiId = $user->gerai->id;

            // Card 1: Total Pendapatan Gerai Ini
            $data['revenue'] = Pemesanan::where('fk_gerai', $geraiId)->where('status', 'completed')->sum('total_harga');
            
            // Card 2: Total Pesanan
            $data['orders_count'] = Pemesanan::where('fk_gerai', $geraiId)->count();

            // Card 3: Menu Aktif (Stok > 0)
            $data['card3_label'] = 'Menu Terdaftar';
            $data['card3_value'] = Produk::where('fk_gerai', $geraiId)->where('stok', '>', 0)->count();
            $data['card3_type']  = 'menu';

            // Card 4: Pesanan Pending (Butuh Tindakan)
            $data['card4_label'] = 'Pesanan Baru';
            $data['card4_value'] = Pemesanan::where('fk_gerai', $geraiId)->where('status', 'pending')->count();
            $data['card4_type']  = 'pending';

            // Tabel: 5 Pesanan Terakhir Gerai Ini
            $data['recent_orders'] = Pemesanan::where('fk_gerai', $geraiId)
                                        ->with(['user', 'detail_pemesanans.produk'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
        }

        return view('admin_page.dashboard', compact('data'));
    }

    // 1. Tampilkan Daftar Gerai
    public function gerai()
    {
        // Ambil data gerai, urutkan yang belum verifikasi di paling atas
        $gerais = Gerai::with(['user', 'kantin'])
                        ->orderBy('is_verified', 'asc') 
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

        return view('admin_page.data_gerais.index', compact('gerais'));
    }

    // 2. Proses Verifikasi Gerai
    public function verifyGerai($id)
    {
        $gerai = Gerai::findOrFail($id);
        
        $gerai->update([
            'is_verified' => true
        ]);

        return redirect()->back()->with('success', 'Gerai ' . $gerai->nama . ' berhasil diverifikasi!');
    }

    // 3. Hapus Gerai (Opsional, jika admin ingin menolak)
    public function destroyGerai($id)
    {
        $gerai = Gerai::findOrFail($id);
        $gerai->delete();

        return redirect()->back()->with('success', 'Gerai berhasil dihapus.');
    }

    // 4. Tampilkan Daftar Pesanan dengan Filter
    public function orders(Request $request)
    {
        $query = Pemesanan::with(['user', 'gerai', 'detail_pemesanans.produk'])
                    ->orderBy('created_at', 'desc');

        // 1. Filter by Status (Tab)
        $status = $request->query('status', 'all');
        if ($status != 'all') {
            $query->where('status', $status);
        }

        // 2. Filter by Gerai (Dropdown)
        $geraiId = $request->query('gerai_id');
        if ($geraiId) {
            $query->where('fk_gerai', $geraiId);
        }

        $orders = $query->paginate(10);
        
        // Data pendukung untuk filter
        $gerais = Gerai::all(); 
        
        // Hitung Counter untuk Badge Tab
        $counts = [
            'pending' => Pemesanan::where('status', 'pending')->count(),
            'cooking' => Pemesanan::where('status', 'cooking')->count(),
            'ready'   => Pemesanan::where('status', 'ready')->count(),
        ];

        return view('admin_page.data_pemesanans.index', compact('orders', 'gerais', 'status', 'counts', 'geraiId'));
    }

    // 1. Tampilkan Daftar User
    public function users(Request $request)
    {
        $query = User::query();

        // Fitur Pencarian Sederhana
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(10);

        return view('admin_page.data_users.index', compact('users'));
    }

    // 2. Update Role User
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Cegah Admin mengubah role dirinya sendiri (agar tidak terkunci)
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengubah role akun sendiri.');
        }

        $request->validate([
            'role' => 'required|in:admin,penjual,user'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Role pengguna berhasil diubah menjadi ' . ucfirst($request->role));
    }

    // 3. Hapus User
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Cegah Admin menghapus dirinya sendiri
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        // Hapus User (Data terkait seperti Gerai/Pesanan akan ikut terhapus jika settingan database ON DELETE CASCADE)
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
