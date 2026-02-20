<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grua extends Model
{
    use SoftDeletes;

    protected $table = 'gruas';
    protected $fillable = ['tipo', 'id_gestor', 'estado', 'id_zona', 'observaciones'];

    public function gestor() {

        return $this->belongsTo(Gestor::class);
    }

    public function ordenes() {

        return $this->belongsToMany(Orden::class, 'grua_orden', 'grua_id', 'orden_id');
    }

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }

    public function zona() {

        return $this->belongsTo(Zona::class, 'id_zona');
    }

    public function operarios() {

        return $this->belongsToMany(Operario::class, 'operario_grua', 'grua_id', 'operario_id');
    }

}
