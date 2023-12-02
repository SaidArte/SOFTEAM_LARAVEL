<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PSacrificioController extends Controller
{

    const urlapi='http://82.180.133.39:4000/' ;

    public function psacrificio()
{
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
    $psacrificio = Http::withHeaders($headers)->get(self::urlapi.'PSACRIFICIO/GETALL');
    $citaArreglo = json_decode($psacrificio->body(), true);
    // Imprime los datos para verificar si están llegando correctamente


    return view('Alcaldia.psacrificio', compact('citaArreglo'));
    //->with('citaArreglo', $citaArreglo)
    //->width('AnimalArreglo', $AnimalArreglo);
    
}

public function nuevo_psacrificio(Request $request)
{
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
    $nuevo_psacrificio = Http::withHeaders($headers)->post(self::urlapi.'PSACRIFICIO/INSERTAR', [
        "FEC_REG_PSACRIFICIO"   => $request->input("FEC_REG_PSACRIFICIO"),
        "NOM_PERSONA"           => $request->input("NOM_PERSONA"),
        "DNI_PERSONA"           => $request->input("DNI_PERSONA"),
        "TEL_PERSONA"           => $request->input("TEL_PERSONA"),
        "FEC_SACRIFICIO"        => $request->input("FEC_SACRIFICIO"),
        "DIR_PSACRIFICIO"       => $request->input("DIR_PSACRIFICIO"),
        "ANIMAL"            => $request->input("ANIMAL"),
        "COL_ANIMAL"            => $request->input("COL_ANIMAL"),
    ]);

    if ($nuevo_psacrificio->successful()) {
        return redirect('/psacrificio')->with('success', 'Registro creado exitosamente.');
    } else {
        return redirect()->back()->with('error', 'Hubo un problema al crear el registro.');
    }
}


        public function actualizar_psacrificio(Request $request)
        {
            $headers = [
                'Authorization' => 'Bearer ' . Session::get('token'),
            ];
            $actualizar_psacrificio = Http::withHeaders($headers)->put(self::urlapi.'PSACRIFICIO/ACTUALIZAR/'.$request->input("COD_PSACRIFICIO"), [
                "COD_PSACRIFICIO"       => $request->input("COD_PSACRIFICIO"),
                "FEC_REG_PSACRIFICIO"   => $request->input("FEC_REG_PSACRIFICIO"),
                "NOM_PERSONA"           => $request->input("NOM_PERSONA"),
                "DNI_PERSONA"           => $request->input("DNI_PERSONA"),
                "TEL_PERSONA"           => $request->input("TEL_PERSONA"),
                "FEC_SACRIFICIO"        => $request->input("FEC_SACRIFICIO"),
                "DIR_PSACRIFICIO"       => $request->input("DIR_PSACRIFICIO"),
                "ANIMAL"            => $request->input("ANIMAL"),
                "COL_ANIMAL"            => $request->input("COL_ANIMAL"),
            ]);
        
            if ($actualizar_psacrificio->successful()) {
                return redirect('/psacrificio')->with('update_success', 'Datos actualizados exitosamente.');
            } else {
                return redirect('/psacrificio')->with('update_error', 'Error al actualizar los datos.');
            }
        }
       
    
}