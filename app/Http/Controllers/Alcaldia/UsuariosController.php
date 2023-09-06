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
        // Imprime los datos para verificar si están llegando correctamente.

        return view('Alcaldia.usuarios')
        ->with('citaArreglo', $citaArreglo)
        ->with('rolesArreglo', $rolesArreglo);
    }

    public function nuevo_usuario(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $nuevo_usuario = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_USUARIOS',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "COD_PERSONA"  => $request -> input("COD_PERSONA"),
            "NOM_USUARIO"   => $request -> input("NOM_USUARIO"),
            "PAS_USUARIO"   => $request -> input("PAS_USUARIO"),
            "IND_USUARIO"   => $request -> input("IND_USUARIO")
        ]);
        return redirect('/Usuarios');

    }

    public function actualizar_usuario(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $actualizar_usuario = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "NOM_USUARIO"   => $request -> input("NOM_USUARIO"),
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "IND_USUARIO"           => $request -> input("IND_USUARIO")
        ]);
        return redirect('/Usuarios');

    }

    public function actualizar_pass_usuarios(Request $request){ //Este código es innesesario.

        $actualizar_pass_usuario = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PASS_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "PAS_USUARIO"       => $request -> input("PAS_USUARIO"),
        ]);
        return redirect('/Usuarios');

    }


}