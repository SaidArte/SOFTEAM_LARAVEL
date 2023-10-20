<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <!-- Agrega los enlaces a los archivos de estilo de Bootstrap y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Recuperación de Contraseña</h1>

        <form method="POST" action="{{ route('auth.passwords.answer.redirect') }}">
            @csrf
            <div class="mb-3">
                <label for="PREGUNTA" class="form-label">Pregunta Secreta:</label>
                <input type="hidden" id="NOM_USUARIO" name="NOM_USUARIO" class="form-control" value="{{ $NOM_USUARIO }}" required>
                <input type="text" readonly id="PREGUNTA" name="PREGUNTA" class="form-control" value="{{ $PREGUNTA }}" required>
            </div>

            <div class="mb-3">
                <label for="secret_answer" class="form-label">Respuesta Secreta:</label>
                <input type="password" id="RESPUESTA" name="RESPUESTA" class="form-control" oninput="validarRespuesta(this.value)" required>
                <div class="invalid-feedback" id="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-light toggle-password" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i> Ver Respuesta</button>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submitButton">Enviar</button>
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
        <script>
            function validarRespuesta(respuesta) {
                var btnGuardar = document.getElementById("submitButton");
                var inputElement = document.getElementById("RESPUESTA");
                var invalidFeedback = document.getElementById("invalid-feedback");

                // Quitar simbolos.
                inputElement.value = inputElement.value.replace(/[^a-zA-Z0-9 ]/g, "");
                /*Al agregar un espacio en la expresión regular (junto con a-zA-Z0-9), se permite 
                que se ingresen espacios en la respuesta secreta mientras aún se eliminan otros 
                caracteres no deseados. Esto debería funcionar para permitir espacios en la entrada.*/
                if (respuesta.length === 0) {
                    inputElement.classList.add("is-invalid");
                    invalidFeedback.textContent = "Favor, escriba su respuesta secreta.";
                    btnGuardar.disabled = true;
                } else if (respuesta.length > 100) {
                    inputElement.classList.add("is-invalid");
                    invalidFeedback.textContent = "Error, desbordamiento del campo. Las respuestas son menores de 100 caracteres.";
                    btnGuardar.disabled = true;
                } else {
                    inputElement.classList.remove("is-invalid");
                    invalidFeedback.textContent = "";
                    btnGuardar.disabled = false;
                }
            }

            function togglePasswordVisibility() {
                var passwordInput = document.getElementById("RESPUESTA");
                var toggleIcon = document.querySelector(".toggle-password i");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    toggleIcon.classList.remove("fa-eye");
                    toggleIcon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password";
                    toggleIcon.classList.remove("fa-eye-slash");
                    toggleIcon.classList.add("fa-eye");
                }
            }
        </script>
    </div>

    <!-- Agrega el enlace al archivo de script de Bootstrap (si es necesario) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
