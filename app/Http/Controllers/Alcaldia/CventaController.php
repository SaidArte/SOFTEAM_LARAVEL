<?php

namespace App\Http\Controllers\Alcaldia;

use TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CventaController extends Controller
{

    const urlapi= 'http://82.180.133.39:4000/' ;

   public function Cventa(){
      $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
      ];
      $Cventa = Http::withHeaders($headers)->get(self::urlapi.'CVENTA/GETALL');
      $citaArreglo = json_decode($Cventa->body(), true);
      // Imprime los datos para verificar si están llegando correctamente
      // dd($citaArreglo);
      $Animal = Http::withHeaders($headers)->get(self::urlapi.'ANIMAL/GETALL');
      $AnimalArreglo = json_decode($Animal->body(), true);
      $personas = Http::withHeaders($headers)->get(self::urlapi.'PERSONAS/GETALL');
      $personasArreglo = json_decode($personas->body(), true);
      // Imprime los datos para verificar si están llegando correctamente
     // dd($citaArreglo);

     
      return view('Alcaldia.cventa')
      ->with('citaArreglo', $citaArreglo)
      ->with('AnimalArreglo', $AnimalArreglo)
     ->with('personasArreglo', $personasArreglo); 
  
      //return view('Alcaldia.Cventa', compact('citaArreglo'));
   } 



   public function nuevo_cventa(request $request)
   {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
       //
       $nuevo_cventa = Http::withHeaders($headers)->post(self::urlapi.'CVENTA/INSERTAR',[
       //"TABLA_NOMBRE"=>$request->input("TABLA_NOMBRE"),
       
       // "COD_CVENTA"=> $request->input("COD_CVENTA"),
        //"FEC_CVENTA"=> $request->input("FEC_CVENTA"),
        "COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        "NOM_COMPRADOR"=> $request->input("NOM_COMPRADOR"),
        "DNI_COMPRADOR"=> $request->input("DNI_COMPRADOR"),
        "COD_ANIMAL" => $request->input("COD_ANIMAL"),
        "FOL_CVENTA" => $request->input("FOL_CVENTA"),
        "ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
        //"CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
       // "RAZ_ANIMAL" => $request->input("RAZ_ANIMAL"),
        //"COL_ANIMAL"=> $request->input("COL_ANIMAL"),
        //"COD_FIERRO" => $request->input("COD_FIERRO"),
        //"VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
        //"HER_ANIMAL" => $request->input("HER_ANIMAL"),
        //"DET_ANIMAL"=> $request->input("DET_ANIMAL"),
       ]);


       
       return redirect('/Cventa');
   }

   public function actualizar_cventa(request $request)
   {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
       //
       $actualizar_cventa = Http::withHeaders($headers)->put(self::urlapi.'CVENTA/ACTUALIZAR/' .$request->input("COD_CVENTA"),[
       //"TABLA_NOMBRE"=>$request->input("TABLA_NOMBRE"),
       
        "COD_CVENTA"=>$request->input("COD_CVENTA") ,
        "COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        "NOM_COMPRADOR"=> $request->input("NOM_COMPRADOR"),
        "DNI_COMPRADOR"=> $request->input("DNI_COMPRADOR"),
        "COD_ANIMAL" => $request->input("COD_ANIMAL"),
        "FOL_CVENTA" => $request->input("FOL_CVENTA"),
        "ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
       // "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
        //"RAZ_ANIMAL" => $request->input("RAZ_ANIMAL"),
        //"COL_ANIMAL"=> $request->input("COL_ANIMAL"),
        //"COD_FIERRO" => $request->input("COD_FIERRO"),
        //"VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
        //"HER_ANIMAL" => $request->input("HER_ANIMAL"),
        //"DET_ANIMAL"=> $request->input("DET_ANIMAL"),
       ]);

       
       //return redirect('/Cventa');
       if ($actualizar_cventa->successful()) {
        return redirect('/Cventa')->with('update_success', 'Datos actualizados exitosamente.');
      } else {
        return redirect('/Cventa')->with('update_error', 'Error al actualizar los datos.');
      }
    
   }

   public function generarPdf($id){
    // Obtener datos del registro seleccionado ($Cventa) por su ID
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];

    $response = Http::withHeaders($headers)->get(self::urlapi.'CVENTA/GETALL');
    $cventas = json_decode($response->body(), true);

    $response2 = Http::withHeaders($headers)->get(self::urlapi.'ANIMAL/GETALL');
    $animales = json_decode($response2->body(), true);

    // Buscar el registro específico por ID
    $Cventa = collect($cventas)->firstWhere('COD_CVENTA', $id);

    // Verificar si se encontró el registro
    if (!$Cventa) {
        return response('Registro no encontrado.', 404);
    }

    // Buscar el animal específico por ID
    $Animal = collect($animales)->firstWhere('COD_ANIMAL', $Cventa['COD_ANIMAL']);

    $logo1Path = base_path('public/vendor/adminlte/dist/img/Talanga.png');
    $logo2Path = base_path('public/vendor/adminlte/dist/img/Honduras.png');

    // Crear instancia de TCPDF con formato de página y orientación
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

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
        <title>Municipalidad de Talanga - Carta de Venta</title>
        <style>
            body {
                text-align: center;
            }

            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            header div {
                display: flex;
                align-items: center;
            }

            header h1,
            header h6 {
                margin: 0;
            }

            header img {
                margin: 0 20px; /* Espaciado entre la imagen y los títulos */
            }

            section {
                text-align: justify;
            }

            section p {
                margin: 0;
            }

            .signature {
                margin-top: 10px;
            }
        </style>
    </head>

