<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    // CATATAN: Model ini TIDAK pakai HasRandomId, karena ID-nya ('G001')
    // Anda masukkan manual, bukan acak. Pengaturan Anda sudah benar.

    protected $table = 'gejalas';

    protected $primaryKey = 'kode_gejala';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_gejala', 'nama_gejala'];

    public function gejalaDipilih()
    {
        return $this->hasMany(GejalaDipilih::class, 'kode_gejala', 'kode_gejala');
    }
}
