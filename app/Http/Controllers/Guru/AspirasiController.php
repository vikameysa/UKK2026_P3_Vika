<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Progres;
use App\Models\HistoryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    private function getGuru()
    {
        return Auth::user()->guru;
    }

    // DASHBOARD
    public function dashboard()
    {
        $guru = $this->getGuru();

        $statistik = [
            'total' => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses' => Aspirasi::where('status', 'Proses')->count(),
            'selesai' => Aspirasi::where('status', 'Selesai')->count(),
        ];

        if ($guru->canCreateAspirasi()) {
            $aspirasiTerbaru = Aspirasi::with(['kategori', 'ruangan'])
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();
        } elseif ($guru->jabatan === 'Wali Kelas') {
            $kelasId = $guru->getKelasId();

            if ($kelasId) {
                $aspirasiTerbaru = Aspirasi::with(['user.siswa', 'kategori', 'ruangan'])
                    ->whereHas('user.siswa', fn($q) => $q->where('id_kelas', $kelasId))
                    ->latest()
                    ->take(5)
                    ->get();
            } else {
                $aspirasiTerbaru = collect();
            }
        } elseif ($guru->canViewAllAspirasi()) {
            $aspirasiTerbaru = Aspirasi::with(['user.siswa', 'user.guru', 'kategori', 'ruangan'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            $aspirasiTerbaru = collect();
        }

        $bulanLabels = [];
        $bulanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');

            $bulanData[] = Aspirasi::whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();
        }

        return view('guru.dashboard', compact('guru', 'statistik', 'aspirasiTerbaru', 'bulanLabels', 'bulanData'));
    }

    // INDEX
    public function index(Request $request)
    {
        $guru = $this->getGuru();

        if ($guru->canCreateAspirasi() && !$guru->canManageAspirasi()) {
            $query = Aspirasi::with(['kategori', 'ruangan'])
                ->where('user_id', Auth::id())
                ->where('status', '!=', 'Selesai');
        } elseif ($guru->jabatan === 'Wali Kelas') {
            $type = $request->get('type', 'kelas');

            if ($type === 'saya') {
                $query = Aspirasi::with(['kategori', 'ruangan'])
                    ->where('user_id', Auth::id())
                    ->where('status', '!=', 'Selesai');
            } else {
                $kelasId = $guru->getKelasId();

                $query = $kelasId
                    ? Aspirasi::with(['user.siswa', 'kategori', 'ruangan'])
                        ->where('status', '!=', 'Selesai')
                        ->whereHas('user.siswa', fn($q) => $q->where('id_kelas', $kelasId))
                    : Aspirasi::whereRaw('1 = 0');
            }
        } elseif ($guru->canViewAllAspirasi()) {
            $query = Aspirasi::with(['user.siswa', 'user.guru', 'kategori', 'ruangan'])
                ->where('status', '!=', 'Selesai');
        } else {
            $query = Aspirasi::whereRaw('1 = 0');
        }

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
                $q->where('keterangan', 'like', "%{$request->search}%")
                  ->orWhere('lokasi', 'like', "%{$request->search}%");
            });
        }

        $aspirasi = $query->latest()->paginate(10);

        $statistik = [
            'total' => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses' => Aspirasi::where('status', 'Proses')->count(),
            'selesai' => Aspirasi::where('status', 'Selesai')->count(),
        ];

        return view('guru.aspirasi.index', [
            'guru' => $guru,
            'aspirasi' => $aspirasi,
            'statistik' => $statistik,
            'kategoris' => Kategori::all(),
            'ruangans' => Ruangan::all(),
            'currentType' => $request->get('type', 'kelas'),
        ]);
    }

    // CREATE
    public function create()
    {
        $guru = $this->getGuru();

        if (!$guru->canCreateAspirasi()) {
            abort(403);
        }

        return view('guru.aspirasi.create', [
            'guru' => $guru,
            'kategoris' => Kategori::all(),
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $guru = $this->getGuru();

        if (!$guru->canCreateAspirasi()) {
            return back()->with('error', 'Tidak diizinkan');
        }

        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $ruangan = Ruangan::findOrFail($request->id_ruangan);

        $fotoPath = $request->file('foto')
            ? $request->file('foto')->store('aspirasi_foto', 'public')
            : null;

        Aspirasi::create([
            'user_id' => Auth::id(),
            'id_kategori' => $request->id_kategori,
            'id_ruangan' => $request->id_ruangan,
            'lokasi' => $ruangan->nama_ruangan . ' (' . $ruangan->kode_ruangan . ')',
            'keterangan' => $request->keterangan,
            'foto' => $fotoPath,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('guru.aspirasi.index')->with('success', 'Berhasil');
    }

    // DETAIL
    public function detail($id)
    {
        $guru = $this->getGuru();

        $query = Aspirasi::with(['kategori', 'ruangan', 'progres.user', 'historyStatus.pengubah']);

        if ($guru->canCreateAspirasi()) {
            $query->where('user_id', Auth::id());
        }

        $aspirasi = $query->findOrFail($id);

        return view('guru.aspirasi.detail', compact('guru', 'aspirasi'));
    }

    // FEEDBACK
    public function storeFeedback(Request $request, $id)
    {
        $guru = $this->getGuru();

        if (!$guru->canManageAspirasi()) {
            return back()->with('error', 'Tidak diizinkan');
        }

        $request->validate(['feedback' => 'required']);

        Progres::create([
            'id_aspirasi' => $id,
            'user_id' => Auth::id(),
            'keterangan_progres' => 'Feedback: ' . $request->feedback,
        ]);

        return back()->with('success', 'OK');
    }

    // PROGRES
    public function storeProgres(Request $request, $id)
    {
        $guru = $this->getGuru();

        if (!$guru->canManageAspirasi()) {
            return back()->with('error', 'Tidak diizinkan');
        }

        $request->validate(['keterangan_progres' => 'required']);

        Progres::create([
            'id_aspirasi' => $id,
            'user_id' => Auth::id(),
            'keterangan_progres' => $request->keterangan_progres,
        ]);

        return back()->with('success', 'OK');
    }

    // STATUS
    public function updateStatus(Request $request, $id)
    {
        $guru = $this->getGuru();

        if (!$guru->canChangeStatus()) {
            return back()->with('error', 'Tidak diizinkan');
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);

        HistoryStatus::create([
            'id_aspirasi' => $id,
            'status_lama' => $aspirasi->status,
            'status_baru' => $request->status,
            'diubah_oleh' => Auth::id(),
        ]);

        $aspirasi->update(['status' => $request->status]);

        return back()->with('success', 'Status updated');
    }

    // HISTORY
    public function history(Request $request)
    {
        $guru = $this->getGuru();

        $query = HistoryStatus::with(['aspirasi']);

        if ($guru->canCreateAspirasi() && !$guru->canManageAspirasi()) {
            $query->whereHas('aspirasi', fn($q) => $q->where('user_id', Auth::id()));
            $aspirasiSelesai = Aspirasi::where('status', 'Selesai')->count();
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return view('guru.history', [
            'guru' => $guru,
            'history' => $query->latest()->paginate(20),
            'currentType' => 'semua',
        ]);
    }
}
