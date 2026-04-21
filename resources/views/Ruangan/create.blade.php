@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Tambah Ruangan</h4>
            <form action="{{ route('Ruangan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Kode Ruangan</label>
                    <input type="text" name="kode_ruangan" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Jenis Ruangan</label>
                    <select name="jenis_ruangan" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="Kelas">Kelas</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Perpustakaan">Perpustakaan</option>
                        <option value="Kantin">Kantin</option>
                        <option value="Lapangan">Lapangan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('Ruangan.ruangan') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection