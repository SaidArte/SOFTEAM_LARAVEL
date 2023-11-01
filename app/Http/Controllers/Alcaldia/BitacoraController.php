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

        $response = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_TBITACORA');
        
        $triggers = $response->json();

        $triggerText = '';

        // Determinar el texto a mostrar
        if(!empty($triggers)){
            $triggerText = 'S';
        }else{
            $triggerText = 'N';
        }

        return view('Alcaldia.bitacora')
            ->with('bitacoraArreglo', $bitacoraArreglo)
            ->with('triggerText', $triggerText);
    }

    public function CrearTriggers(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $ctriggers = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/CREAR-TRIGGERS-USUARIOS');
        if ($ctriggers->successful()) {
            // La solicitud se completó con éxito, puedes manejar la respuesta aquí.
            $data = $ctriggers->json();
        } else {
            // La solicitud falló, puedes manejar el error aquí.
            $error = $ctriggers->json();
        }
    }

    public function EliminarTriggers(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $etriggers = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/ELIMINAR-TRIGGERS-USUARIOS');
        if ($etriggers->successful()) {
            // La solicitud se completó con éxito, puedes manejar la respuesta aquí.
            $data = $etriggers->json();
        } else {
            // La solicitud falló, puedes manejar el error aquí.
            $error = $etriggers->json();
        }
    }
}