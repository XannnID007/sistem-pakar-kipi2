<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Laporan Diagnosa KIPI Berat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #000;
            margin: 20px;
            background-color: #fff;
        }
        h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* auto agar isi bisa mengatur sendiri */
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            font-size: 9px;
            word-break: break-word;
        }
        th {
            background-color: #f0f0f0;
        }
        ul {
            margin: 0;
            padding-left: 15px;
            list-style-type: disc;
        }
        li {
            margin-bottom: 2px;
        }
        td:nth-child(14),
        td:nth-child(15) {
            white-space: normal;
        }
    </style>
</head>
<body>

    <h2>Laporan KIPI Berat</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Jenis kelamin</th>
                <th>Tgl Lahir</th>
                <th>Usia (bulan)</th>
                <th>Nama Ibu</th>
                <th>Alamat</th>
                <th>Vaksin</th>
                <th>Tempat Imunisasi</th>
                <th>Tgl Imunisasi</th>
                <th>Tgl Diagnosa</th>
                <th>Jenis KIPI</th>
                <th>Tingkat keyakinan</th>
                <th>Gejala</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $riwayat->nama_anak }}</td>
                <td>{{ $riwayat->jenis_kelamin }}</td>
                <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_lahir)->format('d-m-Y') }}</td>
                <td>{{ $riwayat->usia_anak }}</td>
                <td>{{ $riwayat->nama_ibu }}</td>
                <td>{{ $riwayat->alamat }}</td>
                <td>{{ $riwayat->jenis_vaksin ?? '-' }}</td>
                <td>{{ $riwayat->tempat_imunisasi ?? '-' }}</td>
                <td>{{ $riwayat->tanggal_imunisasi ? \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->format('d-m-Y') : '-' }}</td>
                <td>{{ $riwayat->tanggal ? \Carbon\Carbon::parse($riwayat->tanggal)->format('d-m-Y') : '-' }}</td>
                <td>{{ ucfirst($riwayat->jenis_kipi) }}</td>
                <td>{{ number_format($riwayat->nilai_cf * 100, 0) }}%</td>
                <td>
                    <ul>
                        @foreach ($riwayat->gejalaDipilih->where('cf_user', 1) as $g)
                            <li>{{ $g->gejala->nama_gejala ?? '-' }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $riwayat->saran }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
