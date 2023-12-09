<?php

namespace App\Http\Controllers\Alcaldia;

use TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class PSacrificioController extends Controller
{

    const urlapi='http://82.180.133.39:4000/' ;

    public function psacrificio()
{
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
    $psacrificio = Http::withHeaders($headers)->get(self::urlapi.'PSACRIFICIO/GETALL');
    $citaArreglo = json_decode($psacrificio->body(), true);
    // Imprime los datos para verificar si están llegando correctamente


    return view('Alcaldia.psacrificio', compact('citaArreglo'));
    //->with('citaArreglo', $citaArreglo)
    //->width('AnimalArreglo', $AnimalArreglo);
    
}

public function nuevo_psacrificio(Request $request)
{
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
    $nuevo_psacrificio = Http::withHeaders($headers)->post(self::urlapi.'PSACRIFICIO/INSERTAR', [
        "FEC_REG_PSACRIFICIO"   => $request->input("FEC_REG_PSACRIFICIO"),
        "NOM_PERSONA"           => $request->input("NOM_PERSONA"),
        "DNI_PERSONA"           => $request->input("DNI_PERSONA"),
        "TEL_PERSONA"           => $request->input("TEL_PERSONA"),
        "FEC_SACRIFICIO"        => $request->input("FEC_SACRIFICIO"),
        "DIR_PSACRIFICIO"       => $request->input("DIR_PSACRIFICIO"),
        "ANIMAL"            => $request->input("ANIMAL"),
        "COL_ANIMAL"            => $request->input("COL_ANIMAL"),
    ]);

    if ($nuevo_psacrificio->successful()) {
        return redirect('/psacrificio')->with('success', 'Registro creado exitosamente.');
    } else {
        return redirect()->back()->with('error', 'Hubo un problema al crear el registro.');
    }
}


        public function actualizar_psacrificio(Request $request)
        {
            $headers = [
                'Authorization' => 'Bearer ' . Session::get('token'),
            ];
            $actualizar_psacrificio = Http::withHeaders($headers)->put(self::urlapi.'PSACRIFICIO/ACTUALIZAR/'.$request->input("COD_PSACRIFICIO"), [
                "COD_PSACRIFICIO"       => $request->input("COD_PSACRIFICIO"),
                "FEC_REG_PSACRIFICIO"   => $request->input("FEC_REG_PSACRIFICIO"),
                "NOM_PERSONA"           => $request->input("NOM_PERSONA"),
                "DNI_PERSONA"           => $request->input("DNI_PERSONA"),
                "TEL_PERSONA"           => $request->input("TEL_PERSONA"),
                "FEC_SACRIFICIO"        => $request->input("FEC_SACRIFICIO"),
                "DIR_PSACRIFICIO"       => $request->input("DIR_PSACRIFICIO"),
                "ANIMAL"            => $request->input("ANIMAL"),
                "COL_ANIMAL"            => $request->input("COL_ANIMAL"),
            ]);
        
            if ($actualizar_psacrificio->successful()) {
                return redirect('/psacrificio')->with('update_success', 'Datos actualizados exitosamente.');
            } else {
                return redirect('/psacrificio')->with('update_error', 'Error al actualizar los datos.');
            }
        }

        public function generarPdfPS($id){
            // Obtener datos del registro seleccionado ($Cventa) por su ID
            $headers = [
                'Authorization' => 'Bearer ' . Session::get('token'),
            ];
        
            $response = Http::withHeaders($headers)->get(self::urlapi.'PSACRIFICIO/GETALL');
            $sacrificios = json_decode($response->body(), true);
        
            // Buscar el registro específico por ID
            $Sacrificio = collect($sacrificios)->firstWhere('COD_PSACRIFICIO', $id);
        
            // Verificar si se encontró el registro
            if (!$Sacrificio) {
                return response('Registro no encontrado.', 404);
            }
        
            // Crear instancia de TCPDF con formato de página y orientación
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $fechaSacrificio = $Sacrificio['FEC_SACRIFICIO'];

            // Convertir la fecha a un objeto DateTime
            $dateTime = new DateTime($fechaSacrificio);

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
                </style>
            </head>
            <body>
                <h1>Municipalidad de Talanga</h1>
                <h6>DEPARTAMENTO DE FRANCISCO MORAZAN - HONDURAS C.A.</h6>
                <h6>Correo Electrónico: municipalidadtalanga2022@gmail.com</h6>
                <br><br><br>
                <h1>PERMISO DE SACRIFICIO DE UN ANIMAL</h1>
                <br><br>
                <div style=\"text-align: justify;\">
                <p>El infrascrito director Municipal de Justicia de este Municipio concede permiso al señor(a):
                 {$Sacrificio['NOM_PERSONA']}, con número de identidad {$Sacrificio['DNI_PERSONA']}, 
                para un sacrificio de un {$Sacrificio['ANIMAL']} de color {$Sacrificio['COL_ANIMAL']} 
                con el siguiente fierro: 
                será sacrificado el día $dia del mes $mes del año $año 
                en la siguiente dirección: {$Sacrificio['DIR_PSACRIFICIO']}.</p>
                </div>
                <br><br>
                

                <div class=\"signature\"><center>
                    <p>______________________________________</p>
                    <h3>Juez de Justicia Municipal</h3>
                </div></center>
            </body>
            </html>
          ";
        
            // Agregar el contenido al PDF
            $pdf->writeHTML($contenido, true, false, true, false, '');
        
            // Descargar el PDF, "D" para descarga directa e "I" para pre-visualización.
            $pdf->Output("Permiso_de_Sacrificio.pdf", "I");
          }
       
    
}