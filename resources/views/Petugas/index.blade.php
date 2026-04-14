@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tabel Data Petugas</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('Petugas.create') }}" class="btn btn-primary">
                        + Tambah Petugas
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($petugas as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- FOTO --}}
                                <td>
                                    <img src="{{ $p->petugas?->foto ? asset($p->petugas->foto) : '' }}"
                                        width="45" height="45"
                                        style="border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                                </td>

                                <td>{{ $p->petugas->nip ?? '-' }}</td>
                                <td>{{ $p->petugas->nama ?? '-' }}</td>
                                <td>
                                    {{ ($p->petugas->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                                <td>{{ $p->email }}</td>

                                <td>
                                    <span class="badge {{ ($p->petugas->status ?? 'aktif') == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($p->petugas->status ?? 'Aktif') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- DETAIL --}}
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#modalPetugas{{ $p->id }}">
                                            Detail
                                        </button>

                                        {{-- EDIT --}}
                                        <a href="{{ route('Petugas.edit', $p->petugas->id) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            Edit
                                        </a>

                                        {{-- DELETE --}}
                                        <form method="POST"
                                            action="{{ route('Petugas.destroy', $p->petugas->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL --}}
                            <div class="modal fade" id="modalPetugas{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Petugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">

                                            <img src="{{ $p->petugas?->foto ? asset($p->petugas->foto) : '' }}"
                                                width="120" height="120"
                                                style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">

                                            <hr>

                                            <p><strong>NIP:</strong> {{ $p->petugas->nip ?? '-' }}</p>
                                            <p><strong>Nama:</strong> {{ $p->petugas->nama ?? '-' }}</p>
                                            <p><strong>Jenis Kelamin:</strong>
                                                {{ $p->petugas->jenis_kelamin ?? '-' }}
                                            </p>
                                            <p><strong>Tanggal Lahir:</strong>
                                                {{ $p->petugas->tanggal_lahir ?? '-' }}
                                            </p>
                                            <p><strong>No HP:</strong> {{ $p->petugas->no_hp ?? '-' }}</p>
                                            <p><strong>Alamat:</strong> {{ $p->petugas->alamat ?? '-' }}</p>
                                            <p><strong>Email:</strong> {{ $p->email ?? '-' }}</p>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada data petugas
                                </td>
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