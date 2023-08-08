<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\PermisoTrasladoController;

//Ruta para el GetAll (Obtener todos los registros)
Route::get('',[PermisoTrasladoController::class,'permisotraslado']);
//Ruta Para el insert
Route::post('/insertar',[PermisoTrasladoController::class,'nuevo_PermisoTraslado']);
//Ruta para el Update
Route::put('/actualizar',[PermisoTrasladoController::class,'actualizar_PermisoTraslado']);
