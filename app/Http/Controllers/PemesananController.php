<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Pemesanan::where('fk_user', Auth::id())
                        ->with(['detail_pemesanans.produk', 'gerai'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user_page.orders.index', compact('orders'));
    }

}
