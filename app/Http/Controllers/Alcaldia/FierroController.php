<?php

namespace App\Http\Controllers\Alcaldia;

use TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use DateTime;
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

    public function generarPdfF($id){
        // Obtener datos del registro seleccionado ($Cventa) por su ID
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
    
        $response = Http::withHeaders($headers)->get(self::urlapi . 'PERSONAS/GETALL');
        $personas = json_decode($response->body(), true);

        $response2 = Http::withHeaders($headers)->get(self::urlapi . 'FIERROS/GETALL');
        $fierros = json_decode($response2->body(), true);
    
        // Buscar el registro específico por ID
        $Fierro = collect($fierros)->firstWhere('COD_FIERRO', $id);
    
        // Verificar si se encontró el registro
        if (!$Fierro) {
            return response('Registro no encontrado.', 404);
        }
        
        // Buscar el animal específico por ID
        $Persona = collect($personas)->firstWhere('COD_PERSONA', $Fierro['COD_PERSONA']);

        // Crear instancia de TCPDF con formato de página y orientación
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $fechaReg = $Fierro['FEC_TRAMITE_FIERRO'];

        // Convertir la fecha a un objeto DateTime
        $dateTime = new DateTime($fechaReg);

        // Obtener el día, mes y año como cadenas
        $dia = $dateTime->format('d');
        $mes = $dateTime->format('m');
        $año = $dateTime->format('Y');


    

        // Configurar el salto de página automático
        $pdf->SetAutoPageBreak(true, 10);
        // Agregar una página al PDF
        $pdf->AddPage();
        

    
        // Establecer el contenido del PDF con los datos del registro
        $contenido = "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>Permisos de Sacrificio</title>
            <style>
                body {
                    font-family: \"Times New Roman\", Times, serif;
                    margin: 0;
                    padding: 0;
                    text-align: justify;
                    line-height: 1.6;
                }
                .logo-container {
                    margin: 0 20px; /* Ajusta este valor según tu preferencia */
                }
                .logo-container img {
                    width: 1500px;
                    height: 400px;
                }
               
                h1, h6 {
                    text-align: center;
                    margin-top: 10px;
                }
                h1:first-of-type, h6:first-of-type {
                    margin-top: 20px;
                }
                h1 + h6 {
                    margin-top: 60px;
                }
                h1 + h6 + h1 {
                    margin-top: 40px;
                }
                p {
                    margin: 0 0 2.0em;
                    text-indent: 2em;
                }
                .divider {
                    width: 100%;
                    text-align: center;
                }
                .divider p {
                    display: inline-block;
                    width: 60%;
                    border-bottom: 1px solid #000;
                }
                .signature {
                    margin-top: 50px;
                    text-align: center;
                }
                .signature p {
                    margin: 0;
                }
                .signature h3 {
                    margin-top: 10px;
                }
                .folio {
                    font-weight: bold;
                    color: red;
                }
            </style>
        </head>
     <div class=\"logo-container\">
         <img src=\"vendor/adminlte/dist/img/Encabezado.jpg\" alt=\"Logo 1\">
     </div>
         <section>
    <body>
            <h1>REGISTRO DE FIERRO</h1>
            <h1>{$Persona['NOM_PERSONA']}</h1>    
            <img src=\"imagenes/fierros/{$Fierro['IMG_FIERRO']}\" alt=\"Fierro\">  
               
            <div style=\"text-align: justify;\">
            <span class=\"folio\">Nº: {$Fierro['NUM_FOLIO_FIERRO']} </span>
            <p>El día de hoy se presentó el señor (a):
             {$Persona['NOM_PERSONA']}, con número de identidad {$Persona['DNI_PERSONA']}, 
             y la siguiente dirección:  {$Persona['DES_DIRECCION']}. Solicitó la autorización para su fierro de tipo {$Fierro['TIP_FIERRO']},
             procediendo a bucar en los libros que esta Municipalidad lleva y al no encotrar una igual o parecida se le dio
             tramite a la inscripcion de su figura para que pueda herrar sus semovientes de campo, 
            que fue registrado el día $dia del mes $mes del año $año 
            </div>
           

            <div class=\"signature\"><center>
                <p>______________________________________</p>
                <p>Firma y Huella del Señor(a):</p>
                <h4>{$Persona['NOM_PERSONA']}</h4>
                <h4>{$Persona['DNI_PERSONA']}</h4>
            </div></center>
        </section>
    </body>
        </html>
      ";
    
        // Agregar el contenido al PDF
        $pdf->writeHTML($contenido, true, false, true, false, '');
    
        // Descargar el PDF, "D" para descarga directa e "I" para pre-visualización.
        $pdf->Output("Registro_Fierro.pdf", "I");
      }
}

