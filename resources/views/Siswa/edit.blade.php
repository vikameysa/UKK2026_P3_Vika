@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Data Siswa</h4>

                <form action="{{ route('Siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- KOLOM KIRI --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" value="{{ $siswa->nis }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" value="{{ $siswa->nama }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" value="{{ $siswa->kelas }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" value="{{ $siswa->jurusan }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    value="{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '' }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" value="{{ $siswa->no_hp }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" required>{{ $siswa->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ $siswa->email }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>
                        </div>

                        {{-- KOLOM KANAN - FOTO --}}
                        <div class="col-md-6">
                            <label class="form-label">Foto Saat Ini</label>
                            <div class="mb-3 text-center">
<img src="{{ $siswa->foto ? asset($siswa->foto) : '' }}"
     width="120" height="120"
     style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ganti Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti. Maks 2MB.</small>
                            </div>
                        </div>

                    </div>{{-- end .row --}}

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('Siswa.siswa') }}" class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection