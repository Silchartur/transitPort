<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'parkings';
    protected $fillable = ['disponible', 'activa'];

    protected static function booted() {

        static::created(function ($parking) {

            $parking->codigo = "P-" . $parking->id;
            $parking->save();
        });
    }

    public function zona() {

        return $this->belongsTo(Zona::class);
    }
}
