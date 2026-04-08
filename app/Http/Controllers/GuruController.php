<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
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
            'foto'           => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        Guru::create($data);
        return redirect()->route('Guru.guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nip'            => 'required|unique:guru,nip,' . $id,
            'nama'           => 'required',
            'mata_pelajaran' => 'required',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required',
            'no_hp'          => 'required',
            'foto'           => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($guru->foto) Storage::disk('public')->delete($guru->foto);
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);
        return redirect()->route('Guru.guru')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        if ($guru->foto) Storage::disk('public')->delete($guru->foto);
        $guru->delete();
        return redirect()->route('Guru.guru')->with('success', 'Data guru berhasil dihapus.');
    }
}