@extends('layouts.pakar')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color:rgb(21, 140, 156)">
            <h4 class="mb-0">Data Diagnosa KIPI Berat</h4>
        </div>
        <div class="card-body">

            @if($riwayats->isEmpty())
                <div class="alert alert-warning text-center">
                    Belum ada data diagnosa.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-white">
                            <tr>
                                <th>Nama Anak</th>
                                <th>Nama Ibu</th>
                                <th>Usia Anak</th>
                                <th>Tanggal Diagnosa</th>
                                <th>Jenis KIPI</th>
                                <th>Nilai CF</th>
                                <th>Saran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayats as $item)
                                <tr>
                                    <td>{{ $item->nama_anak }}</td>
                                    <td>{{ $item->nama_ibu }}</td>
                                    <td>{{ $item->usia_anak }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                    <td class="text-capitalize">{{ $item->jenis_kipi}}</td>
                                    <td>{{ number_format($item->nilai_cf * 100) }}%</td>
                                    <td>{{ $item->saran }}</td>
                                    <td>
                                        <a href="{{ route('pakar.riwayat.berat.detail', $item->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
