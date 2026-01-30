<?php

use App\Http\Controllers\BuquesController;
use Illuminate\Support\Facades\Route;

//RUTAS BUQUE
Route::get('/obtenerBuques', [BuquesController::class, 'obtenerBuques'])->name('obtenerBuques');

Route::view('/insertarBuque', 'insertarBuque')->name('insertarBuque');
Route::post('/crearBuque', [BuquesController::class, 'crearBuque']) ->name('crearBuque');

Route::get('/editarBuque/{id}', [BuquesController::class, 'buscarBuquePorId']) -> name('buscarBuquePorId');
Route::patch('/actualizarBuque/{id}', [BuquesController::class, 'modificarBuque']) -> name('modificarBuque');

Route::delete('/borrarBuque/{id}', [BuquesController::class, 'eliminarBuque']) -> name('eliminarBuque');
