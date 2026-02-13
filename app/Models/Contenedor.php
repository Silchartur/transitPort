<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Contenedor extends Model
{
    protected $table = "contenedores";

    protected $fillable = [
        'num_serie',
        'companyia',
        'existe',
        'observaciones',
        'buque_id',
        'parking_id'
    ];


    public function parking()
    {
        return $this->hasMany(Parking::class);
    }


    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }


    public function ordenesDeTrabajo()
    {
        return $this->hasMany(Orden::class);
    }


    public function gruas()
    {
        return $this->hasMany(Grua::class);
    }
}
