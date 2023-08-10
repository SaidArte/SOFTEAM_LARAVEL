<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; // Importa el facade de autenticación

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post('http://localhost:3000/api/login', [
            'COD_USUARIO' => $request->input('COD_USUARIO'),
            'PAS_USUARIO' => $request->input('PAS_USUARIO'),
        ]);
    
        $data = $response->json();
    
        if ($response->successful()) {
            return redirect()->route('home'); // Redirigir al home
        } else {
            return redirect()->route('login')->with('error', $data['error']);
        }
    }
    

}