@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="ph ph-list"></i> Daftar Aspirasi</h5>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Filter Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            {{-- FIX: $kategoris (dari controller) dan loop var ganti $kat --}}
                            @foreach($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari keterangan atau lokasi..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>ID</th>
                                <th>Pengirim</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aspirasi as $a)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $a->id_aspirasi }}</td>
                                <td>
                                    @php
                                        $pengirim = $a->user->siswa ?? $a->user->guru;
                                    @endphp
                                    {{ $pengirim->nama ?? $a->user->email }}
                                </td>
                                <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $a->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>{{ Str::limit($a->keterangan, 50) }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $a->status }}</span>
                                </td>
                                <td>{{ $a->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('petugas.aspirasi.detail', $a->id_aspirasi) }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $aspirasi->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection