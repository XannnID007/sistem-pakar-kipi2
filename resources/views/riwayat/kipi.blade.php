@extends('layouts.pakar')

{{-- Set judul halaman di topbar --}}
@section('page_title', 'Data Diagnosa KIPI')

@section('content')

    {{-- Main container untuk filter dan tabel --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        {{-- Header untuk Filter Form --}}
        <form method="GET" action="{{ route('pakar.riwayat.kipi') }}" class="p-6 md:p-8 border-b border-slate-200">
            {{-- Grid untuk form filter --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">

                {{-- Filter Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">Diagnosa</label>
                    <select name="kategori" id="kategori" onchange="this.form.submit()"
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 text-base">
                        <option value="">-- Semua Diagnosa --</option>
                        <option value="Ringan (reaksi lokal)"
                            {{ request('kategori') == 'Ringan (reaksi lokal)' ? 'selected' : '' }}>Ringan (reaksi lokal)
                        </option>
                        <option value="Ringan (reaksi sistemik)"
                            {{ request('kategori') == 'Ringan (reaksi sistemik)' ? 'selected' : '' }}>Ringan (reaksi
                            sistemik)</option>
                        <option value="Berat" {{ request('kategori') == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>

                {{-- Filter Bulan --}}
                <div>
                    <label for="bulan" class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                    <select name="bulan" id="bulan"
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 text-base"
                        onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Filter Tahun --}}
                <div>
                    <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                    <select name="tahun" id="tahun"
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 text-base"
                        onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Tombol Buat Laporan --}}
                <div>
                    <a href="{{ route('laporan.kipi.bulanan', [
                        'kategori' => request('kategori'),
                        'bulan' => request('bulan'),
                        'tahun' => request('tahun'),
                    ]) }}"
                        target="_blank"
                        class="flex items-center justify-center w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:bg-green-700 transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-file-pdf mr-2"></i>
                        <span>Buat Laporan</span>
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            @if ($riwayat->isEmpty())
                {{-- Tampilan Jika Data Kosong --}}
                <div class="px-6 py-12 text-center text-slate-500 bg-slate-50">
                    <i class="fas fa-box-open fa-4x mb-4 text-slate-300"></i>
                    <p class="text-xl font-medium">Data tidak ditemukan.</p>
                    <p class="text-md mt-2">Tidak ada data untuk kategori dan periode yang dipilih.</p>
                </div>
            @else
                {{-- Tabel Data --}}
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nama Anak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nama Ibu</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Usia (bln)</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Tgl Diagnosa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Jenis KIPI</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nilai CF</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Saran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($riwayat as $item)
                            <tr
                                class="group hover:bg-slate-50 transition-colors duration-200
                                {{-- Beri tanda jika belum dibaca dan KIPI Berat --}}
                                @if (strtolower($item->jenis_kipi) === 'berat' && !$item->is_read) bg-red-50 hover:bg-red-100 border-l-4 border-red-500 @endif
                            ">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                    {{ $item->nama_anak }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $item->nama_ibu }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $item->usia_anak }} bln
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                    {{-- Pewarnaan Teks Sesuai Kategori --}}
                                    @if (ucfirst($item->jenis_kipi) == 'Berat') text-red-600
                                    @elseif(ucfirst($item->jenis_kipi) == 'Ringan (reaksi sistemik)') text-amber-600
                                    @else text-blue-600 @endif
                                ">
                                    {{ ucfirst($item->jenis_kipi) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                                    {{ number_format($item->nilai_cf * 100) }}%</td>
                                <td class="px-6 py-4 text-sm text-slate-700 min-w-[20rem]">
                                    {{ Str::limit($item->saran, 70) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('pakar.riwayat.kipi.detail', $item->id) }}"
                                        class="flex items-center gap-1 bg-sky-500 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-sky-600 transition-colors">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
