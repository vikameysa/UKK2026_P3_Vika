<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $petugas = User::where('role', 'petugas')
            ->with('petugas')
            ->whereHas('petugas')
            ->get();

        return view('petugas.index', compact('petugas'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('petugas.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|unique:petugas,nip',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required',
            'alamat'        => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'foto'          => 'nullable|image|max:2048',
        ]);

        // =========================
        // UPLOAD FOTO (MANUAL)
        // =========================
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/petugas'), $filename);

            $fotoPath = 'assets/images/petugas/' . $filename;
        }

        // =========================
        // CREATE USER
        // =========================
        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        // =========================
        // CREATE PETUGAS
        // =========================
        Petugas::create([
            'user_id'       => $user->id,
            'nip'           => $request->nip,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'status'        => 'aktif',
            'foto'          => $fotoPath,
        ]);

        return redirect()->route('Petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('petugas.edit', compact('petugas'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nip'   => 'required|unique:petugas,nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $petugas->user_id,
            'foto'  => 'nullable|image|max:2048',
        ]);

        // =========================
        // DATA UPDATE PETUGAS
        // =========================
        $data = [
            'nip'           => $request->nip,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'status'        => $petugas->status,
        ];

        // =========================
        // UPDATE FOTO
        // =========================
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($petugas->foto && file_exists(public_path($petugas->foto))) {
                unlink(public_path($petugas->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/petugas'), $filename);

            $data['foto'] = 'assets/images/petugas/' . $filename;
        }

        $petugas->update($data);

        // =========================
        // UPDATE USER
        // =========================
        $petugas->user->update([
            'email' => $request->email
        ]);

        if ($request->password) {
            $petugas->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('Petugas.index')
            ->with('success', 'Petugas berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        // hapus foto
        if ($petugas->foto && file_exists(public_path($petugas->foto))) {
            unlink(public_path($petugas->foto));
        }

        // hapus user + petugas
        $petugas->user->delete();
        $petugas->delete();

        return redirect()->route('Petugas.index')
            ->with('success', 'Petugas berhasil dihapus');
    }
}