<?php

namespace App\Models;

use App\Traits\HasRandomId; // 1. Import Trait
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasRandomId; // 2. Gunakan Trait

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan'; // 3. Primary key sudah benar

    protected $fillable = [
        'id_diagnosa',
        'jenis_laporan',
        'tanggal_laporan',
        'file_path',
        'nama_file',
    ];
    protected $casts = [
        'tanggal_laporan' => 'date',
    ];

    // Relasi ke Diagnosa
    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class, 'id_diagnosa', 'id_diagnosa');
    }
}
