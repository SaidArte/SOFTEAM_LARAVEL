
<!doctype html>
<html lang="en">

<head>
  @if(session()->has('user_data'))
    <script>
    window.location.href = "{{ route('auth.login') }}"; // Cambia a 'home' si la sessión sigue activa.
    </script>
  @endif
  
  <title>Ingrese la Contraseña</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/estilos.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Importando la fuente de Google Font -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  </style>

  <style>
    /* Fuente de Google Fonts */
    font-family: 'Poppins', sans-serif;
  </style>
  
  <style>
    /* Estilos de color al boton de Iniciar */
    .gradient-environmental {
      background: linear-gradient(to right, #3BB78F, #0F4C75); /* Ajustar los colores según las preferencias */
    }
    .gradient-environmental-red {
    background: linear-gradient(to right, #800000, #800000); /* Cambia el gradiente a rojo */
    }
    .custom-button {
    background: #cc3333; /* Color de fondo rojo */
    /* Agrega otros estilos según tus necesidades */
    color: white; /* Texto en color blanco */
    border: none; /* Sin borde */
    /* Agrega otros estilos según tus necesidades */
    }

    /* Estilos al boton de crear uno nuevo */
    .cta {
      position: relative;
      margin: auto;
      padding: 12px 18px;
      transition: all 0.2s ease;
      border: none;
      background: none;
      }

    .cta:before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      border-radius: 50px;
      background: #b1dae7;
      width: 45px;
      height: 45px;
      transition: all 0.3s ease;
    }

    .cta span {
      position: relative;
      font-family: "Ubuntu", sans-serif;
      font-size: 18px;
      font-weight: 700;
      letter-spacing: 0.05em;
      color: #234567;
    }

    .cta svg {
      position: relative;
      top: 0;
      margin-left: 10px;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
      stroke: #234567;
      stroke-width: 2;
      transform: translateX(-5px);
      transition: all 0.3s ease;
    }

    .cta:hover:before {
      width: 100%;
      background: #b1dae7;
    }

    .cta:hover svg {
      transform: translateX(0);
    }

    .cta:active {
      transform: scale(0.95);
    }
  </style>
  <style> /* estilo para el error al iniciar sesion */
    .error-message {
        display: none;
        color: #dc3545;
        font-size: 14px;
        font-weight: 500;
        margin-top: 5px;
    }
  </style>

</head>

<body>
  <section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                      <img src="vendor/adminlte/dist/img/Talanga.png"
                        style="width: 150px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">Ingrese la Contraseña</h4>
                  </div>
                    <form method="POST" action="{{ route('auth.passwords.reset.submit') }}">
                        @csrf
                        <input type="hidden" class="form-control" id='NOM_USUARIO' name="NOM_USUARIO" value="{{ $NOM_USUARIO }}" required>
                        <input type="hidden" class="form-control" id='COD_USUARIO' name="COD_USUARIO" value="{{ $COD_USUARIO }}" required>
                        <label for="new_password" class="col-md-4 col-form-label text-md-right">Contraseña: </label>
                        <div class="form-outline mb-4">
                            <input type="password" id="PAS_USUARIO" name="PAS_USUARIO" class="form-control" required autocomplete="PAS_USUARIO">
                            <input type="hidden" name="password_valid" id="passwordValid" value="0">
                                    <br>
                                    <span id="passwordError" class="text-danger"></span>
                        </div>
                        <p>Confirmar Contraseña</p>
                        <div class="form-outline mb-4">
                            <input id="CONF_PAS" type="password" name="CONF_PAS" class="form-control" required autocomplete="CONF_PAS">
                            <div class="invalid-feedback" id="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <span class="btn btn-light toggle-password" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i> Ver Contraseña</span>
                        </div>
                        <div class="text-center pt-1 mb-5 pb-1">
                            <button type="submit" class="btn btn-primary" id="submitButton" disabled>Guardar</button>
                            <a href="{{ route('auth.login') }}" class="btn btn-danger">Cancelar</a>
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
                        @if(session('notification'))
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        Swal.fire({
                                            icon: '{{ session('notification')['type'] }}',
                                            title: '{{ session('notification')['title'] }}',
                                            text: '{{ session('notification')['message'] }}',
                                        });
                                    </script>
                        @endif
                    </form>
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center gradient-environmental">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <center><h4 class="mb-4">BIENVENIDOS AL DEPARTAMENTO DE JUSTICIA MUNICIPAL DE TALANGA</h4></center>
                  <center><h3 class="mb-3">0824</h3></center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>
</html>