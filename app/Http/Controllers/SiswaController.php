<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
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
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($data);
        return redirect()->route('Siswa.siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis'           => 'required|unique:siswa,nis,' . $id,
            'nama'          => 'required',
            'kelas'         => 'required',
            'jurusan'       => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);
        return redirect()->route('Siswa.siswa')->with('success', 'Data siswa berhasil diupdate.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
        $siswa->delete();
        return redirect()->route('Siswa.siswa')->with('success', 'Data siswa berhasil dihapus.');
    }
}