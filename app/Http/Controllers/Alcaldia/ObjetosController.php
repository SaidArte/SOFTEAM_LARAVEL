<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ObjetosController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Objetos(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $Objetos = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_OBJETOS');
        $citaArreglo = json_decode($Objetos->body(), true);
        // Imprime los datos para verificar si están llegando correctamente.

    return view('Alcaldia.Objetos', compact('citaArreglo'));
    }

    public function nuevo_objeto(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $nuevo_objeto = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_OBJETOS',[
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);
        return redirect('/Objetos');

    }

    public function actualizar_objeto(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $actualizar_objeto = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_OBJETOS',[
            "COD_OBJETO"       => $request -> input("COD_OBJETO"),
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);
        return redirect('/Objetos');

    }


}