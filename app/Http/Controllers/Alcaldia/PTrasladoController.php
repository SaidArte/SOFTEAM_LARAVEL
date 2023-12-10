<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use TCPDF;
use DateTime;

class PTrasladoController extends Controller
{

    const urlapi='http://82.180.133.39:4000/' ;

    public function ptraslado(){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];

  // Obtener los datos de personas desde el controlador PersonasController
   $personasController = new PersonasController();
   $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
   $personasArreglo = json_decode($personas, true);

    $ptraslado = Http::withHeaders($headers)->get(self::urlapi.'PTRASLADO/GETALL');
    $citaArreglo = json_decode($ptraslado->body(), true);
    // Imprime los datos para verificar si están llegando correctamente
    // dd($citaArreglo);

    return view('Alcaldia.ptraslado', compact('citaArreglo', 'personasArreglo'));
    }

    //Con esta funcion se podrán insertar nuevos Permisos de Traslado
    public function nuevo_PermisoTraslado(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $nuevo_PermisoTraslado = Http::withHeaders($headers)->post(self::urlapi.'PTRASLADO/INSERTAR',[
            "FEC_TRASLADO" => $request -> input("FEC_TRASLADO"),
            "COD_PERSONA" => $request -> input("COD_PERSONA"),            
            "DIR_ORIG_PTRASLADO" => $request -> input("DIR_ORIG_PTRASLADO"),
            "DIR_DEST_TRASLADO" => $request -> input("DIR_DEST_TRASLADO"),
            "NOM_TRANSPORTISTA" => $request -> input("NOM_TRANSPORTISTA"),
            "DNI_TRANSPORTISTA"=> $request -> input("DNI_TRANSPORTISTA"),
            "TEL_TRANSPORTISTA"=> $request -> input( "TEL_TRANSPORTISTA"),
            "MAR_VEHICULO"=> $request -> input("MAR_VEHICULO"),
            "MOD_VEHICULO"=> $request -> input("MOD_VEHICULO"),
            "MAT_VEHICULO"=> $request -> input("MAT_VEHICULO"),
            "COL_VEHICULO"=> $request -> input("COL_VEHICULO"),
            "MON_TRASLADO"=> $request -> input("MON_TRASLADO"),
            "COD_FIERRO"=> $request -> input("COD_FIERRO"),
            "CAN_GANADO"=> $request -> input("CAN_GANADO"),
            "ESTADO" => $request->input("ESTADO"),
        ]);
        return redirect('/ptraslado');
    }

   //La siguiente funcion permite actualizar los permisos de traslado

   public function actualizar_PermisoTraslado(Request $request){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
            
    $actualizar_PermisoTraslado = Http::withHeaders($headers)->put(self::urlapi.'PTRASLADO/ACTUALIZAR/',[
        "COD_PTRASLADO" => $request -> input("COD_PTRASLADO"),

        "FEC_TRASLADO" => $request -> input("FEC_TRASLADO"),
        "COD_PERSONA" => $request -> input("COD_PERSONA"),
        "DIR_ORIG_PTRASLADO" => $request -> input("DIR_ORIG_PTRASLADO"),
        "DIR_DEST_TRASLADO" => $request -> input("DIR_DEST_TRASLADO"),
        "NOM_TRANSPORTISTA" => $request -> input("NOM_TRANSPORTISTA"),
        "DNI_TRANSPORTISTA"=> $request -> input("DNI_TRANSPORTISTA"),
        "TEL_TRANSPORTISTA"=> $request -> input( "TEL_TRANSPORTISTA"),
        "MAR_VEHICULO"=> $request -> input("MAR_VEHICULO"),
        "MOD_VEHICULO"=> $request -> input("MOD_VEHICULO"),
        "MAT_VEHICULO"=> $request -> input("MAT_VEHICULO"),
        "COL_VEHICULO"=> $request -> input("COL_VEHICULO"),
        "MON_TRASLADO"=> $request -> input("MON_TRASLADO"),
        "CAN_GANADO"=> $request -> input("CAN_GANADO"),
        "ESTADO" => $request->input("ESTADO"),
    
    ]);
    return redirect('/ptraslado');
}

public function generarPdfT($id){
    // Obtener datos del registro seleccionado ($Cventa) por su ID
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];

    $response = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
    $personas = json_decode($response, true);

    $response2 = Http::withHeaders($headers)->get(self::urlapi.'PTRASLADO/GETALL');
    $ptraslados = json_decode($response2->body(), true);

    $response3 = Http::withHeaders($headers)->get(self::urlapi . 'FIERROS/GETALL');
    $fierros = json_decode($response3->body(), true);

    // Buscar el registro específico por ID
    $Traslado = collect($ptraslados)->firstWhere('COD_PTRASLADO', $id);

    // Verificar si se encontró el registro
    if (!$Traslado) {
        return response('Registro no encontrado.', 404);
    }

    // Buscar la persona por ID.
    $Persona = collect($personas)->firstWhere('COD_PERSONA', $Traslado['COD_PERSONA']);

    // Buscar la persona por ID.
    $Fierro = collect($fierros)->firstWhere('COD_FIERRO', $Traslado['COD_PERSONA']);

    // Crear instancia de TCPDF con formato de página y orientación
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $fechaReg = $Traslado['FEC_TRASLADO'];

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
        <title>Permisos de Traslado</title>
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
        </style>
    </head>
    <div class=\"logo-container\">
    <img src=\"vendor/adminlte/dist/img/Encabezado.jpg\" alt=\"Logo 1\">
        </div>
        <section>
    <body>
        <h1>GUIA FRANCA</h1>
        <p>El infrascrito Director Municipal de Justicia Municipal por medio de la presente, concede permiso a {$Persona['NOM_PERSONA']}.</p>
        <p>Dicho traslado será desde: {$Traslado['DIR_ORIG_PTRASLADO']}. </p>
        <p>Hasta: {$Traslado['DIR_DEST_TRASLADO']}. </p>
        <p>En el vehículo:</p>
        <p>Marca: {$Traslado['MAR_VEHICULO']} Color: {$Traslado['COL_VEHICULO']}. </p>
        <p>Placa: {$Traslado['MAT_VEHICULO']}. </p>
        <p>Nombre del conductor: {$Traslado['NOM_TRANSPORTISTA']}. </p>
        <p>Donde se solicita a las autoridades civiles y policiales no abstaculizar dicho traslado.</p>
        <p>Talanga F.M. $dia del mes $mes del año $año.</p>
        <br>
        <div class=\"signature\">
            <p>______________________________________</p>
            <h3>Director de Justicia Municipal</h3>
        </div>
    </body>
    </html>
    ";

    // Agregar el contenido al PDF
    $pdf->writeHTML($contenido, true, false, true, false, '');

    // Descargar el PDF, "D" para descarga directa e "I" para pre-visualización.
    $pdf->Output("Permiso_de_Traslado.pdf", "I");
    }

}