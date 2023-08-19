<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PreguntasController extends Controller
{

    public function Preguntas(){
    $Preguntas = Http::get('http://localhost:3000/SEGURIDAD/GETALL_PREGUNTAS');
    $PreguntasArreglo = json_decode($Preguntas->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Preguntas', compact('PreguntasArreglo'));
    }

    public function nueva_pregunta(Request $request){

        $nuevo_pregunta = Http::post('http://localhost:3000/SEGURIDAD/INSERTAR_PREGUNTAS',[
            "PREGUNTA"    => $request -> input("PREGUNTA")
        ]);
        return redirect('/Preguntas');

    }

    public function actualizar_pregunta(Request $request){

        $actualizar_pregunta = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_PREGUNTAS',[
            "COD_PREGUNTA"       => $request -> input("COD_PREGUNTA"),
            "PREGUNTA"    => $request -> input("PREGUNTA")
        ]);
        return redirect('/Preguntas');

    }

    /*public function eliminar_usuario(Request $request, $id){

        $eliminar_psacrificio = Http::delete('http://localhost:3000/SEGURIDAD/ELIMINAR_USUARIO/' . $id);
        return redirect('/Usuarios');
    } */


}