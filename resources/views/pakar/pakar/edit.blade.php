@extends('layouts.pakar')

@section('page_title', 'Edit Pakar')

@section('content')

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-8 pb-4 border-b border-slate-200">Edit Data Pakar</h2>

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

        <form action="{{ route('pakar.update', $pakar->id_user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name"
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg"
                    value="{{ old('name', $pakar->name) }}" placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input type="email" name="email" id="email"
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg"
                    value="{{ old('email', $pakar->email) }}" placeholder="Masukkan alamat email" required>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru (Opsional)</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg pr-10"
                        placeholder="Kosongkan jika tidak ingin mengubah password">
                    <span
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-slate-400 hover:text-indigo-600"
                        onclick="togglePassword()">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </span>
                </div>
                <p class="mt-2 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password.</p>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-200 mt-8">
                <a href="{{ route('pakar.index') }}"
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

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
