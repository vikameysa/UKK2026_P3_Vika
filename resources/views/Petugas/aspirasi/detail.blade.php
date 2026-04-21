@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">Detail Aspirasi #{{ $aspirasi->id }}</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th width="30%">Kategori</th><td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td></tr>
                    <tr><th>Ruangan</th><td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td></tr>
                    <tr>
                        <th>Pengirim</th>
                        <td>
                            @php
                                $pengirim = $aspirasi->user->siswa ?? $aspirasi->user->guru;
                            @endphp
                            {{ $pengirim->nama ?? $aspirasi->user->email }}
                            <br><small class="text-muted">{{ $pengirim->kelas ?? $pengirim->jabatan ?? '-' }}</small>
                        

                    
                    <tr><th>Keterangan</th><td>{{ $aspirasi->keterangan }}</td></tr>
                    @if($aspirasi->foto)
                    <tr><th>Foto Awal</th><td><img src="{{ asset('storage/' . $aspirasi->foto) }}" width="200" class="img-thumbnail"></td></tr>
                    @endif

                    @php
                        $fotoBukti = null;
                        $fotoBuktiKeterangan = null;
                        foreach($aspirasi->progres as $progres) {
                            if(str_contains($progres->keterangan_progres, '📎 Foto bukti:')) {
                                preg_match('/📎 Foto bukti: (.*)/', $progres->keterangan_progres, $matches);
                                if(isset($matches[1])) {
                                    $fotoBukti = $matches[1];
                                    $fotoBuktiKeterangan = $progres->keterangan_progres;
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    @if($fotoBukti)
                    <tr>
                        <th>Foto Bukti Selesai</th>
                        <td>
                            <img src="{{ $fotoBukti }}" alt="Foto Bukti" width="300" class="img-thumbnail">
                            <br>
                            <small class="text-muted">Foto bukti penanganan setelah selesai</small>
                            @if($fotoBuktiKeterangan)
                            <br>
                            <small class="text-muted">Keterangan: {{ Str::limit(str_replace('📎 Foto bukti: ' . $fotoBukti, '', $fotoBuktiKeterangan), 100) }}</small>
                            @endif
                        

                     
                    @endif
                    
                    <tr><th>Status</th>
                        <td>
                            <span class="badge bg-{{ $aspirasi->status == 'Selesai' ? 'success' : ($aspirasi->status == 'Proses' ? 'info' : 'warning') }}">
                                {{ $aspirasi->status }}
                            </span>
                        

                    
                    <tr><th>Dibuat Pada</th><td>{{ $aspirasi->created_at->format('d/m/Y H:i:s') }}</td></tr>
                    @if($aspirasi->status == 'Selesai')
                    <tr><th>Selesai Pada</th><td>{{ $aspirasi->updated_at->format('d/m/Y H:i:s') }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

@push('scripts')
<script>
    document.getElementById('fotoBukti').addEventListener('change', function(e) {
        const preview = document.getElementById('fotoPreview');
        const img = document.getElementById('previewImg');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.style.display = 'none';
        }
    });

    const statusSelect = document.getElementById('statusSelect');
    const warningAlert = document.getElementById('warningAlert');
    const keteranganRequired = document.getElementById('keteranganRequired');
    const fotoRequired = document.getElementById('fotoRequired');
    const keteranganText = document.getElementById('keteranganText');
    const fotoBukti = document.getElementById('fotoBukti');
    const submitBtn = document.getElementById('submitBtn');
    
    function checkStatus() {
        const isSelesai = statusSelect.value === 'Selesai';
        
        if (isSelesai) {
            warningAlert.style.display = 'block';
            keteranganText.required = true;
            fotoBukti.required = true;
            keteranganRequired.style.display = 'inline';
            fotoRequired.style.display = 'inline';
            validateForm();
        } else {
            warningAlert.style.display = 'none';
            keteranganText.required = false;
            fotoBukti.required = false;
            keteranganRequired.style.display = 'none';
            fotoRequired.style.display = 'none';
            keteranganText.classList.remove('is-invalid');
            fotoBukti.classList.remove('is-invalid');
        }
    }
    
    function validateForm() {
        if (statusSelect.value === 'Selesai') {
            if (!keteranganText.value.trim()) {
                keteranganText.classList.add('is-invalid');
            } else {
                keteranganText.classList.remove('is-invalid');
            }
            
            if (!fotoBukti.files.length) {
                fotoBukti.classList.add('is-invalid');
            } else {
                fotoBukti.classList.remove('is-invalid');
            }
        }
    }
    
    statusSelect.addEventListener('change', checkStatus);
    keteranganText.addEventListener('input', validateForm);
    fotoBukti.addEventListener('change', validateForm);
    
    submitBtn.addEventListener('click', function(e) {
        if (statusSelect.value === 'Selesai') {
            if (!keteranganText.value.trim()) {
                e.preventDefault();
                keteranganText.classList.add('is-invalid');
                alert('Harap isi keterangan penanganan!');
                return false;
            }
            if (!fotoBukti.files.length) {
                e.preventDefault();
                fotoBukti.classList.add('is-invalid');
                alert('Harap upload foto bukti penanganan!');
                return false;
            }
        }
    });
    
    checkStatus();
</script>
@endpush
@endsection