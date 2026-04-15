<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Progres;
use App\Models\HistoryStatus;

class PengaduanController extends Controller
{
    // ==================== LIST ====================
    public function index(Request $request)
    {
        $query = Aspirasi::with([
            'user.siswa',
            'user.guru',
            'kategori',
            'ruangan',
            'progres'
        ])->where('status', '!=', 'Selesai');

        // Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('keterangan', 'like', '%' . $request->search . '%')
                    ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategoris = Kategori::all();
        $ruangans = Ruangan::all();

        $statistik = [
            'total' => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses' => Aspirasi::where('status', 'Proses')->count(),
            'selesai' => Aspirasi::where('status', 'Selesai')->count(),
        ];

        return view('Pengaduan.index', compact(
            'aspirasi',
            'kategoris',
            'ruangans',
            'statistik'
        ));
    }

    /// ==================== DETAIL ====================
    public function show($id)
    {
        $aspirasi = Aspirasi::with([
            'user.siswa',
            'user.guru',
            'kategori',
            'ruangan',
            'progres.user',
            'historyStatus.pengubah'
        ])->findOrFail($id);

        $kategoris = Kategori::all();
        $ruangans = Ruangan::all();

        return view('Pengaduan.detail', compact(
            'aspirasi',
            'kategoris',
            'ruangans'
        ));
    }

    // ==================== CREATE ====================
    public function create()
    {
        $kategoris = Kategori::all();
        $ruangans = Ruangan::all();

        return view('Pengaduan.create', compact('kategoris', 'ruangans'));
    }

    // ==================== STORE ====================
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'id_ruangan' => 'required',
            'keterangan' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        Aspirasi::create([
            'user_id' => auth()->id(),
            'id_kategori' => $request->id_kategori,
            'id_ruangan' => $request->id_ruangan,
            'keterangan' => $request->keterangan,
            'lokasi' => $request->lokasi,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('Pengaduan.pengaduan')
            ->with('success', 'Aspirasi berhasil dikirim');
    }

    // ==================== FEEDBACK ====================
    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        Progres::create([
            'id_aspirasi' => $id,
            'user_id' => auth()->id(),
            'keterangan_progres' => 'Feedback: ' . $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil ditambahkan');
    }

    // ==================== PROGRES ====================
    public function storeProgres(Request $request, $id)
    {
        $request->validate([
            'keterangan_progres' => 'required|string'
        ]);

        Progres::create([
            'id_aspirasi' => $id,
            'user_id' => auth()->id(),
            'keterangan_progres' => $request->keterangan_progres,
        ]);

        return redirect()->back()->with('success', 'Progres berhasil ditambahkan');
    }

    // ==================== UPDATE STATUS ====================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'keterangan_progres' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);

        // Simpan history
        HistoryStatus::create([
            'id_aspirasi' => $id,
            'status_lama' => $aspirasi->status,
            'status_baru' => $request->status,
            'diubah_oleh' => auth()->id(),
        ]);

        $aspirasi->update([
            'status' => $request->status
        ]);

        $fotoBuktiPath = null;

        if ($request->hasFile('foto_bukti')) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('aspirasi_bukti', 'public');
        }

        if ($request->filled('keterangan_progres')) {
            $text = $request->keterangan_progres;

            if ($fotoBuktiPath) {
                $text .= "\n📎 " . asset('storage/' . $fotoBuktiPath);
            }

            Progres::create([
                'id_aspirasi' => $id,
                'user_id' => auth()->id(),
                'keterangan_progres' => $text,
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    // ==================== DELETE ====================
    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        if ($aspirasi->foto && Storage::disk('public')->exists($aspirasi->foto)) {
            Storage::disk('public')->delete($aspirasi->foto);
        }

        Progres::where('id_aspirasi', $id)->delete();
        HistoryStatus::where('id_aspirasi', $id)->delete();
        $aspirasi->delete();

        return redirect()->route('Pengaduan.pengaduan')
            ->with('success', 'Data berhasil dihapus');
    }
}
