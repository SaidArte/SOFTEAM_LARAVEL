<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ObjetosController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Objetos(){
    $Objetos = Http::get(self::urlapi.'SEGURIDAD/GETALL_OBJETOS');
    $citaArreglo = json_decode($Objetos->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Objetos', compact('citaArreglo'));
    }

    public function nuevo_objeto(Request $request){

        $nuevo_objeto = Http::post(self::urlapi.'SEGURIDAD/INSERTAR_OBJETOS',[
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);
        return redirect('/Objetos');

    }

    public function actualizar_objeto(Request $request){

        $actualizar_objeto = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_OBJETOS',[
            "COD_OBJETO"       => $request -> input("COD_OBJETO"),
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);
        return redirect('/Objetos');

    }


}