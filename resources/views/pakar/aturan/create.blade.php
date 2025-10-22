@extends('layouts.pakar')

@section('page_title', 'Tambah Aturan')

@section('content')

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-8 pb-4 border-b border-slate-200">Tambah Aturan Baru</h2>

        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 text-red-800 px-6 py-4 rounded-xl mb-8 flex items-start shadow-md border-l-4 border-red-500"
                role="alert">
                <div class="flex-shrink-0 mr-4 mt-1">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-lg mb-2">Terjadi Kesalahan Validasi:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Pesan sukses (jika ada, meskipun jarang di halaman create) --}}
        @if (session('success'))
            <div class="relative bg-green-50 text-green-800 px-6 py-4 rounded-xl mb-8 flex items-center shadow-md border-l-4 border-green-500"
                role="alert">
                <i class="fas fa-check-circle text-2xl text-green-600 mr-4"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('pakar.aturan.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="kode_kategori_kipi" class="block text-sm font-medium text-slate-700 mb-2">Kategori KIPI</label>
                <select name="kode_kategori_kipi" id="kode_kategori_kipi"
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 text-lg"
                    required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoriKipiList as $kategori)
                        <option value="{{ $kategori->kode_kategori_kipi }}"
                            {{ old('kode_kategori_kipi') == $kategori->kode_kategori_kipi ? 'selected' : '' }}>
                            {{ $kategori->kode_kategori_kipi }} - {{ $kategori->jenis_kipi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="kode_gejala" class="block text-sm font-medium text-slate-700 mb-2">Gejala</label>
                <select name="kode_gejala" id="kode_gejala"
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 text-lg"
                    required>
                    <option value="">-- Pilih Gejala --</option>
                    @foreach ($gejalaList as $gejala)
                        <option value="{{ $gejala->kode_gejala }}"
                            {{ old('kode_gejala') == $gejala->kode_gejala ? 'selected' : '' }}>
                            {{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Grid untuk MB dan MD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="mb" class="block text-sm font-medium text-slate-700 mb-2">MB (Measure of
                        Belief)</label>
                    <input type="number" step="0.01" min="0" max="1" name="mb" id="mb"
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg"
                        placeholder="0.0 - 1.0" value="{{ old('mb') }}" required>
                    <p class="mt-2 text-xs text-slate-500">Nilai keyakinan (contoh: 0.8)</p>
                </div>
                <div>
                    <label for="md" class="block text-sm font-medium text-slate-700 mb-2">MD (Measure of
                        Disbelief)</label>
                    <input type="number" step="0.01" min="0" max="1" name="md" id="md"
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg"
                        placeholder="0.0 - 1.0" value="{{ old('md') }}" required>
                    <p class="mt-2 text-xs text-slate-500">Nilai ketidakyakinan (contoh: 0.2)</p>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-200 mt-8">
                <a href="{{ route('pakar.aturan.index') }}"
                    class="px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i> Simpan Aturan
                </button>
            </div>
        </form>
    </div>
@endsection
