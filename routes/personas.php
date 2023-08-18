<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\PersonasController;

Route::get('',[PersonasController::class,'personas']);
Route::post('/insertar',[PersonasController::class,'nueva_persona']);
Route::post('/actualizar',[PersonasController::class,'actualizar_persona']);
Route::post('/personas/insertar-imagen', [PersonasController::class, 'guardarImagen'])->name('personas.guardar-imagen');
