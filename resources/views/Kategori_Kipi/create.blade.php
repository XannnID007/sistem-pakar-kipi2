@extends('layouts.pakar')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Kategori KIPI</h1>

    {{-- Notifikasi error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tambah kategori --}}
    <form action="{{ route('pakar.kategori_kipi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kode_kategori_kipi" class="form-label">Kode KIPI</label>
            <input type="text" name="kode_kategori_kipi" class="form-control" value="{{ $kodeBaru }}" readonly>
        </div>

        <div class="mb-3">
            <label for="jenis_kipi" class="form-label">Jenis KIPI</label>
            <input type="text" name="jenis_kipi" id="jenis_kipi" class="form-control" value="{{ old('jenis_kipi') }}" placeholder="Contoh: Ringan, Sedang, Berat" required>
        </div>

        <div class="mb-3">
            <label for="saran" class="form-label">Saran Penanganan</label>
            <textarea name="saran" id="saran" class="form-control" rows="4" placeholder="Masukkan saran penanganan" required>{{ old('saran') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pakar.kategori_kipi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
