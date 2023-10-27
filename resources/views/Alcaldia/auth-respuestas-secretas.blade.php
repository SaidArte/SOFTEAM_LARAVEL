@extends('adminlte::page')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @if(session()->has('user_data'))
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Cambiar Pregunta de Seguridad</div>

                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif <!-- Cambiar después-->

                            <form method="POST" action="{{ route('Alcaldia.auth-respuestas-secretas.redirect') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="current_password" class="col-md-4 col-form-label text-md-right">Ingrese su contraseña: </label>

                                    <div class="form-group position-relative">
                                        <input type="password" id="PAS_USUARIO" name="PAS_USUARIO" class="form-control" required autocomplete="PAS_USUARIO"/>
                                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Siguiente</button>
                                        <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
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
                            <script>
                                function togglePasswordVisibility() {
                                    var passwordInput = document.getElementById("PAS_USUARIO");
                                    var eyeIcon = document.querySelector(".eye-icon i");

                                    if (passwordInput.type === "password") {
                                        passwordInput.type = "text"; // Mostrar contraseña
                                        eyeIcon.classList.remove("fa-eye");
                                        eyeIcon.classList.add("fa-eye-slash");
                                    } else {
                                        passwordInput.type = "password"; // Ocultar contraseña
                                        eyeIcon.classList.remove("fa-eye-slash");
                                        eyeIcon.classList.add("fa-eye");
                                    }
                                }
                            </script>
                            <style>
                                /*Estlos para icono de ojo*/
                                    .eye-icon {
                                    position: absolute;
                                    top: 50%;
                                    right: 10px;
                                    transform: translateY(-50%);
                                    cursor: pointer;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@endsection
