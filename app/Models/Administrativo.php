<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    protected $table = 'administrativos';
    protected $fillable = ['nombre', 'apellidos', 'email', 'telefono'];

    public function ordenesDeTrabajo() {

        return $this->hasMany(OrdenDeTrabajo::class);
    }
}
