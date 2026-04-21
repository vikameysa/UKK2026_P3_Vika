@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="ph ph-check-circle"></i> History Aspirasi Selesai</h5>
                    <small>Daftar aspirasi yang sudah selesai ditangani</small>
                </div>
                @if($aspirasiSelesai->count() > 0)
                <a href="{{ route('siswa.aspirasi.export-pdf') }}" class="btn btn-light btn-sm text-success fw-semibold">
                    <i class="ph ph-file-pdf"></i> Export Semua PDF
                </a>
                @endif
            </div>
            <div class="card-body">
                @if($aspirasiSelesai->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>ID</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Keterangan</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspirasiSelesai as $index => $aspirasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $aspirasi->id_aspirasi }}</td>
                                <td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td>
                                <td>{{ Str::limit($aspirasi->keterangan, 50) }}</td>
                                <td>{{ $aspirasi->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('siswa.aspirasi.detail', $aspirasi->id_aspirasi) }}" class="btn btn-info btn-sm">
                                        <i class="ph ph-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('siswa.aspirasi.export-single-pdf', $aspirasi->id_aspirasi) }}" class="btn btn-danger btn-sm" title="Download PDF">
                                        <i class="ph ph-file-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info text-center">
                    <i class="ph ph-info ph-2x"></i>
                    <h5 class="mt-2">Belum Ada History</h5>
                    <p class="mb-0">Belum ada aspirasi yang selesai ditangani.</p>
                    <a href="{{ route('siswa.aspirasi.status') }}" class="btn btn-primary mt-3">
                        <i class="ph ph-chart-line"></i> Lihat Status Aktif
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection