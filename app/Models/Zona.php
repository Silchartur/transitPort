<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';
    protected $fillable = ['tipo', 'activa'];

    public function parkings() {

        return $this->hasMany(Parking::class);
    }
}
