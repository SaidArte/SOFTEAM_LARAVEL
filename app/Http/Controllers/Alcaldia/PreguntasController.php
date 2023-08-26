<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PreguntasController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Preguntas(){
    $Preguntas = Http::get(self::urlapi.'SEGURIDAD/GETALL_PREGUNTAS');
    $PreguntasArreglo = json_decode($Preguntas->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Preguntas', compact('PreguntasArreglo'));
    }

    public function nueva_pregunta(Request $request){

        $nuevo_pregunta = Http::post(self::urlapi.'SEGURIDAD/INSERTAR_PREGUNTAS',[
            "PREGUNTA"    => $request -> input("PREGUNTA")
        ]);
        return redirect('/Preguntas');

    }

    public function actualizar_pregunta(Request $request){

        $actualizar_pregunta = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PREGUNTAS',[
            "COD_PREGUNTA"       => $request -> input("COD_PREGUNTA"),
            "PREGUNTA"    => $request -> input("PREGUNTA")
        ]);
        return redirect('/Preguntas');

    }


}