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
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Usuarios', compact('citaArreglo'));
    }

    public function nuevo_usuario(Request $request){

        $nuevo_usuario = Http::post('http://localhost:3000/SEGURIDAD/INSERTAR_USUARIOS',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "COD_PERSONA"  => $request -> input("COD_PERSONA"),
            "PAS_USUARIO"   => $request -> input("PAS_USUARIO"),
            "IND_USUARIO"   => $request -> input("IND_USUARIO"),
            "LIM_INTENTOS"   => $request -> input("LIM_INTENTOS"),
            "NUM_INTENTOS_FALLIDOS"    => $request -> input("NUM_INTENTOS_FALLIDOS"),
            "FEC_VENCIMIENTO"    => $request -> input("FEC_VENCIMIENTO"),
            "PREGUNTA"    => $request -> input("PREGUNTA"),
            "RESPUESTA"   => $request -> input("RESPUESTA")
        ]);
        return redirect('/Usuarios');

    }

    public function actualizar_usuario(Request $request){

        $actualizar_usuario = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "IND_USUARIO"           => $request -> input("IND_USUARIO"),
            "FEC_ULTIMO_CAMBIO"           => $request -> input("FEC_ULTIMO_CAMBIO"),
            "FEC_ULTIMO_ACCESO"           => $request -> input("FEC_ULTIMO_ACCESO"),
            "LIM_INTENTOS"        => $request -> input("LIM_INTENTOS"),
            "NUM_INTENTOS_FALLIDOS"            => $request -> input("NUM_INTENTOS_FALLIDOS"),
            "FEC_VENCIMIENTO"       => $request -> input("FEC_VENCIMIENTO")
        ]);
        return redirect('/Usuarios');

    }

    public function actualizar_pass_usuarios(Request $request){

        $actualizar_pass_usuario = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_PASS_USUARIOS',[
            "COD_USUARIO"       => $request -> input("COD_USUARIO"),
            "PAS_USUARIO"       => $request -> input("PAS_USUARIO"),
        ]);
        return redirect('/Usuarios');

    }

    /*public function eliminar_usuario(Request $request, $id){

        $eliminar_psacrificio = Http::delete('http://localhost:3000/SEGURIDAD/ELIMINAR_USUARIO/' . $id);
        return redirect('/Usuarios');
    } */


}