<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operario extends Model
{
    protected $table = "operarios";
    protected $fillable = ['tipo','nombre', 'apellidos', 'email', 'telefono','imagen'];

    public function gruas() {

        return $this->hasMany(Grua::class);
    }

    public function ordenesDeTrabajo() {

        return $this->hasMany(OrdenDeTrabajo::class);
    }

    protected static function booted()
    {
        static::created(function ($operario) {
            $operario->codigo = "O-" . $operario->id;
            $operario->save();
        });
    }

}
