<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\PSacrificioController;

Route::get('',[PSacrificioController::class,'psacrificio']);

Route::post('/insertar',[PSacrificioController::class,'nuevo_psacrificio']);
Route::post('/actualizar',[PSacrificioController::class,'actualizar_psacrificio']);
Route::get('/generar-pdf/{id}', [PSacrificioController::class, 'generarPdfPS']);
Route::post('/sacrificios/insertar-imagen', [PSacrificioController::class, 'guardarImagen'])->name('sacrificios.guardar-imagen');
