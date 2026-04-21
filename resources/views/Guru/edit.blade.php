@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">

        <h4>Edit Guru</h4>

        <form action="{{ route('Guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input name="nip" value="{{ $guru->nip }}" class="form-control mb-2">
            <input name="nama" value="{{ $guru->nama }}" class="form-control mb-2">
            <input name="mata_pelajaran" value="{{ $guru->mata_pelajaran }}" class="form-control mb-2">

            <select name="jenis_kelamin" class="form-control mb-2">
                <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <input type="date" name="tanggal_lahir"
                value="{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('Y-m-d') }}"
                class="form-control mb-2">

            <input name="no_hp" value="{{ $guru->no_hp }}" class="form-control mb-2">

            <textarea name="alamat" class="form-control mb-2">{{ $guru->alamat }}</textarea>

            <input name="email" value="{{ $guru->email }}" class="form-control mb-2">

            <input name="password" type="password" class="form-control mb-2">


               <div class="col-md-6">
                    <label class="form-label">Foto Saat Ini</label>
                        <div class="mb-3 text-center">
                            <img src="{{ $guru->foto ? asset($guru->foto) : asset('assets/images/guru/') }}"
                                    width="120" height="120"
                                    style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">
                        </div>
                    <div class="mb-2">
                        <label class="form-label">Ganti Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti. Maks 2MB.</small>
                    </div>
                </div>

            <button class="btn btn-primary">Update</button>
        </form>

    </div>
</div>
@endsection