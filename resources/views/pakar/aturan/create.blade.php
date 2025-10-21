@extends('layouts.pakar')

@section('content')
<div class="container mt-4">
    <h3>Tambah Aturan</h3>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pakar.aturan.store') }}" method="POST">
        @csrf

        {{-- Pilih Kategori KIPI --}}
        <div class="mb-3">
            <label for="kode_kategori_kipi" class="form-label">Kategori KIPI</label>
            <select name="kode_kategori_kipi" id="kode_kategori_kipi" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriKipiList as $kategori)
                    <option value="{{ $kategori->kode_kategori_kipi }}"
                        {{ old('kode_kategori_kipi') == $kategori->kode_kategori_kipi ? 'selected' : '' }}>
                        {{ $kategori->kode_kategori_kipi }} - {{ $kategori->jenis_kipi }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Gejala --}}
        <div class="mb-3">
            <label for="kode_gejala" class="form-label">Gejala</label>
            <select name="kode_gejala" id="kode_gejala" class="form-control" required>
                <option value="">-- Pilih Gejala --</option>
                @foreach($gejalaList as $gejala)
                    <option value="{{ $gejala->kode_gejala }}"
                        {{ old('kode_gejala') == $gejala->kode_gejala ? 'selected' : '' }}>
                        {{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- MB --}}
        <div class="mb-3">
            <label for="mb" class="form-label">MB (0 - 1)</label>
            <input type="number" step="0.1" min="0" max="1"
                   class="form-control" id="mb" name="mb"
                   value="{{ old('mb') }}" required>
        </div>

        {{-- MD --}}
        <div class="mb-3">
            <label for="md" class="form-label">MD (0 - 1)</label>
            <input type="number" step="0.1" min="0" max="1"
                   class="form-control" id="md" name="md"
                   value="{{ old('md') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pakar.aturan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
