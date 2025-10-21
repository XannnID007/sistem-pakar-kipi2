<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    protected $table = 'diagnosa';

    protected $fillable = [
        'user_id', 'nama_ibu', 'nama_anak', 'jenis_kelamin',
        'tanggal_lahir', 'usia_anak', 'alamat', 'jenis_vaksin',
        'tempat_imunisasi', 'tanggal_imunisasi', 'tanggal',
        'jenis_kipi', 'saran', 'nilai_cf'
    ];

    public function gejalaDipilih()
    {
        return $this->hasMany(GejalaDipilih::class, 'diagnosa_id', 'id');
    }
}