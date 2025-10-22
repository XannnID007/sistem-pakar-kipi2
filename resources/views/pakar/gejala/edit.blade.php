@extends('layouts.pakar')

@section('content')
    <div class="container">
        <h1>Edit Gejala</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pakar.gejala.update', $gejala->kode_gejala) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kode_gejala" class="form-label">Kode Gejala</label>
                <input type="text" name="kode_gejala" id="kode_gejala" class="form-control"
                    value="{{ old('kode_gejala', $gejala->kode_gejala) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nama_gejala" class="form-label">Nama Gejala</label>
                <input type="text" name="nama_gejala" id="nama_gejala" class="form-control"
                    value="{{ old('nama_gejala', $gejala->nama_gejala) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pakar.gejala.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
