@extends('layouts.pakar')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Data Pakar</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    {{-- Tombol tambah gejala --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('pakar.create') }}" class="btn btn-primary mb-3">Tambah Pakar</a>
    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('pakar.pengetahuan.index') }}" class="mb-4 flex gap-2">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari nama atau email..." 
            value="{{ request('search') }}"
            class="border border-gray-300 rounded px-4 py-2 flex-grow focus:outline-none focus:ring focus:border-blue-500"
        >
        <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
            Cari
        </button>
    </form>
    </div>
  
    
    {{-- Tabel Data Pakar --}}
    <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pakars as $pakar)
                <tr>
                    <td>{{ $pakar->name }}</td>
                    <td>{{ $pakar->email }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="d-flex justify-content-center">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('pakar.edit', $pakar->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('pakar.destroy', $pakar->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pakar ini?')" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-600">Belum ada data pakar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
