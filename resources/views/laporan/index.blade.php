@extends('layouts.pakar')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color:rgb(21, 140, 156)">
                <h4 class="mb-0">Riwayat Laporan</h4>
            </div>
            <div class="card-body">
                @if ($laporan->isEmpty())
                    <p class="text-center">Belum ada laporan yang tersedia.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Laporan</th>
                                <th>Periode / Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->jenis_laporan ?? 'Laporan Lain' }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td class="d-flex gap-2">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('pakar.laporan.show', $item->id_laporan) }}"
                                            class="btn btn-info btn-sm">
                                            Detail
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('pakar.laporan.destroy', $item->id_laporan) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <!-- Tombol Kembali -->

            </div>
        </div>
    </div>
@endsection
