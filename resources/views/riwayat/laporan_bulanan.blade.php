<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan KIPI</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        h2, h4 { text-align: center; margin: 0; }
        ul { padding-left: 20px; margin: 0; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

{{-- Tombol dan alert hanya tampil saat tidak dicetak --}}
<div class="no-print" style="text-align: center; margin-top: 20px;">
    @if (session('success'))
        <div id="success-alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;">
            ✅ {{ session('success') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('success-alert')?.remove(), 2000);
        </script>
    @endif

    <form method="POST" action="{{ route('pakar.riwayat.kipi.kirim') }}" style="display: inline;">
        @csrf
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
        <button type="submit">Simpan Laporan</button>
    </form>
    <a href="{{ route('pakar.riwayat.kipi') }}" 
   style="display: inline-block; margin-left: 10px; background-color:whitesmoke; color: black; padding: 2px 14px; border-radius: 5px; text-decoration: none; border: 1px solid black;">
    Kembali
</a>

</div>

{{-- Judul dan periode --}}
<h2>Laporan Diagnosa KIPI Berat & Ringan</h2>
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

{{-- Tabel data --}}
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
        @forelse($riwayat as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama_anak }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
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
    @if($item->gejalaDipilih->count())
        <ul>
        @foreach($item->gejalaDipilih->where('cf_user', '!=', 0) as $g)
                <li>
                    {{ $g->gejala->nama_gejala ?? '-' }}
                </li>
            @endforeach
        </ul>
    @else
        <span style="color: #6c757d;">Tidak ada gejala yang dipilih.</span>
    @endif
</td>

                <td>{{ $item->saran ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="15" style="text-align: center;">Tidak ada data diagnosa untuk periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
