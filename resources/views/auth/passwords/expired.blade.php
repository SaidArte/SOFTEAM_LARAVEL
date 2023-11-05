<!doctype html>
<html lang="en">

<head>
  @if(session()->has('user_data'))
    <script>
    window.location.href = "{{ route('auth.login') }}"; // Cambia a 'login' si la sessión sigue activa.
    </script>
  @endif
  
  <title>Inicio de Sesión</title>
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

    /*Estlos para icono de ojo*/
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
                        <h4 class="mt-1 mb-5 pb-1">Cambio de Contraseña</h4>
                  </div>
                    <form method="POST" action="{{ route('auth.passwords.expired.submit') }}">
                        @csrf
                        <label class="form-label" for="new_password">Contraseña</label>
                        <input type="hidden" class="form-control" id='COD_USUARIO' name="COD_USUARIO" value="{{ $COD_USUARIO }}" required>
                        <input type="hidden" class="form-control" id='NOM_USUARIO' name="NOM_USUARIO" value="{{ $NOM_USUARIO }}" required>
                        <div class="form-group position-relative">
                            <input type="password" id="PAS_USUARIO" name="PAS_USUARIO" class="form-control" required autocomplete="PAS_USUARIO">
                            <span class="eye-icon" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye"></i>
                            </span>
                            <div id="error-container" style="margin-top: 10px;"></div>
                        </div>
                        <label class="form-label" for="new_password_confirmation">Confirmar Contraseña</label>
                        <div class="form-group position-relative">
                            <input type="password" id="CONF_PAS" name="CONF_PAS" class="form-control" required autocomplete="CONF_PAS">
                            <span class="eye-icon2" onclick="togglePasswordVisibility2()">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="text-center pt-1 mb-5 pb-1">
                            <button type="submit" class="btn btn-primary">Siguiente</button>
                            <a href="{{ route('auth.login') }}" class="btn btn-danger">Cancelar</a>
                        </div>
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