<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantins = Kantin::paginate(5);
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
            'nama' => 'required|string|max:255|unique:kategoris,nama',
        ]);

        Kantin::create([
            'nama' => $request->nama,
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
            'nama' => 'required|string|max:255|unique:kategoris,nama,'. $id,
        ]);

        $kantin = Kantin::findOrFail($id);
        $kantin->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kantins.index')->with('success', 'Kantin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kantin = Kantin::findOrFail($id);
        $kantin->delete();
        
        return redirect()->route('kantins.index')->with('success', 'Kantin berhasil dihapus');
    }
}
