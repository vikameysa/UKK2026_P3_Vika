@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Ruangan</h4>

            <form action="{{ route('Ruangan.update', $ruangan->id_ruangan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kode --}}
                <div class="mb-3">
                    <label>Kode Ruangan</label>
                    <input type="text" name="kode_ruangan"
                        value="{{ old('kode_ruangan', $ruangan->kode_ruangan) }}"
                        class="form-control">
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label>Nama Ruangan</label>
                    <input type="text" name="nama_ruangan"
                        value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                        class="form-control">
                </div>

                {{-- Jenis --}}
                <div class="mb-3">
                    <label>Jenis Ruangan</label>
                    <select name="jenis_ruangan" class="form-control">
                        <option value="Kelas" {{ $ruangan->jenis_ruangan == 'Kelas' ? 'selected' : '' }}>Kelas</option>
                        <option value="Laboratorium" {{ $ruangan->jenis_ruangan == 'Laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                        <option value="Perpustakaan" {{ $ruangan->jenis_ruangan == 'Perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                        <option value="Kantin" {{ $ruangan->jenis_ruangan == 'Kantin' ? 'selected' : '' }}>Kantin</option>
                        <option value="Lapangan" {{ $ruangan->jenis_ruangan == 'Lapangan' ? 'selected' : '' }}>Lapangan</option>
                        <option value="Lainnya" {{ $ruangan->jenis_ruangan == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Lokasi --}}
                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi"
                        value="{{ old('lokasi', $ruangan->lokasi) }}"
                        class="form-control">
                </div>

                {{-- Kapasitas --}}
                <div class="mb-3">
                    <label>Kapasitas</label>
                    <input type="number" name="kapasitas"
                        value="{{ old('kapasitas', $ruangan->kapasitas) }}"
                        class="form-control">
                </div>

                {{-- Kondisi --}}
                <div class="mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control">
                        <option value="Baik" {{ $ruangan->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ $ruangan->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $ruangan->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        <option value="Dalam Perbaikan" {{ $ruangan->kondisi == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control">{{ old('deskripsi', $ruangan->deskripsi) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('Ruangan.ruangan') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection