<?php

use App\Http\Controllers\Alcaldia\BitacoraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('',[BitacoraController::class,'Bitacora']);
Route::delete('/delete-bitacora', [BitacoraController::class, 'EliminarBitacora'])->name('bitacora.delete-all');