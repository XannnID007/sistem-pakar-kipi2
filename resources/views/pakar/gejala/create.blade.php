@extends('layouts.pakar')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Gejala</h1>

        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form tambah gejala --}}
        <form action="{{ route('pakar.gejala.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kode_gejala" class="form-label">Kode Gejala</label>
                <input type="text" name="kode_gejala" class="form-control" value="{{ $kodeBaru }}" readonly>
            </div>
            <div class="mb-3">
                <label for="nama_gejala" class="form-label">Nama Gejala</label>
                <input type="text" name="nama_gejala" id="nama_gejala" class="form-control"
                    placeholder="Contoh: Ruam dan gatal di kulit" value="{{ old('nama_gejala') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pakar.gejala.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
