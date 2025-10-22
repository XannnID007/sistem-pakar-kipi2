@extends('layouts.pakar')

@section('page_title', 'Detail Diagnosa')

@section('content')

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <div class="p-6 md:p-8 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">Detail Diagnosa Pasien</h2>
            <p class="text-sm text-slate-500 mt-1">
                Diagnosa pada: {{ \Carbon\Carbon::parse($riwayat->tanggal)->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
            </p>
        </div>

        <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- KOLOM KIRI: Data & Imunisasi --}}
            <div class="space-y-6">
                {{-- Card Data Anak --}}
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <h5 class="text-lg font-semibold text-slate-800 p-4 bg-slate-100 border-b border-slate-200">
                        <i class="fas fa-child mr-2 text-indigo-500"></i> Data Anak
                    </h5>
                    <table class="w-full">
                        <tbody class="divide-y divide-slate-200">
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50 w-1/3">Nama Anak</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->nama_anak ?? '-' }}</td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Jenis Kelamin</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->jenis_kelamin ?? '-' }}</td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Tanggal Lahir</td>
                                <td class="px-4 py-2 text-slate-800">
                                    {{ $riwayat->tanggal_lahir ? \Carbon\Carbon::parse($riwayat->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Usia (bln)</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->usia_anak ?? '-' }} bln</td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Nama Ibu</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Alamat</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->alamat ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Card Data Imunisasi --}}
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <h5 class="text-lg font-semibold text-slate-800 p-4 bg-slate-100 border-b border-slate-200">
                        <i class="fas fa-syringe mr-2 text-blue-500"></i> Data Imunisasi
                    </h5>
                    <table class="w-full">
                        <tbody class="divide-y divide-slate-200">
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50 w-1/3">Jenis Vaksin</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->jenis_vaksin ?? '-' }}</td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Tempat Imunisasi</td>
                                <td class="px-4 py-2 text-slate-800">{{ $riwayat->tempat_imunisasi ?? '-' }}</td>
                            </tr>
                            <tr class="text-sm">
                                <td class="px-4 py-2 font-medium text-slate-600 bg-slate-50">Tanggal Imunisasi</td>
                                <td class="px-4 py-2 text-slate-800">
                                    {{ $riwayat->tanggal_imunisasi ? \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                            $filteredGejala = $gejala->filter(
                                fn($item) => $item->cf_user != 0 && $item->cf_user != 0.5,
                            );
                        @endphp

                        @if ($filteredGejala->isNotEmpty())
                            <ul class="list-disc list-inside space-y-2 text-sm text-slate-700">
                                @foreach ($filteredGejala as $g)
                                    <li>{{ $g->gejala->nama_gejala ?? '-' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-slate-500 text-sm italic">Tidak ada gejala yang dipilih oleh pengguna.</p>
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
                            {{ isset($riwayat->nilai_cf) ? number_format($riwayat->nilai_cf * 100, 0) : '-' }}%
                        </span>
                        <p class="font-semibold text-slate-800 text-lg">
                            Kemungkinan KIPI {{ $riwayat->jenis_kipi ?? '-' }}
                        </p>
                    </div>

                    <h6 class="font-semibold text-slate-800 mb-1">Saran Penanganan:</h6>
                    <p class="text-sm text-slate-700">{{ $riwayat->saran ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Footer Tombol Aksi --}}
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex justify-end items-center gap-4 rounded-b-3xl">
            @if (strtolower($riwayat->jenis_kipi) === 'berat')
                <form method="POST" action="{{ route('pakar.riwayat.berat.kirim', $riwayat->id) }}">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                        <i class="fas fa-file-export mr-2"></i> Buat Laporan
                    </button>
                </form>
            @endif
            <a href="{{ route('pakar.riwayat.kipi') }}"
                class="px-5 py-2 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors duration-200">
                Kembali
            </a>
        </div>

    </div>
    </div>
@endsection
