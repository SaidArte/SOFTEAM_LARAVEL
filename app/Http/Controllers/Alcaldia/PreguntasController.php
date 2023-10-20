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

    public function nueva_pregunta(Request $request) {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
    
        $pregunta = $request->input("PREGUNTA");
    
        $pregunta = "¿" . $pregunta . "?";  // Se utilizan puntos (.) para concatenar cadenas.

        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_PREGUNTAS',[
            "PREGUNTA"       => $pregunta,
        ]);

        $data = $response->json();
        if (!empty($data)) {
            return redirect()->back()->with('error', 'Esta pregunta ya está registrada.')->withInput();
        }
    
        $nueva_pregunta = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_PREGUNTAS', [
            "PREGUNTA" => $pregunta,
        ]);

        if ($nueva_pregunta->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro exitoso!',
                'message' => 'La pregunta ha sido guardada.'
            ];
            return redirect('/Preguntas')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }    

    public function actualizar_pregunta(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $pregunta = $request->input("PREGUNTAE");

        $pregunta = "¿" . $pregunta . "?";  // Se utilizan puntos (.) para concatenar cadenas.

        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_PREGUNTAS',[
            "PREGUNTA"       => $pregunta,
        ]);

        $data = $response->json();
        if (!empty($data)) {
            return redirect()->back()->with('error', 'Esta pregunta ya está registrada.')->withInput();
        }

        $actualizar_pregunta = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PREGUNTAS',[
            "COD_PREGUNTA"       => $request -> input("COD_PREGUNTA"),
            "PREGUNTA"    => $pregunta,
        ]);

        
        if ($actualizar_pregunta->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro actualizado!',
                'message' => 'La pregunta ha sido modificada.'
            ];
            return redirect('/Preguntas')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }

    }


}