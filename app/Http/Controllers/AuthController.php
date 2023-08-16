<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $NOM_USUARIO = $request->input('NOM_USUARIO');
        $PAS_USUARIO = $request->input('PAS_USUARIO');

        $response = Http::post('http://localhost:3000/api/login', [
            'NOM_USUARIO' => $NOM_USUARIO,
            'PAS_USUARIO' => $PAS_USUARIO
        ]);

        $data = $response->json();

        if ($response->successful()) {
            $user = $data['user'];
            Session::put('user_data', $user); //Almacena datos del usuario
            return redirect()->route('home'); // Redirigir al home
        } else {
            if ($data['error_type'] === 'inactive') {
                return redirect()->back()->with('error', 'Este usuario está inactivo');
            } else {
                return redirect()->back()->with('error', 'Usuario o Contraseña incorrectos');
            }
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect()->route('login');
    }
}
