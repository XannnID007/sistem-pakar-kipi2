<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole; // Import middleware class

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Form Lupa Password


Route::get('/lupa-password', [AuthController::class, 'formLupaPassword'])->name('lupa.password.form');
Route::post('/lupa-password', [AuthController::class, 'kirimLinkReset'])->name('lupa.password.kirim');

// Route reset password (Laravel membutuhkan route dengan nama password.reset)
Route::get('/reset-password/{token}', [AuthController::class, 'formAturPasswordBaru'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');



Route::middleware('auth')->group(function () {

    // Route dashboard utama yang redirect sesuai role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'bidan_desa') {
            return redirect()->route('pakar.dashboard');
        } elseif ($role === 'orang_tua') {
            return redirect()->route('dashboard.user');
        } elseif ($role === 'kepala_puskesmas') {
            return redirect()->route('kepala.dashboard');
        }
        abort(403, 'Role tidak dikenali');
    })->name('dashboard');

    // Dashboard pakar
    Route::get('/dashboard/pakar', function () {
        return view('pakar.dashboard');
    })->middleware(CheckRole::class . ':bidan_desa')->name('pakar.dashboard');

    // Dashboard pengguna
    Route::get('/dashboard/user', function () {
        return view('user.dashboard');
    })->middleware(CheckRole::class . ':orang_tua')->name('dashboard.user');

    // Dashboard kepala puskesmas
    Route::get('/dashboard/kepala', function () {
        return view('kepala.dashboard');
    })->middleware(CheckRole::class . ':kepala_puskesmas')->name('kepala.dashboard');

});

use App\Http\Controllers\DiagnosisController;

Route::middleware('auth')->group(function () {
    Route::get('/diagnosa/data', [DiagnosisController::class, 'showDataForm'])->name('diagnosa.data');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.data.store');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.storeData');
    Route::get('/diagnosa/gejala', [DiagnosisController::class, 'showGejalaForm'])->name('diagnosa.gejala');
    Route::post('/diagnosa/proses', [DiagnosisController::class, 'prosesDiagnosa'])->name('diagnosa.proses');
    Route::get('/diagnosa/ulang', [DiagnosisController::class, 'diagnosaUlang'])->name('diagnosa.ulang');
   
});
use App\Http\Controllers\PakarController;

Route::get('pakar/user', [PakarController::class, 'user'])->name('pakar.user');
Route::get('/dashboard/pakar', [PakarController::class, 'dashboard'])->name('pakar.dashboard');
Route::resource('pakar/pakar', PakarController::class)->except(['show']);
Route::get('/pakar/riwayat-diagnosa', [PakarController::class, 'riwayatDiagnosa'])->name('pakar.riwayat');
Route::get('/pakar/laporan', [PakarController::class, 'laporan'])->name('pakar.laporan');
Route::get('/pakar/laporan/cetak', [PakarController::class, 'cetakLaporan'])->name('pakar.cetak_laporan');
Route::delete('/pakar/user/{id}', [UserController::class, 'destroy'])->name('pakar.user.destroy');



use App\Http\Controllers\GejalaController;

Route::prefix('pakar')->name('pakar.')->group(function () {
    Route::resource('gejala', GejalaController::class);
});
Route::get('/pakar/gejala/{kode_gejala}/edit', [GejalaController::class, 'edit'])->name('pakar.gejala.edit');


use App\Http\Controllers\KategoriKipiController;

Route::prefix('pakar')->name('pakar.')->group(function () {
    Route::resource('kategori_kipi', KategoriKipiController::class);
});
use App\Http\Controllers\AturanController;

