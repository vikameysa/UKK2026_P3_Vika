@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Data Kelas</h4>
                <a href="{{ route('Kelas.create') }}" class="btn btn-primary">
                    + Tambah Kelas
                </a>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Kapasitas</th>
                            <th>Deskripsi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>
                                    {{ $k->jurusan->nama_jurusan ?? '-' }}
                                </td>

                                <td>{{ $k->kapasitas }}</td>
                                <td>{{ $k->deskripsi }}</td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('Kelas.edit', $k->id_kelas) }}"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('Kelas.destroy', $k->id_kelas) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin hapus data?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Data belum ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection