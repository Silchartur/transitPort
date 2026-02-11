<?php

namespace App\Observers;

use App\Models\Orden;

class OrdenObserver
{

    public function updated(Orden $orden)
    {

        $contenedor = $orden->contenedor;

        if ($contenedor) {

            $nuevaUbicacion = $this->calcularUbicacion($orden, $contenedor);

            $contenedor->update([
                'ubicacion' => $nuevaUbicacion
            ]);
        }
    }

    private function calcularUbicacion(Orden $orden, $contenedor)
    {
        switch ($orden->tipo) {
            case 'descarga':
                switch ($orden->estado) {
                    case 'en_zona_desc':
                        return 'Zona de descarga';
                    case 'pendiente':
                        return 'Buque';
                    case 'completada':
                        return 'Parking';
                    default:
                        return $contenedor->ubicacion;
                }

            case 'carga':
                switch ($orden->estado) {
                    case 'en_zona_desc':
                        return 'Patio';
                    case 'pendiente':
                        return 'Parking';
                    case 'completada':
                        return 'Buque';
                    default:
                        return $contenedor->ubicacion;
                }

            default:
                return $contenedor->parking_id ? 'Parking' : 'Buque';
        }
    }

    public function cambiarEstadoGrua(Orden $orden, $grua){

        switch ($orden->estado) {
            case 'pendiente':

                break;

            default:
                # code...
                break;
        }

    }
}
