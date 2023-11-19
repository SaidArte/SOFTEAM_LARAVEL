<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ParametrosController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Parametros(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $parametros = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_PARAMETROS');
        $parametrosArreglo = json_decode($parametros->body(), true);
        // Imprime los datos para verificar si están llegando correctamente.

        return view('Alcaldia.parametros')
        ->with('parametrosArreglo', $parametrosArreglo);
    }

    public function nuevo_parametros(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $NOM_USUARIO = Session::get('user_data')['NOM_USUARIO'];

        //Probamos que el nombre de usuario no este registrado.
        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_PARAMETROS', [
            'PARAMETRO' => $request -> input("PARAMETRO")
        ]);

        $data = $response->json();

        if (!empty($data)) {
            return redirect()->back()->with('error', 'El nombre de este parámetro ya está registrado. Favor, ingrese uno diferente.')->withInput();
        }

        $nuevo_param = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_PARAMETROS',[
            "PARAMETRO" => $request -> input("PARAMETRO"),
            "DES_PARAMETRO" => $request -> input("DES_PARAMETRO"),
            "VALOR" => $request -> input("VALOR"),
            "USUARIO_CREADOR" => $NOM_USUARIO
        ]);

        if ($nuevo_param->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro exitoso!',
                'message' => 'El parámetro ha sido ingresado.'
            ];
            return redirect('/Parametros')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }

    }

    public function actualizar_parametros(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $NOM_USUARIO = Session::get('user_data')['NOM_USUARIO'];

        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_PARAMETROS',[
            "PARAMETRO"  => $request -> input("PARAMETRO"),
        ]);

        $data = $response->json();
        //Se verifica si "$data" no viene vacia, si es realmente un arreglo y si trae mas de una tupla.
        if (!empty($data) && is_array($data) && count($data) > 0) {
            foreach ($data as $parametros) { //Hacemos un ciclo para recorrer el arreglo, importante.
                //Aqui vemos si exite el campo "PARAMETRO" dentro de "$parametros" y luego lo comparamos con el del formulario.
                if (isset($parametros['PARAMETRO']) && $parametros['PARAMETRO'] != $request->input("PARAMETRO")) {
                    return redirect()->back()->with('error', 'El parámetro ingresado ya existe.')->withInput();
                }
            }
        }

        $actualizar_param = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PARAMETROS',[   
            "COD_PARAMETRO"       => $request -> input("COD_PARAMETRO"),
            "PARAMETRO"   => $request -> input("PARAMETRO"),
            "DES_PARAMETRO"   => $request -> input("DES_PARAMETRO"),
            "VALOR"           => $request -> input("VALOR"),
            "USUARIO_MODIFICADOR"           => $NOM_USUARIO
        ]);

        if ($actualizar_param->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro actualizado!',
                'message' => 'El parámetro ha sido modificado.'
            ];
            return redirect('/Parametros')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }
}