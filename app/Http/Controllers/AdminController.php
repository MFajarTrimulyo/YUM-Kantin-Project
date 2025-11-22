<?php

namespace App\Http\Controllers;

use App\Models\Gerai;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin_page.dashboard');
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
}
