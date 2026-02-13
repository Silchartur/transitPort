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
Route::get('/listadoUsuarios',[UsuariosController::class, 'listadoUsuarios'])->name('listadoUsuarios');

Route::view('/registro', 'registrar')->name('registrar');
Route::post('/registro',[UsuariosController::class, 'registro'])->name('registro');



    Route::put('/gestor_update/{id}',[GestoresController::class, 'update'])->name('gestor_update');

    Route::put('/administrativo_update/{id}',[AdministrativosController::class, 'update'])->name('administrativo_update');

    Route::put('/operario_update/{id}',[OperariosController::class, 'update'])->name('operario_update');

//RUTAS DE GESTOR QUE INCLUYEN VISTAS EN LARAVEL
Route::middleware('auth:gestor')->group(function () {


});
