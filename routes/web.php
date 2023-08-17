<?php

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Agrega esta importación

// Ruta de inicio


// Rutas generadas por Auth::routes()
Auth::routes();
// Ruta para el pdf
Route::get('psacrificio/pdf' , function () {
    $pdf = PDF ::loadView('Alcaldia.pdf'); 
    return $pdf->stream('Permiso.pdf');
})->name('psacrificio.pdf');

Route::get('fierro/pdf/{fierroId}', 'PDFController@generateFierroPDF')->name('fierro.pdf');


// Rutas adicionales
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::delete('/psacrificio/eliminar/{id}', 'Alcaldia\PSacrificioController@eliminar_psacrificio');
Route::post('/personas', [PersonasController::class, 'store'])->name('store');

// Importaciones de los controladores
use App\Http\Controllers\Alcaldia\PersonasController;
use App\Http\Controllers\Alcaldia\FierroController;
use App\Http\Controllers\Alcaldia\PSacrificioController;
use App\Http\Controllers\Alcaldia\UsuariosController;
use App\Http\Controllers\Alcaldia\PreguntasController;
use App\Http\Controllers\Alcaldia\RolesController;
use App\Http\Controllers\Alcaldia\ObjetosController;
use App\Http\Controllers\Alcaldia\PermisosController;
use App\Http\Controllers\Alcaldia\RespuestasController;
use App\Http\Controllers\Alcaldia\MantenimientosController;
use App\Http\Controllers\Alcaldia\PTrasladoController;


// Resto de tus rutas...
// Aquí puedes agregar las rutas para tus otros controladores
Route::get('/', function () {
    return view('auth.login');
});
// Rutas de autenticación personalizadas
//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password.submit');
