@extends('layouts.app')

@section('title', 'Login - Sistem Pakar KIPI')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-container">
    <div class="card shadow-sm p-4">
        <h4 class="text-center fw-bold">Login</h4>

        {{-- Tampilkan Error --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-3" style="font-size: 0.85rem;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required class="form-control form-control-sm">
            </div>

            <div class="mb-3 position-relative">
                <input type="password" name="password" id="password" placeholder="Password" required class="form-control form-control-sm pe-5">
                <span class="toggle-password" onclick="togglePassword()">
                    <i id="toggleIcon" class="fa-solid fa-eye text-muted"></i>
                </span>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-sm">Login</button>

            <div class="forgot-password">
                <a href="{{route('lupa.password.form')}}">Lupa Password?</a>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Belum punya akun? 
                <a href="{{ route('register.form') }}" class="text-primary fw-semibold text-decoration-none">
                    Daftar di sini
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
