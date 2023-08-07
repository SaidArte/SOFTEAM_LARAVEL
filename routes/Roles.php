<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\RolesController;

Route::get('',[RolesController::class,'Roles']);

Route::post('/insertar',[RolesController::class,'nuevo_rol']);
Route::post('/actualizar',[RolesController::class,'actualizar_rol']);