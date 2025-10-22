@extends('layouts.pakar')

@section('page_title', 'Edit Gejala')

@section('content')

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-8 pb-4 border-b border-slate-200">Edit Gejala</h2>

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

        <form action="{{ route('pakar.gejala.update', $gejala->kode_gejala) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="kode_gejala" class="block text-sm font-medium text-slate-700 mb-2">Kode Gejala</label>
                <input type="text" name="kode_gejala" id="kode_gejala"
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg bg-slate-100 text-slate-600 cursor-not-allowed text-lg"
                    value="{{ old('kode_gejala', $gejala->kode_gejala) }}" readonly>
                <p class="mt-2 text-xs text-slate-500">Kode gejala ini tidak dapat diubah.</p>
            </div>

            <div class="mb-8">
                <label for="nama_gejala" class="block text-sm font-medium text-slate-700 mb-2">Nama Gejala</label>
                <input type="text" name="nama_gejala" id="nama_gejala"
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg"
                    value="{{ old('nama_gejala', $gejala->nama_gejala) }}" required>
                @error('nama_gejala')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-200 mt-8">
                <a href="{{ route('pakar.gejala.index') }}"
                    class="px-6 py-3 border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-100 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
