<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alcaldia\BackupRestoreController;

Route::get('',[BackupRestoreController::class,'backuprestore']);
Route::get('/app/backups/{filename}', 'BackupRestoreController@descargarBackup')->name('descargarBackup');
Route::post('/backuprestore', [BackupRestoreController::class, 'backuprestore'])->name('backuprestore.index');
// routes/web.php
Route::delete('/backuprestore/{filename}', [BackupRestoreController::class, 'deleteBackup'])->name('backuprestore.delete');
Route::post('/backuprestore/{filename}', [BackupRestoreController::class, 'downloadBackup'])->name('backuprestore.download');

// Ruta para restaurar la base de datos
Route::post('/restaurar', [BackupRestoreController::class, 'restaurarBackup'])->name('backuprestore.restaurar');
