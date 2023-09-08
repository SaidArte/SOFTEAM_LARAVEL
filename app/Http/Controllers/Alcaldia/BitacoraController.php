<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BitacoraController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Bitacora(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $Bitacora = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_BITACORA');
        $bitacoraArreglo = json_decode($Bitacora->body(), true);
        // Imprime los datos para verificar si están llegando correctamente.

        return view('Alcaldia.bitacora')
        ->with('bitacoraArreglo', $bitacoraArreglo);
    }


}