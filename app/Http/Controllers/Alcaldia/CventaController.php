<?php

namespace App\Http\Controllers\Alcaldia;

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


       
       return redirect('/cventa');
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

       
       return redirect('/cventa');
   }


}
