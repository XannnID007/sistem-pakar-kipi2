@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4" style="max-width: 400px; width: 100%;">
        <h4 class="text-center mb-3">Lupa Password</h4>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('lupa.password.kirim') }}">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" placeholder="Masukkan email Anda" required class="form-control">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{ route('login.form') }}">Kembali ke Login</a>
        </div>
    </div>
</div>
@endsection
