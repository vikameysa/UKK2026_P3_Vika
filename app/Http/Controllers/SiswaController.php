<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('user')->latest()->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|max:2048',
        ]);

        // 1. BUAT USER
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // 2. UPLOAD FOTO
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/siswa'), $filename);

            $fotoPath = 'assets/images/siswa/' . $filename;
        }

        // 3. SIMPAN SISWA
        Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }
}