<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patio extends Model
{
    protected $table = "patios";
    protected $fillable = ['capacidad'];


    public function gruas_sc() {

        return $this->hasMany(Grua_sc::class);
    }

    public function zonas() {

        return $this->hasMany(Zona::class);
    }
}


