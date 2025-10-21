@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f4f8;
    }
    .card {
        background: #fff;
        padding: 12px 16px;
        margin: 20px auto;
        max-width: 480px;  /* lebih kecil */
        border-radius: 8px;
        box-shadow: 0 0 8px rgb(0 0 0 / 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 12px; /* lebih kecil */
        color: #333;
    }
    h5 {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
        text-align: center;
    }
    p.date {
        font-size: 10px;
        color: #666;
        margin-bottom: 12px;
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
    }
    table thead th {
        background-color: #eee;
        padding: 6px 8px;
        border: 1px solid #ccc;
        font-weight: 600;
        font-size: 11px;
        text-align: center;
    }
    table tbody td {
        padding: 6px 8px;
        border: 1px solid #ccc;
        vertical-align: middle;
        font-size: 11px;
        word-break: break-word;
    }
    table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    table tbody td:first-child {
    font-weight: normal; /* atau hapus saja property font-weight */
    width: 40%;
    white-space: nowrap;

    }
    /* Untuk kolom diagnosis dan saran */
    .result-percentage {
        color: #2e7d32; /* hijau */
        font-weight: 700;
        font-size: 22px;
        text-align: center;
        margin-bottom: 3px;
    }
    .result-text {
        text-align: center;
        font-size: 10px;
        color: #555;
    }
    .btn-group {
        text-align: center;
       
    }
    .btn {
        font-size: 11px;
        padding: 6px 14px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        margin: 0 6px;
        min-width: 100px;
        text-transform: capitalize;
    }
    .btn-primary {
        background-color: #1e88e5;
        color: white;
    }
    .btn-primary:hover {
        background-color: #1565c0;
    }
    .btn-success {
        background-color: #43a047;
        color: white;
    }
    .btn-success:hover {
        background-color: #2e7d32;
    }
</style>

<div class="card">
    <h5>Hasil Diagnosa KIPI</h5>
    <p class="date">{{ \Carbon\Carbon::parse($riwayat->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</p>

    {{-- Data Anak --}}
    <table>
    <thead>
        <tr>
            <th colspan="4">Data Anak</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Nama Anak</strong></td>
            <td>{{ $riwayat->nama_anak ?? '-' }}</td>
            <td><strong>Jenis Kelamin</strong></td>
            <td>{{ $riwayat->jenis_kelamin ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Lahir</strong></td>
            <td>
                @if($riwayat->tanggal_lahir)
                    {{ \Carbon\Carbon::parse($riwayat->tanggal_lahir)->locale('id')->isoFormat('D MMM Y') }}
                @else
                    -
                @endif
            </td>
            <td><strong>Usia (bln)</strong></td>
            <td>{{ $riwayat->usia_anak ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Ibu</strong></td>
            <td>{{ $riwayat->nama_ibu ?? '-' }}</td>
            <td><strong>Vaksin</strong></td>
            <td>{{ $riwayat->jenis_vaksin ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tempat imunisasi</strong></td>
            <td>{{ $riwayat->tempat_imunisasi ?? '-' }}</td>
            <td><strong>Tanggal Imunisasi</strong></td>
            <td>
                @if($riwayat->tanggal_imunisasi)
                    {{ \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->locale('id')->isoFormat('D MMM Y') }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td colspan="3">{{ $riwayat->alamat ?? '-' }}</td>
        </tr>
    </tbody>
</table>


{{-- Gejala yang dialami --}}
{{-- Gejala yang dialami --}}
<table>
    <thead>
        <tr>
            <th colspan="2">Gejala yang Dialami</th>
        </tr>
    </thead>
    <tbody>
        @php
            $gejalaDipilih = $riwayat->gejalaDipilih->filter(fn($g) => $g->cf_user > 0)->values();
            $count = $gejalaDipilih->count();
        @endphp

        @for ($i = 0; $i < $count; $i += 2)
            <tr>
                <td>{{ $gejalaDipilih[$i]->gejala->nama_gejala ?? '' }}</td>
                <td>
                    @if(isset($gejalaDipilih[$i + 1]))
                        {{ $gejalaDipilih[$i + 1]->gejala->nama_gejala ?? '' }}
                    @else
                        &nbsp;
                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
</table>

    {{-- Hasil Diagnosa --}}
    <table>
        <thead>
            <tr>
                <th style="width: 35%;">Hasil Diagnosa</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="result-percentage">{{ number_format($riwayat->nilai_cf * 100, 0) }}%</div>
                    <div class="result-text">Kemungkinan KIPI <strong>{{ $riwayat->jenis_kipi}}</strong></div>
                </td>
                <td style="font-size: 11px;">{{ $riwayat->saran ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="btn-group">
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">kembali</a>
        <a href="{{ route('riwayat.cetak', $riwayat->id) }}" target="_blank" class="btn btn-primary">cetak</a>
    </div>
</div>
@endsection
