<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PTrasladoController extends Controller
{

    const urlapi='http://82.180.133.39:4000/' ;

    public function ptraslado(){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];

  // Obtener los datos de personas desde el controlador PersonasController
   $personasController = new PersonasController();
   $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
   $personasArreglo = json_decode($personas, true);

    $ptraslado = Http::withHeaders($headers)->get(self::urlapi.'PTRASLADO/GETALL');
    $citaArreglo = json_decode($ptraslado->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.ptraslado', compact('citaArreglo', 'personasArreglo'));
    }

    //Con esta funcion se podrán insertar nuevos Permisos de Traslado
    public function nuevo_PermisoTraslado(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $nuevo_PermisoTraslado = Http::withHeaders($headers)->post(self::urlapi.'PTRASLADO/INSERTAR',[
            "FEC_TRASLADO" => $request -> input("FEC_TRASLADO"),
            "COD_PERSONA" => $request -> input("COD_PERSONA"),            
            "DIR_ORIG_PTRASLADO" => $request -> input("DIR_ORIG_PTRASLADO"),
            "DIR_DEST_TRASLADO" => $request -> input("DIR_DEST_TRASLADO"),
            "NOM_TRANSPORTISTA" => $request -> input("NOM_TRANSPORTISTA"),
            "DNI_TRANSPORTISTA"=> $request -> input("DNI_TRANSPORTISTA"),
            "TEL_TRANSPORTISTA"=> $request -> input( "TEL_TRANSPORTISTA"),
            "MAR_VEHICULO"=> $request -> input("MAR_VEHICULO"),
            "MOD_VEHICULO"=> $request -> input("MOD_VEHICULO"),
            "MAT_VEHICULO"=> $request -> input("MAT_VEHICULO"),
            "COL_VEHICULO"=> $request -> input("COL_VEHICULO"),
            "MON_TRASLADO"=> $request -> input("MON_TRASLADO"),
            "COD_FIERRO"=> $request -> input("COD_FIERRO"),
            "CAN_GANADO"=> $request -> input("CAN_GANADO"),
        ]);
        return redirect('/ptraslado');
    }

   //La siguiente funcion permite actualizar los permisos de traslado

   public function actualizar_PermisoTraslado(Request $request){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
            
    $actualizar_PermisoTraslado = Http::withHeaders($headers)->put(self::urlapi.'PTRASLADO/ACTUALIZAR/',[
        "COD_PTRASLADO" => $request -> input("COD_PTRASLADO"),

        "FEC_TRASLADO" => $request -> input("FEC_TRASLADO"),
        "COD_PERSONA" => $request -> input("COD_PERSONA"),
        "DIR_ORIG_PTRASLADO" => $request -> input("DIR_ORIG_PTRASLADO"),
        "DIR_DEST_TRASLADO" => $request -> input("DIR_DEST_TRASLADO"),
        "NOM_TRANSPORTISTA" => $request -> input("NOM_TRANSPORTISTA"),
        "DNI_TRANSPORTISTA"=> $request -> input("DNI_TRANSPORTISTA"),
        "TEL_TRANSPORTISTA"=> $request -> input( "TEL_TRANSPORTISTA"),
        "MAR_VEHICULO"=> $request -> input("MAR_VEHICULO"),
        "MOD_VEHICULO"=> $request -> input("MOD_VEHICULO"),
        "MAT_VEHICULO"=> $request -> input("MAT_VEHICULO"),
        "COL_VEHICULO"=> $request -> input("COL_VEHICULO"),
        "MON_TRASLADO"=> $request -> input("MON_TRASLADO"),
    
    ]);
    return redirect('/ptraslado');
}

}