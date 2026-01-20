<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDeTrabajo extends Model
{
    protected $table = 'ordenesDeTrabajo';
    protected $fillable = ['tipo', 'estado', 'prioridad'];
    //hay que poner en fillable las foreign keys? como origen (buque), destino (zona patio), etc?

    protected static function booted() {

        static::created(function ($orden) {

            $prefijos = [
                'carga' => 'OC-',
                'descarga' => 'OD-',
            ];

            $prefijo = $prefijos[$orden->tipo];
            $orden->codigo = $prefijo . $orden->id;
            $orden->save();
        });
    }

    public function administrativo() {

        return $this->belongsTo(Administrativo::class);
    }

    public function operarios() {

        return $this->belongsToMany(Operario::class);
    }

    public function contenedor() {

        return $this->belongsTo(Contenedor::class);
    }

    public function gruas() {

        return $this->hasMany(Grua::class);
    }
}
