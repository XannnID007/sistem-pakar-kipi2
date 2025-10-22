@extends('layouts.pakar')

@section('page_title', 'Data Aturan')

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

        {{-- Header untuk Aksi (Tambah & Cari) --}}
        <div class="p-6 md:p-8 border-b border-slate-200 flex flex-col md:flex-row justify-between items-center gap-6">
            <a href="{{ route('pakar.aturan.create') }}"
                class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 w-full md:w-auto text-center justify-center">
                <i class="fas fa-plus"></i>
                <span>Tambah Aturan Baru</span>
            </a>

            <form method="GET" action="{{ route('pakar.aturan.index') }}" class="relative w-full md:max-w-xs group">
                <input type="text" name="search" placeholder="Cari gejala atau KIPI..." value="{{ request('search') }}"
                    class="block w-full pl-12 pr-4 py-3 border-2 border-slate-300 rounded-lg focus:outline-none focus:ring-0 focus:border-indigo-500 transition-all duration-300 text-slate-800 placeholder-slate-400 group-hover:border-indigo-400">
                <i
                    class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
            </form>
        </div>

        {{-- Tabel daftar aturan --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kode
                            KIPI</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kode
                            Gejala</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama
                            Gejala</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">MB
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">MD
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($aturanList as $item)
                        <tr class="group hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                {{ $item->kategoriKipi->kode_kategori_kipi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                {{ $item->kode_gejala }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $item->gejala->nama_gejala ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-center font-mono">
                                {{ number_format($item->mb, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-center font-mono">
                                {{ number_format($item->md, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-4">
                                    <a href="{{ route('pakar.aturan.edit', $item->id_aturan) }}"
                                        class="text-indigo-500 hover:text-indigo-700 transition-colors duration-200"
                                        title="Edit Aturan">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>
                                    <form action="{{ route('pakar.aturan.destroy', $item->id_aturan) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus aturan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 transition-colors duration-200"
                                            title="Hapus Aturan">
                                            <i class="fas fa-trash-alt text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500 bg-slate-50">
                                <i class="fas fa-box-open fa-4x mb-4 text-slate-300"></i>
                                <p class="text-xl font-medium">Data aturan tidak ditemukan.</p>
                                <p class="text-md mt-2">Belum ada aturan yang ditambahkan atau tidak sesuai dengan pencarian
                                    Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
