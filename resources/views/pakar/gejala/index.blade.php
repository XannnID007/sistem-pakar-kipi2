@extends('layouts.pakar')

@section('content')
    <div class="container mb-3">
        <h1>Gejala</h1>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tombol tambah gejala dan form pencarian --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3 flex-wrap gap-2">
            <a href="{{ route('pakar.gejala.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>

            <form method="GET" action="{{ route('pakar.gejala.index') }}" class="d-flex gap-2"
                style="max-width: 400px; width: 100%;">
                <input type="text" name="search" placeholder="Cari gejala" value="{{ request('search') }}"
                    class="form-control">
                <button type="submit" class="btn btn-primary">
                    Cari
                </button>
            </form>
        </div>

        {{-- Tabel daftar gejala --}}
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Gejala</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gejalas as $gejala)
                    <tr>
                        <td>{{ $gejala->kode_gejala }}</td>
                        <td>{{ $gejala->nama_gejala }}</td>
                        <td class="text-center text-nowrap">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('pakar.gejala.edit', $gejala->kode_gejala) }}"
                                    class="btn btn-warning btn-sm px-2 py-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('pakar.gejala.destroy', $gejala->kode_gejala) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus gejala ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-2 py-1">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
