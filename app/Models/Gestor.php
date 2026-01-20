<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = "gestores";
    protected $fillable = ['prefijo','nombre', 'apellidos', 'email', 'telefono'];

    public function gruas() {

        return $this->hasMany(Grua::class);
    }


    protected static function booted()
    {
        static::created(function ($gestor) {
            $gestor->codigo = $gestor->prefijo . $gestor->id;
            $gestor->save();
        });
    }

}
