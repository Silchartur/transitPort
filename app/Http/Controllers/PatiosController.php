<?php

namespace App\Http\Controllers;
use App\Models\Patio;
use Illuminate\Http\Request;

class PatiosController extends Controller
{
    public function obtenerPatio() {

        $patio = Patio::all();

        return response()->json($patio);
    }

}
