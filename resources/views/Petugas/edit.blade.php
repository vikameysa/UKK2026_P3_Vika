@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Edit Data Petugas</h4>

                <form action="{{ route('Petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-4 text-center">

                            <img src="{{ $petugas->foto ? asset($petugas->foto) : asset('img/default-avatar.png') }}"
                                width="130" height="130"
                                style="border-radius:50%; object-fit:cover; border:3px solid #ddd;"
                                class="mb-3"
                                id="preview-foto">

                            <div>
                                <h6 class="mb-0">{{ $petugas->nama }}</h6>
                                <span class="badge bg-success">
                                    {{ ucfirst($petugas->status ?? 'aktif') }}
                                </span>
                            </div>

                        </div>

                        <div class="col-md-8">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control"
                                           value="{{ $petugas->nip }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control"
                                           value="{{ $petugas->nama }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="L" {{ $petugas->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ $petugas->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                           value="{{ $petugas->tanggal_lahir ? $petugas->tanggal_lahir->format('Y-m-d') : '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control"
                                           value="{{ $petugas->no_hp }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ $petugas->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ $petugas->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control">{{ $petugas->alamat }}</textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ $petugas->user->email ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Password (opsional)</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak diubah</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*"
                                           onchange="previewFoto(this)">
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('Petugas.index') }}" class="btn btn-secondary">Batal</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('preview-foto').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection