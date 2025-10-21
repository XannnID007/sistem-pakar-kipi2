<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\KategoriKipi;

class AturanController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $aturanList = Aturan::with('gejala', 'kategoriKipi')
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('gejala', function ($q) use ($keyword) {
                          $q->where('nama_gejala', 'like', "%{$keyword}%")
                            ->orWhere('kode_gejala', 'like', "%{$keyword}%");
                      })
                      ->orWhereHas('kategoriKipi', function ($q) use ($keyword) {
                          $q->where('nama_kategori', 'like', "%{$keyword}%")
                            ->orWhere('kode_kategori_kipi', 'like', "%{$keyword}%");
                      });
            })
            ->orderBy('id')
            ->get();

        return view('pakar.aturan.index', compact('aturanList'));
    }

    public function create()
    {
        $gejalaList      = Gejala::all();
        $kategoriKipiList = KategoriKipi::all();

        return view('pakar.aturan.create', compact('gejalaList', 'kategoriKipiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kategori_kipi' => 'required|exists:kategori_kipi,kode_kategori_kipi',
            'kode_gejala'        => 'required|exists:gejala,kode_gejala',
            'mb'                 => 'required|numeric|min:0|max:1',
            'md'                 => 'required|numeric|min:0|max:1',
        ]);

        Aturan::create($validated);

        return redirect()->route('pakar.aturan.index')
            ->with('success', 'Aturan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $aturan          = Aturan::findOrFail($id);
        $gejalaList      = Gejala::all();
        $kategoriKipiList = KategoriKipi::all();

        return view('pakar.aturan.edit', compact('aturan', 'gejalaList', 'kategoriKipiList'));
    }

    public function update(Request $request, $id)
    {
        $aturan = Aturan::findOrFail($id);

        $validated = $request->validate([
            'kode_kategori_kipi' => 'required|exists:kategori_kipi,kode_kategori_kipi',
            'kode_gejala'        => 'required|exists:gejala,kode_gejala',
            'mb'                 => 'required|numeric|min:0|max:1',
            'md'                 => 'required|numeric|min:0|max:1',
        ]);

        $aturan->update($validated);

        return redirect()->route('pakar.aturan.index')
            ->with('success', 'Aturan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aturan = Aturan::findOrFail($id);
        $aturan->delete();

        return redirect()->route('pakar.aturan.index')
            ->with('success', 'Aturan berhasil dihapus.');
    }
}
