<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Personas;

class PersonasController extends Controller
{
    const urlapi='http://localhost:3000/';

    public function personas(){
    $personas = Http::get(self::urlapi.'PERSONAS/GETALL');
    $citaArreglo = json_decode($personas->body(), true);

    return view('Alcaldia.personas', compact('citaArreglo'));
    }
    
    public function nueva_persona(Request $request){
        //Codigo para las imagenes
        $request->validate([
            'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagen = $request->file('IMG_PERSONA');

        if ($imagen->isValid()) {
            $extension = $imagen->getClientOriginalExtension();
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $extension;
    
            $imagen->move(public_path('imagenes/personas'), $nombreImagen);
    
            $rutaImagen = '/imagenes/personas/' . $nombreImagen; // Ruta relativa
    
            // Ahora, convertimos la ruta relativa en una ruta absoluta utilizando la función url()
            $rutaImagenAbsoluta = url($rutaImagen);
    
            $nueva_persona = Http::post(self::urlapi.'PERSONAS/INSERTAR',[
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
            return redirect('/personas');
        } else {
            return redirect()->back()->with('error', 'Invalid image file');
        }
    }
    
    public function actualizar_persona(Request $request){
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
                'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $actualizar_persona = Http::put('http://localhost:3000/PERSONAS/ACTUALIZAR/'.$request->input("COD_PERSONA"), $actualizar_personas);
    
        return redirect('/personas');
    }
    
    

    public function subirImagen(Request $request){
        $request->validate([
            'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imagen = $request->file('IMG_PERSONA');
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
        $imagen->move(public_path('imagenes/personas'), $nombreImagen);
    
        // Almacena la ruta de la imagen en la base de datos
        $rutaImagen = '/imagenes/personas/' . $nombreImagen;
        
        $nueva_persona = Http::post(self::urlapi.'PERSONAS/INSERTAR', [
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