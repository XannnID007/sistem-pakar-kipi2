@extends('layouts.pakar')

@section('content')
<div class="container">
    <h1>Edit Data Pakar</h1>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <form action="{{ route('pakar.update', $pakar->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" 
                   value="{{ old('name', $pakar->name) }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="{{ old('email', $pakar->email) }}" required>
        </div>

        {{-- Tombol Aksi --}}
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('pakar.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
