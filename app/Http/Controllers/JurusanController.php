<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required',
            'nama_jurusan' => 'required|max:100',
            'deskripsi' => 'nullable'
        ]);

        Jurusan::create([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('Jurusan.jurusan')
            ->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jurusan' => 'required',
            'nama_jurusan' => 'required|max:100',
            'deskripsi' => 'nullable'
        ]);

        $jurusan = Jurusan::findOrFail($id);

        $jurusan->update([
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('Jurusan.jurusan')
            ->with('success', 'Data jurusan berhasil diupdate');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('Jurusan.jurusan')
            ->with('success', 'Data jurusan berhasil dihapus');
    }
}