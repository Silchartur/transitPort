<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patio extends Model
{
    protected $table = "patios";
    protected $fillable = ['capacidad'];


    public function contenedores(){
        return $this->hasMany(Contenedor::class);
    }
}
