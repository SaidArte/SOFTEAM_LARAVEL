<?php

namespace App\Http\Controllers\AMT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class permisosacrificioController extends Controller

{
    public function permisosacrificio(){
        $permisosacrificio = Http::get('http://localhost:3000/PSACRIFICIO/GETALL');
        $permiso = json_decode($permisosacrificio,true);
        //return $permiso;
        return view('AMT.permisosacrificio', compact('permiso'));
    }
}