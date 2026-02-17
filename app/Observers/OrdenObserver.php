<?php

namespace App\Observers;

use App\Models\Orden;
use App\Models\Parking;

class OrdenObserver
{
    public function updated(Orden $orden)
    {
        $contenedor = $orden->contenedor;

        if (!$contenedor) {
            return;
        }

        // Si tenía parking, liberarlo antes
        if ($contenedor->parking_id) {

            $parkingAnterior = Parking::find($contenedor->parking_id);

            if ($parkingAnterior) {
                $parkingAnterior->estado = 'libre';
                $parkingAnterior->save();
            }
        }

        switch ($orden->estado) {

            case 'pendiente':

                $contenedor->update([
                    'ubicacion' => 'BUQUE',
                    'parking_id' => null
                ]);

                break;


            case 'en_zona_desc':

                $contenedor->update([
                    'ubicacion' => 'ZONA_DESCARGA',
                    'parking_id' => null
                ]);

                break;


            case 'en_proceso_sc':

                $contenedor->update([
                    'ubicacion' => 'SC',
                    'parking_id' => null
                ]);

                break;


            case 'completada':

                $parking = Parking::where('estado', 'libre')->first();

                if ($parking) {

                    $parking->estado = 'ocupado';
                    $parking->save();

                    $contenedor->update([
                        'ubicacion' => 'PARKING',
                        'parking_id' => $parking->id
                    ]);
                }

                break;
        }

        // Cambiar estado de grúas
        foreach ($orden->gruas as $grua) {

            if (
                $orden->estado === 'pendiente' ||
                $orden->estado === 'completada'
            ) {
                $grua->estado = 'disponible';
            }

            if ($orden->estado === 'en_proceso_sts' && $grua->tipo === 'sts') {
                $grua->estado = 'ocupada';
            }

            if (
                ($orden->estado === 'en_zona_desc' ||
                 $orden->estado === 'en_proceso_sc')
                && $grua->tipo === 'sc'
            ) {
                $grua->estado = 'ocupada';
            }

            $grua->save();
        }
    }
}
