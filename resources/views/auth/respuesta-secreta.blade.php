<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas de Seguridad</title>
    <!-- Agrega los enlaces a los archivos de estilo de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Ingreso de Pregunta y Respuesta Secreta</h1>
        <p>Necesaria para la recuperación de la cuenta, en caso de olvido de contraseña</p>

        <form method="POST" action="{{ route('auth.respuesta-secreta.submit') }}">
            @csrf
            <input type="hidden" class="form-control" id='COD_USUARIO' name="COD_USUARIO" value="{{ $COD_USUARIO }}" required>
            <div class="mb-3">
                <label for="PREGUNTA">Pregunta de seguridad: </label>
                <select class="form-select custom-select" id="PREGUNTA" name="PREGUNTA" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    @foreach ($preguntasArreglo as $preguntas)
                    <option value="{{$preguntas['PREGUNTA']}}">{{$preguntas['PREGUNTA']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="secret_answer" class="form-label">Respuesta secreta: </label>
                <input type="password" id="RESPUESTA" class="form-control" name="RESPUESTA" placeholder="Ingrese la respuesta a la pregunta elegida" required>
                <div id="respuestaError" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="guardarButton" disabled>Guardar</button>
                <a href="{{ route('auth.login') }}" class="btn btn-secondary">Cancelar</a>
            </div>
            <br>
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <div class="text-center">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                </div>
            @endif
        </form>
    </div>

    <!-- Agrega el enlace al archivo de script de Bootstrap (si es necesario) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>