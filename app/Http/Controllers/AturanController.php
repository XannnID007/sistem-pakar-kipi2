<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aturan;
use App\Models\Gejala; // Sesuai model yang Anda berikan
use App\Models\KategoriKipi; // Sesuai model yang Anda berikan

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
                        // DIUBAH: kolom 'nama_kategori' menjadi 'jenis_kipi'
                        $q->where('jenis_kipi', 'like', "%{$keyword}%")
                            ->orWhere('kode_kategori_kipi', 'like', "%{$keyword}%");
                    });
            })
            // DIUBAH: 'id' menjadi 'id_aturan'
            ->orderBy('id_aturan')
            ->get();

        return view('pakar.aturan.index', compact('aturanList'));
    }

    public function create()
    {
        // Logika ini sudah benar dan tidak perlu diubah
        $gejalaList       = Gejala::all();
        $kategoriKipiList = KategoriKipi::all();

        return view('pakar.aturan.create', compact('gejalaList', 'kategoriKipiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // DIUBAH: Nama tabel 'kategori_kipi' menjadi 'kategori_kipis'
            'kode_kategori_kipi' => 'required|exists:kategori_kipis,kode_kategori_kipi',
            // DIUBAH: Nama tabel 'gejala' menjadi 'gejalas'
            'kode_gejala'        => 'required|exists:gejalas,kode_gejala',
            'mb'                 => 'required|numeric|min:0|max:1',
            'md'                 => 'required|numeric|min:0|max:1',
        ]);

        // Logika ini sudah benar.
        // Trait HasRandomId akan otomatis mengisi 'id_aturan'.
        Aturan::create($validated);

        return redirect()->route('pakar.aturan.index')
            ->with('success', 'Aturan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Logika ini sudah benar.
        // FindOrFail akan mencari berdasarkan $primaryKey ('id_aturan')
        $aturan           = Aturan::findOrFail($id);
        $gejalaList       = Gejala::all();
        $kategoriKipiList = KategoriKipi::all();

        return view('pakar.aturan.edit', compact('aturan', 'gejalaList', 'kategoriKipiList'));
    }

    public function update(Request $request, $id)
    {
        // Logika ini sudah benar
        $aturan = Aturan::findOrFail($id);

        $validated = $request->validate([
            // DIUBAH: Nama tabel 'kategori_kipi' menjadi 'kategori_kipis'
            'kode_kategori_kipi' => 'required|exists:kategori_kipis,kode_kategori_kipi',
            // DIUBAH: Nama tabel 'gejala' menjadi 'gejalas'
            'kode_gejala'        => 'required|exists:gejalas,kode_gejala',
            'mb'                 => 'required|numeric|min:0|max:1',
            'md'                 => 'required|numeric|min:0|max:1',
        ]);

        // Logika ini sudah benar
        $aturan->update($validated);

        return redirect()->route('pakar.aturan.index')
            ->with('success', 'Aturan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Logika ini sudah benar
        $aturan = Aturan::findOrFail($id);
        $aturan->delete();

        return redirect()->route('pakar.aturan.index')
            ->with('success', 'Aturan berhasil dihapus.');
    }
}
