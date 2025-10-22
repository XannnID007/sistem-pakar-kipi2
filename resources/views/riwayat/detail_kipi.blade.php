@extends('layouts.pakar')

@section('page_title', 'Detail Diagnosa')

@section('content')

    <div class="max-w-7xl mx-auto">
        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-slate-600">
                <li><a href="{{ route('pakar.riwayat.kipi') }}" class="hover:text-indigo-600">Data Diagnosa</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-slate-900 font-medium">Detail Diagnosa</li>
            </ol>
        </nav>

        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-t-2xl p-6 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Detail Diagnosa Pasien</h1>
                    <p class="text-indigo-100">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Diagnosa pada:
                        {{ \Carbon\Carbon::parse($riwayat->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }}
                    </p>
                </div>

                {{-- Status Badge --}}
                <div class="mt-4 md:mt-0">
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                        {{ strtolower($riwayat->jenis_kipi) === 'berat'
                            ? 'bg-red-500 text-white'
                            : (strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false
                                ? 'bg-yellow-500 text-white'
                                : 'bg-blue-500 text-white') }}">
                        @if (strtolower($riwayat->jenis_kipi) === 'berat')
                            <i class="fas fa-exclamation-triangle mr-2"></i>KIPI Berat
                        @elseif(strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false)
                            <i class="fas fa-exclamation-circle mr-2"></i>KIPI Ringan (Sistemik)
                        @else
                            <i class="fas fa-info-circle mr-2"></i>KIPI Ringan (Lokal)
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-b-2xl shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">

                {{-- Grid Layout --}}
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    {{-- Kolom Kiri: Data Pasien --}}
                    <div class="xl:col-span-1 space-y-6">

                        {{-- Card Data Anak --}}
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-4 py-3 border-b border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <i class="fas fa-child mr-2 text-indigo-600"></i>
                                    Data Anak
                                </h3>
                            </div>
                            <div class="p-4">
                                <dl class="space-y-3">
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Nama</dt>
                                        <dd class="text-slate-900 font-medium">{{ $riwayat->nama_anak ?? '-' }}</dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Jenis Kelamin</dt>
                                        <dd class="text-slate-900">
                                            <span class="inline-flex items-center">
                                                <i
                                                    class="fas {{ $riwayat->jenis_kelamin == 'Laki-laki' ? 'fa-mars text-blue-500' : 'fa-venus text-pink-500' }} mr-1"></i>
                                                {{ $riwayat->jenis_kelamin ?? '-' }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Tanggal Lahir</dt>
                                        <dd class="text-slate-900">
                                            {{ $riwayat->tanggal_lahir ? \Carbon\Carbon::parse($riwayat->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Usia</dt>
                                        <dd class="text-slate-900">
                                            <span
                                                class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                                                {{ $riwayat->usia_anak ?? '-' }} bulan
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        {{-- Card Data Ibu --}}
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-4 py-3 border-b border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <i class="fas fa-female mr-2 text-pink-600"></i>
                                    Data Ibu
                                </h3>
                            </div>
                            <div class="p-4">
                                <dl class="space-y-3">
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Nama Ibu</dt>
                                        <dd class="text-slate-900 font-medium">{{ $riwayat->nama_ibu ?? '-' }}</dd>
                                    </div>
                                    <div class="py-2">
                                        <dt class="font-medium text-slate-600 mb-2">Alamat</dt>
                                        <dd class="text-slate-900 bg-slate-50 p-3 rounded-lg">
                                            {{ $riwayat->alamat ?? '-' }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        {{-- Card Data Imunisasi --}}
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-4 py-3 border-b border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                    <i class="fas fa-syringe mr-2 text-green-600"></i>
                                    Data Imunisasi
                                </h3>
                            </div>
                            <div class="p-4">
                                <dl class="space-y-3">
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Jenis Vaksin</dt>
                                        <dd class="text-slate-900 font-medium">{{ $riwayat->jenis_vaksin ?? '-' }}</dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="font-medium text-slate-600">Tempat</dt>
                                        <dd class="text-slate-900">{{ $riwayat->tempat_imunisasi ?? '-' }}</dd>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <dt class="font-medium text-slate-600">Tanggal</dt>
                                        <dd class="text-slate-900">
                                            {{ $riwayat->tanggal_imunisasi ? \Carbon\Carbon::parse($riwayat->tanggal_imunisasi)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Tengah & Kanan: Gejala & Hasil --}}
                    <div class="xl:col-span-2 space-y-6">

                        {{-- Card Gejala --}}
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-slate-200">
                                <h3 class="text-xl font-semibold text-slate-800 flex items-center">
                                    <i class="fas fa-stethoscope mr-3 text-amber-600"></i>
                                    Gejala yang Dialami
                                </h3>
                            </div>
                            <div class="p-6">
                                @php
                                    $filteredGejala = $gejala->filter(fn($item) => $item->cf_user > 0);
                                @endphp

                                @if ($filteredGejala->isNotEmpty())
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($filteredGejala as $index => $g)
                                            <div
                                                class="flex items-start p-4 bg-slate-50 rounded-lg border border-slate-200">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-amber-100 text-amber-800 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-slate-800 font-medium mb-1">
                                                        {{ $g->gejala->nama_gejala ?? '-' }}
                                                    </p>
                                                    <div class="flex items-center">
                                                        <span class="text-xs text-slate-600 mr-2">Keyakinan:</span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                                                            {{ $g->cf_user == 1 ? 'Yakin (1.0)' : ($g->cf_user == 0.5 ? 'Ragu-ragu (0.5)' : $g->cf_user) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-exclamation-circle text-4xl text-slate-300 mb-4"></i>
                                        <p class="text-slate-500 text-lg">Tidak ada gejala yang dipilih oleh pengguna.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Card Hasil Diagnosa --}}
                        <div
                            class="border-2 rounded-xl overflow-hidden
                            {{ strtolower($riwayat->jenis_kipi) === 'berat'
                                ? 'border-red-300 bg-red-50'
                                : (strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false
                                    ? 'border-yellow-300 bg-yellow-50'
                                    : 'border-blue-300 bg-blue-50') }}">

                            <div
                                class="px-6 py-4 border-b
                                {{ strtolower($riwayat->jenis_kipi) === 'berat'
                                    ? 'bg-red-100 border-red-200'
                                    : (strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false
                                        ? 'bg-yellow-100 border-yellow-200'
                                        : 'bg-blue-100 border-blue-200') }}">
                                <h3 class="text-xl font-semibold text-slate-800 flex items-center">
                                    <i
                                        class="fas fa-chart-line mr-3 
                                        {{ strtolower($riwayat->jenis_kipi) === 'berat'
                                            ? 'text-red-600'
                                            : (strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false
                                                ? 'text-yellow-600'
                                                : 'text-blue-600') }}"></i>
                                    Hasil Diagnosa Sistem
                                </h3>
                            </div>

                            <div class="p-6">
                                {{-- Tingkat Keyakinan --}}
                                <div class="text-center mb-6">
                                    <div class="relative inline-block">
                                        <div class="w-32 h-32 mx-auto mb-4">
                                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 120 120">
                                                <circle cx="60" cy="60" r="50" stroke-width="8"
                                                    stroke="#e5e7eb" fill="none"></circle>
                                                <circle cx="60" cy="60" r="50" stroke-width="8"
                                                    stroke="{{ strtolower($riwayat->jenis_kipi) === 'berat' ? '#dc2626' : (strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false ? '#d97706' : '#2563eb') }}"
                                                    fill="none" stroke-linecap="round"
                                                    stroke-dasharray="{{ 2 * 3.14159 * 50 }}"
                                                    stroke-dashoffset="{{ 2 * 3.14159 * 50 * (1 - ($riwayat->nilai_cf ?? 0)) }}">
                                                </circle>
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span
                                                    class="text-3xl font-bold 
                                                    {{ strtolower($riwayat->jenis_kipi) === 'berat'
                                                        ? 'text-red-600'
                                                        : (strpos(strtolower($riwayat->jenis_kipi), 'sistemik') !== false
                                                            ? 'text-yellow-600'
                                                            : 'text-blue-600') }}">
                                                    {{ isset($riwayat->nilai_cf) ? number_format($riwayat->nilai_cf * 100, 0) : '-' }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="text-xl font-bold text-slate-800 mb-2">
                                        Kemungkinan KIPI {{ $riwayat->jenis_kipi ?? '-' }}
                                    </h4>
                                    <p class="text-slate-600">Tingkat keyakinan sistem pakar</p>
                                </div>

                                {{-- Saran Penanganan --}}
                                <div class="bg-white/50 rounded-lg p-6 border border-slate-200">
                                    <h5 class="font-semibold text-slate-800 mb-3 flex items-center">
                                        <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                                        Saran Penanganan
                                    </h5>
                                    <div class="prose prose-sm max-w-none">
                                        <p class="text-slate-700 leading-relaxed">{{ $riwayat->saran ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer dengan Action Buttons --}}
            <div
                class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center text-sm text-slate-600">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Data diagnosa telah tersimpan dalam sistem</span>
                </div>

                <div class="flex items-center gap-3">
                    @if (strtolower($riwayat->jenis_kipi) === 'berat')
                        <form method="POST" action="{{ route('pakar.riwayat.berat.kirim', $riwayat->id) }}"
                            class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fas fa-file-export mr-2"></i>
                                Buat Laporan
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('pakar.riwayat.kipi') }}"
                        class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Animasi untuk progress circle
        document.addEventListener('DOMContentLoaded', function() {
            const circle = document.querySelector('circle[stroke-dasharray]');
            if (circle) {
                // Reset ke 0
                circle.style.strokeDashoffset = circle.getAttribute('stroke-dasharray');

                // Animate ke nilai yang benar
                setTimeout(() => {
                    circle.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
                    circle.style.strokeDashoffset = circle.getAttribute('stroke-dashoffset');
                }, 500);
            }
        });
    </script>
@endpush
