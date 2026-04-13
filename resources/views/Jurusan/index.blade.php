@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Data Jurusan</h4>
                <a href="{{ route('Jurusan.create') }}" class="btn btn-primary">
                    + Tambah Jurusan
                </a>
            </div>

            {{-- Alert sukses --}}
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
                            <th>Kode Jurusan</th>
                            <th>Nama Jurusan</th>
                            <th>Deskripsi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusan as $j)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $j->kode_jurusan }}</td>
                                <td>{{ $j->nama_jurusan }}</td>
                                <td>{{ $j->deskripsi }}</td>

                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Edit --}}
                                        <a href="{{ route('Jurusan.edit', $j->id_jurusan) }}"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('Jurusan.destroy', $j->id_jurusan) }}"
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
                                <td colspan="5" class="text-center">
                                    Data jurusan belum ada
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