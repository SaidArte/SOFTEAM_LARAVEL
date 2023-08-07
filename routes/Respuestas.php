<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\RespuestasController;

Route::get('',[RespuestasController::class,'Respuestas']);

Route::post('/actualizar',[RespuestasController::class,'actualizar_respuesta']);