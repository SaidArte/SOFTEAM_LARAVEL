<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RespuestasController extends Controller
{

    public function Respuestas(){
        $Respuestas = Http::get('http://localhost:3000/SEGURIDAD/GETONE_RESPUESTAS');
        $citaArreglo = json_decode($Respuestas->body(), true);
        // Imprime los datos para verificar si están llegando correctamente
        // dd($citaArreglo);

        return view('Alcaldia.Respuestas', compact('citaArreglo'));
    }

    public function actualizar_respuesta(Request $request){

        $actualizar_respuesta = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_RESPUESTAS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "PREGUNTA"  => $request -> input("PREGUNTA"),
            "RESPUESTA"   => $request -> input("RESPUESTA"),
        ]);
        return redirect('/Respuestas');
    }

    /*public function eliminar_respuesta(Request $request, $id){

        $eliminar_respuesta = Http::delete('http://localhost:3000/SEGURIDAD/ELIMINAR_RESPUESTA/' . $id);
        return redirect('/Respuestas');
    } */


}