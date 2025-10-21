<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use Carbon\Carbon;

class HasilDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $query = Diagnosa::where('user_id', Auth::id())
            ->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('diagnosa')) {
            $query->where('diagnosa', $request->diagnosa);
        }

        $riwayat = $query->orderByDesc('tanggal')->get();

        return view('riwayat.index', compact('riwayat'));
    }

    public function simpan(Request $request)
    {
        $gejalaDipilih = $request->input('gejala_dipilih', []);
    
        if (is_string($gejalaDipilih)) {
            $gejalaDipilih = json_decode($gejalaDipilih, true) ?? [];
        }
    
        // ✅ Cek apakah diagnosa serupa sudah ada
        $existing = Diagnosa::where('user_id', Auth::id())
            ->where('nama_anak', $request->nama_anak)
            ->whereDate('tanggal_imunisasi', $request->tanggal_imunisasi)
            ->first();
    
        if ($existing) {
            return redirect()
                ->route('riwayat.index')
                ->with('info', 'Data diagnosa sudah pernah disimpan sebelumnya.');
        }
    
        // Jika belum ada, baru buat data baru
        $diagnosa = Diagnosa::create([
            'user_id'           => Auth::id(),
            'nama_ibu'          => $request->nama_ibu,
            'nama_anak'         => $request->nama_anak,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'usia_anak'         => $request->usia_anak,
            'alamat'            => $request->alamat,
            'jenis_vaksin'      => $request->jenis_vaksin,
            'tempat_imunisasi'  => $request->tempat_imunisasi,
            'tanggal_imunisasi' => $request->tanggal_imunisasi,
            'tanggal'           => now(),
            'jenis_kipi'        => $request->jenis_kipi,
            'nilai_cf'          => floatval($request->nilai_cf),
            'saran'             => $request->saran,
        ]);
    
        foreach ($gejalaDipilih as $g) {
            $diagnosa->gejalaDipilih()->create([
                'kode_gejala' => $g['kode'] ?? null,
                'nama_gejala' => $g['nama'] ?? ($g['nama_gejala'] ?? '-'),
                'cf_user'     => $g['cf_user'] ?? 0,
            ]);
        }
    
        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Diagnosa berhasil disimpan ke riwayat.');
    }
    
    

    public function show($id)
    {
        $riwayat = Diagnosa::with('gejalaDipilih')->findOrFail($id);
    
        // ✅ Tandai sudah dibaca jika KIPI Berat dan belum dibaca
        if ($riwayat->jenis_kipi === 'Berat' && !$riwayat->is_read) {
            $riwayat->is_read = true;
            $riwayat->save();
        }
    
        $hasilTerbaik = [
            'jenis_kipi' => $riwayat->jenis_kipi,
            'nilai_cf'   => $riwayat->nilai_cf,
            'saran'      => $riwayat->saran,
        ];
    
        return view('riwayat.show', [
            'riwayat'        => $riwayat,
            'gejalaDipilih'  => $riwayat->gejalaDipilih,
            'hasilTerbaik'   => $hasilTerbaik,
        ]);
    }
    
    public function destroy($id)
    {
        Diagnosa::findOrFail($id)->delete();
        return redirect()->route('riwayat.index')->with('success', 'Riwayat diagnosa berhasil dihapus.');
    }

    public function cetak($id)
    {
        $riwayat = Diagnosa::with('gejalaDipilih')->findOrFail($id);

        $hasilTerbaik = [
            'jenis_kipi' => $riwayat->jenis_kipi,
            'cf'         => $riwayat->nilai_cf,
            'saran'      => $riwayat->saran,
        ];

        return view('riwayat.cetak', [
            'riwayat'       => $riwayat,
            'gejalaDipilih' => $riwayat->gejalaDipilih,
            'hasilTerbaik'  => $hasilTerbaik,
        ]);
    }

    public function kipiBerat()
    {
        Diagnosa::where('jenis_kipi', 'Berat')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $riwayats = Diagnosa::with('gejalaDipilih')
            ->where('jenis_kipi', 'Berat')
            ->latest()
            ->get();

        return view('riwayat.kipi_berat', compact('riwayats'));
    }

    public function kipi(Request $request)
    {
        $query = Diagnosa::with('gejalaDipilih');

        if ($request->filled('kategori')) {
            $query->where('jenis_kipi', $request->kategori);
        } else {
            $query->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $riwayat = $query->latest()->get();

        return view('riwayat.kipi', compact('riwayat'));
    }

    public function detailKIPI($id)
{
    $diagnosa = Diagnosa::with(['gejalaDipilih.gejala'])->findOrFail($id);

    // 🔔 Cek apakah KIPI berat dan belum dibaca
    if ($diagnosa->jenis_kipi === 'Berat' && !$diagnosa->is_read) {
        $diagnosa->is_read = true;
        $diagnosa->save();
    }

    return view('riwayat.detail_kipi', [
        'riwayat' => $diagnosa,
        'gejala' => $diagnosa->gejalaDipilih,
    ]);
}


        // Halaman preview laporan bulanan
        public function laporanBulanan(Request $request)
        {
            $riwayat = Diagnosa::with('gejalaDipilih')
                ->when($request->filled('kategori'), fn($q) => $q->where('jenis_kipi', $request->kategori))
                ->when(!$request->filled('kategori'), fn($q) => $q->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']))
                ->when($request->filled('bulan'), fn($q) => $q->whereMonth('tanggal', $request->bulan))
                ->when($request->filled('tahun'), fn($q) => $q->whereYear('tanggal', $request->tahun))
                ->latest()
                ->get();
    
            return view('riwayat.laporan_bulanan', compact('riwayat', 'request'));
        }
    
        // Kirim laporan bulanan (semua kategori)
        public function kirimBulanan(Request $request)
        {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
    
            $riwayat = Diagnosa::with('gejalaDipilih')
                ->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat'])
                ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
                ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
                ->get();
    
            $namaBulan = $bulan ? Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM') : 'Semua';
            $periode = $bulan && $tahun
                ? "{$namaBulan}_{$tahun}"
                : ($tahun ? "Tahun_{$tahun}" : 'Semua_Periode');
    
            $namaFile = "Laporan_KIPI_Bulanan_{$periode}_" . now()->format('Ymd_His') . ".pdf";
            $filePath = 'storage/laporan/' . $namaFile;
    
            $pdf = Pdf::loadView('riwayat.laporan_pdf', [
                'riwayat'  => $riwayat,
                'kategori' => 'Semua',
                'request'  => $request,
            ])->setPaper('A4', 'landscape');
    
            $pdf->save(public_path($filePath));
    
            Laporan::create([
                'id_diagnosa'   => null,
                'jenis_laporan' => 'KIPI Bulanan',
                'tanggal_laporan' => now()->toDateString(),
                'file_path'     => $filePath,
                'nama_file'     => $namaFile,
            ]);
    
            return redirect()->back()->with('success', 'Laporan Bulanan berhasil disimpan.');
        }
    
        // Kirim laporan KIPI berat dari detail diagnosa
        public function kirimKIPIBerat($id)
        {
            $riwayat = Diagnosa::with('gejalaDipilih')->findOrFail($id);
    
            if (strtolower($riwayat->jenis_kipi) !== 'berat') {
                return redirect()->back()->with('error', 'Hanya data dengan kategori KIPI Berat yang dapat dikirim.');
            }
    
            $namaFile = 'Laporan_KIPI_Berat_' . now()->format('Ymd_His') . '.pdf';
            $filePath = 'storage/laporan/' . $namaFile;
    
            $pdf = Pdf::loadView('riwayat.laporan_kipi_berat_pdf', [
                'riwayat' => $riwayat,
                'gejala'  => $riwayat->gejalaDipilih,
            ])->setPaper('A4', 'portrait');
    
            $pdf->save(public_path($filePath));
    
            Laporan::create([
                'id_diagnosa'   => $riwayat->id,
                'jenis_laporan' => 'KIPI Berat',
                'tanggal_laporan' => now()->toDateString(),
                'file_path'     => $filePath,
                'nama_file'     => $namaFile,
            ]);
    
            return redirect()->route('pakar.riwayat.kipi')->with('success', 'Laporan KIPI Berat berhasil disimpan.');
        }
    }
    