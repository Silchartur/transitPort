<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
    protected $table = "contenedores";
    protected $fillable = ['num__serie', 'companyia', 'existe', 'observaciones'];

    public function patio(){

        return $this->belongsTo(Patio::class);
    }

    public function buque() {

        return $this->belongsTo(Buque::class);
    }

    public function ordenesDeTrabajo() {

        return $this->hasMany(OrdenDeTrabajo::class);
    }

    public function gruas() {

        return $this->hasMany(Grua::class);
    }
}


