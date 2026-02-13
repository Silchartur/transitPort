<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'parkings';
    protected $fillable = ['estado', 'activa'];

    public function zona() {

        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function contenedor(){

        return $this->hasOne(Contenedor::class, 'parking_id');
    }
}
