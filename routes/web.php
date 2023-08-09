<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('home');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::delete('/psacrificio/eliminar/{id}', 'Alcaldia\PSacrificioController@eliminar_psacrificio'); //Ruta del boton eliminar


use App\Http\Controllers\Alcaldia\PersonasController;
use App\Http\Controllers\Alcaldia\FierroController;
use App\Http\Controllers\Alcaldia\PSacrificioController;
use App\Http\Controllers\Alcaldia\UsuariosController;
use App\Http\Controllers\Alcaldia\PreguntasController;
use App\Http\Controllers\Alcaldia\RolesController;
use App\Http\Controllers\Alcaldia\ObjetosController;
use App\Http\Controllers\Alcaldia\PermisosController;
use App\Http\Controllers\Alcaldia\RespuestasController;
use App\Http\Controllers\Alcaldia\MantenimientosController;
use App\Http\Controllers\Alcaldia\PTrasladoController;




