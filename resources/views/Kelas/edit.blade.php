@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Data Kelas</h4>

            <form action="{{ route('Kelas.update', $kelas->id_kelas) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas"
                        class="form-control @error('nama_kelas') is-invalid @enderror"
                        value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                    @error('nama_kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tingkat</label>
                    <select name="tingkat"
                        class="form-select @error('tingkat') is-invalid @enderror">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="10" {{ old('tingkat', $kelas->tingkat) == '10' ? 'selected' : '' }}>10</option>
                        <option value="11" {{ old('tingkat', $kelas->tingkat) == '11' ? 'selected' : '' }}>11</option>
                        <option value="12" {{ old('tingkat', $kelas->tingkat) == '12' ? 'selected' : '' }}>12</option>
                    </select>
                    @error('tingkat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jurusan</label>
                    <select name="id_jurusan"
                        class="form-select @error('id_jurusan') is-invalid @enderror">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id_jurusan }}"
                                {{ old('id_jurusan', $kelas->id_jurusan) == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas"
                        class="form-control @error('kapasitas') is-invalid @enderror"
                        value="{{ old('kapasitas', $kelas->kapasitas) }}">
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        rows="3">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('Kelas.kelas') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection