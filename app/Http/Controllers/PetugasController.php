<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aspirasi;
use App\Models\Progres;
use App\Models\HistoryStatus;
use App\Models\Kategori; // FIX 1: tambah import Kategori

class PetugasController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        return view('Petugas.dashboard', [
            'total'    => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses'   => Aspirasi::where('status', 'Proses')->count(),
            'selesai'  => Aspirasi::where('status', 'Selesai')->count(),
        ]);
    }

    // ================= INDEX =================
    public function index(Request $request)
    {
        $query = Aspirasi::with(['user.siswa', 'user.guru', 'kategori', 'ruangan'])
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->search) {
            $query->where('keterangan', 'like', "%{$request->search}%");
        }

        return view('Petugas.aspirasi.index', [
            'aspirasi'  => $query->paginate(10),
            'kategoris' => Kategori::all(), // FIX 2: kirim $kategoris ke view
        ]);
    }

    // ================= DETAIL =================
    // FIX 3: nama method 'detail' bukan 'show', dan view path pakai huruf besar 'Petugas'
    public function detail($id)
    {
        $aspirasi = Aspirasi::with([
            'user.siswa',
            'user.guru',
            'kategori',
            'ruangan',
            'progres.user',
            'historyStatus.pengubah',
        ])->findOrFail($id);

        return view('Petugas.aspirasi.detail', compact('aspirasi'));
    }

    // ================= FEEDBACK =================
    public function storeFeedback(Request $request, $id)
    {
        $request->validate(['feedback' => 'required']);

        Progres::create([
            'id_aspirasi'        => $id,
            'user_id'            => Auth::id(),
            'keterangan_progres' => 'Feedback: ' . $request->feedback,
        ]);

        return back()->with('success', 'Feedback terkirim');
    }

    // ================= PROGRES =================
    public function storeProgres(Request $request, $id)
    {
        $request->validate(['keterangan_progres' => 'required']);

        Progres::create([
            'id_aspirasi'        => $id,
            'user_id'            => Auth::id(),
            'keterangan_progres' => $request->keterangan_progres,
        ]);

        return back()->with('success', 'Progres ditambahkan');
    }

    // ================= STATUS =================
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Menunggu,Proses,Selesai']);

        $aspirasi = Aspirasi::findOrFail($id);

        HistoryStatus::create([
            'id_aspirasi' => $id,
            'status_lama' => $aspirasi->status,
            'status_baru' => $request->status,
            'diubah_oleh' => Auth::id(),
        ]);

        $aspirasi->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diupdate');
    }

    // ================= HISTORY =================
    public function history()
    {
        return view('Petugas.history', [
            'history' => HistoryStatus::with('aspirasi')->latest()->paginate(20),
        ]);
    }
}
