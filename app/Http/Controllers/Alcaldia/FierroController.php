<?php
namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class FierroController extends Controller
{
    const urlapi='http://localhost:3000/';

    public function fierro()
    {

        $personasController = new PersonasController();
        $personas = Http::get(self::urlapi.'PERSONAS/GETALL');
        $personasArreglo = json_decode($personas, true);

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
    // Valida los datos antes de realizar la actualización
    $request->validate([
        'IMG_FIERRO' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Obtiene el código del fierro a actualizar
    $codFierro = $request->input("COD_FIERRO");

    // Realiza la consulta para obtener la información del fierro antes de la actualización
    $fierro = Http::get(self::urlapi . 'FIERROS/OBTENER/' . $codFierro);
    
    if ($fierro->successful()) {
        $fierroArreglo = json_decode($fierro->body(), true);

        // Valida si se ha proporcionado una nueva imagen
        if ($request->hasFile('IMG_FIERRO')) {
            $imagen = $request->file('IMG_FIERRO');

            if ($imagen->isValid()) {
                $extension = $imagen->getClientOriginalExtension();
                $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $extension;

                $imagen->move(public_path('imagenes/fierros'), $nombreImagen);

                $rutaImagen = '/imagenes/fierros/' . $nombreImagen;
                $rutaImagenAbsoluta = url($rutaImagen);
            }
        } else {
            // Si no se proporcionó una nueva imagen, utiliza la ruta de la imagen actual
            $rutaImagenAbsoluta = $fierroArreglo['IMG_FIERRO'];
        }

        // Realiza la solicitud de actualización con los datos nuevos
        $actualizar_fierro = Http::put(self::urlapi . '/FIERROS/ACTUALIZAR/' . $codFierro, [
            "COD_FIERRO"           => $codFierro,
            "COD_PERSONA"          => $request->input("COD_PERSONA"),
            "FEC_TRAMITE_FIERRO"   => $request->input("FEC_TRAMITE_FIERRO"),
            "NUM_FOLIO_FIERRO"     => $request->input("NUM_FOLIO_FIERRO"),
            "TIP_FIERRO"           => $request->input("TIP_FIERRO"),
            "MON_CERTIFICO_FIERRO" => $request->input("MON_CERTIFICO_FIERRO"),
            "IMG_FIERRO"           => $rutaImagenAbsoluta,
        ]);

        return redirect('/fierro');
    } else {
        // Handle the error when the API request to get fierro data fails
        return redirect()->back()->with('error', 'Failed to retrieve fierro data for update.');
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

