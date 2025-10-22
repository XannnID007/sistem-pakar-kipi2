<?php

namespace App\Models;

use App\Traits\HasRandomId; // 1. Import Trait
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasRandomId; // 2. Gunakan Trait

    protected $table = 'aturan';
    protected $primaryKey = 'id_aturan'; // 3. Ganti nama Primary Key
    public $timestamps = false; // 4. Sesuai migrasi, tidak ada timestamps

    // Properti 'incrementing' and 'keyType' otomatis di-handle oleh Trait

    protected $fillable = [
        'kode_kategori_kipi',
        'kode_gejala',
        'mb',
        'md'
    ];

    // Relasi ini sudah benar karena menggunakan 'kode_kategori_kipi'
    public function kategoriKipi()
    {
        return $this->belongsTo(KategoriKipi::class, 'kode_kategori_kipi', 'kode_kategori_kipi');
    }

    // Relasi ini sudah benar karena menggunakan 'kode_gejala'
    public function gejala()
    {
        // Pastikan Anda punya model 'Gejala' atau ganti ke 'Gejalas'
        return $this->belongsTo(Gejala::class, 'kode_gejala', 'kode_gejala');
    }
}
