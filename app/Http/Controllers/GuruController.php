<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user')->latest()->get();
        return view('Guru.index', compact('guru'));
    }

    public function create()
    {
        return view('Guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'            => 'required|unique:guru,nip',
            'nama'           => 'required',
            'mata_pelajaran' => 'required',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required',
            'no_hp'          => 'required',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6',
            'foto'           => 'nullable|image|max:2048',
        ]);

        // 1. user (login)
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        // 2. foto
        $fotoPath = null;

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/guru'), $namaFile);

            $fotoPath = 'assets/images/guru/' . $namaFile;
        }

        // 3. guru
        Guru::create([
            'user_id'        => $user->id,
            'nip'            => $request->nip,
            'nama'           => $request->nama,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'foto'           => $fotoPath,
        ]);

        return redirect()->route('Guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        $request->validate([
            'nip'            => 'required|unique:guru,nip,' . $guru->id,
            'nama'           => 'required',
            'mata_pelajaran' => 'required',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required',
            'no_hp'          => 'required',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'password'       => 'nullable|min:6',
            'foto'           => 'nullable|image|max:2048',
        ]);

        // update user
        $user->update([
            'name'  => $request->nama,
            'email' => $request->email,
            'password' => $request->password
                ? Hash::make($request->password)
                : $user->password,
        ]);

        // update foto
        $fotoPath = $guru->foto;

        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($fotoPath && file_exists(public_path($fotoPath))) {
                unlink(public_path($fotoPath));
            }

            $file = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/guru'), $namaFile);

            $fotoPath = 'assets/images/guru/' . $namaFile;
        }

        // update guru
        $guru->update([
            'nip'            => $request->nip,
            'nama'           => $request->nama,
            'mata_pelajaran' => $request->mata_pelajaran,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'foto'           => $fotoPath,
        ]);

        return redirect()->route('Guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->foto && file_exists(public_path($guru->foto))) {
            unlink(public_path($guru->foto));
        }

        if ($guru->user) {
            $guru->user->delete();
        }

        $guru->delete();

        return redirect()->route('Guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
