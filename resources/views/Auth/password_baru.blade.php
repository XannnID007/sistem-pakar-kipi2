@extends('layouts.app')

@section('title', 'Atur Password Baru')

@section('content')
<div class="login-container">
    <div class="card shadow-sm p-4">
        <h4 class="text-center fw-bold mb-3">Atur Password Baru</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password baru" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Atur Password</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login.form') }}">Kembali ke Login</a>
        </div>
    </div>
</div>
@endsection
