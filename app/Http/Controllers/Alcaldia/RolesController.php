<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RolesController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Roles(){
    $Roles = Http::get(self::urlapi.'SEGURIDAD/GETALL_ROLES');
    $citaArreglo = json_decode($Roles->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Roles', compact('citaArreglo'));
    }

    public function nuevo_rol(Request $request){

        $nuevo_rol = Http::post(self::urlapi.'SEGURIDAD/INSERTAR_ROLES',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);
        return redirect('/Roles');

    }

    public function actualizar_rol(Request $request){

        $actualizar_rol = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_ROLES',[
            "COD_ROL"  => $request -> input("COD_ROL"),
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);
        return redirect('/Roles');

    }


}