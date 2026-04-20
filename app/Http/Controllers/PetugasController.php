<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Petugas;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::with('user')->latest()->paginate(10);
        return view('Petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('Petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|unique:petugas,nip',
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_hp'         => 'nullable|string',
            'alamat'        => 'nullable|string',
            'status'        => 'nullable|in:aktif,nonaktif',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        $data = $request->only(['nip', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'no_hp', 'alamat', 'status']);
        $data['user_id'] = $user->id;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_petugas', 'public');
            $data['foto'] = 'storage/' . $path;
        }

        Petugas::create($data);

        return redirect()->route('Petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);
        return view('Petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $request->validate([
            'nip'           => 'required|unique:petugas,nip,' . $id,
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $petugas->user_id,
            'password'      => 'nullable|min:6',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_hp'         => 'nullable|string',
            'alamat'        => 'nullable|string',
            'status'        => 'nullable|in:aktif,nonaktif',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nip', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'no_hp', 'alamat', 'status']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($petugas->foto) {
                $oldPath = str_replace('storage/', '', $petugas->foto);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('foto')->store('foto_petugas', 'public');
            $data['foto'] = 'storage/' . $path;
        }

        $petugas->update($data);

        $petugas->user->update(['email' => $request->email]);

        if ($request->filled('password')) {
            $petugas->user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('Petugas.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        // Hapus foto
        if ($petugas->foto) {
            $oldPath = str_replace('storage/', '', $petugas->foto);
            Storage::disk('public')->delete($oldPath);
        }

        $petugas->user->delete();
        $petugas->delete();

        return redirect()->route('Petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
}