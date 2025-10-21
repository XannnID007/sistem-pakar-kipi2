<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Diagnosa KIPI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>

<div class="card shadow-sm mx-auto mt-4" style="max-width: 700px;">
    <div class="card-body">
        <div class="text-center mb-3">
            <h5>Hasil Diagnosa Kejadian Ikutan Pasca Imunisasi (KIPI)</h5>
            <p class="text-muted">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
            </p>
        </div>

        {{-- Tabel Data Ibu & Anak --}}
        <table class="table table-bordered mb-4">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th colspan="2">Data Ibu & Anak</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><strong>Nama Anak</strong></td><td>{{ session('nama_anak', '-') }}</td></tr>
                <tr><td><strong>Jenis Kelamin</strong></td><td>{{ session('jenis_kelamin', '-') }}</td></tr>
                <tr><td><strong>Tanggal Lahir</strong></td>
                    <td>
                        @if(session('tanggal_lahir'))
                            {{ \Carbon\Carbon::parse(session('tanggal_lahir'))->locale('id')->isoFormat('D MMMM Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr><td><strong>Usia Anak (bulan)</strong></td><td>{{ session('usia_anak', '-') }}</td></tr>
                <tr><td><strong>Nama Ibu</strong></td><td>{{ session('nama_ibu', '-') }}</td></tr>
                <tr><td><strong>Alamat</strong></td><td>{{ session('alamat', '-') }}</td></tr>
                <tr><td><strong>Jenis Vaksin</strong></td><td>{{ session('jenis_vaksin', '-') }}</td></tr>
                <tr><td><strong>Tempat Imunisasi</strong></td><td>{{ session('tempat_imunisasi', '-') }}</td></tr>
                <tr><td><strong>Tanggal Imunisasi</strong></td>
                    <td>
                        @if(session('tanggal_imunisasi'))
                            {{ \Carbon\Carbon::parse(session('tanggal_imunisasi'))->locale('id')->isoFormat('D MMMM Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Gejala yang Dipilih --}}
        <h6 class="mt-4 mb-2">Gejala yang Dipilih</h6>
        @if (!empty($gejalaDipilih))
            <table class="table table-bordered table-sm">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>Gejala</th>
                        <th style="width: 120px;">Keyakinan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gejalaDipilih as $index => $g)
                        @if ($g['cf_user'] > 0)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $g['nama'] }}</td>
                            <td class="text-center">
                                @switch($g['cf_user'])
                                    @case(1)
                                        Yakin - 1
                                        @break
                                    @case(0.5)
                                        Ragu-ragu - 0.5
                                        @break
                                    @default
                                        {{ $g['cf_user'] }}
                                @endswitch
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Tidak ada gejala yang dipilih.</p>
        @endif

        {{-- Hasil Diagnosa --}}
        <h6 class="mt-3 mb-2">Hasil Diagnosa</h6>
        @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
            <table class="table table-bordered table-sm">
                <thead class="table-light text-center">
                    <tr>
                        <th>Hasil Diagnosa</th>
                        <th>Saran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center align-middle" style="width: 200px;">
                            <h4 class="text-success fw-bold mb-1">
                                {{ number_format($hasilTerbaik['cf'] * 100, 0) }}%
                            </h4>
                            <small>Kemungkinan KIPI <strong>{{ $hasilTerbaik['jenis_kipi'] }}</strong></small>
                        </td>
                        <td>{{ $hasilTerbaik['saran'] ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">Tidak ada hasil diagnosa yang ditampilkan.</p>
        @endif
    </div>
</div>

<script>
    window.addEventListener('afterprint', function () {
        window.location.href = "{{ route('riwayat.index') }}";
    });

    window.print();
</script>

</body>
</html>
