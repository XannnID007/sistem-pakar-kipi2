<?php

namespace App\Models;

use App\Traits\HasRandomId; // 1. Import Trait
use Illuminate\Database\Eloquent\Model;

class GejalaDipilih extends Model
{
    use HasRandomId; // 2. Gunakan Trait

    protected $table = 'gejala_dipilih';
    protected $primaryKey = 'id_gejala_dipilih'; // 3. Tambahkan Primary Key

    protected $fillable = [
        'id_diagnosa', // 4. Ganti 'diagnosa_id' menjadi 'id_diagnosa'
        'kode_gejala',
        'cf_user'
    ];

    public function diagnosa()
    {
        // 5. Sesuaikan foreign key dan owner key
        return $this->belongsTo(Diagnosa::class, 'id_diagnosa', 'id_diagnosa');
    }

    public function gejala()
    {
        // Relasi ini sudah benar
        // Pastikan Anda punya model 'Gejala' atau ganti ke 'Gejalas'
        return $this->belongsTo(Gejala::class, 'kode_gejala', 'kode_gejala');
    }
}
