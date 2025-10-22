@extends('layouts.app')

@section('title', 'Login - Sistem Pakar KIPI')

@section('styles')
    {{-- Hapus link login.css, ganti dengan style inline jika perlu --}}
    <style>
        /* CSS untuk toggle password dipindahkan ke Tailwind */
    </style>
@endsection

@section('content')
    <div class="flex items-center justify-center py-12">
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-slate-100 mx-auto">
            <h2 class="text-2xl font-bold text-slate-800 text-center mb-8 pb-4 border-b border-slate-200">Login</h2>

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

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email Anda" value="{{ old('email') }}"
                        required
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Password Anda" required
                            class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-300 text-slate-800 placeholder-slate-400 text-lg pr-10">

                        {{-- Tombol Toggle Password --}}
                        <span
                            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-slate-400 hover:text-indigo-600"
                            onclick="togglePassword()">
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="text-sm text-right mb-6">
                    <a href="{{ route('lupa.password.form') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium text-lg">
                    Login
                </button>
            </form>

            <div class="text-center mt-6 pt-6 border-t border-slate-200">
                <p class="text-sm text-slate-600">
                    Belum punya akun?
                    <a href="{{ route('register.form') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Script ini tidak perlu diubah, sudah kompatibel --}}
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
