@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Tambah Data Kelas</h4>

            <form action="{{ route('Kelas.store') }}" method="POST">
                @csrf

                {{-- Nama Kelas --}}
                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas"
                        class="form-control"
                        value="{{ old('nama_kelas') }}">
                </div>

                {{-- Tingkat --}}
                <div class="mb-3">
                    <label class="form-label">Tingkat</label>
                    <select name="tingkat" class="form-select">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>

                {{-- Jurusan --}}
                <div class="mb-3">
                    <label class="form-label">Jurusan</label>
                    <select name="id_jurusan" class="form-select">
                        <option value="">-- Pilih Jurusan --</option>

                        @foreach($jurusan as $j)
                            <option value="{{ $j->id_jurusan }}">
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Kapasitas --}}
                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas"
                        class="form-control">
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control"
                        rows="3"></textarea>
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('Kelas.kelas') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection