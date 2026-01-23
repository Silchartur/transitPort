<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grua_sc extends Model
{
    protected $table = 'gruas_sc';

    public function grua() {

        return $this->belongsTo(Grua::class);
    }

    protected static function booted() {

        static::created(function ($grua_sc) {

            $grua_sc->codigo = "SC-" . $grua_sc->id;
            $grua_sc->save();
        });
    }
}
