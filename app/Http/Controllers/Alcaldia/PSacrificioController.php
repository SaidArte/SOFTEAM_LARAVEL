<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PSacrificioController extends Controller
{

    const urlapi='http://localhost:3000/';

    public function psacrificio()
{
    $psacrificio = Http::get(self::urlapi.'PSACRIFICIO/GETALL');
    $citaArreglo = json_decode($psacrificio->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);
    $animalController = new AnimalController();
    $Animal = Http::get(self::urlapi.'ANIMAL/GETALL');
    $AnimalArreglo = json_decode($Animal->body(), true);

    return view('Alcaldia.psacrificio', compact('citaArreglo', 'AnimalArreglo'));
    //->with('citaArreglo', $citaArreglo)
    //->width('AnimalArreglo', $AnimalArreglo);
    
}

public function nuevo_psacrificio(Request $request)
{
    $nuevo_psacrificio = Http::post(self::urlapi.'PSACRIFICIO/INSERTAR', [
        "FEC_REG_PSACRIFICIO"   => $request->input("FEC_REG_PSACRIFICIO"),
        "NOM_PERSONA"           => $request->input("NOM_PERSONA"),
        "DNI_PERSONA"           => $request->input("DNI_PERSONA"),
        "TEL_PERSONA"           => $request->input("TEL_PERSONA"),
        "FEC_SACRIFICIO"        => $request->input("FEC_SACRIFICIO"),
        "COD_ANIMAL"            => $request->input("COD_ANIMAL"),
        "DIR_PSACRIFICIO"       => $request->input("DIR_PSACRIFICIO"),
    ]);

    if ($nuevo_psacrificio->successful()) {
        return redirect('/psacrificio')->with('success', 'Registro creado exitosamente.');
    } else {
        return redirect()->back()->with('error', 'Hubo un problema al crear el registro.');
    }
}


        public function actualizar_psacrificio(Request $request)
        {
            $actualizar_psacrificio = Http::put(self::urlapi.'PSACRIFICIO/ACTUALIZAR/'.$request->input("COD_PSACRIFICIO"), [
                "COD_PSACRIFICIO"       => $request->input("COD_PSACRIFICIO"),
                "FEC_REG_PSACRIFICIO"   => $request->input("FEC_REG_PSACRIFICIO"),
                "NOM_PERSONA"           => $request->input("NOM_PERSONA"),
                "DNI_PERSONA"           => $request->input("DNI_PERSONA"),
                "TEL_PERSONA"           => $request->input("TEL_PERSONA"),
                "FEC_SACRIFICIO"        => $request->input("FEC_SACRIFICIO"),
                "COD_ANIMAL"            => $request->input("COD_ANIMAL"),
                "DIR_PSACRIFICIO"       => $request->input("DIR_PSACRIFICIO"),
            ]);
        
            if ($actualizar_psacrificio->successful()) {
                return redirect('/psacrificio')->with('update_success', 'Datos actualizados exitosamente.');
            } else {
                return redirect('/psacrificio')->with('update_error', 'Error al actualizar los datos.');
            }
        }
       
    
}