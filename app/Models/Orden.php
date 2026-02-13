<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';
    protected $fillable = ['tipo', 'estado', 'prioridad'];

    public function administrativo() {

        return $this->belongsTo(Administrativo::class);
    }

    /*
    public function operarios() {

        return $this->belongsToMany(Operario::class, 'operario_orden', 'orden_id', 'operario_id');
    }*/

    public function operarioSTS() {

        return $this->belongsToMany(Operario::class, 'operario_orden', 'orden_id', 'operario_id')
            ->withPivot('tipo')
            ->wherePivot('tipo', 'sts');
    }

    public function operarioSC() {

        return $this->belongsToMany(Operario::class, 'operario_orden', 'orden_id', 'operario_id')
            ->withPivot('tipo')
            ->wherePivot('tipo', 'sc');
    }

    public function contenedor() {

        return $this->belongsTo(Contenedor::class);
    }

    public function gruas() {

        return $this->belongsToMany(Grua::class, 'grua_orden', 'orden_id', 'grua_id');
    }

    public function buque() {

        return $this->belongsTo(Buque::class);
    }

    public function parking() {

        return $this->belongsTo(Parking::class);
    }
}
