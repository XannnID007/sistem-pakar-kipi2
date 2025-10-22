<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKipi extends Model
{
    // CATATAN: Model ini juga TIDAK pakai HasRandomId, karena ID-nya ('K001')
    // Anda masukkan manual. Pengaturan Anda sudah benar.

    protected $table = 'kategori_kipis';

    protected $primaryKey = 'kode_kategori_kipi';
    public $incrementing = false;
    protected $keyType = 'string';

    // Anda menggunakan 'created_at'/'updated_at' di Seeder, jadi jangan set 'false'
    // public $timestamps = false; 

    protected $fillable = ['kode_kategori_kipi', 'jenis_kipi', 'saran'];
}
