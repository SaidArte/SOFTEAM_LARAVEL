<!doctype html>
<html lang="en">

<head>
  <title>Inicio de Sesión</title>
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
                        <h4 class="mt-1 mb-5 pb-1">Inicio de Sesión</h4>
                  </div>

                  <form action="{{ route('auth.login') }}" method="post">
                  @csrf
                    <p><center>Ingresa tu Usuario y Contraseña</center></p>
                    <div class="form-outline mb-4">
                      <input type="text" id="NOM_USUARIO" name="NOM_USUARIO" class="form-control"
                        placeholder="Usuario" value="{{ old('NOM_USUARIO') }}"/>
                      <label class="form-label" for="COD_USUARIO">Usuario</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" id="PAS_USUARIO" name="PAS_USUARIO" class="form-control"
                        placeholder="Contraseña" />
                      <label class="form-label" for="PAS_USUARIO">Contraseña</label>
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                        <button type="submit" class="btn btn-primary btn-block fa-lg gradient-environmental mb-2">  Iniciar  </button>
                  </div>
                  <div>
                  <center> <a class="text-muted" href="{{ route('auth.usuariopassreset') }}">¿Olvidaste la contraseña?</a></center>
                  </div>
                    @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <div class="text-center">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    </div>
                    @endif
              <!--  <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">¿No tienes Usuario?</p>
                      <button class="cta">
                        <span>Crear uno Nuevo</span>
                        <svg viewBox="0 0 13 10" height="10px" width="15px">
                          <path d="M1,5 L11,5"></path>
                          <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                      </button>
                    </div> -->
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
<script>
  // JavaScript para mostrar u ocultar el mensaje de error
  document.addEventListener("DOMContentLoaded", function () {
    const mensajeError = document.getElementById("mensajeError");
    
    // Mostrar el mensaje de error
    function mostrarMensajeError() {
      mensajeError.style.display = "block";
    }
    
    // Ocultar el mensaje de error
    function ocultarMensajeError() {
      mensajeError.style.display = "none";
    }
    
    // Agregar eventos para mostrar u ocultar el mensaje
    document.getElementById("COD_USUARIO").addEventListener("input", ocultarMensajeError);
    document.getElementById("PAS_USUARIO").addEventListener("input", ocultarMensajeError);
    
    // Mostrar el mensaje de error al enviar el formulario
    document.querySelector("form").addEventListener("submit", mostrarMensajeError);
  });
</script>

</html>
