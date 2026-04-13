<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('kelas.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'id_jurusan' => 'required',
            'kapasitas' => 'required|integer',
            'deskripsi' => 'nullable'
        ]);

        Kelas::create($request->all());

        return redirect()->route('Kelas.kelas')
            ->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jurusan = Jurusan::all();

        return view('kelas.edit', compact('kelas', 'jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'id_jurusan' => 'required',
            'kapasitas' => 'required|integer',
            'deskripsi' => 'nullable'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('Kelas.kelas')
            ->with('success', 'Data kelas berhasil diupdate');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('Kelas.kelas')
            ->with('success', 'Data kelas berhasil dihapus');
    }
}