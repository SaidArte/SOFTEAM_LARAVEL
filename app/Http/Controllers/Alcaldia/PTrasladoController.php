<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PtrasladoController extends Controller
{

    public function PTraslado(){
    $PTraslado = Http::get('http://localhost:3000/PTRASLADO/GETALL');
    $citaArreglo = json_decode($PTraslado->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.PTraslado', compact('citaArreglo'));
    }

    //Con esta funcion se podrán insertar nuevos Permisos de Traslado
    public function nuevo_PermisoTraslado(Request $request){
            
        $nuevo_PermisoTraslado = Http::post('http://localhost:3000/PTRASLADO/INSERTAR',[
            "FEC_REG_TRASLADO" => $request -> input("FEC_REG_TRASLADO"),
            "FEC_TRASLADO" => $request -> input("FEC_TRASLADO"),
            "COD_PERSONA" => $request -> input("COD_PERSONA"),
            "DIR_ORIG_PTRASLADO" => $request -> input("DIR_ORIG_PTRASLADO"),
            "DIR_DEST_TRASLADO" => $request -> input("DIR_DEST_TRASLADO"),
            "NOM_TRASNPORTISTA" => $request -> input("NOM_TRASNPORTISTA"),
            "DNI_TRANSPORTISTA"=> $request -> input("DNI_TRANSPORTISTA"),
            "TEL_TRANSPORTISTA"=> $request -> input( "TEL_TRANSPORTISTA"),
            "MAR_VEHICULO"=> $request -> input("MAR_VEHICULO"),
            "MOD_VEHICULO"=> $request -> input("MOD_VEHICULO"),
            "MAT_VEHICULO"=> $request -> input("MAT_VEHICULO"),
            "COL_VEHICULO"=> $request -> input("COL_VEHICULO"),
            "MON_TRASLADO"=> $request -> input("MON_TRASLADO"),
            "COD_DTRASLADO"=> $request -> input("COD_DTRASLADO"),
            "COD_FIERRO"=> $request -> input("COD_FIERRO"),
            "CAN_GANADO"=> $request -> input("CAN_GANADO"),
        ]);
        return readirect('\PTraslado');
    }

   //La siguiente funcion permite actualizar los permisos de traslado

   public function actualizar_PermisoTraslado(Request $request){
            
    $actualizar_PermisoTraslado = Http::put('http://localhost:3000/PTRASLADO/ACTUALIZAR/'.$request->input("COD_PTRASLADO"),[
        "COD_PTRASLADO" => $request -> input("COD_PTRASLADO"),
        "FEC_REG_TRASLADO" => $request -> input("FEC_REG_TRASLADO"),
        "FEC_TRASLADO" => $request -> input("FEC_TRASLADO"),
        "COD_PERSONA" => $request -> input("COD_PERSONA"),
        "DIR_ORIG_PTRASLADO" => $request -> input("DIR_ORIG_PTRASLADO"),
        "DIR_DEST_TRASLADO" => $request -> input("DIR_DEST_TRASLADO"),
        "NOM_TRASNPORTISTA" => $request -> input("NOM_TRASNPORTISTA"),
        "DNI_TRANSPORTISTA"=> $request -> input("DNI_TRANSPORTISTA"),
        "TEL_TRANSPORTISTA"=> $request -> input( "TEL_TRANSPORTISTA"),
        "MAR_VEHICULO"=> $request -> input("MAR_VEHICULO"),
        "MOD_VEHICULO"=> $request -> input("MOD_VEHICULO"),
        "MAT_VEHICULO"=> $request -> input("MAT_VEHICULO"),
        "COL_VEHICULO"=> $request -> input("COL_VEHICULO"),
        "MON_TRASLADO"=> $request -> input("MON_TRASLADO"),
        "COD_DTRASLADO"=> $request -> input("COD_DTRASLADO"),
        "COD_FIERRO"=> $request -> input("COD_FIERRO"),
        "CAN_GANADO"=> $request -> input("CAN_GANADO"),
    ]);
    return readirect('\PTraslado');
}
}