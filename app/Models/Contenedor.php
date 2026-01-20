<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
    protected $table = "buques";
    protected $fillable = ['prefijo','num__serie', 'companyia', 'existe'];

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


      protected static function booted()
    {
        static::created(function ($contenedor) {
            $contenedor->codigo = $contenedor->prefijo . $contenedor->id;
            $contenedor->save();
        });
    }
}


