@extends('layouts.app')

@section('content')
<style>
    .card {
        padding: 11px; /* lebih kecil */
        margin-top: 20px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        max-width: 500px; /* dipersempit lagi */
    }
    h5 {
        font-size: 1rem; /* kecil */
        font-weight: 600;
        margin-bottom: 4px;
    }
    h6 {
        font-size: 0.8rem;
        font-weight: 300;
        margin-bottom: 2px;
    }
    table {
        margin-bottom: 0.4rem;
    }
    table th, table td {
        font-size: 11px; /* lebih kecil */
        padding: 4px 6px; /* lebih rapat */
        vertical-align: middle;
    }
    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
        font-size: 11px;
    }
    .btn {
        font-size: 11px; /* lebih kecil */
        padding: 4px 10px; /* rapat */
        border-radius: 5px;
    }
    p {
        font-size: 11px;
        margin-bottom: 6px;
    }
    small {
        font-size: 10px;
    }
</style>

<div class="card shadow-sm mx-auto">
    <h5 class="text-center">Hasil Diagnosa KIPI</h5>
    <p class="text-center text-muted">
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
    </p>

    {{-- Tabel Data Anak --}}
    <table class="table table-bordered align-middle" style="table-layout: fixed; width:100%;">
        <thead>
          <tr>
            <th colspan="4" class="text-center">Data Anak</th>
        </tr>

        </thead>
        <tbody>
            <tr>
                <td><strong>Nama Anak</strong></td>
                <td>{{ session('nama_anak', '-') }}</td>
                <td><strong>Jenis Kelamin</strong></td>
                <td>{{ session('jenis_kelamin', '-') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Lahir</strong></td>
                <td>
                    @if(session('tanggal_lahir'))
                        {{ \Carbon\Carbon::parse(session('tanggal_lahir'))->locale('id')->isoFormat('D MMM Y') }}
                    @else
                        -
                    @endif
                </td>
                <td><strong>Usia (bln)</strong></td>
                <td>{{ session('usia_anak', '-') }}</td>
            </tr>
            <tr>
                <td><strong>Ibu</strong></td>
                <td>{{ session('nama_ibu', '-') }}</td>
                <td><strong>Vaksin</strong></td>
                <td>{{ session('jenis_vaksin', '-') }}</td>
            </tr>
            <tr>
                <td><strong>Tempat imunisasi</strong></td>
                <td>{{ session('tempat_imunisasi', '-') }}</td>
                <td><strong>Tgl Imunisasi</strong></td>
                <td>
                    @if(session('tanggal_imunisasi'))
                        {{ \Carbon\Carbon::parse(session('tanggal_imunisasi'))->locale('id')->isoFormat('D MMM Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td colspan="3">{{ session('alamat', '-') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Gejala --}}
@if (!empty($gejalaDipilih) && is_array($gejalaDipilih))
    @php 
        // hanya ambil gejala yang cf_user > 0
        $filteredGejala = array_filter($gejalaDipilih, fn($g) => isset($g['cf_user']) && floatval($g['cf_user']) > 0);
        $chunks = array_chunk($filteredGejala, 2);

        function kategori($cf) {
        if ($cf == 0) return "Tidak"; 
        elseif ($cf > 0 && $cf <= 0.5) return "Ragu-ragu";
        elseif ($cf > 0.5) return "Ya";
        else return "-";
    }
    @endphp

    @if(count($filteredGejala) > 0)
        <table class="table table-bordered table-sm">
            <thead class="text-center">
                <tr>
                    <th colspan="2">Gejala</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chunks as $row)
                    <tr>
                        <td>
                            {{ $row[0]['nama'] ?? ($row[0]['nama_gejala'] ?? '-') }}
                            
                        </td>
                        <td>
                            @if(isset($row[1]))
                                {{ $row[1]['nama'] ?? ($row[1]['nama_gejala'] ?? '-') }}
                               
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted fst-italic">Tidak ada gejala yang dipilih.</p>
    @endif
@else
    <p class="text-muted fst-italic">Tidak ada gejala.</p>
@endif

    {{-- Hasil Diagnosa --}}

    @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
        <table class="table table-bordered table-sm">
            <thead class="text-center">
                <tr>
                    <th style="width: 150px;">Diagnosa</th>
                    <th>Saran</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center align-middle">
                        <h5 class="text-success fw-bold mb-1" style="font-size:14px;">
                            {{ number_format($hasilTerbaik['cf'] * 100, 0) }}%
                        </h5>
                        <small>KIPI <strong>{{ $hasilTerbaik['jenis_kipi'] }}</strong></small>
                    </td>
                    <td style="font-size:11px;">{{ $hasilTerbaik['saran'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p class="text-muted fst-italic">Tidak ada hasil diagnosa.</p>
    @endif

   
    <div class="d-flex justify-content-center align-items-center">
        @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
            <form action="{{ route('riwayat.simpan') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="nama_ibu" value="{{ session('nama_ibu') }}">
                <input type="hidden" name="nama_anak" value="{{ session('nama_anak') }}">
                <input type="hidden" name="usia_anak" value="{{ session('usia_anak') }}">
                <input type="hidden" name="jenis_kipi" value="{{ $hasilTerbaik['jenis_kipi'] }}">
                <input type="hidden" name="nilai_cf" value="{{ $hasilTerbaik['cf'] }}">
                <input type="hidden" name="saran" value="{{ $hasilTerbaik['saran'] }}">
                <input type="hidden" name="gejala_dipilih" value='@json($gejalaDipilih)'>
                <input type="hidden" name="jenis_kelamin" value="{{ session('jenis_kelamin') }}">
                <input type="hidden" name="tanggal_lahir" value="{{ session('tanggal_lahir') }}">
                <input type="hidden" name="alamat" value="{{ session('alamat') }}">
                <input type="hidden" name="jenis_vaksin" value="{{ session('jenis_vaksin') }}">
                <input type="hidden" name="tempat_imunisasi" value="{{ session('tempat_imunisasi') }}">
                <input type="hidden" name="tanggal_imunisasi" value="{{ session('tanggal_imunisasi') }}">

                <button type="submit" class="btn btn-success me-2">Simpan</button>
            </form>
        @endif
        <a href="{{ route('diagnosa.ulang') }}" class="btn btn-primary">diagnosa ulang</a>
    </div>
</div>
@endsection
