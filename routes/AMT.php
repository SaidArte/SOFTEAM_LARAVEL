<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AMT\AMTController;

Route::get('',[AMTController::class,'AMT']);