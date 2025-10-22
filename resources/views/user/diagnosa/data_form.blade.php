@extends('layouts.app')

@section('title', 'Mulai Diagnosa - Sistem Pakar KIPI')

@section('content')
    {{-- Container untuk memusatkan card --}}
    <div class="flex justify-center">

        {{-- Card Utama --}}
        <div class="w-full max-w-3xl bg-white p-8 rounded-3xl shadow-xl border border-slate-100 mx-auto">

            {{-- Judul Card --}}
            <h2
                class="text-xl font-bold text-slate-800 text-center mb-6 pb-4 border-b border-slate-200 flex items-center justify-center gap-2">
                <i class="fas fa-clipboard-list text-indigo-500 text-2xl"></i>
                <span>Mohon lengkapi data terlebih dahulu</span>
            </h2>

            {{-- Tampilkan Error Validasi (Jika ada) --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-start shadow-md border-l-4 border-red-500"
                    role="alert">
                    <div class="flex-shrink-0 mr-4 mt-1">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-lg mb-2">Terjadi Kesalahan:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('diagnosa.storeData') }}" method="POST">
                @csrf

                {{-- Grid 2 Kolom --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

                    {{-- Kolom Kiri --}}
                    <div>
                        <div class="mb-4">
                            <label for="nama_ibu" class="block text-sm font-medium text-slate-700 mb-2">Nama Ibu</label>
                            <input type="text" id="nama_ibu" name="nama_ibu"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('nama_ibu', Auth::user()->name) }}" required> {{-- Mengisi nama user yg login --}}
                        </div>

                        <div class="mb-4">
                            <label for="nama_anak" class="block text-sm font-medium text-slate-700 mb-2">Nama Anak</label>
                            <input type="text" id="nama_anak" name="nama_anak"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('nama_anak') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="usia_anak" class="block text-sm font-medium text-slate-700 mb-2">Usia Anak
                                (bulan)</label>
                            <input type="number" id="usia_anak" name="usia_anak"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('usia_anak') }}" min="0" max="60" required>
                        </div>

                        <div class="mb-4">
                            <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700 mb-2">Jenis
                                Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir
                                Anak</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div>
                        <div class="mb-4">
                            <label for="alamat" class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="2"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="jenis_vaksin" class="block text-sm font-medium text-slate-700 mb-2">Jenis
                                Vaksin</label>
                            <input type="text" id="jenis_vaksin" name="jenis_vaksin"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('jenis_vaksin') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="tempat_imunisasi" class="block text-sm font-medium text-slate-700 mb-2">Tempat
                                Imunisasi</label>
                            <input type="text" id="tempat_imunisasi" name="tempat_imunisasi"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('tempat_imunisasi') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_imunisasi" class="block text-sm font-medium text-slate-700 mb-2">Tanggal
                                Imunisasi</label>
                            <input type="date" id="tanggal_imunisasi" name="tanggal_imunisasi"
                                class="block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('tanggal_imunisasi') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium text-lg">
                        <i class="fas fa-play-circle"></i>
                        Mulai Diagnosa
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
