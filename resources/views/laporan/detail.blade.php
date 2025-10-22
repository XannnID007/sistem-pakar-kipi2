@extends('layouts.pakar')

{{-- Set judul halaman di topbar --}}
@section('page_title', 'Detail Laporan')

@section('content')

    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        {{-- Header Card --}}
        <div class="p-6 md:p-8 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">Detail Laporan {{ $laporan->jenis_laporan }}</h2>
        </div>

        {{-- Body Card --}}
        <div class="p-6 md:p-8">
            {{-- Menggunakan Definition List <dl> untuk tampilan yang lebih rapi --}}
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-600">Jenis Laporan</dt>
                    <dd class="mt-1 text-lg font-semibold text-slate-900">{{ $laporan->jenis_laporan }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-600">Tanggal Laporan Dibuat</dt>
                    <dd class="mt-1 text-lg text-slate-900">
                        {{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d M Y, H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-600">Nama File</dt>
                    <dd class="mt-1 text-lg text-slate-900">{{ $laporan->nama_file }}</dd>
                </div>
            </dl>

            {{-- Jika mau embed PDF di halaman --}}
            {{-- 
            <div class="mt-6 border border-slate-300 rounded-lg overflow-hidden">
                <iframe src="{{ asset($laporan->file_path) }}" class="w-full h-[600px]"></iframe> 
            </div>
            --}}
        </div>

        {{-- Footer Tombol Aksi --}}
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
            <a href="{{ route('pakar.laporan.index') }}"
                class="px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors duration-200">
                Kembali
            </a>
            <a href="{{ asset($laporan->file_path) }}" target="_blank"
                class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                <i class="fas fa-download mr-2"></i> Buka / Unduh PDF
            </a>
        </div>
    </div>
@endsection
