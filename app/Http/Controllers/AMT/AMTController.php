<?php

namespace App\Http\Controllers\AMT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AMTController extends Controller

{
    public function AMT(){
        return view ('AMT.AMT');
    }
}