<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Aspirasi #{{ $aspirasi->id_aspirasi }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; padding: 36px; background: white; }

        .no-print { text-align: center; margin-bottom: 20px; }
        .btn-print {
            background: #198754; color: white; border: none;
            padding: 8px 24px; border-radius: 6px; font-size: 13px; cursor: pointer;
        }
        .btn-back {
            background: #6c757d; color: white; border: none;
            padding: 8px 20px; border-radius: 6px; font-size: 13px;
            cursor: pointer; margin-right: 8px; text-decoration: none;
            display: inline-block;
        }

        .header { text-align: center; border-bottom: 3px solid #198754; padding-bottom: 12px; margin-bottom: 22px; }
        .header h2 { font-size: 16px; font-weight: bold; color: #198754; margin-bottom: 4px; }
        .header p { font-size: 10px; color: #777; }
        .badge-selesai {
            display: inline-block; background: #d1e7dd; color: #0a3622;
            padding: 3px 14px; border-radius: 12px; font-size: 11px;
            font-weight: bold; margin-top: 6px;
        }

        .section { border: 1px solid #dee2e6; border-radius: 5px; margin-bottom: 16px; overflow: hidden; }
        .section-header { background: #198754; color: white; padding: 8px 14px; font-size: 12px; font-weight: bold; }
        .section-body { padding: 12px 14px; }

        table.detail { width: 100%; border-collapse: collapse; }
        table.detail td { padding: 5px 6px; font-size: 11px; border-bottom: 1px solid #f1f1f1; vertical-align: top; }
        table.detail td:first-child { color: #666; width: 160px; }
        table.detail td:nth-child(2) { width: 12px; color: #999; }
        table.detail td:last-child { font-weight: bold; color: #1a1a1a; }
        table.detail tr:last-child td { border-bottom: none; }

        .keterangan-box {
            background: #f8f9fa; border-left: 4px solid #198754;
            padding: 10px 14px; border-radius: 0 4px 4px 0;
            font-size: 11px; line-height: 1.8; color: #333;
        }

        .history-item { border-left: 3px solid #0dcaf0; padding: 4px 10px; margin-bottom: 8px; }
        .history-item .tgl { color: #888; font-size: 10px; margin-bottom: 2px; }
        .history-item .sts { font-weight: bold; font-size: 11px; }
        .history-item .oleh { color: #888; font-size: 10px; }

        .ttd { margin-top: 36px; text-align: right; }
        .ttd-inner { display: inline-block; text-align: center; width: 200px; }
        .ttd-inner p { font-size: 11px; margin-bottom: 52px; }
        .ttd-inner .nama { font-weight: bold; border-top: 1px solid #333; padding-top: 4px; font-size: 11px; }

        .footer { margin-top: 28px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #dee2e6; padding-top: 8px; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 14px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <a href="{{ route('siswa.aspirasi.detail', $aspirasi->id_aspirasi) }}" class="btn-back">&#8592; Kembali</a>
        <button class="btn-print" onclick="window.print()">&#128438; Print / Simpan PDF</button>
    </div>

    <div class="header">
        <h2>BUKTI ASPIRASI SELESAI</h2>
        <p>Dokumen resmi sebagai bukti aspirasi telah ditindaklanjuti</p>
        <div class="badge-selesai">&#10004; STATUS: SELESAI</div>
    </div>

    {{-- Detail Aspirasi --}}
    <div class="section">
        <div class="section-header">Informasi Aspirasi</div>
        <div class="section-body">
            <table class="detail">
                <tr>
                    <td>Nomor Aspirasi</td><td>:</td>
                    <td>#{{ str_pad($aspirasi->id_aspirasi, 4, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Kategori</td><td>:</td>
                    <td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Ruangan / Lokasi</td><td>:</td>
                    <td>{{ $aspirasi->ruangan->nama_ruangan ?? $aspirasi->lokasi }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pengiriman</td><td>:</td>
                    <td>{{ $aspirasi->created_at->format('d/m/Y H:i') }} WIB</td>
                </tr>
                <tr>
                    <td>Tanggal Selesai</td><td>:</td>
                    <td>{{ $aspirasi->updated_at->format('d/m/Y H:i') }} WIB</td>
                </tr>
                <tr>
                    <td>Status</td><td>:</td>
                    <td style="color:#198754; font-weight:bold;">&#10004; Selesai</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Info Siswa --}}
    <div class="section">
        <div class="section-header">Informasi Siswa</div>
        <div class="section-body">
            <table class="detail">
                <tr>
                    <td>Nama Siswa</td><td>:</td>
                    <td>{{ $siswa->name }}</td>
                </tr>
                <tr>
                    <td>Email</td><td>:</td>
                    <td>{{ $siswa->email }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="section">
        <div class="section-header">Keterangan / Isi Aspirasi</div>
        <div class="section-body">
            <div class="keterangan-box">{{ $aspirasi->keterangan }}</div>
        </div>
    </div>


    @if($aspirasi->historyStatus->count() > 0)
    <div class="section">
        <div class="section-header">Riwayat Perubahan Status</div>
        <div class="section-body">
            @foreach($aspirasi->historyStatus as $history)
            <div class="history-item">
                <div class="tgl">{{ $history->created_at->format('d/m/Y H:i') }}</div>
                <div class="sts">{{ $history->status_lama }} &rarr; {{ $history->status_baru }}</div>
                <div class="oleh">Oleh: {{ $history->pengubah->guru->nama ?? $history->pengubah->petugas->nama ?? $history->pengubah->email }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="ttd">
        <div class="ttd-inner">
            <p>Mengetahui,<br>{{ now()->format('d/m/Y') }}</p>
            <div class="nama">Pihak Sekolah</div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d/m/Y H:i:s') }} WIB &nbsp;|&nbsp; Sistem Aspirasi Sekolah
    </div>

</body>
</html>