<body>

    <header>
        <div>
            <img src=\"vendor/adminlte/dist/img/Talanga.jpg\" alt=\"Logo 1\" width=\"100\" height=\"100\" />
            <h1>Municipalidad de Talanga</h1>
        </div>
        <div>
            <h6>DEPARTAMENTO DE FRANCISCO MORAZÁN - HONDURAS C.A.</h6>
            <img src=\"vendor/adminlte/dist/img/Honduras.jpg\" alt=\"Logo 2\" width=\"100\" height=\"100\" />
        </div>
    </header>
    
        <section>
            <h1>CARTA DE VENTA</h1>
            <div style=\"text-align: justify;\">
                <p>Yo, {$Cventa['NombreVendedor']}, mayor de edad, vecino de: __________________, por medio de la presente
                    hago constar que en esta fecha he vendido y entregado al señor (a): {$Cventa['NOM_COMPRADOR']}, vecino
                    de: ________________, en lo cual me obligo a la evicción y saneamiento conforme a la ley.</p>
            </div>
            <p>CLASE: {$Animal['CLAS_ANIMAL']} </p>
            <p>COLOR: {$Animal['COL_ANIMAL']} </p>
            <p>FIERRO</p>
            <p>HERRADO: {$Animal['HER_ANIMAL']}</p>
            <p>VENTEADO: {$Animal['VEN_ANIMAL']}</p>
            <p>CANTIDAD: _____________</p>
            <p>REGISTRO: _____________</p>
            <p>FOLIO: {$Cventa['FOL_CVENTA']} </p>
            <p>ANTECEDENTES: {$Cventa['ANT_CVENTA']} </p>
            <br>
            <p>NOTA: El infrascrito Director Municipal de Justicia, da fe de esta carta de venta. No somos responsables de
                adulteraciones de este documento. Cualquier modificación, borrado o tachado debe ser refrendada por el sello
                del Director Municipal de Justicia.</p>
            <br>
            <p>Talanga FM. Día ____ del mes ____ del año ______</p>
            <div style=\"text-align: center;\">
                <p>F. __________________</p>
                <p>ID VENDEDOR ___________</p>
            </div>
            <br><br>
            <div class=\"signature\" style=\"text-align: center;\">
                <p>______________</p>
                <h3>DIRECTOR MUNICIPAL DE JUSTICIA</h3>
            </div>
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
