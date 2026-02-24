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

        //$table->enum('estado', ['pendiente', 'en_proceso_sts', 'en_zona_desc', 'en_proceso_sc', 'completada'])
        switch ($orden->estado) {

            case 'pendiente':

                if ($orden->tipo === "descarga") {
                    $contenedor->update([
                        'ubicacion' => 'Buque',
                        'parking_id' => null
                    ]);
                } else {
                    $contenedor->update([
                        'ubicacion' => 'Parking',
                        'parking_id' => $orden->parking_id
                    ]);
                    //cambiamos el estao del parking a ocupado
                    if ($orden->parking) {
                        $orden->parking->update(['estado' => 'ocupado']);
                    }
                }
                break;

            case 'en_proceso_sts':

                if ($orden->tipo === "descarga") {
                    $contenedor->update([
                        'ubicacion' => 'Descargando del buque',
                        'parking_id' => null
                    ]);
                } else {
                    $contenedor->update([
                        'ubicacion' => 'Cargando al buque',
                        'parking_id' => null
                    ]);
                }

            case 'en_zona_desc':

                $contenedor->update([
                    'ubicacion' => 'Zona de descarga',
                    'parking_id' => null
                ]);

                break;

            case 'en_proceso_sc':

                if ($orden->tipo === "descarga") {
                    $contenedor->update([
                        'ubicacion' => 'De camino al patio',
                        'parking_id' => null
                    ]);
                } else {
                    $contenedor->update([
                        'ubicacion' => 'De camino a zona descarga',
                        'parking_id' => null
                    ]);
                }

            case 'completada':

                if ($orden->tipo === "descarga") {
                    $parking = $orden->parking;

                    if ($parking) {

                        $parking->estado = 'ocupado';
                        $parking->save();

                        $contenedor->update([
                            'ubicacion' => 'Parking',
                            'parking_id' => $parking->id
                        ]);
                    } else {

                        $contenedor->update([
                            'ubicacion' => 'Buque',
                            'parking_id' => null
                        ]);
                    }
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

            if ($orden->estado === 'en_proceso_sts') {

                if ($grua->tipo === 'sts') {
                    $grua->estado = 'ocupada';
                }
            }

            if ($orden->estado === "en_zona_descarga") {
                if ($orden->tipo === "descarga") {
                    if ($grua->tipo === "sts") {
                        $grua->estado = "disponible";
                    }
                } elseif ($orden->tipo === "carga") {
                    if ($grua->tipo === "sc") {
                        $grua->estado = "disponible";
                    }
                }
            }

            if ($orden->estado === 'en_proceso_sc') {

                if ($grua->tipo === 'sc') {
                    $grua->estado = 'ocupada';
                }
            }

            $grua->save();
        }
    }
}
