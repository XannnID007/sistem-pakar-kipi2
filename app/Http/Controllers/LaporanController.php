<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class LaporanController extends Controller
{
    public function index()
    {
        // Ambil semua laporan milik bidan yang sedang login
        $laporan = Laporan::orderBy('created_at', 'desc')->get();


        return view('laporan.index', compact('laporan'));
    }
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.detail', compact('laporan'));
    }

    // Hapus laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hapus file fisik jika ada
        if ($laporan->file_path && file_exists(public_path($laporan->file_path))) {
            unlink(public_path($laporan->file_path));
        }

        // Hapus record database
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
    public function laporanBerat(Request $request)
{
    $query = Laporan::where('jenis_laporan', 'like', '%Berat%');


    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function($q2) use ($q) {
            $q2->where('nama_file', 'like', "%{$q}%")
               ->orWhereDate('created_at', 'like', "%{$q}%");
        });
    }

    $laporan = $query->orderBy('created_at', 'desc')->get();
    return view('kepala.laporan_kipi_berat', compact('laporan'));
}

public function destroyLaporanBerat($id_laporan)
{
    $laporan = Laporan::findOrFail($id_laporan);
    $filePath = storage_path('app/public/laporan/' . $laporan->nama_file);
    if (file_exists($filePath)) {
        unlink($filePath); // hapus file fisik
    }
    $laporan->delete(); // hapus data di DB
    return redirect()->route('kepala.kipi.berat')->with('success', 'Laporan berhasil dihapus.');
}
public function laporanBulanan(Request $request)
{
    // Ambil semua laporan dengan jenis 'KIPI Bulanan'
    $query = Laporan::where('jenis_laporan', 'like', '%Bulanan%');

    // Filter pencarian jika ada
    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function($q2) use ($q) {
            $q2->where('nama_file', 'like', "%{$q}%")
               ->orWhereDate('created_at', 'like', "%{$q}%");
        });
    }

    $laporan = $query->orderBy('created_at', 'desc')->get();

    return view('kepala.laporan_kipi_bulanan', compact('laporan'));
}

public function destroyLaporanBulanan($id_laporan)
{
    $laporan = Laporan::findOrFail($id_laporan);
    $filePath = storage_path('app/public/laporan/' . $laporan->nama_file);
    if (file_exists($filePath)) {
        unlink($filePath); // hapus file fisik
    }
    $laporan->delete(); // hapus data di DB
    return redirect()->route('kepala.kipi.bulanan')->with('success', 'Laporan berhasil dihapus.');
}



}