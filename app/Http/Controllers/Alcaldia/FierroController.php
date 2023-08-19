<?php
namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class FierroController extends Controller
{
    const urlapi = 'http://localhost:3000/';

    public function fierro()
    {
        $personasController = new PersonasController();
        $personas = Http::get(self::urlapi.'PERSONAS/GETALL');
        $personasArreglo = json_decode($personas->body(), true);

        $fierro = Http::get(self::urlapi.'FIERROS/GETALL');
        $citaArreglo = json_decode($fierro->body(), true);

        return view('Alcaldia.fierro', compact('citaArreglo', 'personasArreglo'));
    }

    public function nuevo_fierro(Request $request)
{
    $request->validate([
        'IMG_FIERRO' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagen = $request->file('IMG_FIERRO');

    if ($imagen->isValid()) {
        $extension = $imagen->getClientOriginalExtension();
        $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $extension;

        $imagen->move(public_path('imagenes/fierros'), $nombreImagen);

        $rutaImagen = '/imagenes/fierros/' . $nombreImagen; // Ruta relativa

        // Ahora, convertimos la ruta relativa en una ruta absoluta utilizando la función url()
        $rutaImagenAbsoluta = url($rutaImagen);

        $nuevo_fierro = Http::post(self::urlapi.'FIERROS/INSERTAR', [
            "COD_PERSONA"            => $request->input("COD_PERSONA"),
            "FEC_TRAMITE_FIERRO"     => $request->input("FEC_TRAMITE_FIERRO"),
            "NUM_FOLIO_FIERRO"       => $request->input("NUM_FOLIO_FIERRO"),
            "TIP_FIERRO"             => $request->input("TIP_FIERRO"),
            "MON_CERTIFICO_FIERRO"   => $request->input("MON_CERTIFICO_FIERRO"),
            "IMG_FIERRO"             => $rutaImagenAbsoluta, // Utilizamos la ruta absoluta
        ]);

        return redirect('/fierro');
    } else {
        return redirect()->back()->with('error', 'Invalid image file');
    }
}

public function actualizar_fierro(Request $request)
{
           // Realiza la solicitud de actualización con los datos nuevos
        $actualizar_fierro =  [
            "COD_FIERRO"           => $request->input("COD_FIERRO"),
            "COD_PERSONA"          => $request->input("COD_PERSONA"),
            "FEC_TRAMITE_FIERRO"   => $request->input("FEC_TRAMITE_FIERRO"),
            "NUM_FOLIO_FIERRO"     => $request->input("NUM_FOLIO_FIERRO"),
            "TIP_FIERRO"           => $request->input("TIP_FIERRO"),
            "MON_CERTIFICO_FIERRO" => $request->input("MON_CERTIFICO_FIERRO"),
          
        ];
        if ($request->hasFile('IMG_FIERRO')) {
            $request->validate([
                'IMG_FIERRO' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $imagen = $request->file('IMG_FIERRO');
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagenes/fierros'), $nombreImagen);
            $rutaImagen = '/imagenes/fierros/' . $nombreImagen;
            $rutaImagenAbsoluta = url($rutaImagen);
    
            // Actualiza la ruta de la imagen en los datos a actualizar
            $actualizar_fierro['IMG_FIERRO'] = $rutaImagenAbsoluta;
        }
    
        $actualizar_fierro_response = Http::put(self::urlapi.'FIERROS/ACTUALIZAR/'.$request->input("COD_FIERRO"), $actualizar_fierro);
        
        if ($actualizar_fierro_response->successful()) {
            return redirect('/fierro')->with('success', 'Datos actualizados exitosamente.');
        } else {
            return redirect('/fierro')->with('error', 'Error al actualizar los datos.');
        }
}


    public function subirImagen(Request $request)
{
    $request->validate([
        'IMG_FIERRO' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagen = $request->file('IMG_FIERRO');
    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
    $imagen->move(public_path('imagenes/fierros'), $nombreImagen);

    // Almacena la ruta de la imagen en la base de datos
    $rutaImagen = '/imagenes/fierros/' . $nombreImagen;
    
    $nuevo_fierro = Http::post(self::urlapi.'FIERROS/INSERTAR', [
        // ... otros campos ...
        "IMG_FIERRO" => $rutaImagen,
    ]);

    // Puedes redirigir de vuelta a la página donde subiste la imagen
    // con un mensaje de éxito
    return redirect()->back()->with('success', 'Imagen del fierro subida exitosamente.');
}


    private function storeImage($image)
    {
        $nombreImagen = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('imagenes/fierros'), $nombreImagen);

        // Aquí puedes guardar el nombre de la imagen en la base de datos si es necesario

        return $nombreImagen;
    }
   
}

