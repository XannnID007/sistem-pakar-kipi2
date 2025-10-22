@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Pesan Sukses (dengan Alpine.js untuk auto-hide) --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="relative bg-green-50 text-green-800 px-6 py-4 rounded-xl mb-8 flex items-center shadow-md border-l-4 border-green-500"
                role="alert">
                <i class="fas fa-check-circle text-2xl text-green-600 mr-4"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Pesan Error (dengan Alpine.js untuk auto-hide) --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="relative bg-red-50 text-red-800 px-6 py-4 rounded-xl mb-8 flex items-start shadow-md border-l-4 border-red-500"
                role="alert">
                <i class="fas fa-exclamation-triangle text-2xl text-red-600 mr-4 mt-1"></i>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Main container untuk tabel --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

            <div class="p-6 md:p-8 border-b border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800">Riwayat Diagnosa Anak Anda</h2>
            </div>

            {{-- Tabel daftar riwayat --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nama Ibu</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nama Anak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Jenis KIPI</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nilai CF</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($riwayat as $item)
                            <tr class="group hover:bg-slate-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                    {{ $item->nama_ibu }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $item->nama_anak }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                @if ($item->jenis_kipi == 'Berat') text-red-600
                                @elseif($item->jenis_kipi == 'Ringan (reaksi sistemik)') text-amber-600
                                @else text-blue-600 @endif">
                                    {{ $item->jenis_kipi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                                    {{ number_format($item->nilai_cf * 100) }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('riwayat.show', $item->id_diagnosa) }}"
                                            class="flex items-center gap-1 bg-sky-500 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-sky-600 transition-colors">
                                            <i class="fas fa-eye"></i>
                                            <span>Detail</span>
                                        </a>
                                        <form action="{{ route('riwayat.destroy', $item->id_diagnosa) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
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
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500 bg-slate-50">
                                    <i class="fas fa-box-open fa-4x mb-4 text-slate-300"></i>
                                    <p class="text-xl font-medium">Belum ada riwayat diagnosa.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6 text-right w-full">
            <a href="{{ route('dashboard.user') }}"
                class="inline-block px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
