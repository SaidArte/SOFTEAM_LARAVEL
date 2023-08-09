<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class FierroController extends Controller
{
   

    public function fierro()
{
   // Obtener los datos de personas desde el controlador PersonasController
   $personasController = new PersonasController();
   $personas = Http::get('http://localhost:3000/PERSONAS/GETALL');
   $personasArreglo = json_decode($personas, true);

    $fierro = Http::get('http://localhost:3000/FIERROS/GETALL');
    $citaArreglo = json_decode($fierro->body(), true);
  
  
    foreach ($citaArreglo as &$fierroItem) 
    
    // dd($citaArreglo);

    return view('Alcaldia.fierro', compact('citaArreglo', 'personasArreglo'));
}

public function nuevo_fierro(Request $request)
{
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $file = $request->file('file');
    $filename = time() . '_' . $file->getClientOriginalName();

    $file->move(public_path('images/fierros'), $filename);

    $nuevo_fierro = Http::post('http://localhost:3000/FIERROS/INSERTAR', [
        "COD_PERSONA" => $request->input("COD_PERSONA"),
        "FEC_TRAMITE_FIERRO" => $request->input("FEC_TRAMITE_FIERRO"),
        "NUM_FOLIO_FIERRO" => $request->input("NUM_FOLIO_FIERRO"),
        "TIP_FIERRO" => $request->input("TIP_FIERRO"),
        "MON_CERTIFICO_FIERRO" => $request->input("MON_CERTIFICO_FIERRO"),
        "IMG_FIERRO" => "/images/fierros/" . $filename,
    ]);

    return redirect('/fierro');
}

public function actualizar_fierro(Request $request)
{
    $actualizar_fierro = Http::put('http://localhost:3000/FIERROS/ACTUALIZAR/' . $request->input("COD_FIERRO"), [
        "COD_FIERRO" => $request->input("COD_FIERRO"),
        "COD_PERSONA" => $request->input("COD_PERSONA"),
        "FEC_TRAMITE_FIERRO" => $request->input("FEC_TRAMITE_FIERRO"),
        "NUM_FOLIO_FIERRO" => $request->input("NUM_FOLIO_FIERRO"),
        "TIP_FIERRO" => $request->input("TIP_FIERRO"),
        "MON_CERTIFICO_FIERRO" => $request->input("MON_CERTIFICO_FIERRO"),
        "IMG_FIERRO" => $request->input("IMG_FIERRO"), // Aquí debes obtener la ruta correcta de la imagen si es necesario
    ]);

    return redirect('/fierro');
}

public function subirImagenFierro(Request $request){
    $request->validate([
        'imagen_fierro' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagen = $request->file('imagen_fierro');
    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
    $imagen->move(public_path('images/fierros'), $nombreImagen);

    // Aquí puedes guardar la ruta de la imagen en la base de datos si es necesario

    return redirect()->back()->with('success', 'Imagen del fierro subida exitosamente.');
}



}