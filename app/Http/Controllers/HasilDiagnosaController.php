<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use App\Models\GejalaDipilih;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HasilDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $query = Diagnosa::where('id_user', Auth::id())
            ->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('diagnosa')) {
            $query->where('jenis_kipi', $request->diagnosa);
        }

        $riwayat = $query->orderByDesc('tanggal')->get();

        return view('riwayat.index', compact('riwayat'));
    }

    public function simpan(Request $request)
    {
        try {
            $gejalaDipilih = $request->input('gejala_dipilih', []);

            if (is_string($gejalaDipilih)) {
                $gejalaDipilih = json_decode($gejalaDipilih, true) ?? [];
            }

            // Cek apakah diagnosa serupa sudah ada
            $existing = Diagnosa::where('id_user', Auth::id())
                ->where('nama_anak', $request->nama_anak)
                ->whereDate('tanggal_imunisasi', $request->tanggal_imunisasi)
                ->first();

            if ($existing) {
                return redirect()
                    ->route('riwayat.index')
                    ->with('info', 'Data diagnosa sudah pernah disimpan sebelumnya.');
            }

            // Buat data diagnosa baru
            $diagnosa = Diagnosa::create([
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

            // Simpan gejala yang dipilih
            foreach ($gejalaDipilih as $g) {
                GejalaDipilih::create([
                    'id_diagnosa' => $diagnosa->id_diagnosa,
                    'kode_gejala' => $g['kode'] ?? null,
                    'cf_user'     => $g['cf_user'] ?? 0,
                ]);
            }

            return redirect()
                ->route('riwayat.index')
                ->with('success', 'Diagnosa berhasil disimpan ke riwayat.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan diagnosa: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan diagnosa: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $riwayat = Diagnosa::with('gejalaDipilih')->findOrFail($id);

            // Tandai sudah dibaca jika KIPI Berat dan belum dibaca
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
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan detail riwayat: ' . $e->getMessage());
            return redirect()
                ->route('riwayat.index')
                ->with('error', 'Data tidak ditemukan.');
        }
    }

    public function destroy($id)
    {
        try {
            $diagnosa = Diagnosa::findOrFail($id);

            // Hapus gejala terkait terlebih dahulu
            $diagnosa->gejalaDipilih()->delete();

            // Hapus diagnosa
            $diagnosa->delete();

            return redirect()
                ->route('riwayat.index')
                ->with('success', 'Riwayat diagnosa berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus riwayat: ' . $e->getMessage());
            return redirect()
                ->route('riwayat.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function cetak($id)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error saat mencetak riwayat: ' . $e->getMessage());
            return redirect()
                ->route('riwayat.index')
                ->with('error', 'Terjadi kesalahan saat mencetak data.');
        }
    }

    public function kipiBerat()
    {
        try {
            // Tandai semua KIPI berat sebagai sudah dibaca
            Diagnosa::where('jenis_kipi', 'Berat')
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $riwayats = Diagnosa::with('gejalaDipilih')
                ->where('jenis_kipi', 'Berat')
                ->latest()
                ->get();

            return view('riwayat.kipi_berat', compact('riwayats'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan KIPI berat: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memuat data KIPI berat.');
        }
    }

    public function kipi(Request $request)
    {
        try {
            $query = Diagnosa::with('gejalaDipilih');

            // Filter berdasarkan kategori
            if ($request->filled('kategori')) {
                $query->where('jenis_kipi', $request->kategori);
            } else {
                $query->whereIn('jenis_kipi', ['Ringan (reaksi lokal)', 'Ringan (reaksi sistemik)', 'Berat']);
            }

            // Filter berdasarkan bulan
            if ($request->filled('bulan')) {
                $query->whereMonth('tanggal', $request->bulan);
            }

            // Filter berdasarkan tahun
            if ($request->filled('tahun')) {
                $query->whereYear('tanggal', $request->tahun);
            }

            // Filter pencarian
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_anak', 'like', "%{$search}%")
                        ->orWhere('nama_ibu', 'like', "%{$search}%")
                        ->orWhere('jenis_vaksin', 'like', "%{$search}%")
                        ->orWhere('tempat_imunisasi', 'like', "%{$search}%");
                });
            }

            $riwayat = $query->latest()->get();

            return view('riwayat.kipi', compact('riwayat'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan data KIPI: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memuat data KIPI.');
        }
    }

    public function detailKIPI($id)
    {
        try {
            $diagnosa = Diagnosa::with(['gejalaDipilih.gejala'])->findOrFail($id);

            // Cek apakah KIPI berat dan belum dibaca
            if ($diagnosa->jenis_kipi === 'Berat' && !$diagnosa->is_read) {
                $diagnosa->is_read = true;
                $diagnosa->save();
            }

            return view('riwayat.detail_kipi', [
                'riwayat' => $diagnosa,
                'gejala' => $diagnosa->gejalaDipilih,
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan detail KIPI: ' . $e->getMessage());
            return redirect()
                ->route('pakar.riwayat.kipi')
                ->with('error', 'Data tidak ditemukan.');
        }
    }

    // Halaman preview laporan bulanan
    public function laporanBulanan(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error saat preview laporan bulanan: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memuat preview laporan.');
        }
    }

    // Kirim laporan bulanan (semua kategori)
    public function kirimBulanan(Request $request)
    {
        try {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $kategori = $request->kategori;

            // Validasi tahun
            if (!$tahun) {
                return redirect()->back()->with('error', 'Tahun harus dipilih untuk membuat laporan.');
            }

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

            // Cek apakah ada data
            if ($riwayat->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data untuk periode yang dipilih.');
            }

            // Buat nama file yang lebih deskriptif
            $namaBulan = $bulan ? Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM') : 'Semua';
            $namaKategori = $kategori ? str_replace([' ', '(', ')'], ['_', '', ''], $kategori) : 'Semua_KIPI';
            $periode = $bulan && $tahun
                ? "{$namaBulan}_{$tahun}"
                : ($tahun ? "Tahun_{$tahun}" : 'Semua_Periode');

            $namaFile = "Laporan_{$namaKategori}_{$periode}_" . now()->format('Ymd_His') . ".pdf";
            $filePath = 'storage/laporan/' . $namaFile;

            // Pastikan folder ada
            $directory = public_path('storage/laporan');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Generate PDF
            $pdf = Pdf::loadView('riwayat.laporan_pdf', [
                'riwayat'  => $riwayat,
                'kategori' => $kategori ?: 'Semua',
                'bulan'    => $bulan,
                'tahun'    => $tahun,
                'namaBulan' => $namaBulan,
                'request'  => $request,
            ])->setPaper('A4', 'landscape');

            $pdf->save(public_path($filePath));

            // Simpan ke database laporan
            Laporan::create([
                'id_diagnosa'     => null,
                'jenis_laporan'   => 'KIPI Bulanan', // UBAH BARIS INI
                'tanggal_laporan' => now()->toDateString(),
                'file_path'       => $filePath,
                'nama_file'       => $namaFile,
            ]);

            // Redirect ke menu laporan dengan pesan sukses
            return redirect()->route('pakar.laporan.index')->with(
                'success',
                'Laporan berhasil dibuat dengan ' . $riwayat->count() . ' data. ' .
                    'File: ' . $namaFile . ' telah tersimpan dan dapat diunduh.'
            );
        } catch (\Exception $e) {
            Log::error('Error saat membuat laporan bulanan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    // Kirim laporan KIPI berat dari detail diagnosa
    public function kirimKIPIBerat($id)
    {
        try {
            $riwayat = Diagnosa::with('gejalaDipilih')->findOrFail($id);

            if (strtolower($riwayat->jenis_kipi) !== 'berat') {
                return redirect()->back()->with('error', 'Hanya data dengan kategori KIPI Berat yang dapat dikirim.');
            }

            $namaFile = 'Laporan_KIPI_Berat_' . $riwayat->nama_anak . '_' . now()->format('Ymd_His') . '.pdf';
            $filePath = 'storage/laporan/' . $namaFile;

            // Pastikan folder ada
            $directory = public_path('storage/laporan');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Generate PDF
            $pdf = Pdf::loadView('riwayat.laporan_kipi_berat_pdf', [
                'riwayat' => $riwayat,
                'gejala'  => $riwayat->gejalaDipilih,
            ])->setPaper('A4', 'portrait');

            $pdf->save(public_path($filePath));

            // Simpan ke database laporan
            Laporan::create([
                'id_diagnosa'     => $riwayat->id_diagnosa,
                'jenis_laporan'   => 'KIPI Berat',
                'tanggal_laporan' => now()->toDateString(),
                'file_path'       => $filePath,
                'nama_file'       => $namaFile,
                // 'nama_pasien'     => $riwayat->nama_anak, // <-- HAPUS BARIS INI
            ]);

            return redirect()->route('laporan.index')->with(
                'success',
                'Laporan KIPI Berat untuk ' . $riwayat->nama_anak . ' berhasil disimpan. ' .
                    'File: ' . $namaFile . ' telah tersimpan dan dapat diunduh di menu laporan.'
            );
        } catch (\Exception $e) {
            Log::error('Error saat membuat laporan KIPI berat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    // Method untuk download laporan
    public function downloadLaporan($filename)
    {
        try {
            $filePath = public_path('storage/laporan/' . $filename);

            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File laporan tidak ditemukan.');
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            Log::error('Error saat download laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh laporan.');
        }
    }

    // Method untuk hapus laporan
    public function hapusLaporan($id)
    {
        try {
            $laporan = Laporan::findOrFail($id);

            // Hapus file fisik
            if (file_exists(public_path($laporan->file_path))) {
                unlink(public_path($laporan->file_path));
            }

            // Hapus record dari database
            $laporan->delete();

            return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus laporan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus laporan.');
        }
    }
}
