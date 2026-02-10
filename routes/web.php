<?php

use App\Http\Controllers\AdministrativosController;
use App\Http\Controllers\BuquesController;
use App\Http\Controllers\GestoresController;
use App\Http\Controllers\OperariosController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//RUTAS DE GESTOR QUE INCLUYEN VISTAS EN LARAVEL
Route::middleware('auth:gestor')->group(function () {

    Route::post('/registro',[UsuariosController::class, 'registro'])->name('registro');

    Route::get('/listadoUsuarios',[UsuariosController::class, 'listadoUsuarios']);

    Route::put('/gestor/{id}',[GestoresController::class, 'update']);

    Route::put('/administrativo/{id}',[AdministrativosController::class, 'update']);

    Route::put('/operario/{id}',[OperariosController::class, 'update']);
});
