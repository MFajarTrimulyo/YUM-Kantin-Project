<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KantinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantins = Kantin::paginate(10);
        return view('admin_page.data_kantins.index', compact('kantins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_page.data_kantins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255|unique:kantins,nama',
            'lokasi' => 'required|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('kantin_photos', 'public');
        }

        Kantin::create([
            'photo' => $photoPath,
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('kantins.index')
            ->with('success', 'Kantin berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kantin = Kantin::findOrFail($id); 
        return view('admin_page.data_kantins.edit', compact('kantin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255|unique:kantins,nama,'. $id,
            'lokasi' => 'required|string|max:255',
        ]);

        $kantin = Kantin::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'lokasi' => $request->lokasi
        ];

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($kantin->photo) {
                Storage::disk('public')->delete($kantin->photo);
            }
            $data['photo'] = $request->file('photo')->store('kantin_photos', 'public');
        }

        $kantin->update($data);

        return redirect()->route('kantins.index')->with('success', 'Kantin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kantin = Kantin::findOrFail($id);
        if ($kantin->photo) {
            Storage::disk('public')->delete($kantin->photo);
        }
        
        $kantin->delete();
        
        return redirect()->route('kantins.index')->with('success', 'Kantin berhasil dihapus');
    }
}
