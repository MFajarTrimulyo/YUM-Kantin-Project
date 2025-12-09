<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StrukController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        
        $order = Pemesanan::with(['gerai', 'user', 'detail_pemesanans.produk'])
                    ->findOrFail($id);

        if ($user->role == 'admin') {
            // Admin BOLEH melihat semua struk -> Lanjut
        } 
        elseif ($user->role == 'penjual') {
            // Penjual HANYA BOLEH lihat struk tokonya sendiri
            if (!$user->gerai || $order->fk_gerai != $user->gerai->id) {
                abort(403, 'Akses Ditolak. Ini bukan pesanan toko Anda.');
            }
        } 
        else { 
            // Pembeli (User) HANYA BOLEH lihat struk miliknya sendiri
            if ($order->fk_user != $user->id) {
                abort(403, 'Akses Ditolak. Ini bukan pesanan Anda.');
            }
        }

        // 3. Tampilkan View Struk
        return view('admin_page.data_pemesanans.struk', compact('order'));
    }
}
