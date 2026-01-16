<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
    protected $table = "buques";
    protected $fillable = ['num__serie', 'companyia', 'existe'];

    public function patio(){
        return $this->belongsTo(Patio::class);
    }
}
