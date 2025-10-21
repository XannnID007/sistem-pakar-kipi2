@extends('layouts.pakar')

@section('content')
<div class="container mt-4">
    <h3>Edit Aturan</h3>

    <form action="{{ route('pakar.aturan.update', $aturan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Dropdown Kategori KIPI --}}
        <div class="form-group mb-3">
            <label for="kode_kategori_kipi">Kategori KIPI</label>
            <select name="kode_kategori_kipi" id="kode_kategori_kipi" class="form-control" required>
                <option value="">-- Pilih Kategori KIPI --</option>
                @foreach($kategoriKipiList as $kategori)
                    <option value="{{ $kategori->kode_kategori_kipi }}"
                        {{ old('kode_kategori_kipi', $aturan->kode_kategori_kipi) == $kategori->kode_kategori_kipi ? 'selected' : '' }}>
                        {{ $kategori->kode_kategori_kipi }} - {{ $kategori->jenis_kipi }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Dropdown Gejala --}}
        <div class="form-group mb-3">
            <label for="kode_gejala">Gejala</label>
            <select name="kode_gejala" id="kode_gejala" class="form-control" required>
                <option value="">-- Pilih Gejala --</option>
                @foreach($gejalaList as $gejala)
                    <option value="{{ $gejala->kode_gejala }}"
                        {{ old('kode_gejala', $aturan->kode_gejala) == $gejala->kode_gejala ? 'selected' : '' }}>
                        {{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- MB --}}
        <div class="mb-3">
            <label for="mb" class="form-label">MB (Measure of Belief)</label>
            <input type="number" step="0.01" min="0" max="1"
                   name="mb" id="mb"
                   class="form-control @error('mb') is-invalid @enderror"
                   value="{{ old('mb', $aturan->mb) }}" required>
            @error('mb')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- MD --}}
        <div class="mb-3">
            <label for="md" class="form-label">MD (Measure of Disbelief)</label>
            <input type="number" step="0.01" min="0" max="1"
                   name="md" id="md"
                   class="form-control @error('md') is-invalid @enderror"
                   value="{{ old('md', $aturan->md) }}" required>
            @error('md')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('pakar.aturan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
