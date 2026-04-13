@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h4>Data Ruangan</h4>
                <a href="{{ route('Ruangan.create') }}" class="btn btn-primary">
                    + Tambah Ruangan
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Kapasitas</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangan as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->nama_ruangan }}</td>
                            <td>{{ $r->kapasitas }}</td>
                            <td>{{ $r->lokasi }}</td>
                            <td>{{ $r->deskripsi }}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('Ruangan.edit', $r->id_ruangan) }}"
                                       class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('Ruangan.destroy', $r->id_ruangan) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Data belum ada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection