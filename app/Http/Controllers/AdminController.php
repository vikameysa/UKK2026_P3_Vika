<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Petugas;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with(['user.siswa', 'user.guru', 'kategori', 'ruangan']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }
        if ($request->ruangan) {
            $query->where('id_ruangan', $request->ruangan);
        }
        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('keterangan', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        $aspirasi  = $query->latest()->paginate(10);
        $kategoris = Kategori::all();
        $ruangans  = Ruangan::all();

        // Statistik
        $totalSiswa    = Siswa::count();
        $totalGuru     = Guru::count();
        $totalAdmin    = Petugas::count(); // ← ganti nama variabel
        $totalAspirasi = Aspirasi::count();

        // Status aspirasi
        $aspirasiMenunggu = Aspirasi::where('status', 'menunggu')->count();
        $aspirasiProses   = Aspirasi::where('status', 'proses')->count();
        $aspirasiSelesai  = Aspirasi::where('status', 'selesai')->count();

        // Grafik per bulan (6 bulan terakhir)
        $bulanLabels = [];
        $bulanData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M Y');
            $bulanData[]   = Aspirasi::whereYear('created_at', $bulan->year)
                                     ->whereMonth('created_at', $bulan->month)
                                     ->count();
        }

        return view('dashboard', compact(
            'aspirasi',
            'kategoris',
            'ruangans',
            'totalSiswa',
            'totalGuru',
            'totalAdmin',
            'totalAspirasi',
            'aspirasiMenunggu',
            'aspirasiProses',
            'aspirasiSelesai',
            'bulanLabels',
            'bulanData'
        ));
    }
}