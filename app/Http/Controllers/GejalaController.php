<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $query = Gejala::query();
    
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_gejala', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_gejala', 'like', '%' . $request->search . '%');
        }
    
        $gejalas = $query->orderBy('kode_gejala')->get();
    
        return view('pakar.gejala.index', compact('gejalas'));
    }
    
    public function create()
    {
        // Ambil data terakhir
        $last = Gejala::orderBy('kode_gejala', 'desc')->first();

        // Hitung nomor berikutnya
        $nextNumber = $last ? intval(substr($last->kode_gejala, 1)) + 1 : 1;

        // Buat kode 
        $kodeBaru = 'G' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('pakar.gejala.create', compact('kodeBaru'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'kode_gejala' => 'required|unique:gejalas,kode_gejala',
            'nama_gejala' => 'required|string|max:100|unique:gejalas,nama_gejala',
        ], [
            'kode_gejala.unique' => 'Kode gejala sudah digunakan.',
            'nama_gejala.unique' => 'Nama gejala sudah ada.',
        ]);

        // Simpan ke database
        Gejala::create([
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
        ]);

        return redirect()->route('pakar.gejala.index')->with('success', 'Data gejala berhasil ditambah');
    }

    public function edit($kode_gejala)
{
    $gejala = Gejala::where('kode_gejala', $kode_gejala)->firstOrFail();
    return view('pakar.gejala.edit', compact('gejala'));
}

public function update(Request $request, $kode_gejala)
{
    // Cari dulu model berdasarkan kode_gejala
    $gejala = Gejala::where('kode_gejala', $kode_gejala)->firstOrFail();

    // Validasi dengan pengecualian kode_gejala dan nama_gejala milik sendiri
    $request->validate([
        'kode_gejala' => 'required|unique:gejalas,kode_gejala,' . $gejala->kode_gejala . ',kode_gejala',
        'nama_gejala' => 'required|string|max:255|unique:gejalas,nama_gejala,' . $gejala->kode_gejala . ',kode_gejala',
    ]);

    // Update data
    $gejala->update([
        'kode_gejala' => $request->kode_gejala,
        'nama_gejala' => $request->nama_gejala,
    ]);

    return redirect()->route('pakar.gejala.index')->with('success', 'Data gejala berhasil diubah');
}

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return redirect()->route('pakar.gejala.index')->with('success', 'Data gejala berhasil dihapus');
    }
}
