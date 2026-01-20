<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patio extends Model
{
    protected $table = "patios";
    protected $fillable = ['prefijo','capacidad'];

    public function contenedores(){

        return $this->hasMany(Contenedor::class);
    }

    public function gruas_sc() {

        return $this->hasMany(Grua_sc::class);
    }

    public function zonas() {

        return $this->hasMany(Zona::class);
    }

    protected static function booted()
    {

        static::created(function ($patio) {
            $patio->codigo = $patio->prefijo . $patio->id;
            $patio->save();
        });
    }
}


