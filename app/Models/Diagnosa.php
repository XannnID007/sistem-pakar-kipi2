<?php

namespace App\Models;

use App\Traits\HasRandomId; // 1. Import Trait
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasRandomId; // 2. Gunakan Trait

    protected $table = 'diagnosa';
    protected $primaryKey = 'id_diagnosa'; // 3. Tambahkan Primary Key

    protected $fillable = [
        'id_user', // 4. Ganti 'user_id' menjadi 'id_user'
        'nama_ibu',
        'nama_anak',
        'jenis_kelamin',
        'tanggal_lahir',
        'usia_anak',
        'alamat',
        'jenis_vaksin',
        'tempat_imunisasi',
        'tanggal_imunisasi',
        'tanggal',
        'jenis_kipi',
        'saran',
        'nilai_cf'
        // 'created_at' dan 'updated_at' ditangani otomatis
    ];

    public function gejalaDipilih()
    {
        // 5. Sesuaikan foreign key dan local key
        return $this->hasMany(GejalaDipilih::class, 'id_diagnosa', 'id_diagnosa');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
