<?php

namespace App\Http\Controllers;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // View Cart
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }
        
        $total = $subtotal;

        return view('user_page.cart.index', compact('cart', 'subtotal', 'total'));
    }

    // Add to Cart
    public function addToCart(Request $request, $id)
    {
        $product = Produk::findOrFail($id);
        $cart = session()->get('cart', []);
        
        // Ambil qty dari modal, default 1 jika error
        $qty = $request->input('qty', 1);
        // Ambil catatan
        $note = $request->input('note', null);
        $rasa = $request->input('rasa', null); // Ambil Rasa

        $cartId = $id . ($rasa ? '_' . Str::slug($rasa) : '');

        if(isset($cart[$cartId])) {
            // Jika produk sudah ada, tambahkan qty-nya
            $cart[$cartId]['qty'] += $qty;
            
            // Update catatan jika user mengisi catatan baru (opsional)
            if($note) {
                $cart[$cartId]['note'] = $note;
            }
        } else {
            // Jika produk baru
            $cart[$cartId] = [
                "fk_produk" => $product->id,
                "name" => $product->nama,
                "qty" => $qty,
                "harga" => ($product->harga_diskon > 0) ? ($product->harga - $product->harga_diskon) : $product->harga,
                "photo" => $product->photo,
                "gerai_id" => $product->fk_gerai,
                "note" => $note, // Simpan catatan
                "rasa" => $rasa // Simpan rasa
            ];
        }

        session()->put('cart', $cart);

        if ($request->input('action') == 'checkout') {
            // Jika klik "Pesan Sekarang", lempar ke cart dengan sinyal buka modal
            return redirect()->route('cart.index')->with('open_checkout_modal', true);
        }
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Remove from Cart
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Produk dihapus!');
        }
    }

    // Checkout
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');

        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // 1. Validasi Bukti Bayar
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_bayar.required' => 'Anda wajib mengupload bukti transfer.',
            'bukti_bayar.image' => 'File harus berupa gambar.',
            'bukti_bayar.max' => 'Ukuran file maksimal 2MB.'
        ]);

        // 2. Upload File
        $buktiPath = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        }

        // 3. Grouping Cart by Gerai
        $ordersByGerai = [];
        foreach($cart as $cartId => $details) {
            // CEK DATA: Jika data keranjang lama (rusak), skip atau reset
            if (!isset($details['fk_produk'])) {
                session()->forget('cart'); // Hapus keranjang rusak
                return redirect()->route('cart.index')
                    ->with('error', 'Sistem diperbarui. Silakan masukkan ulang barang ke keranjang.');
            }

            $geraiId = $details['gerai_id'];
            $ordersByGerai[$geraiId][] = [
                'product_id' => $details['fk_produk'],
                'qty' => $details['qty'],
                'harga' => $details['harga'],
                'catatan' => $details['note'],
                'rasa' => $details['rasa'] ?? null,
            ];
        }

        DB::beginTransaction();
        try {
            foreach($ordersByGerai as $geraiId => $items) {
                
                $totalPerGerai = 0;
                foreach($items as $item) {
                    $totalPerGerai += $item['harga'] * $item['qty'];
                }

                // Create Header Pemesanan
                $pemesanan = Pemesanan::create([
                    'fk_user' => Auth::id(),
                    'fk_gerai' => $geraiId,
                    'total_harga' => $totalPerGerai,
                    'status' => 'pending',
                    'status_bayar' => 'paid', // Asumsi paid menunggu verifikasi admin/penjual
                    'bukti_bayar' => $buktiPath
                ]);

                // Create Details & KURANGI STOK
                foreach($items as $item) {
                    
                    // Ambil data produk terbaru untuk cek stok real-time
                    $produk = Produk::lockForUpdate()->find($item['product_id']); // Lock row agar tidak bentrok

                    if (!$produk) {
                        throw new \Exception("Produk tidak ditemukan.");
                    }

                    // Cek apakah stok cukup
                    if ($produk->stok < $item['qty']) {
                        throw new \Exception("Stok untuk produk '{$produk->nama}' tidak mencukupi. Sisa stok: {$produk->stok}");
                    }

                    // A. Kurangi Stok
                    $produk->decrement('stok', $item['qty']);
                    // Update kolom terjual (Opsional, biar data statistik jalan)
                    $produk->increment('terjual', $item['qty']);

                    // B. Simpan Detail
                    DetailPemesanan::create([
                        'fk_order' => $pemesanan->id,
                        'fk_produk' => $item['product_id'],
                        'qty' => $item['qty'],
                        'harga_satuan_saat_beli' => $item['harga'],
                        'catatan' => $item['catatan'] . ($item['rasa'] ? ' (' . $item['rasa'] . ')' : '')
                    ]);
                }
            }

            session()->forget('cart');
            
            DB::commit();
            return redirect()->route('pemesanan.user.index', ['username' => Auth::user()->username])->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            if($buktiPath) Storage::disk('public')->delete($buktiPath);
            
            return redirect()->back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}
