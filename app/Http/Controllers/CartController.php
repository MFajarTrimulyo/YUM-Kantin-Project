<?php

namespace App\Http\Controllers;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function checkout()
    {
        $cart = session()->get('cart');

        dump($cart);
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // 1. Kelompokkan Item berdasarkan Gerai ID
        $ordersByGerai = [];
        foreach($cart as $cartId => $details) {
            $geraiId = $details['gerai_id'];
            $ordersByGerai[$geraiId][] = [
                'fk_produk' => $details['fk_produk'],
                'qty' => $details['qty'],
                'harga' => $details['harga'],
                'catatan' => $details['note'],
                'rasa' => $details['rasa'] ?? null,
            ];
        }

        DB::beginTransaction();
        try {
            // Loop Utama: Per Gerai (Membuat Header Pesanan)
            foreach($ordersByGerai as $geraiId => $items) {
                
                // Hitung total per gerai
                $totalPerGerai = 0;
                foreach($items as $item) {
                    $totalPerGerai += $item['harga'] * $item['qty'];
                }

                // 2. Buat Record Pemesanan (Header)
                $pemesanan = Pemesanan::create([
                    'fk_user' => Auth::id(),
                    'fk_gerai' => $geraiId,
                    'total_harga' => $totalPerGerai,
                    'status' => 'pending',
                    'status_bayar' => 'unpaid'
                ]);

                // 3. Buat Record Detail Pemesanan (Items)
                foreach($items as $item) {
                    DetailPemesanan::create([
                        'fk_order' => $pemesanan->id,
                        'fk_produk' => $item['fk_produk'], // Pakai ID Asli
                        'qty' => $item['qty'],
                        'harga_satuan_saat_beli' => $item['harga'],
                        'catatan' => $item['catatan'] . ($item['rasa'] ? ' (' . $item['rasa'] . ')' : '') 
                    ]);
                }
            }

            // 4. Kosongkan Keranjang
            session()->forget('cart');
            
            DB::commit();
            return redirect()->route('pemesanan.index')->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi gerai.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }
}
