@extends('layouts.pakar')

@section('page_title', 'Data Diagnosa KIPI')

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

    {{-- Pesan info --}}
    @if (session('info'))
        <div class="relative bg-blue-50 text-blue-800 px-6 py-4 rounded-xl mb-8 flex items-center shadow-md border-l-4 border-blue-500"
            role="alert">
            <div class="flex-shrink-0 mr-4">
                <i class="fas fa-info-circle text-2xl text-blue-600"></i>
            </div>
            <div class="flex-grow">
                <span class="font-semibold">{{ session('info') }}</span>
            </div>
            <button type="button" class="absolute top-3 right-3 text-blue-700 hover:text-blue-900 transition-colors"
                onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
    @endif

    {{-- Main container --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        {{-- Header dengan Filter dan Aksi --}}
        <div class="p-6 md:p-8 border-b border-slate-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">

                {{-- Judul dan Statistik --}}
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Data Diagnosa KIPI</h3>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-600">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-database text-indigo-500"></i>
                            Total: <strong>{{ $riwayat->count() }}</strong> diagnosa
                        </span>
                        @if ($riwayat->where('jenis_kipi', 'Berat')->count() > 0)
                            <span class="flex items-center gap-2 text-red-600">
                                <i class="fas fa-exclamation-triangle"></i>
                                KIPI Berat: <strong>{{ $riwayat->where('jenis_kipi', 'Berat')->count() }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Tombol Aksi Utama --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="toggleFilterModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors">
                        <i class="fas fa-filter"></i>
                        <span>Filter & Cari</span>
                    </button>

                    <button onclick="toggleLaporanModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        <i class="fas fa-file-export"></i>
                        <span>Buat Laporan</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabel Data Diagnosa --}}
        <div class="overflow-x-auto">
            @if ($riwayat->isEmpty())
                {{-- Tampilan Jika Data Kosong --}}
                <div class="px-6 py-16 text-center text-slate-500 bg-slate-50">
                    <i class="fas fa-clipboard-list fa-6x mb-6 text-slate-300"></i>
                    <h3 class="text-2xl font-semibold mb-3">Belum Ada Data Diagnosa</h3>
                    <p class="text-lg">Belum ada diagnosa KIPI yang tercatat dalam sistem.</p>
                </div>
            @else
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Data Anak
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Jenis Vaksin
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Hasil Diagnosa
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nilai CF
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($riwayat as $item)
                            <tr class="group hover:bg-slate-50 transition-colors duration-200">
                                {{-- Tanggal --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <div class="flex flex-col">
                                        <span class="font-medium">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                        </span>
                                        <span class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Data Anak --}}
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">{{ $item->nama_anak }}</span>
                                        <span class="text-xs text-slate-500">
                                            {{ $item->jenis_kelamin }}, {{ $item->usia_anak }} bulan
                                        </span>
                                        <span class="text-xs text-slate-500">
                                            Ibu: {{ $item->nama_ibu }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Jenis Vaksin --}}
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="flex flex-col">
                                        <span class="font-medium capitalize">{{ $item->jenis_vaksin }}</span>
                                        <span class="text-xs text-slate-500">
                                            {{ $item->tempat_imunisasi }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Hasil Diagnosa --}}
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-semibold 
                                            {{ $item->jenis_kipi == 'Berat' ? 'text-red-700' : ($item->jenis_kipi == 'Ringan (reaksi sistemik)' ? 'text-amber-700' : 'text-sky-700') }}">
                                            {{ $item->jenis_kipi }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Nilai CF --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <span
                                        class="font-mono font-semibold px-3 py-1 rounded-full text-xs
                                        {{ $item->nilai_cf >= 0.8 ? 'bg-red-100 text-red-800' : ($item->nilai_cf >= 0.5 ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800') }}">
                                        {{ number_format($item->nilai_cf * 100, 1) }}%
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($item->jenis_kipi == 'Berat')
                                        <div class="flex flex-col items-center gap-1">
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Perlu Tinjauan
                                            </span>
                                            @if (!$item->is_read)
                                                <span
                                                    class="px-2 py-1 text-xs bg-red-600 text-white rounded-full animate-pulse">
                                                    Baru
                                                </span>
                                            @endif
                                        </div>
                                    @elseif ($item->jenis_kipi == 'Ringan (reaksi sistemik)')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                            Ringan Sistemik
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-sky-100 text-sky-800">
                                            Ringan Lokal
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('pakar.riwayat.kipi.detail', $item->id_diagnosa) }}"
                                            class="flex items-center gap-1 bg-indigo-500 text-white px-3 py-2 rounded-md text-xs font-medium hover:bg-indigo-600 transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden sm:inline">Detail</span>
                                        </a>

                                        {{-- Tombol Kirim Laporan untuk KIPI Berat --}}
                                        @if ($item->jenis_kipi == 'Berat')
                                            <form action="{{ route('pakar.riwayat.berat.kirim', $item->id_diagnosa) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin mengirim laporan KIPI Berat ini?');"
                                                class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center gap-1 bg-red-600 text-white px-3 py-2 rounded-md text-xs font-medium hover:bg-red-700 transition-colors"
                                                    title="Kirim Laporan KIPI Berat">
                                                    <i class="fas fa-paper-plane"></i>
                                                    <span class="hidden sm:inline">Kirim</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Modal Filter --}}
    <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Filter & Pencarian</h3>
                    <button onclick="toggleFilterModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form method="GET" action="{{ route('pakar.riwayat.kipi') }}" class="space-y-4">
                    {{-- Pencarian --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pencarian</label>
                        <input type="text" name="search" placeholder="Cari nama anak, ibu, atau vaksin..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    {{-- Filter Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori KIPI</label>
                        <select name="kategori"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Kategori</option>
                            <option value="Ringan (reaksi lokal)"
                                {{ request('kategori') == 'Ringan (reaksi lokal)' ? 'selected' : '' }}>
                                Ringan (reaksi lokal)
                            </option>
                            <option value="Ringan (reaksi sistemik)"
                                {{ request('kategori') == 'Ringan (reaksi sistemik)' ? 'selected' : '' }}>
                                Ringan (reaksi sistemik)
                            </option>
                            <option value="Berat" {{ request('kategori') == 'Berat' ? 'selected' : '' }}>
                                Berat
                            </option>
                        </select>
                    </div>

                    {{-- Filter Bulan --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                            <select name="bulan"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                            <select name="tahun"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua Tahun</option>
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}"
                                        {{ request('tahun') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                            <i class="fas fa-search mr-2"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('pakar.riwayat.kipi') }}"
                            class="flex-1 bg-slate-300 text-slate-700 px-4 py-3 rounded-lg hover:bg-slate-400 transition-colors font-medium text-center">
                            <i class="fas fa-redo mr-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Laporan --}}
    <div id="laporanModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Buat Laporan KIPI</h3>
                    <button onclick="toggleLaporanModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('laporan.kipi.bulanan.kirim') }}" class="space-y-4">
                    @csrf

                    {{-- Kategori untuk Laporan --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori KIPI</label>
                        <select name="kategori"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Kategori</option>
                            <option value="Ringan (reaksi lokal)">Ringan (reaksi lokal)</option>
                            <option value="Ringan (reaksi sistemik)">Ringan (reaksi sistemik)</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>

                    {{-- Periode Laporan --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                            <select name="bulan"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                            <select name="tahun"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="previewLaporan()"
                            class="flex-1 bg-slate-600 text-white px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors font-medium">
                            <i class="fas fa-eye mr-2"></i> Preview
                        </button>
                        <button type="submit"
                            class="flex-1 bg-emerald-600 text-white px-4 py-3 rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                            <i class="fas fa-file-export mr-2"></i> Buat Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.classList.toggle('hidden');
        }

        function toggleLaporanModal() {
            const modal = document.getElementById('laporanModal');
            modal.classList.toggle('hidden');
        }

        function previewLaporan() {
            // Ambil data form
            const form = document.querySelector('#laporanModal form');
            const formData = new FormData(form);

            // Buat URL preview
            const params = new URLSearchParams();
            for (let [key, value] of formData.entries()) {
                if (value) params.append(key, value);
            }

            // Buka preview di tab baru
            window.open(`{{ route('laporan.kipi.bulanan') }}?${params.toString()}`, '_blank');
        }

        // Tutup modal saat klik di luar
        document.addEventListener('click', function(e) {
            const filterModal = document.getElementById('filterModal');
            const laporanModal = document.getElementById('laporanModal');

            if (e.target === filterModal) {
                filterModal.classList.add('hidden');
            }
            if (e.target === laporanModal) {
                laporanModal.classList.add('hidden');
            }
        });

        // ESC key untuk tutup modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('filterModal').classList.add('hidden');
                document.getElementById('laporanModal').classList.add('hidden');
            }
        });
    </script>
@endsection