<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\PreguntasController;

Route::get('',[PreguntasController::class,'Preguntas']);

Route::post('/insertar',[PreguntasController::class,'nueva_pregunta']);
Route::post('/actualizar',[PreguntasController::class,'actualizar_pregunta']);