<?php
use Illuminate\Http\Request;

use App\Http\Controllers\Alcaldia\AnimalController;

use Illuminate\Support\Facades\Route;


Route::get('',[AnimalController::class,'Animal']);
Route::post('/insertar',[AnimalController::class,'nuevo_animal']);
Route::Post('/actualizar',[AnimalController::class,'actualizar_animal']);
