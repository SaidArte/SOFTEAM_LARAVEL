<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PermisosController extends Controller
{

    public function Permisos(){
    $Permisos = Http::get('http://localhost:3000/SEGURIDAD/GETALL_PERMISOS');
    $citaArreglo = json_decode($Permisos->body(), true);
    $roles = Http::get('http://localhost:3000/SEGURIDAD/GETALL_ROLES');
    $rolesArreglo = json_decode($roles->body(), true);
    $objetos = Http::get('http://localhost:3000/SEGURIDAD/GETALL_OBJETOS');
    $objetosArreglo = json_decode($objetos->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    //return view('Alcaldia.Permisos', compact('citaArreglo'));
    return view('Alcaldia.Permisos')
    ->with('citaArreglo', $citaArreglo)
    ->with('rolesArreglo', $rolesArreglo)
    ->with('objetosArreglo', $objetosArreglo); 
    }

    public function nuevo_permiso(Request $request){

        $nuevo_permiso = Http::post('http://localhost:3000/SEGURIDAD/INSERTAR_PERMISOS',[
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "OBJETO"   => $request -> input("OBJETO"),
            "PRM_INSERTAR"   => $request -> input("PRM_INSERTAR"),
            "PRM_ACTUALIZAR"   => $request -> input("PRM_ACTUALIZAR"),
            "PRM_CONSULTAR"   => $request -> input("PRM_CONSULTAR")
        ]);
        return redirect('/Permisos');

    }

    public function actualizar_permiso(Request $request){

        $actualizar_permiso = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_PERMISOS',[
            "COD_ROL"  => $request -> input("COD_ROL"),
            "COD_OBJETO"   => $request -> input("COD_OBJETO"),
            "PRM_INSERTAR"   => $request -> input("PRM_INSERTAR"),
            "PRM_ACTUALIZAR"   => $request -> input("PRM_ACTUALIZAR"),
            "PRM_CONSULTAR"   => $request -> input("PRM_CONSULTAR")
        ]);
        return redirect('/Permisos');

    }

    /*public function eliminar_permiso(Request $request, $id){

        $eliminar_permiso = Http::delete('http://localhost:3000/SEGURIDAD/ELIMINAR_PERMISOS/' . $id);
        return redirect('/Permisos');
    } */


}