<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\http;
use App\Http\Controllers\Controller;


class FierroController extends Controller
{

    public function fierro(){
        $fierro = Http:: get('http://localhost:3000/FIERROS/GETALL');
        $citaArreiglo = json_decode($fierro,true);
        //return

        return view ('Alcaldia.fierro', compact('citaArreiglo'));

        }

        public function nuevo_fierro(Request $request){
            
            $nuevo_fierro = Http::post('http://localhost:3000/FIERROS/INSERTAR',[
                "FEC_TRAMITE_FIERRO" => $request -> input("FEC_TRAMITE_FIERRO"),
                "COD_PERSONA" => $request -> input("COD_PERSONA"),
                "TIP_FIERRO" => $request -> input("TIP_FIERRO"),
                "IMG_FIERRO" => $request -> input("IMG_FIERRO"),
                "NUM_FOLIO_FIERRO" => $request -> input("NUM_FOLIO_FIERRO"),
                "MON_CERTIFICO_FIERRO" => $request -> input("MON_CERTIFICO_FIERRO"),
            ]);
            return readirect('\fierro');
        }

        public function actualizar_fierro(Request $request){
            
            $actualizar_fierro = Http::post('http://localhost:3000/FIERROS/ACTUALIZAR/'.$request->input("COD_FIERRO"),[
                "COD_FIERRO" => $request -> input("COD_FIERRO"),
                "FEC_TRAMITE_FIERRO" => $request -> input("FEC_TRAMITE_FIERRO"),
                "COD_PERSONA" => $request -> input("COD_PERSONA"),
                "TIP_FIERRO" => $request -> input("TIP_FIERRO"),
                "IMG_FIERRO" => $request -> input("IMG_FIERRO"),
                "NUM_FOLIO_FIERRO" => $request -> input("NUM_FOLIO_FIERRO"),
                "MON_CERTIFICO_FIERRO" => $request -> input("MON_CERTIFICO_FIERRO"),
            ]);
            return readirect('\fierro');
        }

}