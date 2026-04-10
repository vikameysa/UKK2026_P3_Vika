@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabel Data Guru</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('Guru.create') }}" class="btn btn-primary">+ Tambah Guru</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Mata Pelajaran</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($guru as $g)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $g->nip }}</td>
                                <td>{{ $g->nama }}</td>
                                <td>{{ $g->mata_pelajaran }}</td>
                                <td>{{ $g->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $g->no_hp }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#modalGuru{{ $g->id }}">
                                        Detail
                                    </button>
                                        <a href="{{ route('Guru.edit', $g->id) }}"
                                            class="btn btn-outline-warning btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('Guru.destroy', $g->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data guru ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL DETAIL --}}
                            <div class="modal fade" id="modalGuru{{ $g->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Guru</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p><strong>NIP:</strong> {{ $g->nip }}</p>
                                            <p><strong>Nama:</strong> {{ $g->nama }}</p>
                                            <p><strong>Mata Pelajaran:</strong> {{ $g->mata_pelajaran }}</p>
                                            <p><strong>Jenis Kelamin:</strong> {{ $g->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                            <p><strong>Tanggal Lahir:</strong> {{ $g->tanggal_lahir }}</p>
                                            <p><strong>Alamat:</strong> {{ $g->alamat }}</p>
                                            <p><strong>No HP:</strong> {{ $g->no_hp }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data guru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection