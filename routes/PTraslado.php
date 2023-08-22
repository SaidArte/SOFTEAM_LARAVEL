<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\PTrasladoController;

//Ruta para el GetAll (Obtener todos los registros)
Route::get('',[PTrasladoController::class,'ptraslado']);
//Ruta Para el insert
Route::post('/insertar',[PTrasladoController::class,'nuevo_PermisoTraslado']);
//Ruta para el Update
Route::post('/actualizar',[PTrasladoController::class,'actualizar_PermisoTraslado']);