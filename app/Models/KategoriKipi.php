<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKipi extends Model
{
    protected $table = 'kategori_kipis'; // pastikan nama tabel benar

    protected $primaryKey = 'kode_kategori_kipi';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false; // jika tabel tidak ada created_at/updated_at

    protected $fillable = ['kode_kategori_kipi', 'jenis_kipi', 'saran'];
}
