<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        $rekenings = Rekening::latest()->get();
        return view('admin_page.data_rekening.index', compact('rekenings'));
    }

    public function create()
    {
        return view('admin_page.data_rekening.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'nomor_rekening' => 'required|numeric',
            'atas_nama' => 'required|string|max:100',
        ]);

        Rekening::create([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
            'is_active' => true // Default aktif
        ]);

        return redirect()->route('admin.rekenings.index')->with('success', 'Rekening berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('admin_page.data_rekening.edit', compact('rekening'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'nomor_rekening' => 'required|numeric',
            'atas_nama' => 'required|string|max:100',
            'is_active' => 'boolean'
        ]);

        $rekening = Rekening::findOrFail($id);
        
        $rekening->update([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
            'is_active' => $request->has('is_active') // Checkbox logic
        ]);

        return redirect()->route('admin.rekenings.index')->with('success', 'Data rekening diperbarui!');
    }

    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();

        return redirect()->route('admin.rekenings.index')->with('success', 'Rekening dihapus.');
    }
}