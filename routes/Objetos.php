<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\ObjetosController;


Route::get('',[ObjetosController::class,'Objetos']);

Route::post('/insertar',[ObjetosController::class,'nuevo_objeto']);
Route::post('/actualizar',[ObjetosController::class,'actualizar_objeto']);
