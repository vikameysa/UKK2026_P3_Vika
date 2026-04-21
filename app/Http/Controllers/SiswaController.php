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

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|unique:siswa,nis',
            'nama'          => 'required',
            'kelas'         => 'required',
            'jurusan'       => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/siswa'), $filename);
            $fotoPath = 'assets/images/siswa/' . $filename;
        }

        Siswa::create([
            'user_id'       => $user->id,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'foto'          => $fotoPath,
        ]);

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $request->validate([
            'nis'           => 'required|unique:siswa,nis,' . $siswa->id,
            'nama'          => 'required',
            'kelas'         => 'required',
            'jurusan'       => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'email'         => 'required|email|unique:users,email,' . $siswa->user_id,
            'password'      => 'nullable|min:6',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $dataUser = ['email' => $request->email];
        if ($request->filled('password')) {
            $dataUser['password'] = Hash::make($request->password);
        }
        $siswa->user->update($dataUser);

        $fotoPath = $siswa->foto;
        if ($request->hasFile('foto')) {
            if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                unlink(public_path($siswa->foto));
            }
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/siswa'), $filename);
            $fotoPath = 'assets/images/siswa/' . $filename;
        }

        $siswa->update([
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas'         => $request->kelas,
            'jurusan'       => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'foto'          => $fotoPath,
        ]);

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        if ($siswa->foto && file_exists(public_path($siswa->foto))) {
            unlink(public_path($siswa->foto));
        }

        $siswa->user->delete();

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}