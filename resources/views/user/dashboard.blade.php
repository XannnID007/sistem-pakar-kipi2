@extends('layouts.app')

@section('content')
<div class="container-dashboard">
    <div class="welcome">
        <h2>Selamat Datang, {{ Auth::user()->name }}</h2>
        <p>Silakan memilih menu untuk memulai konsultasi atau melihat hasil sebelumnya.</p>
    </div>

    <div class="illustration">
        <img src="{{ asset('images/bg.png') }}" alt="Ilustrasi Dokter">
    </div>
</div>

<div class="menu">
    <a href="{{ route('diagnosa.data') }}">
        <div class="menu-icon">📝</div>
        Mulai Diagnosa
    </a>
    <a href="{{ route('riwayat.index') }}">
        <div class="menu-icon">📜</div>
        Riwayat Diagnosa
    </a>
</div>
@endsection
