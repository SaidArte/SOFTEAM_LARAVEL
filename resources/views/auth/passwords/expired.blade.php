<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Contraseña</title>
    <!-- Agrega los enlaces a los archivos de estilo de Bootstrap y Font Awesome (este último 
    para darle estilos al botón de ver respuestas secretas y contraseñas). -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cambiar Contraseña</div>
                    <div class="card-body">
                        <p>Su contraseña a expirado. Favor, ingrese una nueva.</p>

                        <form method="POST" action="{{ route('auth.passwords.expired.submit') }}">
                            @csrf
                            <input type="hidden" class="form-control" id='COD_USUARIO' name="COD_USUARIO" value="{{ $COD_USUARIO }}" required>
                            <input type="hidden" class="form-control" id='NOM_USUARIO' name="NOM_USUARIO" value="{{ $NOM_USUARIO }}" required>
                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">Nueva Contraseña: </label>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <input id="PAS_USUARIO" type="password" name="PAS_USUARIO" required autocomplete="PAS_USUARIO">
                                        <span class="eye-icon" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <div id="error-container" style="margin-top: 10px;"></div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña: </label>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <input id="CONF_PAS" type="password" name="CONF_PAS" required autocomplete="CONF_PAS">
                                        <span class="eye-icon2" onclick="togglePasswordVisibility2()"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="{{ route('auth.login') }}" class="btn btn-danger">Cancelar</a>
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
    <!-- Función en javascript para no permitir dar "submit" si los campos de contraseña y confirmación no son iguales -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const newPasswordInput = document.getElementById("PAS_USUARIO");
            const confirmPasswordInput = document.getElementById("CONF_PAS");
            const submitButton = document.querySelector("button[type='submit']");
            const errorContainer = document.getElementById("error-container");

            function updateSubmitButtonState() {
                const password = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // Verificar que la contraseña no sea menor de 8 caracteres
                const isPasswordValidLength = password.length >= 8 && password.length <= 40;

                // Verificar que la contraseña incluya al menos un número
                const containsNumber = /\d/.test(password);

                // Verificar que la contraseña incluya al menos una letra mayúscula
                const containsUppercase = /[A-Z]/.test(password);

                // Verificar que la contraseña incluya al menos un símbolo especial
                const containsSpecialCharacter = /[!@#$%^&*]/.test(password);

                // Verificar que no se puedan ingresar espacios en blanco
                const hasNoSpaces = !/\s/.test(password);

                // Limpiar los mensajes de error anteriores
                errorContainer.innerHTML = "";

                // Comprobar cada restricción y mostrar mensajes de error apropiados
                if (!isPasswordValidLength) {
                    addErrorMessage("- La contraseña debe ser mayor de 8 caracteres y no mayor de 40.");
                }

                if (!containsNumber) {
                    addErrorMessage("- La contraseña debe contener al menos un número.");
                }

                if (!containsUppercase) {
                    addErrorMessage("- La contraseña debe contener al menos una letra mayúscula.");
                }

                if (!containsSpecialCharacter) {
                    addErrorMessage("- La contraseña debe contener al menos un símbolo especial (!@#$%^&*).");
                }

                if (!hasNoSpaces) {
                    addErrorMessage("- La contraseña no puede contener espacios en blanco.");
                }

                // Habilitar el botón si todas las restricciones se cumplen
                if (
                    isPasswordValidLength &&
                    containsNumber &&
                    containsUppercase &&
                    containsSpecialCharacter &&
                    hasNoSpaces &&
                    password === confirmPassword
                ) {
                    submitButton.removeAttribute("disabled");
                } else {
                    submitButton.setAttribute("disabled", "disabled");
                }
            }

            function addErrorMessage(message) {
                const errorElement = document.createElement("div");
                errorElement.className = "alert alert-danger"; // Aplicar una clase CSS para estilo de alerta roja
                errorElement.textContent = message;
                errorContainer.appendChild(errorElement);
            }

            newPasswordInput.addEventListener("input", updateSubmitButtonState);
            confirmPasswordInput.addEventListener("input", updateSubmitButtonState);
        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("PAS_USUARIO");
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

        function togglePasswordVisibility2() {
            var passwordInput = document.getElementById("CONF_PAS");
            var toggleIcon = document.querySelector(".eye-icon2 i");

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
        /*Estilos para icono de ojo*/
        .eye-icon {
            position: absolute;
            top: 50%;
            left: 165px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .eye-icon2 {
            position: absolute;
            top: 50%;
            left: 165px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</body>
</html>