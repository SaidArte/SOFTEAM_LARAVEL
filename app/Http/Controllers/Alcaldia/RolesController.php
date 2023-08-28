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

        $nuevo_rol = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_ROLES',[
            "NOM_ROL"   => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);
        return redirect('/roles');

    }

    public function actualizar_rol(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $actualizar_rol = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_ROLES',[
            "COD_ROL"  => $request -> input("COD_ROL"),
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "DES_ROL"  => $request -> input("DES_ROL")
        ]);
        return redirect('/roles');

    }


}