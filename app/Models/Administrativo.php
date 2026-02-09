<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends Authenticatable
{

    use HasApiTokens, Notifiable;

    protected $table = 'administrativos';
    protected $fillable = ['nombre', 'apellidos', 'email', 'password', 'telefono', 'imagen', 'observaciones'];

    public function ordenes() {

        return $this->hasMany(Orden::class);
    }

}
