<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\FierroController;
Route::post('/fierro/insertar-imagen', [FierroController::class, 'guardarImagen'])->name('fierro.guardar-imagen');
Route::get('',[FierroController::class,'fierro']);
//DE AQUI
Route::post('/insertar',[FierroController::class,'nuevo_fierro']);
Route::post('/actualizar',[FierroController::class,'actualizar_fierro']);

//HASTA AQUI