<?php

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Agrega esta importación

// Ruta de inicio


// Rutas generadas por Auth::routes()
Auth::routes();
// Ruta para el pdf
//pdf Sacrificio
Route::get('psacrificio/pdf' , function () {
    $pdf = PDF ::loadView('Alcaldia.pdf'); 
    return $pdf->stream('Permiso.pdf');
})->name('psacrificio.pdf');
//pdf Traslado
Route::get('PTraslado/pdfTraslado' , function () {
    $pdf = PDF ::loadView('Alcaldia.pdfTraslado'); 
    return $pdf->stream('Traslado.pdf');
})->name('PTraslado.pdfTraslado');
//pdf Fierro
Route::get('fierro/pdfFierro' , function () {
    $pdf = PDF ::loadView('Alcaldia.pdfFierro'); 
    return $pdf->stream('Fierro.pdf');
})->name('fierro.pdfFierro');

//pdf cventa
Route::get('Cventa/pdfc' , function () {
    $pdf = PDF ::loadView('Alcaldia.pdfc'); 
    return $pdf->stream('Cventa.pdfc');
})->name('Cventa.pdfc');




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
Route::get('/pass-auth', [AuthController::class, 'showUSERPASSRSTForm'])->name('auth.usuariopassreset');
Route::post('/pass-auth', [AuthController::class, 'authResetPassword'])->name('auth.usuariopassreset.redirect');
Route::get('/answer-auth', [AuthController::class, 'showAPassword'])->name('auth.passwords.answer');
Route::post('/answer-auth', [AuthController::class, 'answerResetPassword'])->name('auth.passwords.answer.redirect');
Route::get('/reset-password', [AuthController::class, 'showRSTPassword'])->name('auth.passwords.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.passwords.reset.submit');
Route::get('/preguntas-auth', [AuthController::class, 'showAuthRespuestas'])->name('Alcaldia.auth-respuestas-secretas');
Route::post('/preguntas-auth', [AuthController::class, 'authUsuarioPregunta'])->name('Alcaldia.auth-respuestas-secretas.redirect');
Route::get('/respuestas', [AuthController::class, 'showAuthRespuestas'])->name('Alcaldia.respuestas');
Route::post('/respuestas', [AuthController::class, 'respuestaSeguridad'])->name('Alcaldia.respuestas.submit');
