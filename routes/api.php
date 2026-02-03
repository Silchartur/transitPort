<?php

use App\Http\Controllers\BuquesController;
use App\Http\Controllers\ContenedoresController;
use Illuminate\Support\Facades\Route;

//RUTAS BUQUE
Route::get('/obtenerBuques', [BuquesController::class, 'obtenerBuques'])->name('obtenerBuques');

Route::view('/insertarBuque', 'insertarBuque')->name('insertarBuque');
Route::post('/crearBuque', [BuquesController::class, 'crearBuque']) ->name('crearBuque');

Route::get('/editarBuque/{id}', [BuquesController::class, 'buscarBuquePorId']) -> name('buscarBuquePorId');
Route::patch('/actualizarBuque/{id}', [BuquesController::class, 'modificarBuque']) -> name('modificarBuque');

Route::delete('/borrarBuque/{id}', [BuquesController::class, 'eliminarBuque']) -> name('eliminarBuque');

//RUTAS CONTENEDOR
Route::get('/obtenerContenedor', [ContenedoresController::class, 'obtenerContenedor'])->name('obtenerContenedor');

Route::view('/insertarContenedor', 'insertarContenedor')->name('insertarContenedor');
Route::post('/crearContenedor', [ContenedoresController::class, 'crearContenedor']) ->name('crearContenedor');

Route::get('/editarContenedor/{id}', [ContenedoresController::class, 'buscarContenedorPorId']) -> name('buscarContenedorPorId');
Route::patch('/actualizarContenedor/{id}', [ContenedoresController::class, 'modificarContenedor']) -> name('modificarContenedor');

Route::delete('/borrarContenedor/{id}', [ContenedoresController::class, 'eliminarContenedor']) -> name('eliminarContenedor');
