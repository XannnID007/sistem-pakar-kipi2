@extends('layouts.pakar')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Diagnosa KIPI</h2>

    {{-- Tombol Cetak --}}
    <div class="mb-3">
        <a href="{{ route('pakar.cetak_laporan') }}" target="_blank" class="btn btn-success">
            <i class="fas fa-print"></i> Cetak Laporan Bulanan
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
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
            @forelse($riwayatDiagnosa as $riwayat)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $riwayat->nama_ibu }}</td>
                    <td>{{ $riwayat->nama_anak }}</td>
                    <td>{{ $riwayat->usia_anak }}</td>
                    <td>{{ $riwayat->diagnosa }}</td>
                    <td>{{ number_format($riwayat->nilai_cf * 100, 2) }}%</td>
                    <td>{{ $riwayat->saran }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data riwayat diagnosa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
