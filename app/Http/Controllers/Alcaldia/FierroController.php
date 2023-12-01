<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use App\Models\Fierro;

class FierroController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function fierro()
    {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $personas = Http::withHeaders($headers)->get(self::urlapi . 'PERSONAS/GETALL');
        $personasArreglo = json_decode($personas->body(), true);

        $fierro = Http::withHeaders($headers)->get(self::urlapi . 'FIERROS/GETALL');
        $citaArreglo = json_decode($fierro->body(), true);

        return view('Alcaldia.fierro', compact('citaArreglo', 'personasArreglo'));
    }
      
    public function nuevo_fierro(Request $request)
    {
    
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $request->validate([
            'IMG_FIERRO' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagen = $request->file('IMG_FIERRO');

        if ($imagen->isValid()) {
            $extension = $imagen->getClientOriginalExtension();
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $extension;

            $imagen->move(public_path('imagenes/fierros'), $nombreImagen);

            $rutaImagen = '/imagenes/fierros/' . $nombreImagen; // Ruta relativa

            // Ahora, convierte la ruta relativa en una ruta absoluta utilizando la función url()
            $rutaImagenAbsoluta = url($rutaImagen);

            // Crea un nuevo registro de Fierro en la base de datos
            $nuevo_fierro = Http::withHeaders($headers)->post(self::urlapi.'FIERROS/INSERTAR', [
                "COD_PERSONA" => $request->input("COD_PERSONA"),
                "FEC_TRAMITE_FIERRO" => $request->input("FEC_TRAMITE_FIERRO"),
                "NUM_FOLIO_FIERRO" => $request->input("NUM_FOLIO_FIERRO"),
                "TIP_FIERRO" => $request->input("TIP_FIERRO"),
                "MON_CERTIFICO_FIERRO" => $request->input("MON_CERTIFICO_FIERRO"),
                "IMG_FIERRO" => $rutaImagenAbsoluta, // Utilizamos la ruta absoluta
                "ESTADO" => $request->input("ESTADO"),
            ]);

            return redirect('/fierro')->with('success', 'Registro creado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al crear el registro.');
        }
    }
   
    public function actualizar_fierro(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        
        // Obtén la ruta de la imagen actual del campo oculto
        $rutaImagenActual = $request->input('IMG_FIERRO_actual');
        
        $updateData = [
            "FEC_TRAMITE_FIERRO"   => $request->input("FEC_TRAMITE_FIERRO"),
            "NUM_FOLIO_FIERRO"     => $request->input("NUM_FOLIO_FIERRO"),
            "TIP_FIERRO"           => $request->input("TIP_FIERRO"),
            "MON_CERTIFICO_FIERRO" => $request->input("MON_CERTIFICO_FIERRO"),
            "ESTADO" => $request->input("ESTADO"),
        ];
    
        if ($request->hasFile('IMG_FIERRO')) {
            $request->validate([
                'IMG_FIERRO' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $imagen = $request->file('IMG_FIERRO');
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagenes/fierros'), $nombreImagen);
            $rutaImagen = '/imagenes/fierros/' . $nombreImagen;
            $rutaImagenAbsoluta = url($rutaImagen);
    
            // Update the image path in the update data
            $updateData['IMG_FIERRO'] = $rutaImagenAbsoluta;
            
            // Elimina la imagen anterior si existe
            if ($rutaImagenActual && file_exists(public_path($rutaImagenActual))) {
                unlink(public_path($rutaImagenActual));
            }
        } else {
            // Si no se proporciona una nueva imagen, mantén la ruta de la imagen actual
            $updateData['IMG_FIERRO'] = $rutaImagenActual;
        }
    
        // Perform the update request
        $actualizar_fierro_response = Http::withHeaders($headers)->put(self::urlapi.'FIERROS/ACTUALIZAR/'.$request->input("COD_FIERRO"), $updateData);
    
        if ($actualizar_fierro_response->successful()) {
            return redirect('/fierro')->with('update_success', 'Datos actualizados exitosamente.');
        } else {
            return redirect('/fierro')->with('update_error', 'Error al actualizar los datos.');
        }
    }



    public function subirImagen(Request $request)
{
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
    $request->validate([
        'IMG_FIERRO' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $imagen = $request->file('IMG_FIERRO');
    $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
    $imagen->move(public_path('imagenes/fierros'), $nombreImagen);

    // Almacena la ruta de la imagen en la base de datos
    $rutaImagen = '/imagenes/fierros/' . $nombreImagen;
    
    $nuevo_fierro = Http::withHeaders($headers)->post(self::urlapi.'FIERROS/INSERTAR', [
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

