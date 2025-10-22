@extends('layouts.pakar')

@section('page_title', 'Detail Diagnosa KIPI')

@section('content')

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="relative bg-green-50 text-green-800 px-6 py-4 rounded-xl mb-8 flex items-center shadow-md border-l-4 border-green-500"
            role="alert">
            <div class="flex-shrink-0 mr-4">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
            <div class="flex-grow">
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="absolute top-3 right-3 text-green-700 hover:text-green-900 transition-colors"
                onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
    @endif

    {{-- Header dengan Info Status --}}
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Detail Diagnosa KIPI</h2>
                <div class="flex items-center gap-4 text-sm text-slate-600">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-calendar text-indigo-500"></i>
                        {{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d F Y, H:i') }}
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-user text-indigo-500"></i>
                        {{ $riwayat->user->name ?? 'Pengguna Dihapus' }}
                    </span>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                @if ($riwayat->jenis_kipi == 'Berat')
                    <div class="flex items-center gap-2">
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            KIPI Berat
                        </span>
                        @if (!$riwayat->is_read)
                            <span class="px-3 py-1 text-xs bg-red-600 text-white rounded-full animate-pulse">
                                Baru
                            </span>
                        @endif
                    </div>
                @elseif ($riwayat->jenis_kipi == 'Ringan (reaksi sistemik)')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-amber-100 text-amber-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        Ringan Sistemik
                    </span>
                @else
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-sky-100 text-sky-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Ringan Lokal
                    </span>
                @endif

                {{-- Tombol Aksi --}}
                @if ($riwayat->jenis_kipi == 'Berat')
                    <form action="{{ route('pakar.riwayat.berat.kirim', $riwayat->id_diagnosa) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin mengirim laporan KIPI Berat ini ke sistem pelaporan?');"
                        class="inline-block">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Laporan</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Grid Layout untuk Desktop/Tablet --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Data Pasien (Kolom 1) --}}
        <div class="xl:col-span-1 bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <div class="p-6 md:p-8 border-b border-slate-200">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-circle text-indigo-500"></i>
                    Data Pasien
                </h3>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                {{-- Info Anak --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-baby text-pink-500"></i>
                        Data Anak
                    </h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Nama:</dt>
                            <dd class="font-semibold text-slate-800">{{ $riwayat->nama_anak }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Jenis Kelamin:</dt>
                            <dd class="font-semibold text-slate-800">{{ $riwayat->jenis_kelamin }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Usia:</dt>
                            <dd class="font-semibold text-slate-800">{{ $riwayat->usia_anak }} bulan</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Tanggal Lahir:</dt>
                            <dd class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_lahir)->format('d M Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Info Ibu --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-female text-purple-500"></i>
                        Data Ibu
                    </h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Nama:</dt>
                            <dd class="font-semibold text-slate-800">{{ $riwayat->nama_ibu }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Alamat:</dt>
                            <dd class="font-semibold text-slate-800">{{ $riwayat->alamat }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Info Vaksinasi --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-syringe text-green-500"></i>
                        Data Vaksinasi
                    </h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Jenis Vaksin:</dt>
                            <dd class="font-semibold text-slate-800 capitalize">{{ $riwayat->jenis_vaksin }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Tempat:</dt>
                            <dd class="font-semibold text-slate-800">{{ $riwayat->tempat_imunisasi }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-600">Tanggal:</dt>
                            <dd class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->format('d M Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Hasil Diagnosa & Gejala (Kolom 2-3) --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Hasil Diagnosa --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
                <div class="p-6 md:p-8 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-stethoscope text-red-500"></i>
                        Hasil Diagnosa
                    </h3>
                </div>
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kategori KIPI --}}
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-6">
                            <h4 class="font-semibold text-slate-700 mb-2">Kategori KIPI</h4>
                            <p
                                class="text-2xl font-bold mb-2
                                {{ $riwayat->jenis_kipi == 'Berat' ? 'text-red-600' : ($riwayat->jenis_kipi == 'Ringan (reaksi sistemik)' ? 'text-amber-600' : 'text-sky-600') }}">
                                {{ $riwayat->jenis_kipi }}
                            </p>
                        </div>

                        {{-- Nilai Certainty Factor --}}
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-6">
                            <h4 class="font-semibold text-slate-700 mb-2">Nilai Certainty Factor</h4>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl font-bold text-slate-800">
                                    {{ number_format($riwayat->nilai_cf * 100, 1) }}%
                                </span>
                                <span class="text-sm text-slate-600 mb-1">keyakinan</span>
                            </div>
                            {{-- Progress Bar --}}
                            <div class="w-full bg-slate-200 rounded-full h-2 mt-3">
                                <div class="h-2 rounded-full transition-all duration-500
                                    {{ $riwayat->nilai_cf >= 0.8 ? 'bg-red-500' : ($riwayat->nilai_cf >= 0.5 ? 'bg-amber-500' : 'bg-sky-500') }}"
                                    style="width: {{ $riwayat->nilai_cf * 100 }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Saran Penanganan --}}
                    <div
                        class="mt-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-indigo-500">
                        <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-lightbulb text-indigo-500"></i>
                            Saran Penanganan
                        </h4>
                        <p class="text-slate-700 leading-relaxed">{{ $riwayat->saran }}</p>
                    </div>
                </div>
            </div>

            {{-- Gejala yang Dipilih --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
                <div class="p-6 md:p-8 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-list-check text-emerald-500"></i>
                        Gejala yang Dipilih
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Total {{ $gejala->where('cf_user', '>', 0)->count() }} gejala dilaporkan
                    </p>
                </div>
                <div class="p-6 md:p-8">
                    @if ($gejala->where('cf_user', '>', 0)->count() > 0)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($gejala->where('cf_user', '>', 0) as $item)
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-slate-800">
                                            {{ $item->gejala->nama_gejala ?? 'Gejala tidak ditemukan' }}</h5>
                                        <p class="text-sm text-slate-600">Kode: {{ $item->kode_gejala }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        {{-- Tingkat Keyakinan User --}}
                                        <div class="text-right">
                                            <span class="text-sm text-slate-600">Tingkat Keyakinan:</span>
                                            <div
                                                class="font-bold text-lg
                                                {{ $item->cf_user == 1.0 ? 'text-red-600' : ($item->cf_user == 0.5 ? 'text-amber-600' : 'text-slate-600') }}">
                                                @if ($item->cf_user == 1.0)
                                                    Yakin (100%)
                                                @elseif($item->cf_user == 0.5)
                                                    Kurang Yakin (50%)
                                                @else
                                                    Tidak Yakin (0%)
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Icon Status --}}
                                        <div
                                            class="w-12 h-12 rounded-full flex items-center justify-center
                                            {{ $item->cf_user == 1.0 ? 'bg-red-100 text-red-600' : ($item->cf_user == 0.5 ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-600') }}">
                                            @if ($item->cf_user == 1.0)
                                                <i class="fas fa-check-circle text-xl"></i>
                                            @elseif($item->cf_user == 0.5)
                                                <i class="fas fa-question-circle text-xl"></i>
                                            @else
                                                <i class="fas fa-times-circle text-xl"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-circle fa-4x text-slate-300 mb-4"></i>
                            <p class="text-xl font-medium text-slate-500">Tidak ada gejala yang dilaporkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Navigasi --}}
    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 p-6 bg-white rounded-xl shadow-lg">
        <a href="{{ route('pakar.riwayat.kipi') }}"
            class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    {{-- Print Styles --}}
    <style media="print">
        @page {
            margin: 2cm;
        }

        .no-print {
            display: none !important;
        }

        body {
            font-size: 12pt;
            line-height: 1.4;
        }

        .grid {
            display: block !important;
        }

        .xl\\:col-span-1,
        .xl\\:col-span-2 {
            width: 100% !important;
            margin-bottom: 20px;
        }
    </style>
@endsection
