<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua extends Model
{

    protected $table = 'gruas';
    protected $fillable = ['tipo', 'estado'];

    public function gestores() {

        return $this->belongsTo(Gestor::class);
    }

    public function ordenes() {

        return $this->belongsToMany(Orden::class);
    }

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }

    public function gruaSTS() {

        return $this->hasOne(Grua_sts::class);
    }

    public function gruaSC() {

        return $this->hasOne(Grua_sc::class);
    }

    public function operarios() {

        return $this->belongsToMany(Operario::class);
    }

}
