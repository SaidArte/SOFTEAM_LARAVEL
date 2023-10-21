<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RolesController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Roles(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $Roles = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_ROLES');
        $citaArreglo = json_decode($Roles->body(), true);
        // Imprime los datos para verificar si están llegando correctamente

        return view('Alcaldia.roles', compact('citaArreglo'));
    }

    public function nuevo_rol(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        //Codigo para que no acepte nombres de roles repetidos
        $rol = $request->input("NOM_ROL");
        $Roles = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_ROLES');

        if ($Roles->successful()){
            $roles_todos = $Roles->json();
    
            foreach ($roles_todos as $roles){
                if ($roles["NOM_ROL"] === $rol){
                    return redirect('/Roles')->with('message', [
                        'type' => 'error',
                        'text' => 'El rol ingresado ya existe.'
                    ])->withInput();
                }
            }
        }

        $nuevo_rol = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_ROLES',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);

        if ($nuevo_rol->successful()){
            $notification = [
                'type' => 'success',
                'title' => '¡Registro exitoso!',
                'message' => 'El rol ha sido ingresado.'
            ];
            return redirect('/Roles')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }

    public function actualizar_rol(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        //Código para verficar si no se ingresa un rol repetido (sin tomar en cuenta el que se edita).
        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_ROLES',[
            "NOM_ROL"  => $request -> input("NOM_ROL"),
        ]);

        $data = $response->json();
        //Se verifica si "$data" no viene vacia, si es realmente un arreglo y si trae mas de una tupla.
        if (!empty($data) && is_array($data) && count($data) > 0) {
            foreach ($data as $roles) { //Hacemos un ciclo para recorrer el arreglo, importante.
                //Aqui vemos si exite el campo "COD_ROL" dentro de "$roles" y luego lo comparamos con el del formulario.
                if (isset($roles['COD_ROL']) && $roles['COD_ROL'] != $request->input("COD_ROL")) {
                    return redirect()->back()->with('error', 'El rol ingresado ya existe.')->withInput();
                }
            }
        }

        $actualizar_rol = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_ROLES',[
            "COD_ROL"  => $request -> input("COD_ROL"),
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);

        if ($actualizar_rol->successful()){
            $notification = [
                'type' => 'success',
                'title' => '¡Registro actualizado!',
                'message' => 'El rol ha sido modificado.'
            ];
            return redirect('/Roles')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }


}