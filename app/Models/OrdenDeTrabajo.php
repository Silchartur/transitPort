<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDeTrabajo extends Model
{
    protected $table = 'ordenesDeTrabajo';
    protected $fillable = ['tipo', 'estado', 'prioridad'];
    //hay que poner en fillable las foreign keys? como origen (buque), destino (zona patio), etc?

    public function administrativo() {

        return $this->belongsTo(Administrativo::class);
    }

    public function contenedor() {

        return $this->belongsTo(Contenedor::class);
    }

    public function gruas() {

        return $this->hasMany(Grua::class);
    }
}
