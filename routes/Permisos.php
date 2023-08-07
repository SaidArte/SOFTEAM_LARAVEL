<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\PermisosController;

Route::get('',[PermisosController::class,'Permisos']);

Route::post('/insertar',[PermisosController::class,'nuevo_permiso']);
Route::post('/actualizar',[PermisosController::class,'actualizar_permiso']);