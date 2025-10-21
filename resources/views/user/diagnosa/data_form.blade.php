@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-start mt-4">
    <div class="card shadow-sm p-3 w-100" style="max-width: 700px; border-radius: 10px;">
        <h6 class="text-center mb-3">
            <i class="bi bi-clipboard-check-fill me-1 text-primary"></i>
            Mohon lengkapi data terlebih dahulu
        </h6>

        <form action="{{ route('diagnosa.storeData') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="nama_ibu" class="form-label small">Nama Ibu</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-control form-control-sm" value="{{ old('nama_ibu') }}" required>
                    </div>

                    <div class="mb-2">
                        <label for="nama_anak" class="form-label small">Nama Anak</label>
                        <input type="text" id="nama_anak" name="nama_anak" class="form-control form-control-sm" value="{{ old('nama_anak') }}" required>
                    </div>

                    <div class="mb-2">
                        <label for="usia_anak" class="form-label small">Usia Anak (bulan)</label>
                        <input type="number" id="usia_anak" name="usia_anak" class="form-control form-control-sm" value="{{ old('usia_anak') }}" min="0" max="60" required>
                    </div>

                    <div class="mb-2">
                        <label for="jenis_kelamin" class="form-label small">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control form-control-sm" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="tanggal_lahir" class="form-label small">Tanggal Lahir Anak</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control form-control-sm" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="alamat" class="form-label small">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" class="form-control form-control-sm" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label for="jenis_vaksin" class="form-label small">Jenis Vaksin</label>
                        <input type="text" id="jenis_vaksin" name="jenis_vaksin" class="form-control form-control-sm" value="{{ old('jenis_vaksin') }}" required>
                    </div>

                    <div class="mb-2">
                        <label for="tempat_imunisasi" class="form-label small">Tempat Imunisasi</label>
                        <input type="text" id="tempat_imunisasi" name="tempat_imunisasi" class="form-control form-control-sm" value="{{ old('tempat_imunisasi') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_imunisasi" class="form-label small">Tanggal Imunisasi</label>
                        <input type="date" id="tanggal_imunisasi" name="tanggal_imunisasi" class="form-control form-control-sm" value="{{ old('tanggal_imunisasi') }}" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary w-100">
                <i class="bi bi-play-circle me-1"></i> Mulai Diagnosa
            </button>
        </form>
    </div>
</div>
@endsection
