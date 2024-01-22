<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use TCPDF;
use DateTime;

class CartaController extends Controller
{

    const urlapi='http://82.180.133.39:4000/' ;

    public function carta(){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];

  

    $carta = Http::withHeaders($headers)->get(self::urlapi.'CARTA/GETALL');
    $cartaArreglo = json_decode($carta->body(), true);
       // Imprime los datos para verificar si están llegando correctamente
       $fierro = Http::withHeaders($headers)->get(self::urlapi.'FIERROS/GETALL');
       $fierroArreglo = json_decode($fierro->body(), true);
       $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
       $personasArreglo = json_decode($personas->body(), true);
   

    return view('Alcaldia.carta', compact('cartaArreglo','personasArreglo', 'fierroArreglo'));
    }


    //Con esta funcion se podrán insertar nuevos 
    public function nuevo_carta(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $nuevo_carta = Http::withHeaders($headers)->post(self::urlapi.'CARTA/INSERTAR',[
            
            
           //"COD_CVENTA"=>$request->input("COD_CVENTA") ,
           "COD_PERSONA"=> $request->input("COD_PERSONA") ,
           "NOM_COMPRADOR"=> $request->input("NOM_COMPRADOR"),
           "DNI_COMPRADOR"=> $request->input("DNI_COMPRADOR"),
        
           "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
           "COL_ANIMAL"=> $request->input("COL_ANIMAL"),
           "COD_FIERRO" => $request->input("COD_FIERRO"),
           
           "VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
           "HER_ANIMAL" => $request->input("HER_ANIMAL"),
          "CANT_CVENTA" => $request->input("CANT_CVENTA"), 
           "FOL_CVENTA" => $request->input("FOL_CVENTA"),
           "ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
           "IND_CVENTA"=> $request->input("IND_CVENTA") ,
            
            
            
            
            
        
        ]);
        //return redirect('/carta');

        
            if ($nuevo_carta->successful()) {
               return redirect('/carta')->with('success', 'Registro creado exitosamente.');
           } else {
              return redirect('/carta')->with('error', 'Hubo un problema al crear el registro.');
           }

         
    }

   //La siguiente funcion permite actualizar los permisos de traslado

   public function actualizar_carta(Request $request){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
            
    $actualizar_carta = Http::withHeaders($headers)->put(self::urlapi.'CARTA/ACTUALIZAR/'.$request->input("COD_CVENTA"),[

        "COD_CVENTA"=>$request->input("COD_CVENTA") ,
        //"NOMBRE_VENDEDOR"=> $request->input("NOMBRE_VENDEDOR") ,
        "COD_PERSONA"=> $request->input("COD_PERSONA") ,
        "NOM_COMPRADOR"=> $request->input("NOM_COMPRADOR"),
        "DNI_COMPRADOR"=> $request->input("DNI_COMPRADOR"),
      
        "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
        "COL_ANIMAL"=> $request->input("COL_ANIMAL"),
        "COD_FIERRO" => $request->input("COD_FIERRO"),
        //"IMG_FIERRO" => $request->input("IMG_FIERRO"),
        "VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
        "HER_ANIMAL" => $request->input("HER_ANIMAL"),
        "CANT_CVENTA"=> $request->input("CANT_CVENTA") ,
        "FOL_CVENTA" => $request->input("FOL_CVENTA"),
        "ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
        "IND_CVENTA"=> $request->input("IND_CVENTA") ,
        
        
    
    ]);
    //return redirect('/carta');

    if ($actualizar_carta->successful()) {
        return redirect('/carta')->with('update_success', 'Datos actualizados exitosamente.');
      } else {
        return redirect('/carta')->with('update_error', 'Error al actualizar los datos.');
      }
    
   }



   public function generarPdf($id){
    // Obtener datos del registro seleccionado ($Cventa) por su ID
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];

    $response = Http::withHeaders($headers)->get(self::urlapi.'CARTA/GETALL');
    $carta = json_decode($response->body(), true);

    //$response2 = Http::withHeaders($headers)->get(self::urlapi.'ANIMAL/GETALL');
   // $animales = json_decode($response2->body(), true);

    // Buscar el registro específico por ID
    $carta = collect($carta)->firstWhere('COD_CVENTA', $id);

    // Verificar si se encontró el registro
    if (!$carta) {
        return response('Registro no encontrado.', 404);
    }

    // Buscar el animal específico por ID
   // $Animal = collect($animales)->firstWhere('COD_ANIMAL', $Cventa['COD_ANIMAL']);

    $logo1Path = base_path('public/vendor/adminlte/dist/img/Talanga.png');
    $logo2Path = base_path('public/vendor/adminlte/dist/img/Honduras.png');

    // Crear instancia de TCPDF con formato de página y orientación
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $fechaReg = $carta['FEC_CVENTA'];


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
    <html lang=\"es\">

    <head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Carta de venta</title>
    <style>
                    body {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        min-height: 100vh;
                        margin: 0;
                    }
                    h1 {
                        text-align: center;
                    }
                    .logo-container {
                        margin: 0 20px; /* Ajusta este valor según tu preferencia */
                    }
                    .folio {
                        font-weight: bold;
                        color: red;
                    }
                    .logo-container img {
                        width: 1500px;
                        height: 400px;
                    }
                    .two-columns {
                        column-count: 2;
                    }
                    header {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                        margin: auto; 
                    }
            
                    header h1,
                    header h6 {
                        margin: 0;
                    }

                    section {
                        text-align: justify;
                    }

                    section p {
                        margin: 0;
                    }
                    .two-parts {
                        white-space: nowrap; /* Evita que el texto se divida en varias líneas */
                    }

                    .signature {
                        margin-top: 10px;
                    }
            </style>
            </head>
            <body>
            <div class=\"logo-container\">
                <img src=\"vendor/adminlte/dist/img/Encabezado.jpg\" alt=\"Logo 1\">
            </div>
            <section>
            <h1>CARTA DE VENTA</h1>
            <span class=\"folio\">Nº: {$carta['FOL_CVENTA']} </span>
            <div style=\"text-align: justify;\">
                <p>Yo, {$carta['NOMBRE_VENDEDOR']}, mayor de edad , 
                mediante la presente hago constar que en la fecha de hoy he vendido y entregado al señor (a): {$carta['NOM_COMPRADOR']}, identificado con la cédula de identidad: {$carta['DNI_COMPRADOR']} 
                , en lo cual me obligo a la evicción y saneamiento conforme a la ley.</p>
                    <p class=\"two-parts\">CLASE: {$carta['CLAS_ANIMAL']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COLOR: {$carta['COL_ANIMAL']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REGISTRO: {$carta['FOL_CVENTA']}</p>
                    <p class=\"two-parts\">HERRADO: {$carta['HER_ANIMAL']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VENTEADO: {$carta['VEN_ANIMAL']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ANTECEDENTES: {$carta['ANT_CVENTA']}</p>
                    
                         
                    <br>
                 <p>NOTA: El infrascrito Director Municipal de Justicia, da fe de esta carta de venta. No somos responsables de
                adulteraciones de este documento. Cualquier modificación, borrado o tachado debe ser refrendada por el sello
                del Director Municipal de Justicia </p>

                <p>Talanga Francisco Morazan el día $dia del mes $mes del año $año   </p>
            <br>
            </div>
            <p class=\"two-parts\">________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________</p>
            <p class=\"two-parts\"> &nbsp;&nbsp;&nbsp;&nbsp;{$carta['NOMBRE_VENDEDOR']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Maynor Garcia</p>
            <p class=\"two-parts\"> &nbsp;&nbsp;&nbsp;&nbsp;  Vendedor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Director Municipal de Justicia</p>
            <div class=\"signature\" style=\"text-align: center;\">
                <p>\"TODOS POR EL DESARROLLO DE TALANGA\"</p>
          </div>
        </section>
    
 </body>
  
    </html>
  ";

    // Agregar el contenido al PDF
    $pdf->writeHTML($contenido, true, false, true, false, '');

    // Descargar el PDF, "D" para descarga directa e "I" para pre-visualización.
    $pdf->Output("Carta_de_Venta", "I");
  }
}