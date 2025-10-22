@extends('layouts.app')

@section('title', 'Hasil Diagnosa - Sistem Pakar KIPI')

@section('content')
    <div class="flex justify-center py-12">

        {{-- Card Utama Konten --}}
        <div class="w-full max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-slate-100">

            {{-- Header --}}
            <div class="text-center mb-8 pb-4 border-b border-slate-200">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Diagnosa KIPI Selesai!</h2>
                <p class="text-md text-slate-500">
                    Berikut adalah hasil diagnosa berdasarkan gejala yang Anda masukkan.
                </p>
                <p class="text-sm text-slate-400 mt-2">
                    Tanggal: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                </p>
            </div>

            {{-- Result Card Utama --}}
            @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
                <div
                    class="bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-2xl p-6 mb-8 shadow-lg flex flex-col md:flex-row items-center gap-6">
                    <div class="flex-shrink-0 text-5xl md:text-6xl">
                        <i class="fas fa-syringe"></i> {{-- Ikon suntikan --}}
                    </div>
                    <div class="flex-grow text-center md:text-left">
                        <p class="text-xl font-semibold mb-1">Kemungkinan KIPI yang Dialami:</p>
                        <h3 class="text-4xl font-extrabold mb-2">{{ $hasilTerbaik['jenis_kipi'] }}</h3>
                        <p class="text-lg">Tingkat Kepastian: <span
                                class="font-bold text-yellow-300">{{ number_format($hasilTerbaik['cf'] * 100, 0) }}%</span>
                        </p>
                    </div>
                </div>

                {{-- Saran Penanganan --}}
                <div class="mb-8 p-5 bg-indigo-50 rounded-xl border border-indigo-200">
                    <h4 class="text-lg font-semibold text-indigo-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-indigo-500"></i> Saran Penanganan
                    </h4>
                    <p class="text-slate-700 leading-relaxed text-base">
                        {{ $hasilTerbaik['saran'] ?? 'Tidak ada saran yang tersedia.' }}</p>
                </div>
            @else
                <div class="bg-red-50 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-start shadow-md border-l-4 border-red-500"
                    role="alert">
                    <div class="flex-shrink-0 mr-4 mt-1">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-lg mb-2">Tidak Ada Hasil Diagnosa</p>
                        <p class="text-sm">Maaf, kami tidak dapat memberikan diagnosa berdasarkan gejala yang Anda masukkan.
                            Silakan coba diagnosa ulang.</p>
                    </div>
                </div>
            @endif


            {{-- Accordion untuk Detail Data Anak --}}
            <div class="mb-6 border border-slate-200 rounded-xl overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-5 py-4 bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                    <span class="text-lg font-semibold text-slate-700 flex items-center gap-2">
                        <i class="fas fa-child text-indigo-500"></i> Detail Data Anak
                    </span>
                    <i class="fas fa-chevron-down text-slate-500 transition-transform duration-300"
                        :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                    class="p-5 bg-white border-t border-slate-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm text-slate-700">
                        <p><strong class="text-slate-800">Nama Ibu:</strong> {{ session('nama_ibu', '-') }}</p>
                        <p><strong class="text-slate-800">Nama Anak:</strong> {{ session('nama_anak', '-') }}</p>
                        <p><strong class="text-slate-800">Jenis Kelamin:</strong> {{ session('jenis_kelamin', '-') }}</p>
                        <p><strong class="text-slate-800">Usia Anak:</strong> {{ session('usia_anak', '-') }} bulan</p>
                        <p><strong class="text-slate-800">Tanggal Lahir:</strong>
                            @if (session('tanggal_lahir'))
                                {{ \Carbon\Carbon::parse(session('tanggal_lahir'))->locale('id')->isoFormat('D MMMM Y') }}
                            @else
                                -
                            @endif
                        </p>
                        <p><strong class="text-slate-800">Alamat:</strong> {{ session('alamat', '-') }}</p>
                        <p><strong class="text-slate-800">Jenis Vaksin:</strong> {{ session('jenis_vaksin', '-') }}</p>
                        <p><strong class="text-slate-800">Tempat Imunisasi:</strong> {{ session('tempat_imunisasi', '-') }}
                        </p>
                        <p><strong class="text-slate-800">Tanggal Imunisasi:</strong>
                            @if (session('tanggal_imunisasi'))
                                {{ \Carbon\Carbon::parse(session('tanggal_imunisasi'))->locale('id')->isoFormat('D MMMM Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Accordion untuk Detail Gejala --}}
            @if (
                !empty($gejalaDipilih) &&
                    is_array($gejalaDipilih) &&
                    count(array_filter($gejalaDipilih, fn($g) => isset($g['cf_user']) && floatval($g['cf_user']) > 0)) > 0)
                @php $filteredGejala = array_filter($gejalaDipilih, fn($g) => isset($g['cf_user']) && floatval($g['cf_user']) > 0); @endphp
                <div class="mb-8 border border-slate-200 rounded-xl overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-5 py-4 bg-slate-50 hover:bg-slate-100 transition-colors focus:outline-none">
                        <span class="text-lg font-semibold text-slate-700 flex items-center gap-2">
                            <i class="fas fa-list-check text-indigo-500"></i> Gejala yang Dipilih
                        </span>
                        <i class="fas fa-chevron-down text-slate-500 transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2" class="p-5 bg-white border-t border-slate-200">
                        <ul class="list-disc list-inside space-y-2 text-sm text-slate-700">
                            @foreach ($filteredGejala as $gejala)
                                <li>{{ $gejala['nama'] ?? ($gejala['nama_gejala'] ?? '-') }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-8 pt-6 border-t border-slate-200">
                @if (!empty($hasilTerbaik) && isset($hasilTerbaik['cf'], $hasilTerbaik['jenis_kipi']))
                    <form action="{{ route('riwayat.simpan') }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        {{-- Hidden inputs --}}
                        <input type="hidden" name="nama_ibu" value="{{ session('nama_ibu') }}">
                        <input type="hidden" name="nama_anak" value="{{ session('nama_anak') }}">
                        <input type="hidden" name="usia_anak" value="{{ session('usia_anak') }}">
                        <input type="hidden" name="jenis_kipi" value="{{ $hasilTerbaik['jenis_kipi'] }}">
                        <input type="hidden" name="nilai_cf" value="{{ $hasilTerbaik['cf'] }}">
                        <input type="hidden" name="saran" value="{{ $hasilTerbaik['saran'] }}">
                        <input type="hidden" name="gejala_dipilih" value='@json($gejalaDipilih)'>
                        <input type="hidden" name="jenis_kelamin" value="{{ session('jenis_kelamin') }}">
                        <input type="hidden" name="tanggal_lahir" value="{{ session('tanggal_lahir') }}">
                        <input type="hidden" name="alamat" value="{{ session('alamat') }}">
                        <input type="hidden" name="jenis_vaksin" value="{{ session('jenis_vaksin') }}">
                        <input type="hidden" name="tempat_imunisasi" value="{{ session('tempat_imunisasi') }}">
                        <input type="hidden" name="tanggal_imunisasi" value="{{ session('tanggal_imunisasi') }}">

                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                            <i class="fas fa-save"></i> Simpan Hasil
                        </button>
                    </form>
                @endif
                <a href="{{ route('diagnosa.ulang') }}"
                    class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors duration-200">
                    <i class="fas fa-redo-alt"></i> Diagnosa Ulang
                </a>
            </div>
        </div>
    </div>
@endsection
