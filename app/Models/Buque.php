<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buque extends Model
{
    protected $table = "buques";
    protected $fillable = ['nombre', 'tipo', 'capacidad', 'estado'];

    protected static function booted() {

        static::created(function ($buque) {

            $buque->codigo = "B-" . $buque->id;
            $buque->save();
        });
    }

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }
}
