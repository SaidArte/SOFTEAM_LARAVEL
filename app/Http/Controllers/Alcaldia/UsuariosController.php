<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UsuariosController extends Controller
{

    public function Usuarios(){
    $Usuarios = Http::get('http://localhost:3000/SEGURIDAD/GETALL_USUARIOS');
    $citaArreglo = json_decode($Usuarios->body(), true);
    $roles = Http::get('http://localhost:3000/SEGURIDAD/GETALL_ROLES');
    $rolesArreglo = json_decode($roles->body(), true);
    $preguntas = Http::get('http://localhost:3000/SEGURIDAD/GETALL_PREGUNTAS');
    $preguntasArreglo = json_decode($preguntas->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Usuarios')
    ->with('citaArreglo', $citaArreglo)
    ->with('rolesArreglo', $rolesArreglo)
    ->with('preguntasArreglo', $preguntasArreglo);
    }

    public function nuevo_usuario(Request $request){

        $nuevo_usuario = Http::post('http://localhost:3000/SEGURIDAD/INSERTAR_USUARIOS',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "COD_PERSONA"  => $request -> input("COD_PERSONA"),
            "NOM_USUARIO"   => $request -> input("NOM_USUARIO"),
            "PAS_USUARIO"   => $request -> input("PAS_USUARIO"),
            "IND_USUARIO"   => $request -> input("IND_USUARIO"),
            "FEC_VENCIMIENTO"    => $request -> input("FEC_VENCIMIENTO"),
            "PREGUNTA"    => $request -> input("PREGUNTA"),
            "RESPUESTA"   => $request -> input("RESPUESTA")
        ]);
        return redirect('/Usuarios');

    }

    public function actualizar_usuario(Request $request){

        $actualizar_usuario = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "NOM_USUARIO"   => $request -> input("NOM_USUARIO"),
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "IND_USUARIO"           => $request -> input("IND_USUARIO"),
            "FEC_VENCIMIENTO"       => $request -> input("FEC_VENCIMIENTO")
        ]);
        return redirect('/Usuarios');

    }

    public function actualizar_pass_usuarios(Request $request){ //Este código es innesesario.

        $actualizar_pass_usuario = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_PASS_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "PAS_USUARIO"       => $request -> input("PAS_USUARIO"),
        ]);
        return redirect('/Usuarios');

    }


}