@extends('layouts.pakar')

{{-- Set judul halaman di topbar --}}
@section('page_title', 'Riwayat Laporan')

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

    {{-- Main container untuk tabel --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        {{-- Tabel daftar laporan --}}
        <div class="overflow-x-auto">
            @if ($laporan->isEmpty())
                {{-- Tampilan Jika Data Kosong --}}
                <div class="px-6 py-12 text-center text-slate-500 bg-slate-50">
                    <i class="fas fa-file-excel fa-4x mb-4 text-slate-300"></i>
                    <p class="text-xl font-medium">Belum ada laporan.</p>
                    <p class="text-md mt-2">Belum ada laporan yang dibuat dan disimpan.</p>
                </div>
            @else
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Jenis Laporan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Periode / Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($laporan as $index => $item)
                            <tr class="group hover:bg-slate-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                    {{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $item->jenis_laporan ?? 'Laporan Lain' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('pakar.laporan.show', $item->id_laporan) }}"
                                            class="flex items-center gap-1 bg-sky-500 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-sky-600 transition-colors">
                                            <i class="fas fa-eye"></i>
                                            <span>Detail</span>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('pakar.laporan.destroy', $item->id_laporan) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center gap-1 bg-red-600 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-red-700 transition-colors">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
