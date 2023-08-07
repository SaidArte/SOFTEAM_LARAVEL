<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ObjetosController extends Controller
{

    public function Objetos(){
    $Objetos = Http::get('http://localhost:3000/SEGURIDAD/GETALL_OBJETOS');
    $citaArreglo = json_decode($Objetos->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Objetos', compact('citaArreglo'));
    }

    public function nuevo_objeto(Request $request){

        $nuevo_objeto = Http::post('http://localhost:3000/SEGURIDAD/INSERTAR_OBJETOS',[
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);
        return redirect('/Objetos');

    }

    public function actualizar_objeto(Request $request){

        $actualizar_objeto = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_OBJETOS',[
            "COD_OBJETO"       => $request -> input("COD_OBJETO"),
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);
        return redirect('/Objetos');

    }

    /*public function eliminar_objeto(Request $request, $id){

        $eliminar_objeto = Http::delete('http://localhost:3000/SEGURIDAD/ELIMINAR_OBJETO/' . $id);
        return redirect('/Objetos');
    } */


}