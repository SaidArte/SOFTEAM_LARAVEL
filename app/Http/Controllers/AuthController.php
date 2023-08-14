<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            if ($data['error_type'] === 'inactive') {
                return redirect()->back()->with('error', 'Este usuario está inactivo, ingresa datos correctos');
            } else {
                return redirect()->back()->with('error', 'Usuario o Contraseña incorrectos');
            }
        }
    }
}
