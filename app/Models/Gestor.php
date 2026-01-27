<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = "gestores";
    protected $fillable = ['nombre', 'apellidos', 'email', 'telefono', 'imagen'];

    public function gruas() {

        return $this->hasMany(Grua::class);
    }
}
