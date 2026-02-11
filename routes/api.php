<?php

use App\Http\Controllers\BuquesController;
use App\Http\Controllers\ContenedoresController;
use App\Http\Controllers\OperariosController;
use App\Http\Controllers\PatiosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ZonasController;
use Illuminate\Support\Facades\Route;


//LOGIN y LOGOUT
Route::post('/login/{rol}', [UsuariosController::class, 'login']);

//MIDDLEWARE GESTOR, ADMINISTRATIVO Y OPERARIO
Route::middleware('auth:gestor,administrativo,operario')->group(function () {
    Route::post('/logout', [UsuariosController::class, 'logout']);
});

//MIDDLEWARE GESTOR Y ADMINISTRATIVO
Route::middleware('auth:gestor,administrativo')->group(function () {
    //RUTAS BUQUE
    Route::get('/obtenerBuques', [BuquesController::class, 'obtenerBuques'])->name('obtenerBuques');

    Route::view('/insertarBuque', 'insertarBuque')->name('insertarBuque');
    Route::post('/crearBuque', [BuquesController::class, 'crearBuque'])->name('crearBuque');

    Route::get('/editarBuque/{id}', [BuquesController::class, 'buscarBuquePorId'])->name('buscarBuquePorId');
    Route::patch('/actualizarBuque/{id}', [BuquesController::class, 'modificarBuque'])->name('modificarBuque');

    Route::delete('/borrarBuque/{id}', [BuquesController::class, 'eliminarBuque'])->name('eliminarBuque');

    //RUTAS CONTENEDOR
    Route::get('/obtenerContenedor', [ContenedoresController::class, 'obtenerContenedor'])->name('obtenerContenedor');

    Route::view('/insertarContenedor', 'insertarContenedor')->name('insertarContenedor');
    Route::post('/crearContenedor', [ContenedoresController::class, 'crearContenedor'])->name('crearContenedor');

    Route::get('/editarContenedor/{id}', [ContenedoresController::class, 'buscarContenedorPorId'])->name('buscarContenedorPorId');
    Route::patch('/actualizarContenedor/{id}', [ContenedoresController::class, 'modificarContenedor'])->name('modificarContenedor');

    Route::delete('/borrarContenedor/{id}', [ContenedoresController::class, 'eliminarContenedor'])->name('eliminarContenedor');

    //Saber ubicación contenedor
    Route::get('/contenedor/{id}/ubicacion', [ContenedoresController::class, 'obtenerUbicacionContenedor']);

});

//MIDDLEWARE GESTOR
Route::middleware('auth:gestor')->group(function () {
    //RUTA PATIO
    Route::get('/obtenerPatio', [PatiosController::class, 'obtenerPatio'])->name('obtenerPatio');

    //RUTAS ZONAS
    Route::get('/obtenerZonas', [ZonasController::class, 'obtenerZonas'])->name('obtenerZonas');
    Route::get('/obtenerZonasDescarga', [ZonasController::class, 'obtenerZonasDescarga'])->name('obtenerZonasDescarga');

    Route::get('/editarZonas/{id}', [ZonasController::class, 'buscarZonaPorId'])->name('buscarZonaPorId');
    Route::patch('/actualizarZonas/{id}', [ZonasController::class, 'modicarEstadoZona'])->name('modicarEstadoZona');

    Route::get('/obtenerOperarios', [OperariosController::class, 'obtenerOperarios'])->name('obtenerOperarios');
});
