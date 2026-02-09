<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Operario extends Model
{

    use HasApiTokens, Notifiable;

    protected $table = "operarios";
    protected $fillable = ['nombre', 'apellidos', 'email', 'password', 'telefono', 'imagen', 'observaciones'];

    public function gruas() {

        return $this->hasMany(Grua::class);
    }

    public function ordenes() {

        return $this->belongsToMany(Orden::class);
    }

}
