@extends('layouts.pakar')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h4>Detail Laporan {{ $laporan->jenis_laporan }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Jenis Laporan:</strong> {{ $laporan->jenis_laporan }}</p>
            <p><strong>Tanggal Laporan:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d-m-Y') }}</p>
            <p><strong>Nama File:</strong> {{ $laporan->nama_file }}</p>

            <!-- Tombol Unduh & Kembali sejajar -->
            <div class="d-flex gap-2 mt-3">
                <a href="{{ asset($laporan->file_path) }}" target="_blank" class="btn btn-primary">
                    📄 Buka / Unduh Laporan PDF
                </a>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                    🔙 Kembali
                </a>
            </div>

            {{-- Jika mau embed PDF di halaman --}}
            {{-- 
            <iframe src="{{ asset($laporan->file_path) }}" width="100%" height="600px"></iframe> 
            --}}
        </div>
    </div>
</div>
@endsection
