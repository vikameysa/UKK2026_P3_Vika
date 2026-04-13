@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Data Jurusan</h4>

            <form action="{{ route('Jurusan.update', $jurusan->id_jurusan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kode Jurusan --}}
                <div class="mb-3">
                    <label class="form-label">Kode Jurusan</label>
                    <input type="text" name="kode_jurusan"
                        class="form-control @error('kode_jurusan') is-invalid @enderror"
                        value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}">
                    @error('kode_jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Jurusan --}}
                <div class="mb-3">
                    <label class="form-label">Nama Jurusan</label>
                    <input type="text" name="nama_jurusan"
                        class="form-control @error('nama_jurusan') is-invalid @enderror"
                        value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}">
                    @error('nama_jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        rows="3">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('Jurusan.jurusan') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection