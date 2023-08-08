<?php
use Illuminate\Http\Request;

use App\Http\Controllers\Alcaldia\CventaController;

use Illuminate\Support\Facades\Route;


Route::get('',[CventaController::class,'Cventa']);
Route::post('/insertar',[CventaController::class,'nuevo_cventa']);
Route::Post('/actualizar',[CventaController::class,'actualizar_cventa']);