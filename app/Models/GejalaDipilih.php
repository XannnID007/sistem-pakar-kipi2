<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GejalaDipilih extends Model
{
    protected $table = 'gejala_dipilih';
        protected $fillable = ['diagnosa_id', 'kode_gejala', 'cf_user'];
    
        public function diagnosa()
        {
            return $this->belongsTo(Diagnosa::class);
        }
        public function gejala()
    {
        // Relasi ke model Gejala
        return $this->belongsTo(Gejala::class, 'kode_gejala', 'kode_gejala');
    }
    }
    
