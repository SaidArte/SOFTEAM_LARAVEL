<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cambiar Contraseña</div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('auth.passwords.reset.submit') }}">
                            @csrf
                            <input type="hidden" class="form-control" id='COD_USUARIO' name="COD_USUARIO" value="{{ $COD_USUARIO }}" required>
                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">Nueva Contraseña</label>
                                <div class="col-md-6">
                                    <input id="PAS_USUARIO" type="password" name="PAS_USUARIO" required autocomplete="PAS_USUARIO">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña</label>
                                <div class="col-md-6">
                                    <input id="CONF_PAS" type="password" name="CONF_PAS" required autocomplete="CONF_PAS">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>
