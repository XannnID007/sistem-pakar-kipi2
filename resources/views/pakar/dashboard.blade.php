@extends('layouts.pakar')

{{-- 1. Mengisi judul di topbar --}}
@section('page_title', 'Dashboard')

@section('content')

    {{-- 2. HAPUS: <h2>...</h2> (Sudah pindah ke layout) --}}
    {{-- <h2 class="text-3xl font-semibold text-slate-900 mb-6">Dashboard</h2> --}}

    {{-- 🔔 Notifikasi KIPI Berat (Tetap Sama) --}}
    @if ($jumlahKipiBeratBaru > 0)
        <div class="flex items-start gap-4 p-5 mb-8 bg-red-50 border border-red-300 rounded-lg shadow-md" role="alert">
            <i class="fas fa-exclamation-triangle text-red-600 text-3xl flex-shrink-0"></i>
            <div class="flex-1">
                <h3 class="font-bold text-red-800 text-lg">Notifikasi Penting</h3>
                <p class="text-red-700 mt-1">
                    Ada <strong>{{ $jumlahKipiBeratBaru }}</strong> kasus <b>KIPI Berat</b> baru yang belum diperiksa.
                    <a href="{{ route('pakar.riwayat.kipi') }}" class="font-bold hover:underline ml-2 whitespace-nowrap">
                        Lihat Sekarang &rarr;
                    </a>
                </p>
            </div>
        </div>
    @endif

    {{-- "Bento Grid" untuk Statistik (Tetap Sama) --}}
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">

        <div
            class="md:col-span-2 relative p-6 bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-xl shadow-xl overflow-hidden">
            <i
                class="fas fa-notes-medical absolute -right-2 -bottom-2 text-8xl text-indigo-400 opacity-30 transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <p class="text-indigo-100 uppercase tracking-wider text-sm">Gejala</p>
                <h3 class="text-4xl font-bold mt-1">{{ $jumlahGejala ?? 0 }}</h3>
            </div>
        </div>

        <div
            class="md:col-span-2 relative p-6 bg-gradient-to-br from-sky-500 to-sky-700 text-white rounded-xl shadow-xl overflow-hidden">
            <i
                class="fas fa-layer-group absolute -right-2 -bottom-2 text-8xl text-sky-400 opacity-30 transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <p class="text-sky-100 uppercase tracking-wider text-sm">Kategori KIPI</p>
                <h3 class="text-4xl font-bold mt-1">{{ $jumlahKategori ?? 0 }}</h3>
            </div>
        </div>

        <div
            class="md:col-span-2 relative p-6 bg-gradient-to-br from-teal-500 to-teal-700 text-white rounded-xl shadow-xl overflow-hidden">
            <i
                class="fas fa-book-medical absolute -right-2 -bottom-2 text-8xl text-teal-400 opacity-30 transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <p class="text-teal-100 uppercase tracking-wider text-sm">Aturan</s<p>
                <h3 class="text-4xl font-bold mt-1">{{ $jumlahAturan ?? 0 }}</h3>
            </div>
        </div>

        <div
            class="md:col-span-3 relative p-6 bg-gradient-to-br from-amber-500 to-amber-700 text-white rounded-xl shadow-xl overflow-hidden">
            <i
                class="fas fa-file-medical-alt absolute -right-3 -bottom-3 text-9xl text-amber-400 opacity-30 transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <p class="text-amber-100 uppercase tracking-wider text-sm">Data Diagnosa</p>
                <h3 class="text-4xl font-bold mt-1">{{ $jumlahKipi ?? 0 }}</h3>
            </div>
        </div>

        <div
            class="md:col-span-3 relative p-6 bg-gradient-to-br from-lime-600 to-green-700 text-white rounded-xl shadow-xl overflow-hidden">
            <i
                class="fas fa-clipboard-list absolute -right-3 -bottom-3 text-9xl text-lime-400 opacity-30 transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <p class="text-lime-100 uppercase tracking-wider text-sm">Laporan</p>
                <h3 class="text-4xl font-bold mt-1">{{ $jumlahLaporan ?? 0 }}</h3>
            </div>
        </div>
    </div>

    {{-- Tabel Diagnosa Terbaru --}}
    <div class="mt-8 bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-xl font-semibold text-slate-800">Diagnosa Terbaru</h3>
            <p class="text-sm text-slate-500 mt-1">5 kasus terakhir yang masuk ke sistem.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-xs text-slate-500 font-medium uppercase tracking-wider">Nama Pengguna</th>
                        <th class="px-6 py-3 text-xs text-slate-500 font-medium uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-xs text-slate-500 font-medium uppercase tracking-wider">Hasil Diagnosa
                        </th>
                        <th class="px-6 py-3 text-xs text-slate-500 font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs text-slate-500 font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($kasusTerbaru as $kasus)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">
                                    {{ $kasus->user->name ?? 'Pengguna Dihapus' }}</div>
                                <div class="text-xs text-slate-500">{{ $kasus->nama_ibu ?? $kasus->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{-- Asumsi 'tanggal' adalah objek Carbon/date --}}
                                {{ \Carbon\Carbon::parse($kasus->tanggal)->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                {{ $kasus->jenis_kipi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Badge Status Dinamis --}}
                                @if ($kasus->jenis_kipi == 'Berat')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Perlu Tinjauan
                                    </span>
                                @elseif ($kasus->jenis_kipi == 'Ringan (reaksi sistemik)')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                        Sistemik
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-sky-100 text-sky-800">
                                        Lokal
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{-- Ganti 'pakar.riwayat.show' dengan route Anda yang sesuai --}}
                                <a href="{{ route('pakar.riwayat.kipi') }}?search={{ $kasus->id_diagnosa }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                <i class="fas fa-folder-open fa-2x mb-2"></i>
                                <p>Belum ada data diagnosa yang masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Card (Link ke halaman utama riwayat) --}}
        <div class="p-4 bg-slate-50 border-t border-slate-200 text-center">
            <a href="{{ route('pakar.riwayat.kipi') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                Lihat Semua Riwayat Diagnosa &rarr;
            </a>
        </div>
    </div>

@endsection
