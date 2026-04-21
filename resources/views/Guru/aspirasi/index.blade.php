@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Statistik Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $statistik['total'] }}</h3>
                        <small>Total Aspirasi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $statistik['menunggu'] }}</h3>
                        <small>Menunggu</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $statistik['proses'] }}</h3>
                        <small>Diproses</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $statistik['selesai'] }}</h3>
                        <small>Selesai</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    @if($guru->jabatan == 'Wali Kelas')
                        @if($currentType == 'saya')
                            Aspirasi Saya
                        @else
                            Data Aspirasi Kelas
                        @endif
                    @elseif($guru->canCreateAspirasi())
                        Aspirasi Saya
                    @else
                        Data Aspirasi
                    @endif
                </h5>
            </div>
            <div class="card-body">

                <!-- TABS KHUSUS UNTUK WALI KELAS -->
                @if($guru->jabatan == 'Wali Kelas')
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link {{ $currentType == 'kelas' ? 'active' : '' }}"
                           href="{{ route('guru.aspirasi.index', ['type' => 'kelas']) }}">
                            Data Aspirasi Kelas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $currentType == 'saya' ? 'active' : '' }}"
                           href="{{ route('guru.aspirasi.index', ['type' => 'saya']) }}">
                            Aspirasi Saya
                        </a>
                    </li>
                </ul>
                @endif

                <!-- Alert Info -->
                <div class="alert alert-info mb-3">
                    <strong>Informasi:</strong> Halaman ini hanya menampilkan aspirasi dengan status
                    <strong>Menunggu</strong> dan <strong>Proses</strong>.
                </div>

                <!-- Tombol Buat Aspirasi -->
                @if($guru->canCreateAspirasi())
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('guru.aspirasi.create') }}" class="btn btn-primary">
                        + Buat Aspirasi Baru
                    </a>
                </div>
                @endif

                {{-- FILTER BAR --}}
                <form method="GET" action="{{ route('guru.aspirasi.index') }}" class="mb-4">
                    {{-- Pertahankan tab type untuk wali kelas --}}
                    @if($guru->jabatan == 'Wali Kelas')
                        <input type="hidden" name="type" value="{{ $currentType }}">
                    @endif

                    <div class="row g-2 align-items-end p-3 border rounded bg-light">
                        <div class="col-auto d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold text-nowrap">Status</label>
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Proses"   {{ request('status') == 'Proses'   ? 'selected' : '' }}>Proses</option>
                            </select>
                        </div>
                        <div class="col-auto d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold text-nowrap">Kategori</label>
                            <select name="kategori" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold text-nowrap">Ruangan</label>
                            <select name="ruangan" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                @foreach($ruangans as $r)
                                    <option value="{{ $r->id_ruangan }}" {{ request('ruangan') == $r->id_ruangan ? 'selected' : '' }}>
                                        {{ $r->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold text-nowrap">Dari Tgl</label>
                            <input type="date" name="date_from" class="form-control form-control-sm"
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-auto d-flex align-items-center gap-2">
                            <label class="mb-0 fw-semibold text-nowrap">Sampai Tgl</label>
                            <input type="date" name="date_to" class="form-control form-control-sm"
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="ph ph-funnel"></i> Filter
                            </button>
                        </div>
                        @if(request()->hasAny(['status','kategori','ruangan','date_from','date_to','search']))
                        <div class="col-auto">
                            <a href="{{ route('guru.aspirasi.index', $guru->jabatan == 'Wali Kelas' ? ['type' => $currentType] : []) }}"
                               class="btn btn-secondary btn-sm">
                                <i class="ph ph-arrow-counter-clockwise"></i> Reset
                            </a>
                        </div>
                        @endif
                    </div>
                </form>

                <!-- Tabel Aspirasi -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                @if($guru->jabatan == 'Wali Kelas' && $currentType == 'kelas')
                                <th>Siswa</th>
                                @endif
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aspirasi as $index => $a)
                            <tr>
                                <td>{{ $aspirasi->firstItem() + $index }}</td>

                                @if($guru->jabatan == 'Wali Kelas' && $currentType == 'kelas')
                                <td>
                                    {{ $a->user->siswa->nama ?? '-' }}
                                    <br><small class="text-muted">{{ $a->user->siswa->kelas ?? '-' }}</small>
                                </td>
                                @endif

                                <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $a->ruangan->nama_ruangan ?? $a->lokasi }}</td>
                                <td>{{ Str::limit($a->keterangan, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $a->status == 'Proses' ? 'info' : 'warning' }}">
                                        {{ $a->status }}
                                    </span>
                                </td>
                                <td>{{ $a->created_at ? $a->created_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <a href="{{ route('guru.aspirasi.detail', $a->id_aspirasi) }}" class="btn btn-info btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ ($guru->jabatan == 'Wali Kelas' && $currentType == 'kelas') ? '8' : '7' }}" class="text-center">
                                    Belum ada data aspirasi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $aspirasi->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection