@extends('adminlte::page')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @if(session()->has('user_data'))
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Cambiar Contraseña ({{ session('user_data')['NOM_PERSONA'] }})</div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('change.password.submit') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="PAS_USUARIO" class="col-md-4 col-form-label text-md-right">Contraseña Actual</label>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <input id="PAS_USUARIO" type="password" name="PAS_USUARIO" class="form-control" required autocomplete="PAS_USUARIO">
                                            <span id="actual" class="eye-icon" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password" class="col-md-4 col-form-label text-md-right">Nueva Contraseña</label>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <input id="newPassword" type="password" name="newPassword" class="form-control" required autocomplete="newPassword">
                                            <input type="hidden" name="password_valid" id="passwordValid" value="0">
                                            <span id="nueva" class="eye-icon2" onclick="togglePasswordVisibility2()"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6">
                                        <span id="passwordError" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña</label>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <input id="confPassword" type="password" name="confPassword" class="form-control" required autocomplete="confPassword">
                                            <span id="confirmar" class="eye-icon3" onclick="togglePasswordVisibility3()"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary" id="submitButton" disabled>Guardar</button>
                                        <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        var newPasswordInput = document.getElementById("newPassword");
                                        var passwordValidInput = document.getElementById("passwordValid");
                                        var passwordErrorSpan = document.getElementById("passwordError");
                                        var submitButton = document.getElementById("submitButton");

                                        newPasswordInput.addEventListener("input", function () {
                                            var password = newPasswordInput.value;
                                            var isValid = validatePassword(password);

                                            if (isValid) {
                                                passwordValidInput.value = "1";
                                                passwordErrorSpan.textContent = "";
                                                submitButton.disabled = false;
                                            } else {
                                                passwordValidInput.value = "0";
                                                passwordErrorSpan.textContent = "La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número, un simbolo especial (@$!%*?&), ser no mayor de 40 caracteres y no tener espacios en blanco.";
                                                submitButton.disabled = true;
                                            }
                                        });

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
                                        var passwordInput2 = document.getElementById("newPassword");
                                        var toggleIcon = document.querySelector(".eye-icon2 i");

                                        if (passwordInput2.type === "password") {
                                            passwordInput2.type = "text";
                                            toggleIcon.classList.remove("fa-eye");
                                            toggleIcon.classList.add("fa-eye-slash");
                                        } else {
                                            passwordInput2.type = "password";
                                            toggleIcon.classList.remove("fa-eye-slash");
                                            toggleIcon.classList.add("fa-eye");
                                        }
                                    }

                                    function togglePasswordVisibility3() {
                                        var passwordInput2 = document.getElementById("confPassword");
                                        var toggleIcon = document.querySelector(".eye-icon3 i");

                                        if (passwordInput2.type === "password") {
                                            passwordInput2.type = "text";
                                            toggleIcon.classList.remove("fa-eye");
                                            toggleIcon.classList.add("fa-eye-slash");
                                        } else {
                                            passwordInput2.type = "password";
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
                                        right: 10px;
                                        transform: translateY(-50%);
                                        cursor: pointer;
                                    }

                                    .eye-icon2 {
                                        position: absolute;
                                        top: 50%;
                                        right: 10px;
                                        transform: translateY(-50%);
                                        cursor: pointer;
                                    }

                                    .eye-icon3 {
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
                    </div>
                </div>
            </div>
        </div>
         <!-- MENSAJE BAJO -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        2023 &copy; UNAH  
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a>Version 1.0</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- FIN MENSAJE -->
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@endsection
