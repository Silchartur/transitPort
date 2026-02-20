<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buque extends Model
{
    use SoftDeletes;
    protected $table = "buques";
    protected $fillable = ['nombre', 'tipo', 'capacidad', 'estado', 'observaciones'];

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }
}
