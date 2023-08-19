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

        <form method="POST" action="{{ route('auth.usuariopassreset.redirect') }}">
            @csrf
            <div class="mb-3 row">
                <label for="NOM_USUARIO" class="col-sm-3 col-form-label">Ingrese su usuario:</label>
                <div class="col-sm-3">
                    <input type="text" id="NOM_USUARIO" name="NOM_USUARIO" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
                <a href="{{ route('auth.login') }}" class="btn btn-secondary btn-sm">Cancelar</a>
            </div>
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