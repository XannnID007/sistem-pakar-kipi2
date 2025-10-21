<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $primaryKey = 'id_laporan'; // Tambahkan ini

    protected $fillable = [
       'id_diagnosa',
       'jenis_laporan',
       'tanggal_laporan',
       'file_path',
       'nama_file',
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',  // Koreksi: pakai tanggal_laporan bukan 'periode'
    ];
}
