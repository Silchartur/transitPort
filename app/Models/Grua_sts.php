<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua_sts extends Model
{
    protected $table = 'gruas_sts';

    public function grua() {

        return $this->belongsTo(Grua::class);
    }
}
