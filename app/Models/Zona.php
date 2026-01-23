<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';
    protected $fillable = ['tipo', 'activa'];

    protected static function booted() {

        static::created(function ($zona) {

            $prefijos = [
                'descarga' => 'ZD-',
                'patio' => 'ZP-',
            ];

            $prefijo = $prefijos[$zona->tipo];

            $zona->codigo = $prefijo . $zona->id;
            $zona->save();
        });
    }

    public function parkings() {

        return $this->hasMany(Parking::class);
    }

    public function patio() {

        return $this->belongsTo(Patio::class);
    }

}
