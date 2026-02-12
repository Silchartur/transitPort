<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';
    protected $fillable = ['tipo', 'estado', 'prioridad'];
    //hay que poner en fillable las foreign keys? como origen (buque), destino (zona patio), etc?

    public function administrativo() {

        return $this->belongsTo(Administrativo::class);
    }

    public function operarios() {

        return $this->belongsToMany(Operario::class, 'operario_orden', 'orden_id', 'operario_id');
    }

    public function contenedor() {

        return $this->belongsTo(Contenedor::class);
    }

    public function gruas() {

        return $this->belongsToMany(Grua::class, 'grua_orden', 'orden_id', 'grua_id');
    }
}
