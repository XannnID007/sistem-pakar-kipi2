@extends('layouts.pakar')

@section('content')

<style>
    .card {
        font-size: 0.75rem; /* perkecil font utama */
    }
    table th, table td {
        font-size: 0.7rem;   /* kecilkan teks tabel */
        padding: 3px 6px;    /* rapatkan isi tabel */
    }
    h4, h5 {
        font-size: 0.85rem;  /* kecilkan judul */
        margin-bottom: 0.3rem;
    }
    .btn {
        font-size: 0.7rem;   /* kecilkan tombol */
        padding: 3px 8px;
    }
    .sub-card {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 6px;        /* lebih rapat */
        margin-bottom: 10px;
        background: #fdfdfd;
    }
    .sub-card h5 {
        margin-bottom: 5px;
        font-size: 0.8rem;
        font-weight: 600;
        color:black;
    }
</style>

<div class="container py-2">
    <div class="card shadow-sm">
        <div class="card-header text-white text-center py-2" style="background-color: rgb(21, 140, 156);">
            <h4 class="mb-0">Detail Diagnosa</h4>
        </div>
        <div class="card-body py-2">

            {{-- Data Anak & Imunisasi --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="sub-card">
                    <h4 class="text-center fw-bold">Data Anak</h4>
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr><th>Nama Anak</th><td>{{ $riwayat->nama_anak ?? '-' }}</td></tr>
                                <tr><th>Jenis Kelamin</th><td>{{ $riwayat->jenis_kelamin ?? '-' }}</td></tr>
                                <tr><th>Tanggal Lahir</th>
                                    <td>
                                        {{ $riwayat->tanggal_lahir 
                                            ? \Carbon\Carbon::parse($riwayat->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') 
                                            : '-' }}
                                    </td>
                                </tr>
                                <tr><th>Usia (bln)</th><td>{{ $riwayat->usia_anak ?? '-' }} bln</td></tr>
                                <tr><th>Nama Ibu</th><td>{{ $riwayat->nama_ibu ?? '-' }}</td></tr>
                                <tr><th>Alamat</th><td>{{ $riwayat->alamat ?? '-' }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="sub-card">
                    <h4 class="text-center fw-bold">Data Imunisasi</h4>
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr><th>Jenis Vaksin</th><td>{{ $riwayat->jenis_vaksin ?? '-' }}</td></tr>
                                <tr><th>Tempat Imunisasi</th><td>{{ $riwayat->tempat_imunisasi ?? '-' }}</td></tr>
                                <tr><th>Tanggal Imunisasi</th>
                                    <td>
                                        {{ $riwayat->tanggal_imunisasi 
                                            ? \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->locale('id')->isoFormat('D MMMM Y') 
                                            : '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Gejala & Hasil Diagnosa --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="sub-card">
                    <h4 class="text-center fw-bold">Gejala yang dialami</h4>

                        @php
                            $filteredGejala = $gejala->filter(fn($item) => $item->cf_user != 0 && $item->cf_user != 0.5);
                        @endphp

                        @if($filteredGejala->isNotEmpty())
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    @foreach($filteredGejala as $g)
                                        <tr>
                                            <td>{{ $g->gejala->nama_gejala ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted small mb-0">Tidak ada gejala dipilih.</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="sub-card">
                    <h4 class="text-center fw-bold">Hasil diagnosa</h4>
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        {{ isset($riwayat->nilai_cf) ? number_format($riwayat->nilai_cf * 100) . '%' : '-' }}
                                        <br>kemungkinan KIPI {{ $riwayat->jenis_kipi ?? '-' }}
                                    </td>
                                    <td>{{ $riwayat->saran ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-end gap-2 mt-2">
                @if(strtolower($riwayat->jenis_kipi) === 'berat')
                    <form method="POST" action="{{ route('pakar.riwayat.berat.kirim', $riwayat->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            Buat Laporan
                        </button>
                    </form>
                @endif

                <a href="{{ route('pakar.riwayat.kipi') }}" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
