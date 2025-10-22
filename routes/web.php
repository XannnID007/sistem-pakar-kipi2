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
use App\Http\Controllers\UserController; // Ditambahkan untuk route profile
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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
        // DIUBAH: 'bidan_desa' -> 'pakar'
        if ($role === 'pakar') {
            return redirect()->route('pakar.dashboard');
        } elseif ($role === 'orang_tua') {
            return redirect()->route('dashboard.user');
        }
        // DIHAPUS: Role 'kepala_puskesmas'
        abort(403, 'Role tidak dikenali');
    })->name('dashboard');

    // -- DASHBOARD PAKAR --
    // DIUBAH: Middleware role
    Route::get('/dashboard/pakar', [PakarController::class, 'dashboard'])
        ->middleware(CheckRole::class . ':pakar')
        ->name('pakar.dashboard');

    // -- DASHBOARD PENGGUNA (ORANG TUA) --
    Route::get('/dashboard/user', function () {
        return view('user.dashboard');
    })->middleware(CheckRole::class . ':orang_tua')
        ->name('dashboard.user');

    // DIHAPUS: Dashboard Kepala Puskesmas

    // -- PROFIL PENGGUNA (ORANG TUA) --
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/password', [UserController::class, 'changePassword'])->name('profile.password.change');
    Route::put('/profile/password/update', [UserController::class, 'updatePassword'])->name('profile.password.update');


    // -- PROSES DIAGNOSA (ORANG TUA) --
    Route::get('/diagnosa/data', [DiagnosisController::class, 'showDataForm'])->name('diagnosa.data');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.storeData'); // Hanya perlu satu name
    Route::get('/diagnosa/gejala', [DiagnosisController::class, 'showGejalaForm'])->name('diagnosa.gejala');
    Route::post('/diagnosa/proses', [DiagnosisController::class, 'prosesDiagnosa'])->name('diagnosa.proses');
    Route::get('/diagnosa/ulang', [DiagnosisController::class, 'diagnosaUlang'])->name('diagnosa.ulang');

    // -- RIWAYAT DIAGNOSA (ORANG TUA) --
    Route::get('/riwayat-diagnosa', [HasilDiagnosaController::class, 'index'])->name('riwayat.index');
    Route::post('/riwayat-diagnosa/simpan', [HasilDiagnosaController::class, 'simpan'])->name('riwayat.simpan');
    // DIUBAH: Parameter {id} -> {diagnosa} (untuk route model binding)
    Route::get('/riwayat/{diagnosa}', [HasilDiagnosaController::class, 'show'])->name('riwayat.show');
    Route::delete('/riwayat/{diagnosa}', [HasilDiagnosaController::class, 'destroy'])->name('riwayat.destroy');
    Route::get('/riwayat/{diagnosa}/cetak', [HasilDiagnosaController::class, 'cetak'])->name('riwayat.cetak');


    // == AREA KHUSUS PAKAR ==
    Route::middleware(CheckRole::class . ':pakar')->prefix('pakar')->name('pakar.')->group(function () {

        // -- MANAJEMEN PAKAR LAIN (jika perlu) --
        // DIUBAH: Menggunakan parameter {pakar} sesuai primary key 'id_user'
        Route::resource('pakar', PakarController::class)->except(['show'])->parameters(['pakar' => 'pakar']);

        // -- MANAJEMEN USER (ORANG TUA) --
        Route::get('user', [PakarController::class, 'user'])->name('user');
        // DIHAPUS: Route delete user redundan, sudah dicover resource controller 'pakar'

        // -- MANAJEMEN GEJALA --
        // DIUBAH: Parameter {gejala} -> kode_gejala
        Route::resource('gejala', GejalaController::class)->parameters(['gejala' => 'gejala']);
        // DIHAPUS: Route edit gejala redundan

        // -- MANAJEMEN KATEGORI KIPI --
        // DIUBAH: Parameter {kategori_kipi} -> kategoriKipi (sesuai primary key)
        Route::resource('kategori_kipi', KategoriKipiController::class)->parameters(['kategori_kipi' => 'kategoriKipi']);

        // -- MANAJEMEN ATURAN --
        Route::prefix('aturan')->name('aturan.')->group(function () {
            Route::get('/', [AturanController::class, 'index'])->name('index');
            Route::get('/create', [AturanController::class, 'create'])->name('create');
            Route::post('/store', [AturanController::class, 'store'])->name('store');
            // DIUBAH: Parameter {id} -> {aturan}
            Route::get('/edit/{aturan}', [AturanController::class, 'edit'])->name('edit');
            Route::put('/update/{aturan}', [AturanController::class, 'update'])->name('update');
            Route::delete('/destroy/{aturan}', [AturanController::class, 'destroy'])->name('destroy');
        });

        // -- MELIHAT RIWAYAT & LAPORAN --
        Route::get('/riwayat-diagnosa', [PakarController::class, 'riwayatDiagnosa'])->name('riwayat'); // Melihat semua riwayat user
        Route::get('/laporan', [PakarController::class, 'laporan'])->name('laporan'); // Melihat laporan per periode
        Route::get('/laporan/cetak', [PakarController::class, 'cetakLaporan'])->name('cetak_laporan'); // Cetak laporan

        // -- MELIHAT DATA DIAGNOSA (KIPI) --
        Route::get('/riwayat/kipi', [HasilDiagnosaController::class, 'kipi'])->name('riwayat.kipi'); // Filter data KIPI
        // DIUBAH: Parameter {id} -> {diagnosa}
        Route::get('/riwayat/kipi/{diagnosa}', [HasilDiagnosaController::class, 'detailKIPI'])->name('riwayat.kipi.detail'); // Detail KIPI

        // -- KIRIM LAPORAN --
        Route::post('/riwayat/kirim', [HasilDiagnosaController::class, 'kirimBulanan'])->name('riwayat.kipi.kirim'); // Kirim laporan bulanan
        // DIUBAH: Parameter {id} -> {diagnosa}
        Route::post('/kipi-berat/{diagnosa}/kirim', [HasilDiagnosaController::class, 'kirimKIPIBerat'])->name('riwayat.berat.kirim'); // Kirim laporan KIPI Berat

        // -- MANAJEMEN LAPORAN YANG TERSIMPAN --
        Route::get('/laporan-tersimpan', [LaporanController::class, 'index'])->name('laporan.index'); // Melihat daftar laporan PDF
        // DIUBAH: Parameter {id} -> {laporan}
        Route::get('/laporan-tersimpan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show'); // Mungkin link download?
        Route::delete('/laporan-tersimpan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy'); // Hapus file & record laporan

    }); // End Middleware Pakar

    // DIHAPUS: Semua route untuk Kepala Puskesmas
    // DIHAPUS: Route LaporanController yang di luar middleware pakar (redundant)

});
