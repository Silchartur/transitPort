<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua extends Model
{

    protected $table = 'gruas';
    protected $fillable = ['tipo', 'id_gestor', 'estado', 'id_zona', 'observaciones'];

    public function gestor() {

        return $this->belongsTo(Gestor::class);
    }

    public function ordenes() {

        return $this->belongsToMany(Orden::class);
    }

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }

    public function zona() {

        return $this->belongsTo(Zona::class);
    }

    public function operarios() {

        return $this->belongsToMany(Operario::class, 'operario_grua', 'grua_id', 'operario_id');
    }

}
