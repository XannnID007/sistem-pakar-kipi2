@extends('layouts.pakar')

@section('content')
<h3 class="mb-4">Halaman Dashboard</h3>

{{-- 🔔 Notifikasi KIPI Berat baru --}}
@if($jumlahKipiBeratBaru > 0)
    <div class="alert alert-danger" style="padding: 12px; border-radius: 8px; background-color: #f8d7da; color: #721c24; margin-bottom: 20px;">
        ⚠️ Ada <strong>{{ $jumlahKipiBeratBaru }}</strong> kasus <b>KIPI Berat</b> baru yang belum diperiksa.
        <a href="{{ route('pakar.riwayat.kipi') }}" style="text-decoration: underline; color: #721c24;">Lihat sekarang</a>
    </div>
@endif

<div class="row g-4">
    <div class="col-md-3">
        <div class="card-box">
            <i class="fas fa-notes-medical"></i>
            <div>
                <h4>{{ $jumlahGejala ?? 0 }}</h4>
                <p>Gejala</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <i class="fas fa-list-alt"></i>
            <div>
                <h4>{{ $jumlahKategori ?? 0 }}</h4>
                <p>Kategori KIPI</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <i class="fas fa-book-medical"></i>
            <div>
                <h4>{{ $jumlahAturan ?? 0 }}</h4>
                <p>Aturan</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <i class="fas fa-file-medical-alt"></i>
            <div>
                <h4>{{ $jumlahKipi ?? 0 }}</h4>
                <p>Data Diagnosa</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <i class="fas fa-file-medical-alt"></i>
            <div>
                <h4>{{ $jumlahLaporan ?? 0 }}</h4>
                <p>Laporan</p>
            </div>
        </div>
    </div>
</div>
@endsection
