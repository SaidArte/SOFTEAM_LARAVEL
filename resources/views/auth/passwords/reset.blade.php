<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ingrese la Contraseña</div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('auth.passwords.reset.submit') }}">
                            @csrf
                            <input type="hidden" class="form-control" id='NOM_USUARIO' name="NOM_USUARIO" value="{{ $NOM_USUARIO }}" required>
                            <input type="hidden" class="form-control" id='COD_USUARIO' name="COD_USUARIO" value="{{ $COD_USUARIO }}" required>
                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">Contraseña: </label>
                                <div class="col-md-6">
                                    <input id="PAS_USUARIO" type="password" name="PAS_USUARIO" required autocomplete="PAS_USUARIO">
                                    <input type="hidden" name="password_valid" id="passwordValid" value="0">
                                    <br>
                                    <span id="passwordError" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña: </label>
                                <div class="col-md-6">
                                    <input id="CONF_PAS" type="password" name="CONF_PAS" required autocomplete="CONF_PAS">
                                </div>
                            </div>
                            <div class="col-md-4 col-form-label text-md-right">
                                <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i> Ver Contraseña</span>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="submitButton" disabled>Cambiar Contraseña</button>
                                    <a href="{{ route('auth.login') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </div>
                            <!-- Función en javascript para no permitir dar "submit" si los campos de contraseña y confirmación no son iguales y cumplen con los requisitos -->
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    var newPasswordInput = document.getElementById("PAS_USUARIO");
                                    var confirmPasswordInput = document.getElementById("CONF_PAS");
                                    var passwordValidInput = document.getElementById("passwordValid");
                                    var passwordErrorSpan = document.getElementById("passwordError");
                                    var submitButton = document.getElementById("submitButton");

                                    function updateSubmitButtonState() {
                                        var password = newPasswordInput.value;
                                        var confirmPassword = confirmPasswordInput.value;

                                        // Validar si la contraseña es válida
                                        var isValid = validatePassword(password);

                                        if (isValid) {
                                            passwordValidInput.value = "1";
                                            passwordErrorSpan.textContent = "";

                                            // Verificar si las contraseñas coinciden
                                            if (password === confirmPassword && confirmPassword !== "") {
                                                submitButton.disabled = false;
                                            } else {
                                                passwordErrorSpan.textContent = "Confirme su nueva contraseña.";
                                                submitButton.disabled = true;
                                            }
                                        } else {
                                            passwordValidInput.value = "0";
                                            passwordErrorSpan.textContent = "La contraseña debe tener al menos 8 caracteres o no mayor de 40, una letra mayúscula, un número, un simbolo especial (@$!%*?&) y no tener espacios en blanco.";
                                            submitButton.disabled = true;
                                        }
                                    }

                                    newPasswordInput.addEventListener("input", updateSubmitButtonState);
                                    confirmPasswordInput.addEventListener("input", updateSubmitButtonState);

                                    function validatePassword(password) {
                                        // Realiza aquí las verificaciones necesarias y devuelve true si la contraseña es válida, de lo contrario, devuelve false
                                        // Por ejemplo, puedes usar expresiones regulares y otros métodos de validación aquí
                                        var minLength = 8;
                                        var maxLength = 40;
                                        var containsUpperCase = /[A-Z]/.test(password);
                                        var containsNumber = /\d/.test(password);
                                        var containsSpecialCharacter = /[@$!%*?&]/.test(password);
                                        var containsNoSpaces = !/\s/.test(password);

                                        return (
                                            password.length >= minLength &&
                                            password.length <= maxLength &&
                                            containsUpperCase &&
                                            containsNumber &&
                                            containsSpecialCharacter &&
                                            containsNoSpaces
                                        );
                                    }
                                });
                                function togglePasswordVisibility() {
                                    var passwordInput = document.getElementById("PAS_USUARIO");
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
