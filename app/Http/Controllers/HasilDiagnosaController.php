<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use App\Models\GejalaDipilih; // Ditambahkan untuk relasi
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use Carbon\Carbon;

class HasilDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        // DIUBAH: 'user_id' menjadi 'id_user'
        $query = Diagnosa::where('id_user', Auth::id())
            ->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Kueri 'diagnosa' tidak ada di tabel diagnosa, mungkin maksudnya 'jenis_kipi'?
        // Saya asumsikan maksudnya 'jenis_kipi'
        if ($request->filled('diagnosa')) {
            $query->where('jenis_kipi', $request->diagnosa);
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
        // DIUBAH: 'user_id' menjadi 'id_user'
        $existing = Diagnosa::where('id_user', Auth::id())
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
            // DIUBAH: 'user_id' menjadi 'id_user'
            'id_user'           => Auth::id(),
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
        // Trait HasRandomId akan otomatis mengisi 'id_diagnosa'

        foreach ($gejalaDipilih as $g) {
            // DIUBAH: Kita tidak bisa lagi menggunakan relasi 'gejalaDipilih()'
            // karena model GejalaDipilih membutuhkan 'id_diagnosa'
            // Kita buat manual saja agar lebih eksplisit
            GejalaDipilih::create([
                // DIUBAH: 'diagnosa_id' -> 'id_diagnosa'
                //         '$diagnosa->id' -> '$diagnosa->id_diagnosa'
                'id_diagnosa' => $diagnosa->id_diagnosa,
                'kode_gejala' => $g['kode'] ?? null,
                // 'nama_gejala' tidak ada di tabel gejala_dipilih, kita hapus
                'cf_user'     => $g['cf_user'] ?? 0,
            ]);
        }

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Diagnosa berhasil disimpan ke riwayat.');
    }

    public function show($id)
    {
        // Logika ini sudah benar, FindOrFail akan mencari 
        // berdasarkan $primaryKey ('id_diagnosa')
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
            'riwayat'       => $riwayat,
            'gejalaDipilih' => $riwayat->gejalaDipilih,
            'hasilTerbaik'  => $hasilTerbaik,
        ]);
    }

    public function destroy($id)
    {
        // Logika ini sudah benar
        Diagnosa::findOrFail($id)->delete();
        return redirect()->route('riwayat.index')->with('success', 'Riwayat diagnosa berhasil dihapus.');
    }

    public function cetak($id)
    {
        // Logika ini sudah benar
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
        // Logika ini tidak perlu diubah
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
        // Logika ini tidak perlu diubah
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
        // DIPERBAIKI: Menggunakan parameter $id yang konsisten dengan route
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
        // Logika ini tidak perlu diubah
        $query = Diagnosa::with('gejalaDipilih.gejala');

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('jenis_kipi', $request->kategori);
        } else {
            $query->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);
        }

        // Filter berdasarkan bulan dan tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $riwayat = $query->orderBy('tanggal', 'desc')->get();

        return view('riwayat.laporan_bulanan', compact('riwayat', 'request'));
    }

    // Kirim laporan bulanan (semua kategori)
    public function kirimBulanan(Request $request)
    {
        // Logika ini tidak perlu diubah
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kategori = $request->kategori;

        $query = Diagnosa::with('gejalaDipilih.gejala');

        // Filter berdasarkan kategori jika ada
        if ($kategori) {
            $query->where('jenis_kipi', $kategori);
        } else {
            $query->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);
        }

        // Filter berdasarkan bulan dan tahun
        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }
        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        $riwayat = $query->orderBy('tanggal', 'desc')->get();

        // Buat nama file yang lebih deskriptif
        $namaBulan = $bulan ? Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM') : 'Semua';
        $namaKategori = $kategori ? str_replace(' ', '_', $kategori) : 'Semua_KIPI';
        $periode = $bulan && $tahun
            ? "{$namaBulan}_{$tahun}"
            : ($tahun ? "Tahun_{$tahun}" : 'Semua_Periode');

        $namaFile = "Laporan_{$namaKategori}_{$periode}_" . now()->format('Ymd_His') . ".pdf";
        $filePath = 'storage/laporan/' . $namaFile;

        // Pastikan folder ada
        if (!file_exists(public_path('storage/laporan'))) {
            mkdir(public_path('storage/laporan'), 0755, true);
        }

        $pdf = Pdf::loadView('riwayat.laporan_pdf', [
            'riwayat'  => $riwayat,
            'kategori' => $kategori ?: 'Semua',
            'request'  => $request,
        ])->setPaper('A4', 'landscape');

        $pdf->save(public_path($filePath));

        // Trait HasRandomId akan otomatis mengisi 'id_laporan'
        Laporan::create([
            'id_diagnosa'   => null,
            'jenis_laporan' => 'KIPI Bulanan - ' . ($kategori ?: 'Semua Kategori'),
            'tanggal_laporan' => now()->toDateString(),
            'file_path'     => $filePath,
            'nama_file'     => $namaFile,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disimpan dan dapat diunduh di menu Laporan.');
    }

    // Kirim laporan KIPI berat dari detail diagnosa
    public function kirimKIPIBerat($id)
    {
        // Logika ini sudah benar
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

        // Trait HasRandomId akan otomatis mengisi 'id_laporan'
        Laporan::create([
            // DIUBAH: '$riwayat->id' menjadi '$riwayat->id_diagnosa'
            'id_diagnosa'   => $riwayat->id_diagnosa,
            'jenis_laporan' => 'KIPI Berat',
            'tanggal_laporan' => now()->toDateString(),
            'file_path'     => $filePath,
            'nama_file'     => $namaFile,
        ]);

        return redirect()->route('pakar.riwayat.kipi')->with('success', 'Laporan KIPI Berat berhasil disimpan.');
    }
}
