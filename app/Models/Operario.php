<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operario extends Model
{
    protected $table = "operarios";
    protected $fillable = ['tipo','nombre', 'apellidos', 'email', 'telefono'];
}
