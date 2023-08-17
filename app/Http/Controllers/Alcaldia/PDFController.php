<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fierro; // Make sure to import the Fierro model
use PDF;

class AlcaldiaController extends Controller
{
    public function generateFierroPDF($fierroId)
    {
        // Retrieve data for the specific Fierro record using $fierroId
        $fierroData = Fierro::find($fierroId); // Assuming you have a Fierro model
        
        // Make sure to replace the following line with your actual view name and data
        $pdf = PDF::loadView('pdf.fierro', [
            'fierroData' => $fierroData, // Pass the retrieved data here
            // Other data related to the Fierro record
        ]);

        return $pdf->stream('Fierro_' . $fierroId . '.pdf');
    }
}





