@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabel Data Siswa</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('Siswa.create') }}" class="btn btn-primary">+ Tambah Siswa</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Foto</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Jenis Kelamin</th>
                                <th>Email</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
<img src="{{ $s->foto ? asset($s->foto) : '' }}"
     width="45" height="45"
     style="border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                                </td>
                                <td>{{ $s->nis ?? '-' }}</td>
                                <td>{{ $s->nama ?? '-' }}</td>
                                <td>{{ $s->kelas ?? '-' }}</td>
                                <td>{{ $s->jurusan ?? '-' }}</td>
                                <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $s->user->email ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#modalSiswa{{ $s->id }}">
                                        Detail
                                    </button>
                                        <a href="{{ route('Siswa.edit', $s->id) }}"
                                            class="btn btn-outline-warning btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('Siswa.destroy', $s->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data siswa ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL DETAIL --}}
                            <div class="modal fade" id="modalSiswa{{ $s->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p><strong>NIS:</strong> {{ $s->nis }}</p>
                                            <p><strong>Nama:</strong> {{ $s->nama }}</p>
                                            <p><strong>Kelas:</strong> {{ $s->kelas }}</p>
                                            <p><strong>Jurusan:</strong> {{ $s->jurusan }}</p>
                                            <p><strong>Jenis Kelamin:</strong> {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                            <p><strong>Tanggal Lahir:</strong> {{ $s->tanggal_lahir }}</p>
                                            <p><strong>Alamat:</strong> {{ $s->alamat }}</p>
                                            <p><strong>No HP:</strong> {{ $s->no_hp }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data siswa</td>
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