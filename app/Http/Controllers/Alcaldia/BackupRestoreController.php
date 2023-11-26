<?php

namespace App\Http\Controllers\Alcaldia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class BackupRestoreController extends Controller
{
    const urlapi = 'http://82.180.133.39:4000/';

    public function backuprestore(Request $request, $filename = null)
    {
        // Código para la cabecera
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        // Si se proporciona un nombre de archivo, intenta descargarlo
        if ($filename) {
            return $this->descargarBackup($filename);
        }

        // Hacer la solicitud a la API de Express para obtener la lista de archivos de respaldo
        $backuprestore = Http::withHeaders($headers)->get(self::urlapi . 'SEGURIDAD/BACKUP-LIST');
        
        // Decodificar la respuesta JSON y obtener la lista de archivos
        $response = json_decode($backuprestore->body(), true);
        $citaArreglo = $response['Archivos de respaldo'] ?? [];

        // Pasar la lista de archivos a la vista junto con la URL API
        return view('Alcaldia.backuprestore', ['citaArreglo' => $citaArreglo, 'urlapi' => self::urlapi]);

    }

    private function descargarBackup($filename)
    {
        $token = Session::get('token');
        try {

            // Ajusta la ruta del almacenamiento según tu configuración
            $backupPath = storage_path('app/backups/' . $filename);

            // Verificar si el archivo existe
            if (!file_exists($backupPath)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }

            // Configurar el encabezado de la respuesta para la descarga
            return response()->download($backupPath, $filename, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename=' . $filename,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al descargar el archivo de respaldo: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function downloadBackup($filename)
    {
        // Ajusta la ruta del almacenamiento según tu configuración
        $backupPath = storage_path('app/backups/' . $filename);

        // Verificar si el archivo existe
        if (!file_exists($backupPath)) {
            abort(404);
        }

        // Configurar el encabezado de la respuesta para la descarga
        return response()->download($backupPath, $filename, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ]);
    }

    public function deleteBackup($filename)
    {
        // Código para la cabecera
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        // Realiza la solicitud a la API para eliminar el respaldo
        $response = Http::withHeaders($headers)->get(self::urlapi . 'SEGURIDAD/BACKUP-DELETE/' . $filename);

        // Decodifica la respuesta JSON
        $data = $response->json();

        // Maneja la respuesta según sea necesario (puedes redirigir, mostrar mensajes, etc.)
        if (isset($data['message'])) {
            return redirect()->route('backuprestore.index')->with('success', $data['message']);
        } elseif (isset($data['error'])) {
            return redirect()->route('backuprestore.index')->with('error', $data['error']);
        } else {
            // Manejo de otra respuesta inesperada
            return redirect()->route('backuprestore.index')->with('error', 'Error inesperado al eliminar el respaldo.');
        }
    }

    public function restaurarBackup()
    {
        // Código para la cabecera
        $headers = [
            'Authorization' => 'Bearer ' . Session::get('token'),
        ];

        try {
            // Realiza la solicitud a la API para restaurar la base de datos
            $response = Http::withHeaders($headers)->post(self::urlapi . 'SEGURIDAD/RESTAURAR-BACKUP');

            // Decodifica la respuesta JSON
            $data = $response->json();

            // Maneja la respuesta según sea necesario (puedes redirigir, mostrar mensajes, etc.)
            if (isset($data['message'])) {
                return redirect()->route('backuprestore.index')->with('success', $data['message']);
            } elseif (isset($data['error'])) {
                return redirect()->route('backuprestore.index')->with('error', $data['error']);
            } else {
                // Manejo de otra respuesta inesperada
                return redirect()->route('backuprestore.index')->with('error', 'Error inesperado al restaurar la base de datos.');
            }
        } catch (\Exception $e) {
            \Log::error('Error al restaurar la base de datos: ' . $e->getMessage());
            return redirect()->route('backuprestore.index')->with('error', 'Error interno del servidor al restaurar la base de datos.');
        }
        
    }

}
