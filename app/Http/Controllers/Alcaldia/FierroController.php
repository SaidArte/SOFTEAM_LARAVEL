<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class FierroController extends Controller
{
   

    public function fierro()
{
   

    $fierro = Http::get('http://localhost:3000/FIERROS/GETALL');
    $citaArreglo = json_decode($fierro->body(), true);
  
    // Agregar el nombre de la persona dueña del fierro al arreglo
    // Agregar el nombre de la persona dueña del fierro al arreglo
    foreach ($citaArreglo as &$fierroItem) {
        $persona = Http::get('http://localhost:3000/PERSONAS/' . $fierroItem['COD_PERSONA']);
        $personaData = json_decode($persona->body(), true);
        if (isset($personaData['NOM_PERSONA'])) {
            $fierroItem['NOM_PERSONA'] = $personaData['NOM_PERSONA'];
        } else {
            $fierroItem['NOM_PERSONA'] = 'Nombre No Disponible';
        }
    }
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.fierro', compact('citaArreglo'));
}

        public function nuevo_fierro(Request $request){
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
        
            // Mover el archivo a una ubicación adecuada en el servidor
            $file->move(public_path('images/fierros'), $filename);
            
            $nuevo_fierro = Http::post('http://localhost:3000/FIERROS/INSERTAR',[
                "COD_PERSONA" => $request -> input("COD_PERSONA"),
                "FEC_TRAMITE_FIERRO" => $request -> input("FEC_TRAMITE_FIERRO"),
                "NUM_FOLIO_FIERRO" => $request -> input("NUM_FOLIO_FIERRO"),
                "TIP_FIERRO" => $request -> input("TIP_FIERRO"),
                "MON_CERTIFICO_FIERRO" => $request -> input("MON_CERTIFICO_FIERRO"),
                "IMG_FIERRO" => "/images/fierros/" . $filename,
                                
            ]);
            return redirect('/fierro');
            
        }

        public function actualizar_fierro(Request $request){
            
            $actualizar_fierro = Http::put('http://localhost:3000/FIERROS/ACTUALIZAR/'.$request->input("COD_FIERRO"),[
                "COD_FIERRO" => $request -> input("COD_FIERRO"),
                "COD_PERSONA" => $request -> input("COD_PERSONA"),
                "FEC_TRAMITE_FIERRO" => $request -> input("FEC_TRAMITE_FIERRO"),
                "NUM_FOLIO_FIERRO" => $request -> input("NUM_FOLIO_FIERRO"),
                "TIP_FIERRO" => $request -> input("TIP_FIERRO"),
                "MON_CERTIFICO_FIERRO" => $request -> input("MON_CERTIFICO_FIERRO"),
                "IMG_FIERRO" => $request -> input("IMG_FIERRO"),
                
            ]);
            return redirect('/fierro');

        }



}