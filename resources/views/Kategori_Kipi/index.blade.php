@extends('layouts.pakar')

@section('content')
<div class="container mb-3">
    <h1>Kategori KIPI</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <a href="{{route ('pakar.kategori_kipi.create')}}" class="btn btn-primary mb-3"> <i class="fas fa-plus fa-lg"></i> Tambah Data</a>
    {{-- Form pencarian --}}
        <form method="GET" action="{{ route('pakar.kategori_kipi.index') }}" class="d-flex gap-2" style="max-width: 400px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari Kategori kipi" 
                value="{{ request('search') }}"
                class="form-control"
            >
            <button type="submit" class="btn btn-primary">
                Cari
            </button>
        </form>
    </div>



    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode </th>
                <th>Jenis KIPI</th>
                <th>Saran Penanganan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $item)
                <tr>
                    <td>{{ $item->kode_kategori_kipi }}</td>
                    <td>{{ $item->jenis_kipi }}</td>
                    <td>{{ $item->saran }}</td>
                    <td>
    <div class="d-flex gap-2">
        <a href="{{ route('pakar.kategori_kipi.edit', $item->kode_kategori_kipi) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>

        <form action="{{ route('pakar.kategori_kipi.destroy', $item->kode_kategori_kipi) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">
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
