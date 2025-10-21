@extends('layouts.pakar')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Aturan</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah & pencarian --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3 flex-wrap gap-2">
        <a href="{{ route('pakar.aturan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus fa-lg"></i> Tambah Data
        </a>

        <form method="GET" action="{{ route('pakar.aturan.index') }}" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari" 
                value="{{ request('search') }}"
                class="form-control"
            >
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    @if($aturanList->isEmpty())
        <p class="text-center">Belum ada data aturan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Kode KIPI</th>
                        <th>Kode Gejala</th>
                        <th>Nama Gejala</th>
                        <th>MB</th>
                        <th>MD</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aturanList as $item)
                    <tr>
                    <td>{{ $item->kategoriKipi->kode_kategori_kipi ?? '-' }}</td>
                        <td>{{ $item->kode_gejala }}</td>
                        <td>{{ $item->gejala->nama_gejala ?? '-' }}</td>
                        <td>{{ $item->mb }}</td>
                        <td>{{ $item->md }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('pakar.aturan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                {{-- Form Hapus --}}
                                <form action="{{ route('pakar.aturan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm px-2 py-1">
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
    @endif
</div>
@endsection
