<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MantenimientosController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Mantenimientos(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $Mantenimientos = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_MANTENIMIENTOS');
        $citaArreglo = json_decode($Mantenimientos->body(), true);
        // Imprime los datos para verificar si están llegando correctamente.

    return view('Alcaldia.mantenimientos', compact('citaArreglo'));
    }

    public function nuevo_mantenimiento(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $nuevo_Mantenimiento = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_MANTENIMIENTOS',[
            "FEC_HR_MANTENIMIENTO"  => $request -> input("FEC_HR_MANTENIMIENTO"),
            "TIP_MANTENIMIENTO"   => $request -> input("TIP_MANTENIMIENTO"),
            "DES_MANTENIMIENTO"   => $request -> input("DES_MANTENIMIENTO"),
            "COD_USUARIO"   => $request -> input("COD_USUARIO"),
            "MON_MANTENIMIENTO"   => $request -> input("MON_MANTENIMIENTO")
        ]);
        return redirect('/mantenimientos');

    }

    public function actualizar_mantenimiento(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $actualizar_Mantenimiento = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_MANTENIMIENTOS',[
            "COD_MANTENIMIENTO"  => $request -> input("COD_MANTENIMIENTO"),
            "FEC_HR_MANTENIMIENTO"   => $request -> input("FEC_HR_MANTENIMIENTO"),
            "TIP_MANTENIMIENTO"   => $request -> input("TIP_MANTENIMIENTO"),
            "DES_MANTENIMIENTO"   => $request -> input("DES_MANTENIMIENTO"),
            "COD_USUARIO"   => $request -> input("COD_USUARIO"),
            "MON_MANTENIMIENTO"   => $request -> input("MON_MANTENIMIENTO")
        ]);
        return redirect('/mantenimientos');

    }

}