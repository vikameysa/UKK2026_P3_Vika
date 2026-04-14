@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tambah Data Petugas</h4>

                <form action="{{ route('Petugas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('Petugas.index') }}" class="btn btn-secondary">Batal</a>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection