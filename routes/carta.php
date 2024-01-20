


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\CartaController;

//Ruta para el GetAll (Obtener todos los registros)
Route::get('',[CartaController::class,'carta']);
//Ruta Para el insert
Route::post('/insertar',[CartaController::class,'nuevo_carta']);
//Ruta para el Update
Route::post('/actualizar',[CartaController::class,'actualizar_carta']);
//Ruta para imprimir pdf
Route::get('/generar-pdf/{id}', [CartaController::class, 'generarPdfT']);