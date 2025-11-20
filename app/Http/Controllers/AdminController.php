<?php

namespace App\Http\Controllers;

use App\Models\Gerai;
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
}
