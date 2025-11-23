<?php

namespace App\Http\Controllers;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailPemesananController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // 1. Filter Tanggal (Default: Bulan Ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // 2. Query Dasar (Hanya pesanan SELESAI)
        $query = Pemesanan::where('status', 'completed')
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);

        // 3. Cek Role (Admin vs Penjual)
        if ($user->role == 'penjual') {
            if (!$user->gerai) {
                return redirect()->route('gerai.create')
                    ->with('warning', 'Silakan lengkapi profil Gerai Anda terlebih dahulu sebelum melihat laporan.');
            }

            // Penjual hanya lihat datanya sendiri
            $query->where('fk_gerai', $user->gerai->id);
        }

        // Ambil Data untuk Tabel
        $laporan = $query->with(['user', 'gerai'])->latest()->get();

        // 4. Hitung Ringkasan
        $totalOmzet = $laporan->sum('total_harga');
        $totalTransaksi = $laporan->count();
        
        // Hitung Item Terjual (Butuh query ke detail)
        $detailQuery = DetailPemesanan::whereHas('pemesanan', function($q) use ($startDate, $endDate, $user) {
            $q->where('status', 'completed')
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
            
            if ($user->role == 'penjual' && $user->gerai) {
                $q->where('fk_gerai', $user->gerai->id);
            }
        });
        $totalItemTerjual = $detailQuery->sum('qty');

        // 5. Siapkan Data untuk Grafik (Omzet per Hari)
        $grafikData = $query->reorder() 
        ->select(
            DB::raw('DATE(created_at) as date'), 
            DB::raw('SUM(total_harga) as total')
        )
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        $chartDates = $grafikData->pluck('date'); 
        $chartTotals = $grafikData->pluck('total');

        // Label Sumbu X
        $chartDates = $grafikData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d/m/Y');
        }); 

        // Data Sumbu Y
        $chartTotals = $grafikData->pluck('total'); 

        return view('laporan_page.index', compact(
            'laporan', 'totalOmzet', 'totalTransaksi', 'totalItemTerjual',
            'startDate', 'endDate', 'chartDates', 'chartTotals'
        ));
    }
}
