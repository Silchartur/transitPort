<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua_sc extends Model
{
    protected $table = 'gruas_sc';

    public function grua() {

        return $this->belongsTo(Grua::class);
    }
}
