<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua_sts extends Model
{
    protected $table = 'gruas_sts';

    public function grua() {

        return $this->belongsTo(Grua::class);
    }

    protected static function booted() {

        static::created(function ($grua_sts) {

            $grua_sts->codigo = "STS-" . $grua_sts->id;
            $grua_sts->save();
        });
    }
}
