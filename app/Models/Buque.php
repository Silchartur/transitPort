<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buque extends Model
{
    protected $table = "buques";
    protected $fillable = ['nombre', 'tipo', 'capacidad', 'estado', 'observaciones'];

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }
}
