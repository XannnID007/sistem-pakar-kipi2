@extends('layouts.pakar') {{-- Layout khusus untuk pakar --}}

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
    <h2 class="text-2xl font-semibold mb-6">Daftar User</h2>

    {{-- Form Pencarian --}}
    <div class="flex justify-end mb-6">
        <form method="GET" action="{{ url('pakar/user') }}" class="flex items-center gap-2">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari nama atau email..." 
                value="{{ request('search') }}" 
                class="border border-gray-300 rounded px-4 py-2 w-64 focus:outline-none focus:ring focus:border-blue-500"
            >
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Cari
            </button>
        </form>
    </div>

    {{-- Tabel User --}}
    <div class="overflow-x-auto bg-white shadow-md rounded">
        <table class="min-w-full text-left border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 border-b">Nama</th>
                    <th class="px-4 py-3 border-b">Email</th>
                    <th class="px-4 py-3 border-b">Tanggal Daftar</th>
                    <th class="px-4 py-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-3 border-b">{{ $user->email }}</td>
                        <td class="px-4 py-3 border-b">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 border-b text-center">
                            <form action="{{ route('pakar.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
