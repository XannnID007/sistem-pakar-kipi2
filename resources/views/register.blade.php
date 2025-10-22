@extends('layouts.app')

@section('title', 'Register - Sistem Pakar KIPI')

@section('content')
    <div class="flex items-center justify-center py-12">
        {{-- Ubah max-w-md menjadi max-w-2xl untuk menampung 2 kolom --}}
        <div class="w-full max-w-2xl bg-white p-8 rounded-3xl shadow-xl border border-slate-100 mx-auto">
            <h2 class="text-2xl font-bold text-slate-800 text-center mb-8 pb-4 border-b border-slate-200">Register Akun Baru
            </h2>

            {{-- Tampilkan Error --}}
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Buat Grid 2 Kolom --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6 mb-8">

                    {{-- Kolom 1: Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                        <input type="text" name="name" id="name" placeholder="Nama Lengkap Anda"
                            value="{{ old('name') }}" required
                            class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg">
                    </div>

                    {{-- Kolom 2: Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email Anda"
                            value="{{ old('email') }}" required
                            class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg">
                    </div>

                    {{-- Kolom 1: Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Buat Password" required
                                class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg pr-10 password-input">
                            <span
                                class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-slate-400 hover:text-indigo-600">
                                <i class="fas fa-eye text-slate-400"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Kolom 2: Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi
                            Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Konfirmasi Password Anda" required
                                class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg pr-10 password-input">
                            <span
                                class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-slate-400 hover:text-indigo-600">
                                <i class="fas fa-eye text-slate-400"></i>
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Akhir Grid --}}

                <button type="submit"
                    class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium text-lg">
                    Register
                </button>
            </form>

            <div class="text-center mt-6 pt-6 border-t border-slate-200">
                <p class="text-sm text-slate-600">
                    Sudah punya akun?
                    <a href="{{ route('login.form') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(function(span) {
                span.addEventListener('click', function() {
                    // Target input adalah elemen SIBLING SEBELUMNYA
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
@endsection
