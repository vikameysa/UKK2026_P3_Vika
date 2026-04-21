@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="ph ph-chart-line"></i> Status Aspirasi Aktif</h5>
                <small>Aspirasi yang sedang dalam proses penanganan</small>
            </div>
            <div class="card-body">

                {{-- Statistik --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $statistik['total'] }}</h3>
                                <small>Aspirasi Aktif</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3>{{ $statistik['menunggu'] }}</h3>
                                <small>Menunggu</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h3>{{ $statistik['proses'] }}</h3>
                                <small>Diproses</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('siswa.aspirasi.status') }}" class="mb-4">
                    <div class="row g-2 align-items-end">
                        <div class="col-auto">
                            <label class="form-label mb-1 small">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Proses"   {{ request('status') == 'Proses'   ? 'selected' : '' }}>Proses</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="form-label mb-1 small">Kategori</label>
                            <select name="kategori" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                @foreach($kategoris ?? [] as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="form-label mb-1 small">Ruangan</label>
                            <select name="ruangan" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                @foreach($ruangans ?? [] as $r)
                                <option value="{{ $r->id_ruangan }}" {{ request('ruangan') == $r->id_ruangan ? 'selected' : '' }}>
                                    {{ $r->nama_ruangan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="form-label mb-1 small">Dari Tgl</label>
                            <input type="date" name="date_from" class="form-control form-control-sm"
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-auto">
                            <label class="form-label mb-1 small">Sampai Tgl</label>
                            <input type="date" name="date_to" class="form-control form-control-sm"
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('siswa.aspirasi.status') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </div>
                </form>

                @if($aspirasi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspirasi as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $a->ruangan->nama_ruangan ?? $a->lokasi }}</td>
                                <td>{{ Str::limit($a->keterangan, 50) }}</td>
                                <td>
                                    @php
                                        $statusClass = $a->status == 'Menunggu' ? 'warning' : 'info';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $a->status }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($a->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('siswa.aspirasi.detail', $a->id_aspirasi) }}" class="btn btn-info btn-sm">
                                        <i class="ph ph-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-success text-center">
                    <i class="ph ph-check-circle ph-2x"></i>
                    <h5 class="mt-2">Tidak Ada Aspirasi Aktif</h5>
                    <p class="mb-0">Semua aspirasi Anda sudah selesai ditangani.</p>
                    <a href="{{ route('siswa.aspirasi.history') }}" class="btn btn-primary mt-3">
                        <i class="ph ph-clock-counter-clockwise"></i> Lihat History
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection