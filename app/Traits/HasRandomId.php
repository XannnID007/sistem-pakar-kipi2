<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasRandomId
{
     /**
      * Boot method untuk model.
      * Otomatis mengisi primary key dengan string acak 20 karakter.
      * Termasuk pengecekan bentrok (collision check).
      */
     protected static function bootHasRandomId()
     {
          static::creating(function ($model) {
               // Hanya set ID jika ID-nya masih kosong
               if (empty($model->{$model->getKeyName()})) {
                    $idLength = 20; // Sesuai permintaan Anda
                    $newId = Str::random($idLength);

                    // PENTING: Cek apakah ID ini sudah ada di database.
                    // Jika sudah ada, buat lagi sampai dapat yang unik.
                    while (static::where($model->getKeyName(), $newId)->exists()) {
                         $newId = Str::random($idLength);
                    }

                    // Set ID unik ke model
                    $model->{$model->getKeyName()} = $newId;
               }
          });
     }

     /**
      * Beritahu Eloquent bahwa ID tidak auto-increment.
      */
     public function getIncrementing()
     {
          return false;
     }

     /**
      * Beritahu Eloquent bahwa tipe primary key adalah string.
      */
     public function getKeyType()
     {
          return 'string';
     }
}
