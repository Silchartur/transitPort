<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    protected $table = 'administrativos';
    protected $fillable = ['prefijo','nombre', 'apellidos', 'email', 'telefono'];

    public function ordenesDeTrabajo() {

        return $this->hasMany(OrdenDeTrabajo::class);
    }

    protected static function booted()
    {
        static::created(function ($administrativo) {
            $administrativo->codigo = $administrativo->prefijo . $administrativo->id;
            $administrativo->save();
        });
    }

}
