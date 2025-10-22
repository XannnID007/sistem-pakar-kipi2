<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gejala;
use App\Models\KategoriKipi;
use App\Models\Aturan;
use App\Models\Diagnosa;
use App\Models\Laporan;

class PakarController extends Controller
{
    // Menampilkan daftar user (orang tua)
    public function user(Request $request)
    {
        // Kode ini sudah benar, tidak perlu diubah
        $query = User::where('role', 'orang_tua');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        return view('pakar.user', compact('users'));
    }

    // Dashboard
    public function dashboard()
    {
        // ... (semua $jumlah... Anda tetap sama) ...
        $jumlahPakar = User::where('role', 'pakar')->count();
        $jumlahUser = User::where('role', 'orang_tua')->count();
        $jumlahGejala = Gejala::count();
        $jumlahKategori = KategoriKipi::count();
        $jumlahAturan = Aturan::count();
        $jumlahKipi = Diagnosa::whereIn('jenis_kipi', [
            'Ringan (reaksi lokal)',
            'Ringan (reaksi sistemik)',
            'Berat'
        ])->count();
        $jumlahKipiBeratBaru = Diagnosa::where('jenis_kipi', 'Berat')
            ->where('is_read', false)
            ->count();
        $jumlahLaporan = Laporan::count();
        $kasusRinganLokal = Diagnosa::where('jenis_kipi', 'Ringan (reaksi lokal)')->count();
        $kasusRinganSistemik = Diagnosa::where('jenis_kipi', 'Ringan (reaksi sistemik)')->count();
        $kasusBerat = Diagnosa::where('jenis_kipi', 'Berat')->count();

        // --- BARIS YANG DIPERBARUI ---
        $kasusTerbaru = Diagnosa::with('user')     // Tambahkan ini
            ->latest('tanggal') // Tentukan urutan by tanggal
            ->take(5)
            ->get();
        // -----------------------------

        return view('pakar.dashboard', compact(
            'jumlahPakar',
            'jumlahUser',
            'jumlahGejala',
            'jumlahKategori',
            'jumlahLaporan',
            'jumlahKipi',
            'jumlahKipiBeratBaru',
            'jumlahAturan',
            'kasusRinganLokal',
            'kasusRinganSistemik',
            'kasusBerat',
            'kasusTerbaru' // <--- Data ini sudah siap dipakai
        ));
    }

    // Daftar pakar
    public function index(Request $request)
    {
        // DIUBAH: 'bidan_desa' menjadi 'pakar'
        $query = User::where('role', 'pakar');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pakars = $query->get();

        return view('pakar.pakar.index', compact('pakars'));
    }

    public function create()
    {
        // Kode ini sudah benar
        return view('pakar.pakar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Trait HasRandomId akan mengisi 'id_user'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            // DIUBAH: 'bidan_desa' menjadi 'pakar'
            'role' => 'pakar',
            // DIUBAH: Hapus bcrypt(). Model User sudah punya 'casts' 
            //         untuk hashing password otomatis.
            'password' => $request->password,
        ]);

        return redirect()->route('pakar.index')->with('success', 'Pakar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Kode ini sudah benar. FindOrFail akan mencari 'id_user'
        $pakar = User::findOrFail($id);
        return view('pakar.pakar.edit', compact('pakar'));
    }

    public function update(Request $request, $id)
    {
        $pakar = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // DIUBAH: Aturan unique di-update agar merujuk ke 'id_user'
            'email' => 'required|email|unique:users,email,' . $pakar->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);

        $pakar->name = $validated['name'];
        $pakar->email = $validated['email'];

        if (!empty($validated['password'])) {
            // DIUBAH: Hapus bcrypt(). Model akan auto-hash.
            $pakar->password = $validated['password'];
        }

        $pakar->save();

        return redirect()->route('pakar.index')->with('success', 'Data pakar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Kode ini sudah benar
        $pakar = User::findOrFail($id);
        $pakar->delete();

        return redirect()->route('pakar.index')->with('success', 'Data pakar berhasil dihapus.');
    }

    // Riwayat diagnosa pengguna
    public function riwayatDiagnosa()
    {
        // DIUBAH TOTAL: Menggunakan Eloquent, bukan manual JOIN
        // Ini lebih bersih dan otomatis menggunakan relasi 
        // serta 'id_user' dan 'id_diagnosa' yang benar.
        $riwayatDiagnosa = Diagnosa::with('user') // Eager load relasi 'user'
            ->whereHas('user', function ($query) { // Filter berdasarkan relasi 'user'
                $query->where('role', 'orang_tua');
            })
            ->orderBy('tanggal', 'desc') // 'tanggal' ada di tabel diagnosa
            ->get();

        // Di view, Anda bisa panggil: $riwayat->user->name

        return view('pakar.riwayat', compact('riwayatDiagnosa'));
    }

    // Laporan diagnosa
    public function laporan(Request $request)
    {
        // DIUBAH TOTAL: Menggunakan Eloquent
        $query = Diagnosa::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'orang_tua');
            })
            ->orderBy('tanggal', 'desc');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            // Kolom 'tanggal' ada di tabel diagnosa
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $hasilDiagnosa = $query->get();

        // Di view, Anda bisa panggil:
        // $hasil->nama_ibu (dari tabel diagnosa)
        // $hasil->user->name (dari relasi user)

        return view('pakar.laporan', compact('hasilDiagnosa'));
    }

    // Cetak laporan
    public function cetakLaporan()
    {
        // Kode ini sudah benar
        $diagnosa = Diagnosa::where('tanggal', '>=', now()->subMonth())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pakar.laporan_cetak', compact('diagnosa'));
    }
}
