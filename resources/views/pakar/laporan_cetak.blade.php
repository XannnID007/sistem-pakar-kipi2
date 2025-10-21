<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Diagnosa KIPI - Bulanan</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 14px; margin: 40px; }
        h2, p { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        .kop { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="kop">
        <h2>LAPORAN DIAGNOSA KIPI</h2>
        <p>Periode: {{ \Carbon\Carbon::now()->subMonth()->format('d M Y') }} - {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Ibu</th>
                <th>Nama Anak</th>
                <th>Usia Anak</th>
                <th>Diagnosa</th>
                <th>Nilai CF</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatDiagnosa as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $r->nama_ibu }}</td>
                    <td>{{ $r->nama_anak }}</td>
                    <td>{{ $r->usia_anak }}</td>
                    <td>{{ $r->diagnosa }}</td>
                    <td>{{ number_format($r->nilai_cf * 100, 2) }}%</td>
                    <td>{{ $r->saran }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data dalam 1 bulan terakhir.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <div style="text-align: right; margin-top: 40px;">
        <p>{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        <p><strong>Kepala Puskesmas</strong></p>
        <br><br><br>
        <p>________________________</p>
    </div>
</body>
</html>
