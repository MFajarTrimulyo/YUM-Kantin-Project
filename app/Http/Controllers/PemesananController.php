<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Menampilkan daftar pesanan untuk penjual dengan tab filtering
    public function index(Request $request)
    {
        $geraiId = Auth::user()->gerai->id;
        
        // Default tab: 'pending'
        $status = $request->query('status', 'pending');

        // Query Dasar
        $query = Pemesanan::where('fk_gerai', $geraiId)
                    ->with(['user', 'detail_pemesanans.produk']); // Eager Load

        // Filter berdasarkan Tab
        if ($status == 'history') {
            $query->whereIn('status', ['completed', 'cancelled']);
        } else {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', $status == 'history' ? 'desc' : 'asc')->get();

        // Hitung Badge Counter (Supaya penjual tahu ada berapa order di tiap tab)
        $counts = [
            'pending' => Pemesanan::where('fk_gerai', $geraiId)->where('status', 'pending')->count(),
            'cooking' => Pemesanan::where('fk_gerai', $geraiId)->where('status', 'cooking')->count(),
            'ready'   => Pemesanan::where('fk_gerai', $geraiId)->where('status', 'ready')->count(),
        ];

        return view('penjual_page.data_pesanans.index', compact('orders', 'status', 'counts'));
    }

    // Update Status Pesanan oleh Penjual
    public function updateStatus(Request $request, $id)
    {
        // Eager load detail pemesanan agar bisa akses produknya
        $order = Pemesanan::with('detail_pemesanans.produk')
                    ->where('id', $id)
                    ->where('fk_gerai', Auth::user()->gerai->id)
                    ->firstOrFail();
        
        $request->validate([
            'status' => 'required|in:cooking,ready,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            // LOGIC PENGEMBALIAN STOK (RESTOCK)
            // Jika status berubah JADI 'cancelled' DAN sebelumnya BUKAN 'cancelled'
            if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
                
                foreach ($order->detail_pemesanans as $detail) {
                    if ($detail->produk) {
                        // Kembalikan stok
                        $detail->produk->increment('stok', $detail->qty);
                        
                        // Kurangi data terjual (Opsional, agar statistik akurat)
                        if ($detail->produk->terjual >= $detail->qty) {
                            $detail->produk->decrement('terjual', $detail->qty);
                        }
                    }
                }
            }

            // Update Status Pesanan
            $order->update([
                'status' => $newStatus
            ]);

            DB::commit();

            // Redirect logic
            $redirectStatus = match($newStatus) {
                'cooking' => 'pending',
                'ready' => 'cooking',
                'completed' => 'ready',
                'cancelled' => 'pending',
                default => 'pending'
            };

            return redirect()->route('penjual.pemesanan.index', ['status' => $redirectStatus])
                ->with('success', 'Status pesanan #' . $order->id . ' diperbarui menjadi ' . strtoupper($newStatus));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    // Menampilkan daftar pesanan untuk user
    public function order_user()
    {
        $orders = Pemesanan::where('fk_user', Auth::id())
                        ->with(['detail_pemesanans.produk', 'gerai'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user_page.orders.index', compact('orders'));
    }

    // Batalkan Pesanan oleh User
    public function cancelByUser($id)
    {
        // 1. Cari Pesanan (Pastikan milik user yang sedang login)
        $order = Pemesanan::where('id', $id)
                    ->where('fk_user', Auth::id())
                    ->firstOrFail();

        // 2. Validasi: Hanya boleh cancel jika status masih 'pending'
        if ($order->status != 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::beginTransaction();
        try {
            // 3. Kembalikan Stok (Restock)
            foreach ($order->detail_pemesanans as $detail) {
                if ($detail->produk) {
                    $detail->produk->increment('stok', $detail->qty);
                    
                    // Opsional: Kurangi counter terjual
                    if ($detail->produk->terjual >= $detail->qty) {
                        $detail->produk->decrement('terjual', $detail->qty);
                    }
                }
            }

            // 4. Update Status
            $order->update([
                'status' => 'cancelled'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

}
