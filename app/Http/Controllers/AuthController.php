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

    public function showChangePasswordForm()
    {
        return view('Alcaldia.change-password');
    }

    public function changePassword(Request $request)
    {
        $COD_USUARIO = Session::get('user_data')['COD_USUARIO'];
        $NOM_USUARIO = Session::get('user_data')['NOM_USUARIO'];
        $oldPassword = $request->input('PAS_USUARIO');
        $newPassword = $request->input('newPassword');
        $confPassword = $request->input('confPassword');
        $response = Http::post('http://localhost:3000/api/login', [
            'NOM_USUARIO' => $NOM_USUARIO,
            'PAS_USUARIO' => $oldPassword,
        ]);

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Favor, ingrese su contraseña actual')->withInput();
        }

        if ($oldPassword == $newPassword) {
            return redirect()->back()->with('error', 'Favor, ingrese una contraseña diferente')->withInput();
        } elseif ($newPassword != $confPassword || $newPassword == "") {
            return redirect()->back()->with('error', 'Favor, ingrese una contraseña y confirmela')->withInput();
        }

        $response2 = Http::put('http://localhost:3000/SEGURIDAD/ACTUALIZAR_PASS_USUARIOS', [
            'COD_USUARIO' => $COD_USUARIO,
            'PAS_USUARIO' => $newPassword,
        ]);

        if ($response2->successful()) {
            $notification = [
                'type' => 'success',
                'title' => 'Cambio de contraseña',
                'message' => 'Tu contraseña ha sido actualizada con éxito.'
            ];
            
            return redirect()->route('home')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Error interno de servidor')->withInput();
        }
    }


}
