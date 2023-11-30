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
        // Validación de la imagen
        $request->validate([
            'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagen = $request->file('IMG_PERSONA');
        $dni = $request->input("DNI_PERSONA");
        $nombrePersona = $request->input("NOM_PERSONA");
        $email = $request->input("DIR_EMAIL");
        $numeroTelefono = $request->input("NUM_TELEFONO");

        // Obtén la lista de todas las personas
        $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');

        // Verifica si la solicitud fue exitosa
        if ($personas->successful()) {
            $personas_todas = $personas->json();

            // Validaciones para DNI, nombre, correo electrónico y número de teléfono
            foreach ($personas_todas as $persona) {
                if (isset($persona["DNI_PERSONA"]) && $persona["DNI_PERSONA"] === $dni) {
                    return redirect('/personas')->with('error', 'El DNI ingresado ya existe')->withInput();
                } elseif (isset($persona["NOM_PERSONA"]) && $persona["NOM_PERSONA"] === $nombrePersona) {
                    return redirect('personas')->with('error', 'El nombre ingresado ya existe')->withInput();
                } elseif (isset($persona["DIR_EMAIL"]) && $persona["DIR_EMAIL"] === $email) {
                    return redirect('personas')->with('error', 'El correo electrónico ingresado ya existe')->withInput();
                } elseif (isset($persona["NUM_TELEFONO"]) && $persona["NUM_TELEFONO"] === $numeroTelefono) {
                    return redirect('personas')->with('error', 'El número de teléfono ingresado ya existe')->withInput();
                }
            }
        }
    
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
        // Obtén la información actual de la persona
        $persona_actual = Http::withHeaders($headers)->post(self::urlapi.'PERSONAS/GETONE', [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
        ])->json();

        // Validaciones para DNI
        $dni = $request->input("DNI_PERSONA");
        if (!isset($persona_actual["DNI_PERSONA"]) || $dni !== $persona_actual["DNI_PERSONA"]) {
            $dni_existente = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL')->json();
            foreach ($dni_existente as $persona) {
                // Excluir la persona actual en la verificación
                if (isset($persona["DNI_PERSONA"]) && $persona["DNI_PERSONA"] === $dni && $persona["COD_PERSONA"] != $request->input("COD_PERSONA")) {
                    return redirect('/personas')->with('update_error', 'El DNI ingresado ya existe')->withInput();
                }
            }
        }
        // Validaciones para nombres
        $nombre = $request->input("NOM_PERSONA");
        if (!isset($persona_actual["NOM_PERSONA"]) || $nombre !== $persona_actual["NOM_PERSONA"]) {
            $nombre_existente = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL')->json();
            foreach ($nombre_existente as $persona) {
                // Excluir la persona actual en la verificación
                if (isset($persona["NOM_PERSONA"]) && $persona["NOM_PERSONA"] === $nombre && $persona["COD_PERSONA"] != $request->input("COD_PERSONA")) {
                    return redirect('/personas')->with('update_error', 'El nombre ingresado ya existe')->withInput();
                }
            }
        }

        // Validaciones para correo electrónico
        $emails = $request->input("DIR_EMAIL");
        if (!isset($persona_actual["DIR_EMAIL"]) || $emails !== $persona_actual["DIR_EMAIL"]) {
            $emails_existente = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL')->json();
            foreach ($emails_existente as $persona) {
                // Excluir la persona actual en la verificación
                if (isset($persona["DIR_EMAIL"]) && $persona["DIR_EMAIL"] === $emails && $persona["COD_PERSONA"] != $request->input("COD_PERSONA")) {
                    return redirect('/personas')->with('update_error', 'El correo electrónico ingresado ya existe')->withInput();
                }
            }
        }

        // Validaciones para número de teléfono
        $telefono = $request->input("NUM_TELEFONO");
        if (!isset($persona_actual["NUM_TELEFONO"]) || $telefono !== $persona_actual["NUM_TELEFONO"]) {
            $telefono_existente = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL')->json();
            foreach ($telefono_existente as $persona) {
                // Excluir la persona actual en la verificación
                if (isset($persona["NUM_TELEFONO"]) && $persona["NUM_TELEFONO"] === $telefono && $persona["COD_PERSONA"] != $request->input("COD_PERSONA")) {
                    return redirect('/personas')->with('update_error', 'El teléfono ingresado ya existe')->withInput();
                }
            }
        }

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

        // Obtén la ruta de la imagen actual del campo oculto
        $rutaImagenActual = $request->input('IMG_PERSONA_actual');
    
        // Manejar la imagen si se proporciona
        if ($request->hasFile('IMG_PERSONA')) {
            $request->validate([
                'IMG_PERSONA' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $imagen = $request->file('IMG_PERSONA');
            $nombreImagen = md5(time() . '_' . $imagen->getClientOriginalName()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagenes/personas'), $nombreImagen);
            $rutaImagen = '/imagenes/personas/' . $nombreImagen;
        } else {
            // Si no se ha subido una nueva imagen, utiliza la ruta de la imagen actual
            $rutaImagen = $rutaImagenActual;
        }
    
        // Actualizar los datos, incluyendo la nueva ruta de la imagen si se ha subido una nueva
        $actualizar_personas['IMG_PERSONA'] = $rutaImagen;
    
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