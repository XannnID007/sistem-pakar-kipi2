@extends('layouts.app')

@section('title', 'Login - Sistem Pakar KIPI')

@section('styles')
    <style>
        /* Custom styles untuk form login yang lebih compact */
        .login-container {
            min-height: calc(100vh - 200px);
        }
    </style>
@endsection

@section('content')
    <div class="login-container flex items-center justify-center py-8">
        <div class="w-full max-w-sm bg-white p-6 rounded-2xl shadow-lg border border-slate-200 mx-auto">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-slate-800">Masuk</h2>
                <p class="text-sm text-slate-600 mt-1">Silakan masuk ke akun Anda</p>
            </div>

            {{-- Tampilkan Error --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-800 px-4 py-3 rounded-lg mb-4 border border-red-200" role="alert">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2 mt-0.5 flex-shrink-0"></i>
                        <div class="text-sm">
                            @if ($errors->count() == 1)
                                {{ $errors->first() }}
                            @else
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan email"
                        value="{{ old('email') }}" required
                        class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 text-slate-800 placeholder-slate-400">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required
                            class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 text-slate-800 placeholder-slate-400 pr-10">

                        <button type="button"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-indigo-600 transition-colors"
                            onclick="togglePassword()">
                            <i id="toggleIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 text-slate-700">Ingat saya</label>
                    </div>
                    <a href="{{ route('lupa.password.form') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Lupa password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full px-4 py-2.5 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-6 pt-4 border-t border-slate-200">
                <p class="text-sm text-slate-600">
                    Belum punya akun?
                    <a href="{{ route('register.form') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
