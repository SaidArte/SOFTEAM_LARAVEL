<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\ParametrosController;

Route::get('',[ParametrosController::class,'Parametros']);

Route::post('/insertar',[ParametrosController::class,'nuevo_parametros']);
Route::post('/actualizar',[ParametrosController::class,'actualizar_parametros']);