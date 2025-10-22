<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // Meskipun tidak terpakai, kita biarkan


class LaporanController extends Controller
{
    public function index()
    {
        // Ambil semua laporan
        // Catatan: Komentar Anda "milik bidan yang sedang login"
        // tidak sesuai dengan kodenya. Kode ini mengambil SEMUA laporan.
        $laporan = Laporan::orderBy('created_at', 'desc')->get();

        return view('laporan.index', compact('laporan'));
    }

    public function show($id)
    {
        // Kode ini sudah benar. FindOrFail akan mencari 'id_laporan' (string)
        $laporan = Laporan::findOrFail($id);
        return view('laporan.detail', compact('laporan'));
    }

    // Hapus laporan
    public function destroy($id)
    {
        // Kode ini sudah benar.
        $laporan = Laporan::findOrFail($id);

        // Hapus file fisik jika ada (Logika ini sudah benar)
        if ($laporan->file_path && file_exists(public_path($laporan->file_path))) {
            unlink(public_path($laporan->file_path));
        }

        // Hapus record database
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function laporanBerat(Request $request)
    {
        // Logika ini tidak berubah, tidak ada hubungannya dengan ID
        $query = Laporan::where('jenis_laporan', 'like', '%Berat%');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama_file', 'like', "%{$q}%")
                    ->orWhereDate('created_at', 'like', "%{$q}%");
            });
        }

        $laporan = $query->orderBy('created_at', 'desc')->get();
        return view('kepala.laporan_kipi_berat', compact('laporan'));
    }

    public function destroyLaporanBerat($id_laporan)
    {
        // Kode ini sudah benar (mencari by id_laporan)
        $laporan = Laporan::findOrFail($id_laporan);

        // DIUBAH: Menyamakan logika hapus file dengan fungsi destroy()
        // Menggunakan file_path, bukan nama_file
        if ($laporan->file_path && file_exists(public_path($laporan->file_path))) {
            unlink(public_path($laporan->file_path)); // hapus file fisik
        }

        $laporan->delete(); // hapus data di DB
        return redirect()->route('kepala.kipi.berat')->with('success', 'Laporan berhasil dihapus.');
    }

    public function laporanBulanan(Request $request)
    {
        // Logika ini tidak berubah, tidak ada hubungannya dengan ID
        $query = Laporan::where('jenis_laporan', 'like', '%Bulanan%');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama_file', 'like', "%{$q}%")
                    ->orWhereDate('created_at', 'like', "%{$q}%");
            });
        }

        $laporan = $query->orderBy('created_at', 'desc')->get();

        return view('kepala.laporan_kipi_bulanan', compact('laporan'));
    }

    public function destroyLaporanBulanan($id_laporan)
    {
        // Kode ini sudah benar (mencari by id_laporan)
        $laporan = Laporan::findOrFail($id_laporan);

        // DIUBAH: Menyamakan logika hapus file dengan fungsi destroy()
        // Menggunakan file_path, bukan nama_file
        if ($laporan->file_path && file_exists(public_path($laporan->file_path))) {
            unlink(public_path($laporan->file_path)); // hapus file fisik
        }

        $laporan->delete(); // hapus data di DB
        return redirect()->route('kepala.kipi.bulanan')->with('success', 'Laporan berhasil dihapus.');
    }
}
