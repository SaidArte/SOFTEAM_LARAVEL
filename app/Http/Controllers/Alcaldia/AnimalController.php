<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AnimalController extends Controller
{
    const urlapi='http://localhost:3000/';

   public function Animal(){
      $Animal = Http::get(self::urlapi.'ANIMAL/GETALL');
      $citaArreglo = json_decode($Animal->body(), true);
      // Imprime los datos para verificar si están llegando correctamente
      // dd($citaArreglo);
      $fierro = Http::get(self::urlapi.'FIERROS/GETALL');
      $fierroArreglo = json_decode($fierro->body(), true);
     

     
      return view('Alcaldia.Animal')
      ->with('citaArreglo', $citaArreglo)
      ->with('fierroArreglo', $fierroArreglo);
  
      //return view('Alcaldia.Animal', compact('citaArreglo'));
   } 

   public function nuevo_animal(request $request)
   {
       //
       $nuevo_animal = Http::post(self::urlapi.'ANIMAL/INSERTAR',[
       //"TABLA_NOMBRE"=>$request->input("TABLA_NOMBRE"),
       
        //"COD_CVENTA"=> $request->input("COD_CVENTA"),
        //"FEC_CVENTA"=> $request->input("FEC_CVENTA"),
        //"COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        //"COD_COMPRADOR"=> $request->input("COD_COMPRADOR"),
        //"COD_ANIMAL" => $request->input("COD_ANIMAL"),
        //"FOL_CVENTA" => $request->input("FOL_CVENTA"),
        //"ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
        //"FEC_REG_ANIMAL"=> $request->input("FEC_REG_ANIMAL") ,
        "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
        "RAZ_ANIMAL" => $request->input("RAZ_ANIMAL"),
        "COL_ANIMAL"=> $request->input("COL_ANIMAL"),
        "COD_FIERRO" => $request->input("COD_FIERRO"),
        "VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
        "HER_ANIMAL" => $request->input("HER_ANIMAL"),
        "DET_ANIMAL"=> $request->input("DET_ANIMAL"),
       ]);
       
       return redirect('/Animal');
   }

   

   public function actualizar_animal(request $request)
   {
       //
       $actualizar_animal = Http::put(self::urlapi.'ANIMAL/ACTUALIZAR/'.$request->input("COD_ANIMAL"), [
       //"TABLA_NOMBRE"=>$request->input("TABLA_NOMBRE"),
       
        //"COD_CVENTA"=>$request->input("COD_CVENTA") ,
        //"COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        //"COD_COMPRADOR"=> $request->input("COD_COMPRADOR"),
        "COD_ANIMAL" => $request->input("COD_ANIMAL"),
        //"FOL_CVENTA" => $request->input("FOL_CVENTA"),
        //"ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
        "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
        "RAZ_ANIMAL" => $request->input("RAZ_ANIMAL"),
        "COL_ANIMAL"=> $request->input("COL_ANIMAL"),
        "COD_FIERRO" => $request->input("COD_FIERRO"),
        "VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
        "HER_ANIMAL" => $request->input("HER_ANIMAL"),
        "DET_ANIMAL"=> $request->input("DET_ANIMAL"),
       ]);

       
       return redirect('/Animal');
   }


}

   




