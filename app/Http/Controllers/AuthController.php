<?php
namespace App\Http\Controllers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showChangePasswordForm()
    {
        return view('Alcaldia.change-password');
    }

    public function showUSERPASSRSTForm()
    {
        return view('auth.usuariopassreset');
    }

    public function showAPassword()
    {
        return view('auth.passwords.answer');
    }

    public function showRSTPassword()
    {
        return view('auth.passwords.reset');
    }

    public function showAuthRespuestas()
    {
        return view('Alcaldia.auth-respuestas-secretas');
    }

    public function showRespuestas()
    {
        return view('Alcaldia.respuestas');
    }

    public function showRespuestaForm()
    {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $preguntas = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_PREGUNTAS');
        $preguntasArreglo = json_decode($preguntas->body(), true);
        return view('auth.respuesta-secreta')->with('preguntasArreglo', $preguntasArreglo);
    }

    public function login(Request $request)
    {
        $NOM_USUARIO = $request->input('NOM_USUARIO');
        $PAS_USUARIO = $request->input('PAS_USUARIO');
        $CONTADOR = 0;

        $response = Http::post(self::urlapi.'api/login', [
            'NOM_USUARIO' => $NOM_USUARIO,
            'PAS_USUARIO' => $PAS_USUARIO
        ]);

        $data = $response->json();

        if ($response->successful()) {
            $user = $data['user'];
            $token = $data['token'];
            Session::put('user_data', $user); //Almacena datos del usuario.
            Session::put('token', $token); //Almacena el token.
            $COD_USUARIO = Session::get('user_data')['COD_USUARIO'];
            $NOM_USUARIO = Session::get('user_data')['NOM_USUARIO'];
            $notification = [
                'type' => 'success',
                'title' => '¡Bienvenido(a)!',
                'message' => 'Inicio de sesión exitoso'
            ];
            $CONTADOR = 0;
            $response2 = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_INT_FALLIDOS', [
                'COD_USUARIO' => $COD_USUARIO,
                'NUM_INTENTOS_FALLIDOS' => $CONTADOR,
            ]);

            $response3 = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_FECHA_ACCESO', [
                'COD_USUARIO' => $COD_USUARIO
            ]);
            $tienePregunta = Http::post(self::urlapi.'SEGURIDAD/GETONE_PREGUNTA_USUARIOS', [
                'NOM_USUARIO' => $NOM_USUARIO
            ]);
            
            $dataPregunta = $tienePregunta->json();
            if(empty($dataPregunta)){
                return redirect()->route('auth.respuesta-secreta');
            }
            return redirect()->route('home')->with('notification', $notification); // Redirigir al home y muestra un mensaje de bienvenida.
        } else {
            if ($data['error_type'] === 'inactive') {
                return redirect()->back()->with('error', 'Este usuario está inactivo. Favor, contactar con el administrador');
            } else {
                $response4 = Http::post(self::urlapi.'SEGURIDAD/GETONE_USUARIOS', [
                    'NOM_USUARIO' => $NOM_USUARIO,
                ]);
                
                $data2 = $response4->json();
                if (!empty($data2)) {
                    $CONTADOR = $data2[0]['NUM_INTENTOS_FALLIDOS'];
                    $response5 = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_INT_FALLIDOS', [
                        'COD_USUARIO' => $data2[0]['COD_USUARIO'],
                        'NUM_INTENTOS_FALLIDOS' => $CONTADOR + 1,
                    ]);

                }
                return redirect()->back()->with('error', 'Usuario o Contraseña incorrectos');
            }
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect()->route('login');
    }

    public function changePassword(Request $request)
    {
        $COD_USUARIO = Session::get('user_data')['COD_USUARIO'];
        $NOM_USUARIO = Session::get('user_data')['NOM_USUARIO'];
        $oldPassword = $request->input('PAS_USUARIO');
        $newPassword = $request->input('newPassword');
        $confPassword = $request->input('confPassword');
        $response = Http::post(self::urlapi.'api/login', [
            'NOM_USUARIO' => $NOM_USUARIO,
            'PAS_USUARIO' => $oldPassword,
        ]);

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Favor, ingrese su contraseña actual')->withInput();
        }

        if ($oldPassword == $newPassword) {
            return redirect()->back()->with('error', 'Favor, ingrese una contraseña diferente a la actual')->withInput();
        } elseif ($newPassword != $confPassword || $newPassword == "") {
            return redirect()->back()->with('error', 'Favor, ingrese una contraseña y confirmela')->withInput();
        }

        $response2 = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PASS_USUARIOS', [
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

    public function authResetPassword(Request $request)
    {
        $NOM_USUARIO = $request->input('NOM_USUARIO');

        $response = Http::post(self::urlapi.'SEGURIDAD/GETONE_PREGUNTA_USUARIOS', [
            'NOM_USUARIO' => $NOM_USUARIO,
        ]);

        $data = $response->json();
        if (!empty($data)) {
            $PREGUNTA = $data[0]['PREGUNTA'];
            return view('auth.passwords.answer')->with('PREGUNTA', $PREGUNTA)->with('NOM_USUARIO', $NOM_USUARIO);
        } else {
            return redirect()->back()->with('error', 'Favor, ingrese un usuario valido')->withInput();
        }
    }

    public function answerResetPassword(Request $request)
    {
        $RESPUESTA = $request->input('RESPUESTA');
        $NOM_USUARIO = $request->input('NOM_USUARIO');
        
        $response = Http::post(self::urlapi.'SEGURIDAD/GETONE_RESPUESTAS', [
            'RESPUESTA' => $RESPUESTA,
            'NOM_USUARIO' => $NOM_USUARIO,
        ]);
        $data = $response->json();

        if (!empty($data)) {
            $COD_USUARIO = $data[0]['COD_USUARIO'];
            return view('auth.passwords.reset')->with('COD_USUARIO', $COD_USUARIO);
        } else {
            return redirect()->back()->with('error', 'Favor, ingrese su respuesta secreta')->withInput();
        }
    }

    public function resetPassword(Request $request)
    {
        $COD_USUARIO = $request->input('COD_USUARIO');
        $PAS_USUARIO = $request->input('PAS_USUARIO');
        $CONF_PAS = $request->input('CONF_PAS');

        if ($PAS_USUARIO == $CONF_PAS && $PAS_USUARIO != ""){
            $response = Http::put(self::urlapi.'SEGURIDAD/ACTUALIZAR_PASS_USUARIOS', [
                'COD_USUARIO' => $COD_USUARIO,
                'PAS_USUARIO' => $PAS_USUARIO,
            ]);

            $data = $response->json();

            if ($response->successful()) {
                $notification = [
                    'type' => 'success',
                    'title' => 'Cambio de contraseña',
                    'message' => 'Tu contraseña ha sido actualizada con éxito.'
                ];
                
                return redirect()->route('login')
                    ->with('notification', $notification);
            } else {
                return redirect()->back()->with('error', 'Error interno del servidor')->withInput();
            }
        } else {
            return redirect()->back()->with('error', 'Favor, ingrese una contraseña y confirmela')->withInput();
        }
    }

    public function authUsuarioPregunta(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $NOM_USUARIO = Session::get('user_data')['NOM_USUARIO'];
        $PAS_USUARIO = $request->input('PAS_USUARIO');

        $response = Http::withHeaders($headers)->post(self::urlapi.'api/login', [
            'NOM_USUARIO' => $NOM_USUARIO,
            'PAS_USUARIO' => $PAS_USUARIO
        ]);
        
        if ($response->successful()) {
            $preguntas = Http::withHeaders($headers)->get(self::urlapi.'SEGURIDAD/GETALL_PREGUNTAS');
            $preguntasArreglo = json_decode($preguntas->body(), true);
            $response2 = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_PREGUNTA_USUARIOS', [
                'NOM_USUARIO' => $NOM_USUARIO,
            ]);
            $data2 = $response2->json();
            if (!empty($data2)) {
                $PREGUNTA = $data2[0]['PREGUNTA'];
            }
            return view('Alcaldia.respuestas')->with('preguntasArreglo', $preguntasArreglo)->with('PREGUNTA', $PREGUNTA);
        } else {
            return redirect()->back()->with('error', 'Favor, ingrese su contraseña correctamente')->withInput();
        }
    }

    public function respuestaSeguridad(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];
        $COD_USUARIO = Session::get('user_data')['COD_USUARIO'];
        $PREGUNTA = $request->input('PREGUNTA');
        $RESPUESTA = $request->input('RESPUESTA');

        $response = Http::withHeaders($headers)->put(self::urlapi.'SEGURIDAD/ACTUALIZAR_RESPUESTAS', [
            'COD_USUARIO' => $COD_USUARIO,
            'PREGUNTA' => $PREGUNTA,
            'RESPUESTA' => $RESPUESTA
        ]);

        $data = $response->json();
        if (!empty($data)) {
            $notification = [
                'type' => 'success',
                'title' => 'Actualización de Pregunta/Respuesta de Seguridad',
                'message' => 'Cambios realizados con éxito.'
            ];
            
            return redirect()->route('home')
                ->with('notification', $notification);
        } else {
            return redirect()->back()->with('error', 'Favor, ingrese su respuesta correctamente')->withInput();
        }
    }

    public function tienePermiso($rol, $objeto)
    {
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        $response = Http::withHeaders($headers)->post(self::urlapi.'SEGURIDAD/GETONE_SOLOPERMISOS', [
            'NOM_ROL' => $rol,
            'OBJETO' => $objeto,
            // Otras posibles variables que tu API necesita
        ]);

            $permisos = $response->json();
        if (!empty($permisos)) {

            // Almacena los valores de permisos en la sesión
            Session::put([
                'PRM_INSERTAR' => $permisos[0]['PRM_INSERTAR'],
                'PRM_ACTUALIZAR' => $permisos[0]['PRM_ACTUALIZAR'],
                'PRM_CONSULTAR' => $permisos[0]['PRM_CONSULTAR'],
            ]);
        }else{
            Session::forget(['PRM_INSERTAR', 'PRM_ACTUALIZAR', 'PRM_CONSULTAR']);
        }
    }

    public function InsertarRespuestaSeguridad(Request $request)
    {
        $COD_USUARIO = Session::get('user_data')['COD_USUARIO'];
        $PREGUNTA = $request->input('PREGUNTA');
        $RESPUESTA = $request->input('RESPUESTA');

        $response = Http::post(self::urlapi.'SEGURIDAD/INSERTAR_RESPUESTAS', [
            'COD_USUARIO' => $COD_USUARIO,
            'PREGUNTA' => $PREGUNTA,
            'RESPUESTA' => $RESPUESTA
        ]);

        if ($response->successful()) {
            $notification = [
                'type' => 'success',
                'title' => '¡Respuesta Guardada!',
                'message' => 'Puede volver a iniciar sesión'
            ];
            Session::flush();
            return redirect()->route('login')->with('notification', $notification);
        } else {
            return redirect()->route('login')->with('error', 'Favor, ingrese su respuesta correctamente');
        }
    }

}