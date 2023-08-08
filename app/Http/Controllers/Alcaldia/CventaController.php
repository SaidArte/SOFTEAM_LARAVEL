<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CventaController extends Controller
{

   public function Cventa(){
      $Cventa = Http::get('http://localhost:3000/CVENTA/GETALL');
      $citaArreglo = json_decode($Cventa->body(), true);
      // Imprime los datos para verificar si están llegando correctamente
      // dd($citaArreglo);
  
      return view('Alcaldia.Cventa', compact('citaArreglo'));
   } 



   public function nuevo_cventa(request $request)
   {
       //
       $nuevo_cventa = Http::post('http://localhost:3000/CVENTA/INSERTAR',[
       //"TABLA_NOMBRE"=>$request->input("TABLA_NOMBRE"),
       
       // "COD_CVENTA"=> $request->input("COD_CVENTA"),
        //"FEC_CVENTA"=> $request->input("FEC_CVENTA"),
        "COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        "COD_COMPRADOR"=> $request->input("COD_COMPRADOR"),
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
       //
       $actualizar_cventa = Http::post('http://localhost:3000/CVENTA/ACTUALIZAR', [
       //"TABLA_NOMBRE"=>$request->input("TABLA_NOMBRE"),
       
        //"COD_CVENTA"=>$request->input("COD_CVENTA") ,
        "COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        "COD_COMPRADOR"=> $request->input("COD_COMPRADOR"),
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

       
       return redirect('/Cventa');
   }


}
