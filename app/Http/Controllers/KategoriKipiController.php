<?php

namespace App\Http\Controllers;

use App\Models\KategoriKipi;
use Illuminate\Http\Request;

class KategoriKipiController extends Controller
{
    public function index()
    {
        $kategori = KategoriKipi::all();
        return view('kategori_kipi.index', compact('kategori'));
    }

    public function create()
    {
        $last = KategoriKipi::orderBy('kode_kategori_kipi', 'desc')->first();
        
        if ($last) {
            $lastNumber = intval(substr($last->kode_kategori_kipi, 1));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $kodeBaru = 'K' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('kategori_kipi.create', compact('kodeBaru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori_kipi' => 'required|unique:kategori_kipis,kode_kategori_kipi',
            'jenis_kipi' => 'required|string',
            'saran' => 'required|string',
        ]);

        KategoriKipi::create([
            'kode_kategori_kipi' => $request->kode_kategori_kipi,
            'jenis_kipi' => $request->jenis_kipi,
            'saran' => $request->saran,
        ]);

        return redirect()->route('pakar.kategori_kipi.index')->with('success', 'Kategori KIPI berhasil ditambah');
    }

    public function edit(KategoriKipi $kategoriKipi)
    {
        return view('kategori_kipi.edit', compact('kategoriKipi'));
    }
    

    public function update(Request $request, $kode_kategori_kipi)
    {
        $kategoriKipi = KategoriKipi::findOrFail($kode_kategori_kipi);

        $request->validate([
            'kode_kategori_kipi' => 'required|unique:kategori_kipis,kode_kategori_kipi,' . $kategoriKipi->kode_kategori_kipi . ',kode_kategori_kipi',
            'jenis_kipi' => 'required|string',
            'saran' => 'required|string',
        ]);

        $kategoriKipi->update($request->only('kode_kategori_kipi', 'jenis_kipi', 'saran'));

        return redirect()->route('pakar.kategori_kipi.index')->with('success', 'Kategori KIPI berhasil diubah');
    }

    public function destroy($kode_kategori_kipi)
    {
        $kategoriKipi = KategoriKipi::findOrFail($kode_kategori_kipi);
        $kategoriKipi->delete();

        return redirect()->route('pakar.kategori_kipi.index')->with('success', 'Kategori KIPI berhasil dihapus');
    }
}
