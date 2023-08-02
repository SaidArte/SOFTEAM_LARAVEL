<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\Alcaldia\FierroController;

/*Route::get('/fierro', [FierroController::class, 'fierro'])->name('fierro');
Route::post('/fierro/nuevo', [FierroController::class, 'nuevo_fierro'])->name('fierro.nuevo');
Route::post('/fierro/actualizar', [FierroController::class, 'actualizar_fierro'])->name('fierro.actualizar');*/