Route::prefix('pakar/aturan')->name('pakar.aturan.')->group(function () {
    Route::get('/', [AturanController::class, 'index'])->name('index');
    Route::get('/create', [AturanController::class, 'create'])->name('create');
    Route::post('/store', [AturanController::class, 'store'])->name('store');

    Route::get('/edit/{id}', [AturanController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AturanController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [AturanController::class, 'destroy'])->name('destroy');
});



use App\Http\Controllers\HasilDiagnosaController;
Route::get('/riwayat-diagnosa', [HasilDiagnosaController::class, 'index'])->name('riwayat.index');
Route::post('/riwayat-diagnosa/simpan', [HasilDiagnosaController::class, 'simpan'])->name('riwayat.simpan');
Route::get('/riwayat/kipi-berat', [HasilDiagnosaController::class, 'kipiBerat'])->name('riwayat.kipi_berat');
Route::get('/pakar/riwayat/kipi', [HasilDiagnosaController::class, 'kipi'])->name('pakar.riwayat.kipi');

Route::get('/riwayat/{id}', [HasilDiagnosaController::class, 'show'])->name('riwayat.show');
Route::delete('/riwayat/{id}', [HasilDiagnosaController::class, 'destroy'])->name('riwayat.destroy');
Route::get('/riwayat/{id}/cetak', [HasilDiagnosaController::class, 'cetak'])->name('riwayat.cetak');
Route::get('/pakar/riwayat/kipi-berat/{id}', [HasilDiagnosaController::class, 'detailBerat'])->name('pakar.riwayat.berat.detail');
Route::get('/laporan/kipi/bulanan', [HasilDiagnosaController::class, 'laporanBulanan'])->name('laporan.kipi.bulanan');
Route::post('/pakar/riwayat/kirim', [HasilDiagnosaController::class, 'kirimBulanan'])->name('pakar.riwayat.kipi.kirim');

// Route KIPI Berat - PAKAR
Route::get('/pakar/riwayat/kipi/{id}', [HasilDiagnosaController::class, 'detailKIPI'])->name('pakar.riwayat.kipi.detail');

Route::post('/pakar/kipi-berat/{id}/kirim', [HasilDiagnosaController::class, 'kirimKIPIBerat'])->name('pakar.riwayat.berat.kirim');

use App\Http\Controllers\KepalaController;

Route::get('/kepala/laporan-kipi', [KepalaController::class, 'laporanKIPI'])->name('kepala.laporan.kipi');
// Route untuk kepala melihat laporan
Route::middleware(['auth', CheckRole::class . ':kepala_puskesmas'])->prefix('kepala')->group(function () {
    Route::get('/laporan', [KepalaController::class, 'LaporanKiPI'])->name('kepala.laporan_kipi');
    Route::get('/laporan/{id}', [KepalaController::class, 'showLaporan'])->name('kepala.laporan.show');
    Route::delete('/kepala/laporan/{id}', [KepalaController::class, 'destroy'])->name('kepala.laporan.destroy');
    Route::get('/kepala/laporan', [KepalaController::class, 'laporanKIPI'])->name('kepala.laporan.index');
    Route::get('/kepala/laporan-berat', [KepalaController::class, 'indexBerat'])->name('kepala.laporan.berat');
    Route::delete('/kepala/laporan-berat/{id}', [KepalaController::class, 'destroyLaporanBerat'])->name('kepala.laporan.berat.destroy');

Route::delete('/kepala/laporan/delete/{id}', [KepalaController::class, 'destroy'])->name('kepala.laporan.delete');
Route::prefix('kepala/laporan')->name('kepala.laporan.')->middleware('auth')->group(function () {
    Route::get('/', [KepalaController::class, 'index'])->name('index'); // daftar laporan
    Route::get('/{id}', [KepalaController::class, 'show'])->name('show'); // lihat PDF
    Route::delete('/{id}', [KepalaController::class, 'destroy'])->name('destroy'); // hapus
    
   

});


});

use App\Http\Controllers\LaporanController;

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
Route::delete('laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

Route::get('/kepala/kipi/berat', [LaporanController::class, 'laporanBerat'])->name('kepala.kipi.berat');
Route::delete('/kepala/kipi/berat/{id}', [LaporanController::class, 'destroyLaporanBerat'])->name('kepala.laporan.berat.destroy');

Route::get('/kepala/kipi/bulanan', [LaporanController::class, 'laporanBulanan'])->name('kepala.kipi.bulanan');
Route::delete('/kepala/kipi/bulanan/{id_laporan}', [LaporanController::class, 'destroyLaporanBulanan'])->name('kepala.laporan.bulanan.destroy');
Route::get('/kepala/ringkasan-laporan', [LaporanController::class, 'ringkasanLaporan'])->name('kepala.ringkasan');

});








