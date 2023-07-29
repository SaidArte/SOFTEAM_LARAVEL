<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AMT\permisosacrificioController;

Route::get('',[permisosacrificioController::class,'permisosacrificio']);