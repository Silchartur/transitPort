<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contenedor extends Model
{
    use SoftDeletes;
    
    protected $table = "contenedores";

    protected $fillable = [
        'num_serie',
        'companyia',
        'existe',
        'observaciones',
        'buque_id',
        'parking_id',
        'ubicacion',
    ];


    public function parking()
    {
        return $this->belongsTo(Parking::class, 'parking_id');
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
