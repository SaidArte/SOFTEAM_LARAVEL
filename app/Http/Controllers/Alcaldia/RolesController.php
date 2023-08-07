<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RolesController extends Controller
{

    public function Roles(){
    $Roles = Http::get('http://localhost:3000/SEGURIDAD/GETALL_ROLES');
    $citaArreglo = json_decode($Roles->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.Roles', compact('citaArreglo'));
    }

    public function nuevo_rol(Request $request){

        $nuevo_rol = Http::post('http://localhost:3000/SEGURIDAD/INSERTAR_ROLES',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);
        return redirect('/Roles');

    }

    public function actualizar_rol(Request $request){

        $actualizar_rol = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_ROLES',[
            "COD_ROL"  => $request -> input("COD_ROL"),
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);
        return redirect('/Roles');

    }

    /*public function eliminar_rol(Request $request, $id){

        $eliminar_rol = Http::delete('http://localhost:3000/SEGURIDAD/ELIMINAR_ROL/' . $id);
        return redirect('/Roles');
    } */


}