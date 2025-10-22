<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\PakarController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\KategoriKipiController;
use App\Http\Controllers\AturanController;
use App\Http\Controllers\HasilDiagnosaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;

// == HALAMAN PUBLIK ==
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// == AUTENTIKASI ==
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password
Route::get('/lupa-password', [AuthController::class, 'formLupaPassword'])->name('lupa.password.form');
Route::post('/lupa-password', [AuthController::class, 'kirimLinkReset'])->name('lupa.password.kirim');
Route::get('/reset-password/{token}', [AuthController::class, 'formAturPasswordBaru'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// == AREA KHUSUS SETELAH LOGIN ==
Route::middleware('auth')->group(function () {

    // -- DASHBOARD (Redirect Sesuai Role) --
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'pakar') {
            return redirect()->route('pakar.dashboard');
        } elseif ($role === 'orang_tua') {
            return redirect()->route('dashboard.user');
        }
        abort(403, 'Role tidak dikenali');
    })->name('dashboard');

    // -- DASHBOARD PAKAR --
    Route::get('/dashboard/pakar', [PakarController::class, 'dashboard'])
        ->middleware(CheckRole::class . ':pakar')
        ->name('pakar.dashboard');

    // -- DASHBOARD PENGGUNA (ORANG TUA) --
    Route::get('/dashboard/user', function () {
        return view('user.dashboard');
    })->middleware(CheckRole::class . ':orang_tua')
        ->name('dashboard.user');

    // -- PROFIL PENGGUNA (ORANG TUA) --
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/password', [UserController::class, 'changePassword'])->name('profile.password.change');
    Route::put('/profile/password/update', [UserController::class, 'updatePassword'])->name('profile.password.update');

    // -- PROSES DIAGNOSA (ORANG TUA) --
    Route::get('/diagnosa/data', [DiagnosisController::class, 'showDataForm'])->name('diagnosa.data');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.storeData');
    Route::get('/diagnosa/gejala', [DiagnosisController::class, 'showGejalaForm'])->name('diagnosa.gejala');
    Route::post('/diagnosa/proses', [DiagnosisController::class, 'prosesDiagnosa'])->name('diagnosa.proses');
    Route::get('/diagnosa/ulang', [DiagnosisController::class, 'diagnosaUlang'])->name('diagnosa.ulang');

    // -- RIWAYAT DIAGNOSA (ORANG TUA) --
    Route::get('/riwayat-diagnosa', [HasilDiagnosaController::class, 'index'])->name('riwayat.index');
    Route::post('/riwayat-diagnosa/simpan', [HasilDiagnosaController::class, 'simpan'])->name('riwayat.simpan');
    Route::get('/riwayat/{diagnosa}', [HasilDiagnosaController::class, 'show'])->name('riwayat.show');
    Route::delete('/riwayat/{diagnosa}', [HasilDiagnosaController::class, 'destroy'])->name('riwayat.destroy');
    Route::get('/riwayat/{diagnosa}/cetak', [HasilDiagnosaController::class, 'cetak'])->name('riwayat.cetak');

    // ✅ ROUTE LAPORAN (DIPINDAH KELUAR DARI GROUP PAKAR)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
        Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');

        // Route tambahan untuk laporan KIPI
        Route::get('/kipi-bulanan', [HasilDiagnosaController::class, 'laporanBulanan'])->name('kipi.bulanan');
    });

    // == AREA KHUSUS PAKAR ==
    Route::middleware(CheckRole::class . ':pakar')->prefix('pakar')->name('pakar.')->group(function () {

        // -- MANAJEMEN PAKAR LAIN --
        Route::resource('pakar', PakarController::class)->except(['show'])->parameters(['pakar' => 'pakar']);

        // -- MANAJEMEN USER (ORANG TUA) --
        Route::get('user', [PakarController::class, 'user'])->name('user');

        // -- MANAJEMEN GEJALA --
        Route::resource('gejala', GejalaController::class)->parameters(['gejala' => 'gejala']);

        // -- MANAJEMEN KATEGORI KIPI --
        Route::resource('kategori_kipi', KategoriKipiController::class)->parameters(['kategori_kipi' => 'kategoriKipi']);

        // -- MANAJEMEN ATURAN --
        Route::prefix('aturan')->name('aturan.')->group(function () {
            Route::get('/', [AturanController::class, 'index'])->name('index');
            Route::get('/create', [AturanController::class, 'create'])->name('create');
            Route::post('/store', [AturanController::class, 'store'])->name('store');
            Route::get('/edit/{aturan}', [AturanController::class, 'edit'])->name('edit');
            Route::put('/update/{aturan}', [AturanController::class, 'update'])->name('update');
            Route::delete('/destroy/{aturan}', [AturanController::class, 'destroy'])->name('destroy');
        });

        // -- MELIHAT RIWAYAT & LAPORAN --
        Route::get('/riwayat-diagnosa', [PakarController::class, 'riwayatDiagnosa'])->name('riwayat');
        Route::get('/laporan', [PakarController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/cetak', [PakarController::class, 'cetakLaporan'])->name('cetak_laporan');

        // -- MELIHAT DATA DIAGNOSA (KIPI) --
        Route::get('/riwayat/kipi', [HasilDiagnosaController::class, 'kipi'])->name('riwayat.kipi');
        Route::get('/riwayat/kipi/{diagnosa}', [HasilDiagnosaController::class, 'detailKIPI'])->name('riwayat.kipi.detail');

        // -- KIRIM LAPORAN --
        Route::post('/riwayat/kirim', [HasilDiagnosaController::class, 'kirimBulanan'])->name('riwayat.kipi.kirim');
        Route::post('/kipi-berat/{diagnosa}/kirim', [HasilDiagnosaController::class, 'kirimKIPIBerat'])->name('riwayat.berat.kirim');
    }); // End Middleware Pakar

});
