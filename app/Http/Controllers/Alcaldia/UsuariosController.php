<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UsuariosController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Usuarios(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $Usuarios = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_USUARIOS');
        $citaArreglo = json_decode($Usuarios->body(), true);
        $roles = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_ROLES');
        $rolesArreglo = json_decode($roles->body(), true);
        $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
        $personasArreglo = json_decode($personas->body(), true);
        // Imprime los datos para verificar si están llegando correctamente.

        return view('Alcaldia.usuarios')
        ->with('citaArreglo', $citaArreglo)
        ->with('rolesArreglo', $rolesArreglo)
        ->with('personasArreglo', $personasArreglo);
    }

    public function nuevo_usuario(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $codPersona = $request -> input('COD_PERSONA');

        //Probamos que el nombre de usuario no este registrado.
        $response = Http::post(self::urlapi.'SEGURIDAD/GETONE_USUARIOS', [
            "NOM_USUARIO" => $request -> input("NOM_USUARIO")
        ]);

        $data = $response->json();
        if (!empty($data)) {
            return redirect()->back()->with('error', 'Este nombre de usuario ya está registrado. Favor, ingrese uno diferente.')->withInput();
        }

        //Probamos que la persona no tenga ya un usuario.
        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_PERSONA-USUARIOS',[
            'COD_PERSONA' => $codPersona,
        ]);

        $data = $response->json();
        if (!empty($data)) {
            return redirect()->back()->with('error', 'Esta persona ya tiene un usuario registrado.')->withInput();
        }

        //Probamos que la persona este debidamente registrada.
        $response = Http::withHeaders($headers)->post(self::urlapi.'PERSONAS/GETONE',[
            'COD_PERSONA' => $codPersona,
        ]);

        $data = $response->json();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Este código de persona no existe en la base de datos.')->withInput();
        }

        $nuevo_usuario = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_USUARIOS',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "COD_PERSONA"  => $request -> input("COD_PERSONA"),
            "NOM_USUARIO"   => $request -> input("NOM_USUARIO"),
            "PAS_USUARIO"   => $request -> input("PAS_USUARIO"),
            "IND_USUARIO"   => $request -> input("IND_USUARIO")
        ]);

        if ($nuevo_usuario->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro exitoso!',
                'message' => 'El usuario ha sido ingresado.'
            ];
            return redirect('/Usuarios')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }

    }

    public function actualizar_usuario(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $response = Http::post(self::urlapi.'SEGURIDAD/GETONE_USUARIOS', [
            "NOM_USUARIO" => $request -> input("NOM_USUARIO")
        ]);

        $data = $response->json();
        //Se verifica si "$data" no viene vacia, si es realmente un arreglo y si trae mas de una tupla.
        if (!empty($data) && is_array($data) && count($data) > 0) {
            foreach ($data as $usuario) { //Hacemos un ciclo para recorrer el arreglo, importante.
                //Aqui vemos si exite el campo "COD_USUARIO" dentro de "$usuario" y luego lo comparamos con el del formulario.
                if (isset($usuario['COD_USUARIO']) && $usuario['COD_USUARIO'] != $request->input("COD_USUARIO")) {
                    return redirect()->back()->with('error', 'Este nombre de usuario ya está registrado. Favor, ingrese uno diferente.')->withInput();
                }
            }
        }

        $actualizar_usuario = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "NOM_USUARIO"   => $request -> input("NOM_USUARIO"),
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "IND_USUARIO"           => $request -> input("IND_USUARIO")
        ]);

        if ($actualizar_usuario->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro actualizado!',
                'message' => 'El usuario ha sido modificado.'
            ];
            return redirect('/Usuarios')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }

    public function actualizar_pass_usuarios(Request $request){ //Este código es innesesario.

        $actualizar_pass_usuario = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PASS_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "PAS_USUARIO"       => $request -> input("PAS_USUARIO"),
        ]);
        return redirect('/Usuarios');

    }


}