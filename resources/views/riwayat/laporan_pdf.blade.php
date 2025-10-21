<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan KIPI Ringan dan Berat</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>

    <h2>Laporan Bulanan KIPI Ringan dan Berat </h2>
    <h4>
        Periode:
        @if($request->bulan && $request->tahun)
            {{ \Carbon\Carbon::createFromDate($request->tahun, $request->bulan, 1)->locale('id')->isoFormat('MMMM YYYY') }}
        @elseif($request->tahun)
            Tahun {{ $request->tahun }}
        @else
            Semua Periode
        @endif
    </h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Usia Anak</th>
                <th>Nama Ibu</th>
                <th>Alamat</th>
                <th>Jenis Vaksin</th>
                <th>Tempat Imunisasi</th>
                <th>Tanggal Imunisasi</th>
                <th>Tanggal Diagnosa</th>
                <th>Jenis KIPI</th>
                <th>Tingkat Keyakinan</th>
                <th>Gejala</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
        @foreach($riwayat as $i => $item)
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $item->nama_anak }}</td>
    <td>{{ $item->jenis_kelamin }}</td>
    <td>{{ $item->tanggal_lahir }}</td>
    <td>{{ $item->usia_anak }}</td>
    <td>{{ $item->nama_ibu }}</td>
    <td>{{ $item->alamat }}</td>
    <td>{{ $item->jenis_vaksin ?? '-' }}</td>
    <td>{{ $item->tempat_imunisasi ?? '-' }}</td>
    <td>{{ $item->tanggal_imunisasi ? \Carbon\Carbon::parse($item->tanggal_imunisasi)->format('d-m-Y') : '-' }}</td>
    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
    <td>{{ ucfirst($item->jenis_kipi) }}</td>
    <td>{{ number_format($item->nilai_cf * 100) }}%</td>
    <td>
        <ul style="padding-left: 20px; margin: 0;">
            @foreach ($item->gejalaDipilih->where('cf_user', 1) as $g)
                <li>{{ $g->gejala->nama_gejala ?? '-' }}</li>
            @endforeach
        </ul>
    </td>
    <td>{{ $item->saran }}</td>
</tr>
@endforeach

</tbody>

    </table>

</body>
</html>
