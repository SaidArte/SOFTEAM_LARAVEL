<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Personas;
use Illuminate\Support\Facades\Session;

class PersonasController extends Controller
{
    const urlapi= 'http://82.180.133.39:4000/';

    public function personas(){
    //Codigo para la cabezera
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
    $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
    $citaArreglo = json_decode($personas->body(), true);

    return view('Alcaldia.personas', compact('citaArreglo'));
    }
    
    public function nueva_persona(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        //Codigo para las imagenes
        $request->validate([
            'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $imagen = $request->file('IMG_PERSONA');

        if ($imagen->isValid()) {
            $extension = $imagen->getClientOriginalExtension();
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $extension;
    
            $imagen->move(public_path('imagenes/personas'), $nombreImagen);
    
            $rutaImagen = '/imagenes/personas/' . $nombreImagen; // Ruta relativa
    
            // Ahora, convertimos la ruta relativa en una ruta absoluta utilizando la función url()
            $rutaImagenAbsoluta = url($rutaImagen);
    
            $nueva_persona = Http::withHeaders($headers)->post(self::urlapi.'PERSONAS/INSERTAR',[
                "DNI_PERSONA" => $request->input("DNI_PERSONA"),
                "NOM_PERSONA" => $request->input("NOM_PERSONA"),
                "GEN_PERSONA" => $request->input("GEN_PERSONA"),
                "FEC_NAC_PERSONA" => $request->input("FEC_NAC_PERSONA"),
                "IMG_PERSONA" => $rutaImagenAbsoluta, // Utilizamos la ruta absoluta
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
            if ($nueva_persona->successful()) {
                return redirect('/personas')->with('success', 'Registro creado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Hubo un problema al crear el registro.');
            }
        }  
    }
    
    public function actualizar_persona(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $actualizar_personas = [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "DNI_PERSONA" => $request->input("DNI_PERSONA"),
            "NOM_PERSONA" => $request->input("NOM_PERSONA"),
            "GEN_PERSONA" => $request->input("GEN_PERSONA"),
            "FEC_NAC_PERSONA" => $request->input("FEC_NAC_PERSONA"),
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
        ];
    
        // Manejar la imagen si se proporciona
        if ($request->hasFile('IMG_PERSONA')) {
            $request->validate([
                'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $imagen = $request->file('IMG_PERSONA');
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagenes/personas'), $nombreImagen);
            $rutaImagen = '/imagenes/personas/' . $nombreImagen;
            $rutaImagenAbsoluta = url($rutaImagen);
    
            // Actualiza la ruta de la imagen en los datos a actualizar
            $actualizar_personas['IMG_PERSONA'] = $rutaImagenAbsoluta;
        }
    
        // Realizar la solicitud HTTP para actualizar los datos
        $actualizar_personas = Http::withHeaders($headers)->put(self::urlapi.'PERSONAS/ACTUALIZAR/'.$request->input("COD_PERSONA"), $actualizar_personas);
        if ($actualizar_personas->successful()) {
            return redirect('/personas')->with('update_success', 'Datos actualizados exitosamente.');
        } else {
            return redirect('/personas')->with('update_error', 'Error al actualizar los datos.');
        }
    }
    
    

    public function subirImagen(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $request->validate([
            'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $imagen = $request->file('IMG_PERSONA');
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
        $imagen->move(public_path('imagenes/personas'), $nombreImagen);
    
        // Almacena la ruta de la imagen en la base de datos
        $rutaImagen = '/imagenes/personas/' . $nombreImagen;
        
        $nueva_persona = Http::withHeaders($headers)->post(self::urlapi.'PERSONAS/INSERTAR', [
            // ... otros campos ...
            "IMG_PERSONA" => $rutaImagen,
        ]);
    
        // Puedes redirigir de vuelta a la página donde subiste la imagen
        // con un mensaje de éxito
        return redirect()->back()->with('success', 'Imagen de la persona cargada exitosamente.');
    }
    
    
    private function storeImage($image){
        $nombreImagen = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('imagenes/personas'), $nombreImagen);

        // Aquí puedes guardar el nombre de la imagen en la base de datos si es necesario

        return $nombreImagen;
    }  

}