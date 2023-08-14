<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Personas;

class PersonasController extends Controller
{

    public function personas(){
    $personas = Http::get('http://localhost:3000/PERSONAS/GETALL');
    $citaArreglo = json_decode($personas->body(), true);

    return view('Alcaldia.personas', compact('citaArreglo'));
    }
    
    public function nueva_persona(Request $request){
        $nueva_persona = Http::post('http://localhost:3000/PERSONAS/INSERTAR',[
        "DNI_PERSONA" => $request->input("DNI_PERSONA"),
        "NOM_PERSONA" => $request->input("NOM_PERSONA"),
        "GEN_PERSONA" => $request->input("GEN_PERSONA"),
        "FEC_NAC_PERSONA" => $request->input("FEC_NAC_PERSONA"),
        "IMG_PERSONA" => $request->input("IMG_PERSONA"),
        "COD_DIRECCION" => $request->input("COD_DIRECCION"),
        "DES_DIRECCION" => $request->input("DES_DIRECCION"),
        "TIP_DIRECCION" => $request->input("TIP_DIRECCION"),
        "COD_EMAIL"=> $request->input("COD_EMAIL"),
        "DIR_EMAIL" => $request->input("DIR_EMAIL"),
        "COD_TELEFONO" => $request->input("COD_TELEFONO"),
        "NUM_TELEFONO" => $request->input("NUM_TELEFONO"),
        "TIP_TELEFONO" => $request->input("TIP_TELEFONO"),
        "DES_TELEFONO" => $request->input("DES_TELEFONO"),
        "OPE_TELEFONO" => $request->input("OPE_TELEFONO"),
        "IND_TELEFONO" => $request->input("IND_TELEFONO"),

        ]);
        return redirect('/personas');
    }
    
    public function actualizar_persona(Request $request){
        $actualizar_persona = Http::put('http://localhost:3000/PERSONAS/ACTUALIZAR/'.$request->input("COD_PERSONA"),[
        "COD_PERSONA" => $request->input("COD_PERSONA"),
        "DNI_PERSONA" => $request->input("DNI_PERSONA"),
        "NOM_PERSONA" => $request->input("NOM_PERSONA"),
        "GEN_PERSONA" => $request->input("GEN_PERSONA"),
        "FEC_NAC_PERSONA" => $request->input("FEC_NAC_PERSONA"),
        "IMG_PERSONA" => $request->input("IMG_PERSONA"),
        "COD_DIRECCION" => $request->input("COD_DIRECCION"),
        "DES_DIRECCION" => $request->input("DES_DIRECCION"),
        "TIP_DIRECCION" => $request->input("TIP_DIRECCION"),
        "COD_EMAIL"=> $request->input("COD_EMAIL"),
        "DIR_EMAIL" => $request->input("DIR_EMAIL"),
        "COD_TELEFONO" => $request->input("COD_TELEFONO"),
        "NUM_TELEFONO" => $request->input("NUM_TELEFONO"),
        "TIP_TELEFONO" => $request->input("TIP_TELEFONO"),
        "DES_TELEFONO" => $request->input("DES_TELEFONO"),
        "OPE_TELEFONO" => $request->input("OPE_TELEFONO"),
        "IND_TELEFONO" => $request->input("IND_TELEFONO"),

        ]);
        return redirect('/personas');
    }

    public function store(Request $request){
        $newPost = new Post();
        if($request->hasFile('IMG_PERSONA') ){
            $file = $request->file('IMG_PERSONA');
            $ubicacion = 'images/featureds/';
            $filename = time() . '.' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('IMG_PERSONA')->move($ubicacion, $filename);
            $newPost->IMG_PERSONA = $ubicacion . $filename;
            $newPost->save(); // ¡Agrega esta línea para guardar el registro en la base de datos!
        }    
        return $request->all(); 
    }

}