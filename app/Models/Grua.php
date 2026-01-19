<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua extends Model
{
    protected $table = 'gruas';
    protected $fillable = ['tipo'];

    public function gestores() {

        return $this->belongsTo(Gestor::class);
    }

    public function ordenesDeTrabajo() {

        return $this->hasMany(OrdenDeTrabajo::class);
    }

    public function contenedores() {

        return $this->hasMany(Contenedor::class);
    }
}
