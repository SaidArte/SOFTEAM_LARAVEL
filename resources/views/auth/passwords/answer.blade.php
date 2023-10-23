<!doctype html>
<html lang="en">

<head>
  @if(session()->has('user_data'))
    <script>
    window.location.href = "{{ route('auth.login') }}"; // Cambia a 'home' si la sessión sigue activa.
    </script>
  @endif
  
  <title>Recuperación de Contraseña</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/estilos.css')}}">

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
                        <h4 class="mt-1 mb-5 pb-1">Recuperación de Contraseña</h4>
                  </div>
                    <form method="POST" action="{{ route('auth.passwords.answer.redirect') }}">
                        @csrf
                        <p>Pregunta Secreta:</p>
                        <div class="form-outline mb-4">
                            <input type="hidden" id="NOM_USUARIO" name="NOM_USUARIO" class="form-control" value="{{ $NOM_USUARIO }}" required>
                            <input type="text" readonly id="PREGUNTA" name="PREGUNTA" class="form-control" value="{{ $PREGUNTA }}" required>
                        </div>
                        <p>Respuesta Secreta:</p>
                        <div class="form-outline mb-4">
                            <input type="password" id="RESPUESTA" name="RESPUESTA" class="form-control" oninput="validarRespuesta(this.value)" required>
                            <div class="invalid-feedback" id="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-light toggle-password" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i> Ver Respuesta</button>
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
                    <!-- Agrega el enlace al archivo de script de Bootstrap (si es necesario) -->
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

                    <script>
                        function validarRespuesta(respuesta) {
                            var btnGuardar = document.getElementById("submitButton");
                            var inputElement = document.getElementById("RESPUESTA");
                            var invalidFeedback = document.getElementById("invalid-feedback");

                            // Quitar caracteres no deseados.
                            inputElement.value = inputElement.value.replace(/[^a-zA-Z0-9 ]/g, "");

                            if (respuesta.trim().length === 0) {
                                inputElement.classList.add("is-invalid");
                                invalidFeedback.textContent = "Por favor, escriba su respuesta secreta.";
                                btnGuardar.disabled = true;
                            } else if (respuesta.length > 100) {
                                inputElement.classList.add("is-invalid");
                                invalidFeedback.textContent = "Error: longitud máxima excedida (100 caracteres).";
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