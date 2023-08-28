<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PreguntasController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Preguntas(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $Preguntas = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_PREGUNTAS');
        $PreguntasArreglo = json_decode($Preguntas->body(), true);
        // Imprime los datos para verificar si están llegando correctamente

        return view('Alcaldia.preguntas', compact('PreguntasArreglo'));
    }

    public function nueva_pregunta(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $nuevo_pregunta = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_PREGUNTAS',[
            "PREGUNTA"    => $request -> input("PREGUNTA")
        ]);
        return redirect('/preguntas');

    }

    public function actualizar_pregunta(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $actualizar_pregunta = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PREGUNTAS',[
            "COD_PREGUNTA"       => $request -> input("COD_PREGUNTA"),
            "PREGUNTA"    => $request -> input("PREGUNTA")
        ]);
        return redirect('/preguntas');

    }


}