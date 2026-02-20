<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
    use SoftDeletes;
    protected $table = 'ordenes';
    protected $fillable = ['tipo', 'estado', 'prioridad', 'buque_id', 'parking_id', 'contenedor_id', 'administrativo_id', 'observaciones'];

    public function administrativo() {

        return $this->belongsTo(Administrativo::class);
    }

    public function operario_sts() {

        return $this->belongsToMany(Operario::class, 'operario_orden', 'orden_id', 'operario_id')
            ->wherePivot('tipo', 'sts')
            ->withPivot('tipo');
    }

    public function operario_sc() {

        return $this->belongsToMany(Operario::class, 'operario_orden', 'orden_id', 'operario_id')
            ->wherePivot('tipo', 'sc')
            ->withPivot('tipo');
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
