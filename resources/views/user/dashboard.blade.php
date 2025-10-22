@extends('layouts.app')

@section('title', 'Dashboard - Sistem Pakar KIPI')

@section('content')

    {{-- 1. Hero Card (Welcome + Ilustrasi) --}}
    <div
        class="bg-gradient-to-r from-indigo-600 to-sky-500 text-white rounded-3xl shadow-xl overflow-hidden border border-indigo-300">
        <div class="flex flex-col md:flex-row items-center justify-between p-8 md:p-12 gap-6">

            {{-- Teks Sambutan --}}
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-3xl lg:text-4xl font-bold">
                    Selamat Datang, {{ Auth::user()->name }}
                </h2>
                <p class="text-lg text-indigo-100 mt-4">
                    Silakan memilih menu untuk memulai konsultasi atau melihat hasil sebelumnya.
                </p>
            </div>

            {{-- Ilustrasi --}}
            <div class="hidden md:block flex-shrink-0">
                <img src="{{ asset('images/bg.png') }}" alt="Ilustrasi Dokter" class="w-full max-w-xs lg:max-w-sm h-auto">
            </div>
        </div>
    </div>

    {{-- 2. Menu Grid (Navigasi) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

        {{-- Kartu Mulai Diagnosa --}}
        <a href="{{ route('diagnosa.data') }}"
            class="group bg-white rounded-3xl shadow-xl border border-slate-100 p-8 text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">

            <div class="text-5xl mb-4 transition-transform duration-300 group-hover:scale-110">
                📝
            </div>
            <span class="text-xl font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-300">
                Mulai Diagnosa
            </span>
            <p class="text-sm text-slate-500 mt-2">
                Isi data anak dan mulai konsultasi gejala.
            </p>
        </a>

        {{-- Kartu Riwayat Diagnosa --}}
        <a href="{{ route('riwayat.index') }}"
            class="group bg-white rounded-3xl shadow-xl border border-slate-100 p-8 text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">

            <div class="text-5xl mb-4 transition-transform duration-300 group-hover:scale-110">
                📜
            </div>
            <span class="text-xl font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-300">
                Riwayat Diagnosa
            </span>
            <p class="text-sm text-slate-500 mt-2">
                Lihat semua hasil diagnosa Anda sebelumnya.
            </p>
        </a>

    </div>

@endsection
