<?php
namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

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
    
            if ($nuevo_fierro->successful()) {
                return redirect('/fierro')->with('success', 'Registro creado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Hubo un problema al crear el registro.');
            }
        }
    }

public function actualizar_fierro(Request $request)
{
    $updateData = [
       
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

        // Update the image path in the update data
        $updateData['IMG_FIERRO'] = $rutaImagenAbsoluta;
    }
   // dd($updateData);
    // Perform the update request
    $actualizar_fierro_response = Http::put(self::urlapi.'FIERROS/ACTUALIZAR/'.$request->input("COD_FIERRO"), $updateData);
    
    if ($actualizar_fierro_response->successful()) {
        return redirect('/fierro')->with('update_success', 'Datos actualizados exitosamente.');
    } else {
        return redirect('/fierro')->with('update_error', 'Error al actualizar los datos.');
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

