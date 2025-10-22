@extends('layouts.app')


@section('content')
    <div class="container">
        <h2>Riwayat Diagnosa Anak</h2>

        @if (session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="alert-error" class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <script>
            // Fungsi untuk menghilangkan alert setelah 3 detik
            setTimeout(() => {
                const alertSuccess = document.getElementById('alert-success');
                const alertError = document.getElementById('alert-error');

                if (alertSuccess) {
                    alertSuccess.style.transition = "opacity 0.5s ease";
                    alertSuccess.style.opacity = 0;
                    setTimeout(() => alertSuccess.remove(), 500);
                }

                if (alertError) {
                    alertError.style.transition = "opacity 0.5s ease";
                    alertError.style.opacity = 0;
                    setTimeout(() => alertError.remove(), 500);
                }
            }, 3000); // 3000ms = 3 detik
        </script>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Ibu</th>
                    <th>Nama Anak</th>
                    <th>Usia Anak</th>
                    <th>Jenis KIPI</th>
                    <th>Nilai CF</th>
                    <th>Saran</th>
                    <th>Aksi</th>

                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nama_ibu }}</td>
                        <td>{{ $item->nama_anak }}</td>
                        <td>{{ $item->usia_anak }}</td>
                        <td>{{ $item->jenis_kipi }}</td>
                        <td>{{ number_format($item->nilai_cf * 100) }}%</td>
                        <td>{{ $item->saran }}</td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('riwayat.show', $item->id_diagnosa) }}" class="btn btn-sm btn-info">Lihat
                                    Detail</a>
                                <form action="{{ route('riwayat.destroy', $item->id_diagnosa) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada riwayat diagnosa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3 text-end w-100">
            <a href="{{ route('dashboard.user') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
