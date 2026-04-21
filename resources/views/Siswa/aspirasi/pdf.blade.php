<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>History Aspirasi - {{ $siswa->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; padding: 30px; background: white; }

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

        .header { text-align: center; border-bottom: 2px solid #198754; padding-bottom: 12px; margin-bottom: 18px; }
        .header h2 { font-size: 16px; font-weight: bold; color: #198754; margin-bottom: 4px; }
        .header p { font-size: 10px; color: #666; }

        .info-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box td { padding: 3px 6px; font-size: 11px; }
        .info-box td:first-child { color: #666; width: 170px; }
        .info-box td:nth-child(2) { width: 10px; }
        .info-box td:last-child { font-weight: bold; }

        table.main { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.main thead tr { background-color: #198754; color: white; }
        table.main thead th { padding: 8px; font-size: 11px; text-align: left; border: 1px solid #146c43; }
        table.main tbody td { padding: 7px 8px; border: 1px solid #dee2e6; font-size: 11px; vertical-align: top; }
        table.main tbody tr:nth-child(even) { background: #f8f9fa; }

        .badge-selesai { background: #d1e7dd; color: #0a3622; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; }

        .footer { text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #dee2e6; padding-top: 10px; margin-top: 10px; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <a href="{{ route('siswa.aspirasi.history') }}" class="btn-back">&#8592; Kembali</a>
        <button class="btn-print" onclick="window.print()">&#128438; Print / Simpan PDF</button>
    </div>

    <div class="header">
        <h2>HISTORY ASPIRASI SELESAI</h2>
        <p>Dokumen ini digenerate otomatis oleh Sistem Aspirasi Sekolah</p>
    </div>

    <div class="info-box">
        <table>
            <tr><td>Nama Siswa</td><td>:</td><td>{{ $siswa->name }}</td></tr>
            <tr><td>Email</td><td>:</td><td>{{ $siswa->email }}</td></tr>
            <tr><td>Total Aspirasi Selesai</td><td>:</td><td>{{ $aspirasiSelesai->count() }} aspirasi</td></tr>
            <tr><td>Tanggal Cetak</td><td>:</td><td>{{ now()->format('d/m/Y H:i') }} WIB</td></tr>
        </table>
    </div>

    <table class="main">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="7%">ID</th>
                <th width="18%">Kategori</th>
                <th width="20%">Ruangan</th>
                <th width="33%">Keterangan</th>
                <th width="13%">Tgl Selesai</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aspirasiSelesai as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->id_aspirasi }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->ruangan->nama_ruangan ?? $item->lokasi }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                <td><span class="badge-selesai">Selesai</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:16px; color:#999;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d/m/Y H:i:s') }} WIB &nbsp;|&nbsp; Sistem Aspirasi Sekolah
    </div>

</body>
</html>