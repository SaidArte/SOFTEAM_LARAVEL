<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <!-- Agrega los enlaces a los archivos de estilo de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Recuperación de Contraseña</h1>

        <form method="POST" action="{{ route('auth.passwords.answer.redirect') }}">
            @csrf
            <div class="mb-3">
                <label for="PREGUNTA" class="form-label">Pregunta Secreta:</label>
                <input type="text" readonly id="PREGUNTA" name="PREGUNTA" class="form-control" value="{{ $PREGUNTA }}" required>
            </div>

            <div class="mb-3">
                <label for="secret_answer" class="form-label">Respuesta Secreta:</label>
                <input type="password" id="RESPUESTA" name="RESPUESTA" class="form-control" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Enviar</button>
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
