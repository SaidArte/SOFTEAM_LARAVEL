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
   

    return view('Alcaldia.carta', compact('cartaArreglo'));
    }

    //Con esta funcion se podrán insertar nuevos Permisos de Traslado
    public function nuevo_carta(Request $request){
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $nuevo_carta = Http::withHeaders($headers)->post(self::urlapi.'CARTA/INSERTAR',[
            
            
           //"COD_CVENTA"=>$request->input("COD_CVENTA") ,
           "COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
           "NOM_COMPRADOR"=> $request->input("NOM_COMPRADOR"),
           "DNI_COMPRADOR"=> $request->input("DNI_COMPRADOR"),
           "COD_ANIMAL" => $request->input("COD_ANIMAL"),
           "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
           "COL_ANIMAL"=> $request->input("COL_ANIMAL"),
           "COD_FIERRO" => $request->input("COD_FIERRO"),
           "VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
           "HER_ANIMAL" => $request->input("HER_ANIMAL"),
           "FOL_CVENTA" => $request->input("FOL_CVENTA"),
           "ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
           "IND_CVENTA"=> $request->input("IND_CVENTA") ,
            
            
            
            
            
        
        ]);
        return redirect('/carta');
    }

   //La siguiente funcion permite actualizar los permisos de traslado

   public function actualizar_carta(Request $request){
    $headers = [
        'Authorization' => 'Bearer ' . Session::get('token'),
    ];
            
    $actualizar_carta = Http::withHeaders($headers)->put(self::urlapi.'CARTA/ACTUALIZAR/'.$request->input("COD_CVENTA"),[

        "COD_CVENTA"=>$request->input("COD_CVENTA") ,
        "COD_VENDEDOR"=> $request->input("COD_VENDEDOR") ,
        "NOM_COMPRADOR"=> $request->input("NOM_COMPRADOR"),
        "DNI_COMPRADOR"=> $request->input("DNI_COMPRADOR"),
        "COD_ANIMAL" => $request->input("COD_ANIMAL"),
        "CLAS_ANIMAL"=> $request->input("CLAS_ANIMAL") ,
        "COL_ANIMAL"=> $request->input("COL_ANIMAL"),
        "COD_FIERRO" => $request->input("COD_FIERRO"),
        "VEN_ANIMAL"=> $request->input("VEN_ANIMAL") ,
        "HER_ANIMAL" => $request->input("HER_ANIMAL"),
        "FOL_CVENTA" => $request->input("FOL_CVENTA"),
        "ANT_CVENTA"=> $request->input("ANT_CVENTA") ,
        "IND_CVENTA"=> $request->input("IND_CVENTA") ,
        
        
    
    ]);
    return redirect('/carta');
}
}