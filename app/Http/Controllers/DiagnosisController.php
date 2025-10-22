<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;
use App\Models\GejalaDipilih;
use App\Models\Diagnosa;
use App\Models\Aturan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
    // Menampilkan form data anak
    public function showDataForm()
    {
        return view('user.diagnosa.data_form');
    }

    // Menyimpan data anak ke session
    public function storeData(Request $request)
    {
        $request->validate([
            'nama_ibu'          => 'required|string|max:100',
            'nama_anak'         => 'required|string|max:100',
            'usia_anak'         => 'required|integer|min:0|max:60',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'alamat'            => 'required|string|max:50',
            'jenis_vaksin'      => 'required|string|max:100',
            'tempat_imunisasi'  => 'required|string|max:100',
            'tanggal_imunisasi' => 'required|date',
        ]);

        // Logika ini tidak berubah
        session($request->only([
            'nama_ibu',
            'nama_anak',
            'usia_anak',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'jenis_vaksin',
            'tempat_imunisasi',
            'tanggal_imunisasi',
        ]));

        return redirect()->route('diagnosa.gejala');
    }

    // Menampilkan form gejala
    public function showGejalaForm()
    {
        // Logika ini tidak berubah
        $gejalas = Gejala::all();
        return view('user.diagnosa.gejala_form', compact('gejalas'));
    }

    // Proses diagnosa menggunakan metode Certainty Factor
    public function prosesDiagnosa(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array',
            'gejala.*.jawaban' => 'required|in:1.0,0.5,0.0',
        ]);

        $inputGejala = $request->input('gejala');

        DB::beginTransaction();
        try {
            // Simpan data diagnosa
            $diagnosa = Diagnosa::create([
                'id_user' => auth()->id(),
                'nama_ibu'          => session('nama_ibu'),
                'nama_anak'         => session('nama_anak'),
                'usia_anak'         => session('usia_anak'),
                'jenis_kelamin'     => session('jenis_kelamin'),
                'tanggal_lahir'     => session('tanggal_lahir'),
                'alamat'            => session('alamat'),
                'jenis_vaksin'      => session('jenis_vaksin'),
                'tempat_imunisasi'  => session('tempat_imunisasi'),
                'tanggal_imunisasi' => session('tanggal_imunisasi'),
            ]);
            // Trait HasRandomId akan otomatis mengisi 'id_diagnosa'

            // Simpan gejala yang dipilih user
            foreach ($inputGejala as $kode_gejala => $data) {
                GejalaDipilih::updateOrCreate(
                    // DIUBAH: 'diagnosa_id' -> 'id_diagnosa'
                    //         '$diagnosa->id' -> '$diagnosa->id_diagnosa'
                    ['id_diagnosa' => $diagnosa->id_diagnosa, 'kode_gejala' => $kode_gejala],
                    ['cf_user' => floatval($data['jawaban'])]
                );
            }

            // Ambil semua gejala yang dipilih
            // DIUBAH: 'diagnosa_id' -> 'id_diagnosa'
            //         '$diagnosa->id' -> '$diagnosa->id_diagnosa'
            $gejalaDipilih = GejalaDipilih::where('id_diagnosa', $diagnosa->id_diagnosa)->get();
            $kodeGejalaDipilih = $gejalaDipilih->pluck('kode_gejala');

            // Ambil aturan sesuai gejala yang dipilih
            $aturanList = Aturan::whereIn('kode_gejala', $kodeGejalaDipilih)
                ->with('kategoriKipi')
                ->get()
                // DIUBAH: 'id' menjadi 'id_aturan'
                ->groupBy('id_aturan');

            $hasilDiagnosa = [];

            foreach ($aturanList as $aturanId => $items) {
                $cfCombine = null;
                $kategori  = $items->first()->kategoriKipi ?? null;

                foreach ($items as $item) {
                    $cfUser = $gejalaDipilih->firstWhere('kode_gejala', $item->kode_gejala)->cf_user ?? 0;
                    if ($cfUser == 0) continue;

                    $cf = (floatval($item->mb) - floatval($item->md)) * $cfUser;

                    $cfCombine = is_null($cfCombine)
                        ? $cf
                        : $cfCombine + ($cf * (1 - $cfCombine));
                }

                if (!is_null($cfCombine)) {
                    $hasilDiagnosa[] = [
                        'aturan_id'  => $aturanId, // Ini sudah benar
                        'cf'         => round($cfCombine, 4),
                        'jenis_kipi' => $kategori->jenis_kipi ?? 'Tidak Diketahui',
                        'saran'      => $kategori->saran ?? '-',
                    ];
                }
            }

            // Ambil hasil dengan CF tertinggi
            usort($hasilDiagnosa, fn($a, $b) => $b['cf'] <=> $a['cf']);
            $hasilTerbaik = $hasilDiagnosa[0] ?? null;

            if ($hasilTerbaik) {
                // '$diagnosa' adalah objek Eloquent, ini sudah benar
                $diagnosa->update([
                    'tanggal'    => now(),
                    'jenis_kipi' => $hasilTerbaik['jenis_kipi'],
                    'nilai_cf'   => $hasilTerbaik['cf'],
                    'saran'      => $hasilTerbaik['saran'],
                ]);
            }

            // Siapkan data gejala untuk tampilan
            $gejalas = Gejala::whereIn('kode_gejala', $kodeGejalaDipilih)->get()->keyBy('kode_gejala');
            $gejalaDipilihView = $gejalaDipilih->map(function ($item) use ($gejalas) {
                return [
                    'kode'    => $item->kode_gejala,
                    'nama'    => $gejalas[$item->kode_gejala]->nama_gejala ?? '-',
                    'cf_user' => $item->cf_user,
                ];
            });

            DB::commit();

            return view('user.diagnosa.hasil', [
                'hasilDiagnosa' => $hasilDiagnosa,
                'hasilTerbaik'  => $hasilTerbaik,
                'gejalaDipilih' => $gejalaDipilihView->values()->toArray(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Diagnosa: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors('Terjadi kesalahan saat proses diagnosa.')->withInput();
        }
    }

    // Diagnosa ulang
    public function diagnosaUlang()
    {
        // Logika ini tidak berubah
        if (!session()->has('nama_ibu') || !session()->has('nama_anak') || !session()->has('usia_anak')) {
            return redirect()->route('diagnosa.data_form')->with('error', 'Silakan isi data diri terlebih dahulu.');
        }

        $gejalas = Gejala::all();
        return view('user.diagnosa.gejala_form', compact('gejalas'));
    }
}
