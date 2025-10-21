<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKepala;
use Illuminate\Support\Facades\Storage;

class KepalaController extends Controller
{
    public function index(Request $request)
{
    $query = LaporanKepala::query();

    // Hanya laporan yang mengandung 'Ringan_dan_Sedang' dalam nama file
    $query->where('nama_file', 'like', '%Ringan_dan_Sedang%');

    // Pencarian jika ada input query dari user (opsional)
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('nama_file', 'like', '%' . $request->q . '%')
              ->orWhereDate('created_at', $request->q);
        });
    }

    $laporan = $query->latest()->get();

        return view('kepala.laporan_kipi', compact('laporan'));
    }
    public function show($id)
{
    $laporan = LaporanKepala::findOrFail($id);

    // Redirect ke URL file PDF untuk ditampilkan di tab baru
    return redirect(asset($laporan->file_path));
}
public function destroy($id)
{
    $laporan = LaporanKepala::findOrFail($id);

    // Hapus file dari storage jika ada
    $filePath = public_path($laporan->file_path);
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $laporan->delete();

    return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
}
public function indexBerat(Request $request)
{
    $query = LaporanKepala::query();

    // Filter hanya laporan KIPI Berat berdasarkan nama file
    $query->where('nama_file', 'like', '%KIPI_Berat%');

    // Jika ada input pencarian
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('nama_file', 'like', '%' . $request->q . '%')
              ->orWhereDate('created_at', $request->q);
        });
    }

    $laporan = $query->latest()->get();

    return view('kepala.laporan_kipi_berat', compact('laporan'));
}

public function destroyLaporanBerat($id)
{
    $laporan = \App\Models\LaporanKepala::find($id); // Ganti dengan model yang kamu pakai
    if (!$laporan) {
        return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    }

    // Hapus file dari storage jika ada
    if (Storage::exists('public/laporan/' . $laporan->nama_file)) {
        Storage::delete('public/laporan/' . $laporan->nama_file);
    }

    // Hapus dari database
    $laporan->delete();

    return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
}


}    