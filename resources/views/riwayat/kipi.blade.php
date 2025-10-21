@extends('layouts.pakar')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
    <div class="card-header text-white" style="background-color:rgb(21, 140, 156)">
            <h4 class="mb-0">Data Diagnosa KIPI </h4>
        </div>
        <div class="card-body">

            <!-- Filter Form -->
            <form method="GET" action="{{ route('pakar.riwayat.kipi') }}" class="row g-3 align-items-end ">
                <div class="col-md-3">
                    <label for="kategori">Diagnosa</label>
                    <select name="kategori" id="kategori" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Diagnosa --</option>
                        <option value="Ringan (reaksi lokal)" {{ request('kategori') == 'Ringan (reaksi lokal)' ? 'selected' : '' }}>Ringan (reaksi lokal)</option>
                        <option value="Ringan (reaksi sistemik)" {{ request('kategori') == 'Ringan (reaksi sistemik)' ? 'selected' : '' }}>Ringan (reaksi sistemik)</option>
                        <option value="Berat" {{ request('kategori') == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="bulan">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tahun">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('laporan.kipi.bulanan', [
                        'kategori' => request('kategori'),
                        'bulan' => request('bulan'),
                        'tahun' => request('tahun')
                    ]) }}" target="_blank" class="btn btn-success w-100">
                        📄 Buat Laporan
                    </a>
                </div>
            </form>

            <!-- Data Table -->
            @if($riwayat->isEmpty())
                <div class="alert alert-warning text-center">
                    Tidak ada data untuk kategori dan periode ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama Anak</th>
                                <th>Nama Ibu</th>
                                <th>Usia Anak</th>
                                <th>Tanggal Diagnosa</th>
                                <th>jenis kipi</th>
                                <th>Nilai CF</th>
                                <th>Saran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $item)
                                <tr>
                                    <td>{{ $item->nama_anak }}</td>
                                    <td>{{ $item->nama_ibu }}</td>
                                    <td>{{ $item->usia_anak }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ ucfirst($item->jenis_kipi) }}</td>
                                    <td>{{ number_format($item->nilai_cf * 100) }}%</td>
                                    <td>{{ $item->saran }}</td>
                                    <td>
                                        <a href="{{ route('pakar.riwayat.kipi.detail', $item->id) }}" class="btn btn-sm btn-primary">
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
