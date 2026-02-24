<?php

use App\Http\Controllers\BuquesController;
use App\Http\Controllers\ContenedoresController;
use App\Http\Controllers\OperariosController;
use App\Http\Controllers\PatiosController;
use App\Http\Controllers\GruasController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\ParkingsController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ZonasController;
use Illuminate\Support\Facades\Route;


//LOGIN y LOGOUT
Route::post('/login/{rol}', [UsuariosController::class, 'login']);

//MIDDLEWARE GESTOR, ADMINISTRATIVO Y OPERARIO
Route::middleware('auth:gestor,administrativo,operario')->group(function () {
    Route::get('/obtenerOrdenes', [OrdenesController::class, 'listadoOrdenes'])->name('obtenerOrdenes');
    Route::get('/obtenerOperarios', [OperariosController::class, 'obtenerOperarios'])->name('obtenerOperarios');
    Route::get('/obtenerBuques', [BuquesController::class, 'obtenerBuques'])->name('obtenerBuques');
    Route::get('/obtenerBuquesConContenedores', [BuquesController::class, 'obtenerBuquesConContenedores'])->name('obtenerBuquesConContenedores');
    Route::get('/obtenerContenedor', [ContenedoresController::class, 'obtenerContenedor'])->name('obtenerContenedor');
    Route::get('/obtenerParkings', [ParkingsController::class, 'listadoParkings'])->name('obtenerParkings');

    Route::get('/obtenerGruas', [GruasController::class, 'obtenerGruas'])->name('obtenerGruas');

    Route::post('/logout', [UsuariosController::class, 'logout']);
});

//MIDDLEWARE GESTOR Y ADMINISTRATIVO
Route::middleware('auth:gestor,administrativo')->group(function () {
    //RUTAS BUQUE

    Route::view('/insertarBuque', 'insertarBuque')->name('insertarBuque');
    Route::post('/crearBuque', [BuquesController::class, 'crearBuque'])->name('crearBuque');

    Route::get('/editarBuque/{id}', [BuquesController::class, 'buscarBuquePorId'])->name('buscarBuquePorId');
    Route::patch('/actualizarBuque/{id}', [BuquesController::class, 'modificarBuque'])->name('modificarBuque');

    Route::delete('/borrarBuque/{id}', [BuquesController::class, 'eliminarBuque'])->name('eliminarBuque');

    //RUTAS CONTENEDOR
    Route::view('/insertarContenedor', 'insertarContenedor')->name('insertarContenedor');
    Route::post('/crearContenedor', [ContenedoresController::class, 'crearContenedor'])->name('crearContenedor');

    Route::get('/editarContenedor/{id}', [ContenedoresController::class, 'buscarContenedorPorId'])->name('buscarContenedorPorId');
    Route::patch('/actualizarContenedor/{id}', [ContenedoresController::class, 'modificarContenedor'])->name('modificarContenedor');

    Route::delete('/borrarContenedor/{id}', [ContenedoresController::class, 'eliminarContenedor'])->name('eliminarContenedor');

    //Saber ubicación contenedor
    Route::get('/contenedor/{id}/ubicacion', [ContenedoresController::class, 'obtenerUbicacionContenedor']);

    Route::patch('/actualizarOrden/{id}', [OrdenesController::class, 'modificarOrden'])->name('modificarOrden');

    Route::patch('/actualizarGrua/{id}', [GruasController::class, 'modificarGrua'])->name('modificarGrua');

    //grua
    Route::delete('/borrarGrua/{id}', [GruasController::class, 'eliminarGrua'])->name('eliminarGrua');

     //orden
    Route::delete('/borrarOrden/{id}', [OrdenesController::class, 'eliminarOrden'])->name('eliminarOrden');

});

Route::middleware('auth:administrativo')->group(function () {
    Route::post('/crearOrden', [OrdenesController::class, 'crearOrden'])->name('crearOrden');
    Route::patch('/actualizarOrden/{id}', [OrdenesController::class, 'modificarOrden'])->name('modificarOrden');
});

//MIDDLEWARE GESTOR
Route::middleware('auth:gestor')->group(function () {
    //RUTA PATIO
    Route::get('/patio', [PatiosController::class, 'index']);

    //RUTAS ZONAS
    Route::get('/obtenerZonas', [ZonasController::class, 'obtenerZonas'])->name('obtenerZonas');
    Route::get('/obtenerZonasDescarga', [ZonasController::class, 'obtenerZonasDescarga'])->name('obtenerZonasDescarga');

    Route::get('/editarZonas/{id}', [ZonasController::class, 'buscarZonaPorId'])->name('buscarZonaPorId');
    Route::patch('/actualizarZonas/{id}', [ZonasController::class, 'modicarEstadoZona'])->name('modicarEstadoZona');

    //RUTA CREAR GRÚA
    Route::post('/crearGrua', [GruasController::class, 'crearGrua'])->name('crearGrua');
});

Route::middleware('auth:operario')->group(function () {
    Route::get('/obtenerGruasOperario/{id}', [OperariosController::class, 'obtenerGruasOperario'])->name('obtenerGruasOperario');
    Route::patch('/actualizarEstado/{id}', [OrdenesController::class, 'actualizarEstado'])->name('actualizarEstado');
});
