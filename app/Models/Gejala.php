<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejalas';

    protected $primaryKey = 'kode_gejala';  // <-- tambahkan ini
    public $incrementing = false;            // <-- tambahkan ini karena bukan auto-increment
    protected $keyType = 'string';           // <-- tambahkan ini karena primary key berupa string

    protected $fillable = ['kode_gejala', 'nama_gejala'];

    public function gejalaDipilih()
    {
        return $this->hasMany(GejalaDipilih::class, 'kode_gejala', 'kode_gejala');
    }
}
