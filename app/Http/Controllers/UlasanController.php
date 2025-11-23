<?php

namespace App\Http\Controllers;

use App\Mail\Ulasan;
use App\Models\Ulasan as ModelsUlasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pesan' => 'required|string|min:5'
        ]);

        // 1. Simpan ke Database
        ModelsUlasan::create([
            'email' => $request->email,
            'pesan' => $request->pesan,
            'user_id' => Auth::id() ?? null
        ]);

        // 2. Kirim Email ke Admin
        try {
            Mail::to(config('mail.from.address'))->send(new Ulasan([
                'email' => $request->email,
                'pesan' => $request->pesan
            ]));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim email ulasan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah terkirim.');
    }
}
