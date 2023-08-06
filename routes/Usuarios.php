<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\UsuariosController;

Route::get('',[UsuariosController::class,'Usuarios']);

Route::post('/insertar',[UsuariosController::class,'nuevo_usuario']);
Route::post('/actualizar',[UsuariosController::class,'actualizar_usuario']);