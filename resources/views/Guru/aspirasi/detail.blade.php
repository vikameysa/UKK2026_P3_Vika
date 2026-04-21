@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Detail Aspirasi #{{ $aspirasi->id_aspirasi }}</h6>
                @if($aspirasi->status == 'Selesai')
                <a href="{{ route('guru.aspirasi.export-single-pdf', $aspirasi->id_aspirasi) }}"
                    class="btn btn-danger btn-sm">
                    <i class="ph ph-file-pdf"></i> Download PDF
                </a>
                @endif
            </div>
            <div class="card-body">


                <div class="mb-4">
                    @php
                        $steps = ['Menunggu', 'Proses', 'Selesai'];
                        $currentIndex = array_search($aspirasi->status, $steps);
                    @endphp
                    <div class="d-flex align-items-center justify-content-center gap-0">
                        @foreach($steps as $i => $step)

                            <div class="d-flex flex-column align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="
                                        width: 38px; height: 38px; font-size: 13px;
                                        background: {{ $i <= $currentIndex ? ($step == 'Selesai' ? '#198754' : ($step == 'Proses' ? '#0dcaf0' : '#ffc107')) : '#e9ecef' }};
                                        color: {{ $i <= $currentIndex ? 'white' : '#adb5bd' }};
                                        border: 2px solid {{ $i <= $currentIndex ? ($step == 'Selesai' ? '#198754' : ($step == 'Proses' ? '#0dcaf0' : '#ffc107')) : '#dee2e6' }};
                                    ">
                                    @if($i < $currentIndex)
                                        <i class="ph ph-check"></i>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </div>
                                <small class="mt-1 fw-semibold" style="font-size: 11px; color: {{ $i <= $currentIndex ? '#333' : '#adb5bd' }}">
                                    {{ $step }}
                                </small>
                            </div>
                            @if(!$loop->last)
                            <div style="
                                height: 3px; width: 80px; margin-bottom: 18px;
                                background: {{ $i < $currentIndex ? '#198754' : '#dee2e6' }};
                            "></div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr><th>Kategori</th><td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td></tr>
                    <tr><th>Ruangan</th><td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td></tr>
                    <tr><th>Keterangan</th><td>{{ $aspirasi->keterangan }}</td></tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $aspirasi->status == 'Selesai' ? 'success' : ($aspirasi->status == 'Proses' ? 'info' : 'warning') }}">
                                {{ $aspirasi->status }}
                            </span>
                        </td>
                    </tr>
                    <tr><th>Tanggal</th><td>{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td></tr>
                    @if($aspirasi->status == 'Selesai')
                    <tr><th>Selesai Pada</th><td>{{ $aspirasi->updated_at->format('d/m/Y H:i') }}</td></tr>
                    @endif
                </table>


                @if($aspirasi->status == 'Selesai')
                <div class="alert alert-success d-flex align-items-center gap-2 mt-2">
                    <i class="ph ph-check-circle ph-lg"></i>
                    <div>
                        <strong>Aspirasi telah selesai ditangani.</strong>
                        Silakan download PDF sebagai bukti penyelesaian.
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($guru->canManageAspirasi())
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Kelola Aspirasi</h6>
            </div>
            <div class="card-body">

                <form action="{{ route('guru.aspirasi.feedback', $aspirasi->id_aspirasi) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-2">
                        <label>Feedback</label>
                        <textarea name="feedback" class="form-control" rows="2" placeholder="Tulis feedback untuk siswa..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Kirim Feedback</button>
                </form>

                <hr>

                @if($guru->canChangeStatus())
                <form action="{{ route('guru.aspirasi.status', $aspirasi->id_aspirasi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label>Update Status</label>
                        <select name="status" class="form-control">
                            <option value="Menunggu" {{ $aspirasi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses" {{ $aspirasi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Keterangan (opsional)</label>
                        <textarea name="keterangan_progres" class="form-control" rows="2" placeholder="Keterangan perubahan status..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm">Update Status</button>
                </form>
                @endif

            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Riwayat Progres</h6>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @forelse($aspirasi->progres as $progres)
                <div class="border-start border-primary ps-3 mb-2">
                    <small class="text-muted">{{ $progres->created_at->format('d/m/Y H:i') }}</small>
                    <p class="mb-0 small">{{ $progres->keterangan_progres }}</p>
                    <small>- {{ $progres->user->guru->nama ?? $progres->user->email }}</small>
                </div>
                @empty
                <p class="text-muted">Belum ada progres</p>
                @endforelse
            </div>
        </div>


        <div class="card mt-3">
            <div class="card-header">
                <h6>Riwayat Status</h6>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @forelse($aspirasi->historyStatus as $history)
                <div class="border-start border-info ps-3 mb-2">
                    <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                    <p class="mb-0 small">{{ $history->status_lama }} → {{ $history->status_baru }}</p>
                    <small>- {{ $history->pengubah->guru->nama ?? $history->pengubah->email }}</small>
                </div>
                @empty
                <p class="text-muted">Belum ada riwayat</p>
                @endforelse
            </div>
        </div>

        @if($aspirasi->status == 'Selesai')
        <div class="card mt-3 border-danger">
            <div class="card-body text-center">
                <i class="ph ph-file-pdf ph-2x text-danger mb-2 d-block"></i>
                <p class="small mb-2">Download bukti aspirasi selesai dalam format PDF</p>
                <a href="{{ route('guru.aspirasi.export-single-pdf', $aspirasi->id_aspirasi) }}"
                    class="btn btn-danger btn-sm w-100">
                    <i class="ph ph-file-pdf"></i> Download PDF Bukti
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection