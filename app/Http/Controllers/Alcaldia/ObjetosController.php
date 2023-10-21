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

    return view('Alcaldia.objetos', compact('citaArreglo'));
    }

    public function nuevo_objeto(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        //Codigo para que no acepte nombres de objetos repetidos
        $objeto = $request->input("OBJETO");
        $objetos = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_OBJETOS');

        if ($objetos->successful()){
            $objetos_todos = $objetos->json();
    
            foreach ($objetos_todos as $ob){
                if ($ob["OBJETO"] === $objeto){
                    return redirect('/Objetos')->with('message', [
                        'type' => 'error',
                        'text' => 'El objeto ingresado ya existe.'
                    ])->withInput();
                }
            }
        }
        $nuevo_objeto = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_OBJETOS',[
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);

        if ($nuevo_objeto->successful()){
            $notification = [
                'type' => 'success',
                'title' => '¡Registro exitoso!',
                'message' => 'El objeto ha sido ingresado.'
            ];
            return redirect('/Objetos')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }

    public function actualizar_objeto(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        //Codigo para que no acepte nombres de objetos repetidos.
        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_OBJETOS',[
            "OBJETO"  => $request -> input("OBJETO"),
        ]);

        $data = $response->json();
        //Se verifica si "$data" no viene vacia, si es realmente un arreglo y si trae mas de una tupla.
        if (!empty($data) && is_array($data) && count($data) > 0) {
            foreach ($data as $objetos) { //Hacemos un ciclo para recorrer el arreglo, importante.
                //Aqui vemos si exite el campo "COD_OBJETO" dentro de "$objetos" y luego lo comparamos con el del formulario.
                if (isset($objetos['COD_OBJETO']) && $objetos['COD_OBJETO'] != $request->input("COD_OBJETO")) {
                    return redirect()->back()->with('error', 'El objeto ingresado ya existe.')->withInput();
                }
            }
        }

        $actualizar_objeto = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_OBJETOS',[
            "COD_OBJETO"       => $request -> input("COD_OBJETO"),
            "OBJETO"  => $request -> input("OBJETO"),
            "DES_OBJETO"   => $request -> input("DES_OBJETO"),
            "TIP_OBJETO"   => $request -> input("TIP_OBJETO")
        ]);

        if ($actualizar_objeto->successful()){
            $notification = [
                'type' => 'success',
                'title' => '¡Registro actualizado!',
                'message' => 'El objeto ha sido modificado.'
            ];
            return redirect('/Objetos')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }


}