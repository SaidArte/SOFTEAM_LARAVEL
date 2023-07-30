<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\http;
use App\Http\Controllers\Controller;


class AlcaldiaController extends Controller
{
    public function Alcaldia(){
        return view('Alcaldia.Alcaldia');
    }
}
