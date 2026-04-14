<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

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
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'user_id' => 'required|exists:users,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // =========================
        // UPLOAD FOTO (MANUAL)
        // =========================
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/siswa'), $filename);

            $data['foto'] = 'assets/images/siswa/' . $filename;
        }

        Siswa::create($data);

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // =========================
        // UPDATE FOTO
        // =========================
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                unlink(public_path($siswa->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/images/siswa'), $filename);

            $data['foto'] = 'assets/images/siswa/' . $filename;
        }

        $siswa->update($data);

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto && file_exists(public_path($siswa->foto))) {
            unlink(public_path($siswa->foto));
        }

        $siswa->delete();

        return redirect()->route('Siswa.siswa')
            ->with('success', 'Data berhasil dihapus');
    }
}
