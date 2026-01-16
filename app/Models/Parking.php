<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'parkings';
    protected $fillable = ['disponible', 'activa'];

    public function zona() {

        return $this->belongsTo(Zona::class);
    }
}
