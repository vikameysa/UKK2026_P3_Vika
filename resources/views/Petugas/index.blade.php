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

                                <td>
                                    <img src="{{ $p->foto ? asset($p->foto) : '' }}"
                                        width="45" height="45"
                                        style="border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                                </td>

                                <td>{{ $p->nip ?? '-' }}</td>
                                <td>{{ $p->nama ?? '-' }}</td>
                                <td>
                                    {{ ($p->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                                <td>{{ $p->user->email ?? '-' }}</td>

                                <td>
                                    <span class="badge {{ ($p->status ?? 'aktif') == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($p->status ?? 'Aktif') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#modalPetugas{{ $p->id }}">
                                            Detail
                                        </button>

                                        <a href="{{ route('Petugas.edit', $p->id) }}" class="btn btn-outline-warning btn-sm">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('Petugas.destroy', $p->id) }}">
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

                            <div class="modal fade" id="modalPetugas{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Petugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">

                                            <img src="{{ $p->foto ? asset($p->foto) : '' }}"
                                                width="120" height="120"
                                                style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">

                                            <hr>

                                            <p><strong>NIP:</strong> {{ $p->nip ?? '-' }}</p>
                                            <p><strong>Nama:</strong> {{ $p->nama ?? '-' }}</p>
                                            <p><strong>Jenis Kelamin:</strong> {{ $p->jenis_kelamin ?? '-' }}</p>
                                            <p><strong>Tanggal Lahir:</strong> {{ $p->tanggal_lahir ?? '-' }}</p>
                                            <p><strong>No HP:</strong> {{ $p->no_hp ?? '-' }}</p>
                                            <p><strong>Alamat:</strong> {{ $p->alamat ?? '-' }}</p>
                                            <p><strong>Email:</strong> {{ $p->user->email ?? '-' }}</p>

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