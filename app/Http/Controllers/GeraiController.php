<?php

namespace App\Http\Controllers;

use App\Models\Gerai;
use App\Models\Kantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeraiController extends Controller
{
    public function createOrEdit()
    {
        $user = Auth::user();
        $gerai = $user->gerai;
        $kantins = Kantin::all();

        return view('penjual_page.profile_gerai.index', compact('gerai', 'kantins'));
    }

    public function storeOrUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'fk_kantin' => 'required|exists:kantins,id',
            'deskripsi' => 'nullable|string',
            'is_open' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($user->gerai) {
            // UPDATE
            $user->gerai->update([
                'nama' => $request->nama,
                'fk_kantin' => $request->fk_kantin,
                'deskripsi' => $request->deskripsi,
                'is_open' => $request->has('is_open'),
            ]);
            $message = 'Profil Gerai berhasil diperbarui!';
        } else {
            DB::transaction(function() use ($request, $user) {
                Gerai::create([
                   // 'id' => 'GER' . time(), // Uncomment if no DB Trigger
                    'fk_user' => $user->id,
                    'fk_kantin' => $request->fk_kantin,
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'is_open' => true,
                ]);
            });
            
            $message = 'Selamat! Gerai Anda berhasil dibuat.';
        }

        return redirect()->route('dashboard')->with('success', $message);
    }

    public function pending()
    {
        if(Auth::user()->gerai && Auth::user()->gerai->is_verified){
            return redirect()->route('dashboard');
        }
            
            return view('penjual_page.profile_gerai.pending');
    }
}
