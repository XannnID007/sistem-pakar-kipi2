@extends('layouts.app')

@section('title', 'Detail Riwayat Diagnosa - Sistem Pakar KIPI')

@section('content')
    {{-- Hapus <style> block dan tag <body> --}}

    <div class="flex justify-center py-12"> {{-- Container untuk memusatkan card --}}

        {{-- Card Utama Konten --}}
        <div class="w-full max-w-3xl mx-auto bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-slate-100">

            {{-- Header --}}
            <div class="text-center mb-8 pb-4 border-b border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800 mb-1">Detail Hasil Diagnosa</h2>
                <p class="text-md text-slate-500">
                    Tanggal Diagnosa:
                    {{ \Carbon\Carbon::parse($riwayat->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                {{-- KOLOM KIRI: Data & Imunisasi --}}
                <div class="space-y-6">
                    {{-- Card Data Anak --}}
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <h5 class="text-lg font-semibold text-slate-800 p-4 bg-slate-100 border-b border-slate-200">
                            <i class="fas fa-child mr-2 text-indigo-500"></i> Data Anak
                        </h5>
                        {{-- Menggunakan Definition List <dl> agar lebih semantik & rapi --}}
                        <dl class="divide-y divide-slate-200 text-sm">
                            <div class="grid grid-cols-3 gap-4 px-4 py-3 bg-slate-50">
                                <dt class="font-medium text-slate-600">Nama Anak</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->nama_anak ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                <dt class="font-medium text-slate-600">Jenis Kelamin</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->jenis_kelamin ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3 bg-slate-50">
                                <dt class="font-medium text-slate-600">Tanggal Lahir</dt>
                                <dd class="text-slate-800 col-span-2">
                                    {{ $riwayat->tanggal_lahir ? \Carbon\Carbon::parse($riwayat->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                <dt class="font-medium text-slate-600">Usia (bln)</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->usia_anak ?? '-' }} bln</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3 bg-slate-50">
                                <dt class="font-medium text-slate-600">Nama Ibu</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->nama_ibu ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                <dt class="font-medium text-slate-600">Alamat</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->alamat ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Card Data Imunisasi --}}
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <h5 class="text-lg font-semibold text-slate-800 p-4 bg-slate-100 border-b border-slate-200">
                            <i class="fas fa-syringe mr-2 text-blue-500"></i> Data Imunisasi
                        </h5>
                        <dl class="divide-y divide-slate-200 text-sm">
                            <div class="grid grid-cols-3 gap-4 px-4 py-3 bg-slate-50">
                                <dt class="font-medium text-slate-600">Jenis Vaksin</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->jenis_vaksin ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                <dt class="font-medium text-slate-600">Tempat Imunisasi</dt>
                                <dd class="text-slate-800 col-span-2">{{ $riwayat->tempat_imunisasi ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 px-4 py-3 bg-slate-50">
                                <dt class="font-medium text-slate-600">Tanggal Imunisasi</dt>
                                <dd class="text-slate-800 col-span-2">
                                    {{ $riwayat->tanggal_imunisasi ? \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- KOLOM KANAN: Gejala & Hasil --}}
                <div class="space-y-6">
                    {{-- Card Gejala --}}
                    <div class="border border-slate-200 rounded-xl">
                        <h5
                            class="text-lg font-semibold text-slate-800 p-4 bg-slate-100 border-b border-slate-200 rounded-t-xl">
                            <i class="fas fa-tasks mr-2 text-amber-500"></i> Gejala yang Dialami
                        </h5>
                        <div class="p-4">
                            @php
                                $gejalaDipilih = $riwayat->gejalaDipilih
                                    ->filter(fn($g) => $g->cf_user > 0)
                                    ->loadMissing('gejala')
                                    ->values();
                            @endphp

                            @if ($gejalaDipilih->count() > 0)
                                <ul class="list-disc list-inside space-y-2 text-sm text-slate-700">
                                    @foreach ($gejalaDipilih as $gejala)
                                        <li>{{ $gejala->gejala->nama_gejala ?? ($gejala->kode_gejala ?? 'Gejala tidak diketahui') }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-slate-500 text-sm italic">Tidak ada gejala yang dipilih.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Card Hasil Diagnosa --}}
                    <div
                        class="border-2 
                    @if (strtolower($riwayat->jenis_kipi) === 'berat') border-red-300 bg-red-50
                    @elseif(strtolower($riwayat->jenis_kipi) === 'ringan (reaksi sistemik)') border-amber-300 bg-amber-50
                    @else border-blue-300 bg-blue-50 @endif
                    rounded-xl p-6">

                        <h5 class="text-lg font-semibold text-slate-900 mb-4">
                            <i class="fas fa-poll-h mr-2"></i> Hasil Diagnosa Sistem
                        </h5>

                        <div class="text-center mb-4">
                            <span
                                class="text-5xl font-bold 
                            @if (strtolower($riwayat->jenis_kipi) === 'berat') text-red-600
                            @elseif(strtolower($riwayat->jenis_kipi) === 'ringan (reaksi sistemik)') text-amber-600
                            @else text-blue-600 @endif">
                                {{ number_format($riwayat->nilai_cf * 100, 0) }}%
                            </span>
                            <p class="font-semibold text-slate-800 text-lg">
                                Kemungkinan KIPI {{ $riwayat->jenis_kipi ?? '-' }}
                            </p>
                        </div>

                        <h6 class="font-semibold text-slate-800 mb-1">Saran Penanganan:</h6>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $riwayat->saran ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-center items-center gap-4 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('riwayat.index') }}"
                    class="px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors duration-200">
                    Kembali ke Riwayat
                </a>
                <a href="{{ route('riwayat.cetak', $riwayat->id_diagnosa) }}" target="_blank"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                    <i class="fas fa-print mr-2"></i> Cetak PDF
                </a>
            </div>
        </div>
    </div>
@endsection
