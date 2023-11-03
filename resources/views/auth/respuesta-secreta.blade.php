<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas de Seguridad</title>
    <!-- Agrega los enlaces a los archivos de estilo de Bootstrap y Font Awesome (este último 
    para darle estilos al botón de ver respuestas secretas y contraseñas). -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><center>Pregunta de Seguridad</center></h1>
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
                <label for="secret_answer" class="form-label">Respuesta: </label>
                <div class="form-group position-relative">
                    <input type="password" id="RESPUESTA" name="RESPUESTA" class="form-control" oninput="validarRespuesta(this.value)" required>
                    <span class="eye-icon" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                    <div class="invalid-feedback" id="invalid-feedback"></div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submitButton">Guardar</button>
                <a href="{{ route('auth.login') }}" class="btn btn-danger">Cancelar</a>
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
                var toggleIcon = document.querySelector(".eye-icon i");

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
        <style>
            .eye-icon {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                cursor: pointer;
            }
        </style>
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