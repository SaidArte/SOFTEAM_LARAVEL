<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PermisosController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function Permisos(){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $Permisos = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_PERMISOS');
        $citaArreglo = json_decode($Permisos->body(), true);
        $roles = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_ROLES');
        $rolesArreglo = json_decode($roles->body(), true);
        $objetos = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_OBJETOS');
        $objetosArreglo = json_decode($objetos->body(), true);
        // Imprime los datos para verificar si están llegando correctamente

        //return view('Alcaldia.Permisos', compact('citaArreglo'));
        return view('Alcaldia.permisos')
        ->with('citaArreglo', $citaArreglo)
        ->with('rolesArreglo', $rolesArreglo)
        ->with('objetosArreglo', $objetosArreglo);                          
    }

    public function nuevo_permiso(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        //Probamos si ya hay un conjunto de permisos igual.
        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_SOLOPERMISOS',[
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "OBJETO"   => $request -> input("OBJETO"),
        ]);

        $data = $response->json();
        if (!empty($data)) {
            return redirect()->back()->with('error', 'Este conjunto de permisos ya existe.')->withInput();
        }

        $nuevo_permiso = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/INSERTAR_PERMISOS',[
            "NOM_ROL"  => $request -> input("NOM_ROL"),
            "OBJETO"   => $request -> input("OBJETO"),
            "PRM_INSERTAR"   => $request -> input("PRM_INSERTAR"),
            "PRM_ACTUALIZAR"   => $request -> input("PRM_ACTUALIZAR"),
            "PRM_CONSULTAR"   => $request -> input("PRM_CONSULTAR")
        ]);

        if ($nuevo_permiso->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro exitoso!',
                'message' => 'El conjunto de permisos ha sido registrado.'
            ];
            return redirect('/Permisos')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }

    public function actualizar_permiso(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $actualizar_permiso = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PERMISOS',[
            "COD_ROL"  => $request -> input("COD_ROL"),
            "COD_OBJETO"   => $request -> input("COD_OBJETO"),
            "PRM_INSERTAR"   => $request -> input("PRM_INSERTAR"),
            "PRM_ACTUALIZAR"   => $request -> input("PRM_ACTUALIZAR"),
            "PRM_CONSULTAR"   => $request -> input("PRM_CONSULTAR")
        ]);

        if ($actualizar_permiso->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Registro actualizado!',
                'message' => 'El conjunto de permisos ha sido modificado.'
            ];
            return redirect('/Permisos')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }
}