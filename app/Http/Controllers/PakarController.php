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
        $jumlahPakar = User::where('role', 'bidan_desa')->count();
        $jumlahUser = User::where('role', 'orang_tua')->count();
        $jumlahGejala = Gejala::count();
        $jumlahKategori = KategoriKipi::count();
        $jumlahAturan = Aturan::count();
        $jumlahKipi = Diagnosa::whereIn('jenis_kipi', ['Ringan (reaksi lokal)','Ringan (reaksi Sistemik)', 'Berat'])->count();
        $jumlahKipiBeratBaru = Diagnosa::where('jenis_kipi', 'Berat')
        ->where('is_read', false)
        ->count();
        $jumlahLaporan = Laporan::count();
        $kasusRinganLokal = Diagnosa::where('jenis_kipi', 'Ringan (reaksi lokal)')->count();
        $kasusRinganSistemik = Diagnosa::where('jenis_kipi', 'Ringan (reaksi sistemik)')->count();
        $kasusBerat = Diagnosa::where('jenis_kipi', 'Berat')->count();

        $kasusTerbaru = Diagnosa::latest()->take(5)->get();


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
            'kasusTerbaru' 
        ));
    }

    // Daftar pakar (bidan desa)
    public function index(Request $request)
    {
        $query = User::where('role', 'bidan_desa');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pakars = $query->get();

        return view('pakar.pakar.index', compact('pakars'));
    }

    public function create()
    {
        return view('pakar.pakar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'bidan_desa',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('pakar.index')->with('success', 'Pakar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pakar = User::findOrFail($id);
        return view('pakar.pakar.edit', compact('pakar'));
    }

    public function update(Request $request, $id)
    {
        $pakar = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pakar->id,
            'password' => 'nullable|string|min:6',
        ]);

        $pakar->name = $validated['name'];
        $pakar->email = $validated['email'];

        if (!empty($validated['password'])) {
            $pakar->password = bcrypt($validated['password']);
        }

        $pakar->save();

        return redirect()->route('pakar.index')->with('success', 'Data pakar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pakar = User::findOrFail($id);
        $pakar->delete();

        return redirect()->route('pakar.index')->with('success', 'Data pakar berhasil dihapus.');
    }

    // Riwayat diagnosa pengguna
    public function riwayatDiagnosa()
    {
        $riwayatDiagnosa = Diagnosa::join('users', 'riwayat_diagnosa.user_id', '=', 'users.id')
            ->where('users.role', 'orang_tua')
            ->select('riwayat_diagnosa.*', 'users.name as nama_pengguna')
            ->orderBy('riwayat_diagnosa.tanggal', 'desc')
            ->get();

        return view('pakar.riwayat', compact('riwayatDiagnosa'));
    }

    // Laporan diagnosa
    public function laporan(Request $request)
    {
        $query = Diagnosa::join('users', 'riwayat_diagnosa.user_id', '=', 'users.id')
            ->where('users.role', 'orang_tua')
            ->select('riwayat_diagnosa.*', 'users.name as nama_ibu')
            ->orderBy('riwayat_diagnosa.tanggal', 'desc');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('riwayat_diagnosa.tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $hasilDiagnosa = $query->get();

        return view('pakar.laporan', compact('hasilDiagnosa'));
    }

    // Cetak laporan
    public function cetakLaporan()
    {
        $diagnosa = Diagnosa::where('tanggal', '>=', now()->subMonth())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pakar.laporan_cetak', compact('diagnosa'));
    }
}
