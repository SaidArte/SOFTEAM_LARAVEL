<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\MantenimientosController;

Route::get('',[MantenimientosController::class,'Mantenimientos']);

Route::post('/insertar',[MantenimientosController::class,'nuevo_mantenimiento']);
Route::post('/actualizar',[MantenimientosController::class,'actualizar_mantenimiento']);