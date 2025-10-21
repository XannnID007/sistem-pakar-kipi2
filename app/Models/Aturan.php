<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    protected $table = 'aturan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_kategori_kipi',
        'kode_gejala',
        'mb',
        'md'
    ];

    public function kategoriKipi()
    {
        return $this->belongsTo(KategoriKipi::class, 'kode_kategori_kipi', 'kode_kategori_kipi');
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'kode_gejala', 'kode_gejala');
    }
}
