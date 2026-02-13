<?php

namespace App\Http\Controllers;
use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingsController extends Controller
{
    public function listadoParkings() {

        $parkings = Parking::with('contenedor')->get();

        return response()->json($parkings);
    }
}
