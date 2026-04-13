<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required',
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|integer',
            'lokasi' => 'required',
            'deskripsi' => 'nullable'
        ]);

        Ruangan::create([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
            'kapasitas' => $request->kapasitas,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('Ruangan.ruangan')
            ->with('success', 'Data ruangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_ruangan' => 'required',
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|integer',
            'lokasi' => 'required',
            'deskripsi' => 'nullable'
        ]);

        $ruangan = Ruangan::findOrFail($id);

        $ruangan->update([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
            'kapasitas' => $request->kapasitas,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('Ruangan.ruangan')
            ->with('success', 'Data ruangan berhasil diupdate');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('Ruangan.ruangan')
            ->with('success', 'Data ruangan berhasil dihapus');
    }
}