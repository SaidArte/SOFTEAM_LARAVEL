@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
        <blockquote class="blockquote text-center">
            <p class="mb-0">Registro de Respuestas</p>
        </blockquote>

        @section('content')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <div class="container mt-5">
            <form method="POST" action="{{ route('Alcaldia.respuestas.submit') }}" class="needs-validation respuestas-form">
                @csrf
                <div class="mb-3 row">
                    <label for="ALPREGUNTA" class="col-sm-3 col-form-label">Pregunta anterior:</label>
                    <div class="col-sm-3">
                        <input type="text" readonly id="PREGUNTA" name="PREGUNTA" class="form-control" value="{{ $PREGUNTA }}" required>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3 row">
                    <label for="ALPREGUNTA" class="col-sm-3 col-form-label">Seleccione la pregunta de seguridad:</label>
                        <div class="col-sm-3">
                            <select class="form-select" id="PREGUNTA" name="PREGUNTA" required>
                                <option value="X" selected = "selected" disabled>- Elija una pregunta -</option>
                                @foreach ($preguntasArreglo as $preguntas)
                                    <option value="{{$preguntas['PREGUNTA']}}">{{$preguntas['PREGUNTA']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="RESPUESTA" class="form-label">Respuesta:</label>
                    <div class="form-group position-relative">
                        <input type="password" id="RESPUESTA" name="RESPUESTA" class="form-control" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye"></i>
                        </span>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
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
        <script>
            $(document).ready(function(){
                //Validaciones del nombre rol, no permite que se ingrese numeros ni caracteres especiales, solo letras
                $('#RESPUESTA').on('input', function() {
                    var respuesta = $(this).val();
                    var errorMessage = 'Ingrese su respuesta secreta no mayor de 100 caracteres y sin simbolos.';
                    // Verificar si el nombre de rol no incluye carácteres especiales ni números
                    if (respuesta.length === 0 || respuesta.length > 100 || !/^[a-zA-Z0-9\s]+$/.test(respuesta)) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').text(errorMessage);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).siblings('.invalid-feedback').text('');
                    }
                });
            });
            // Deshabilita el botón de enviar inicialmente
            $('form.needs-validation').find('button[type="submit"]').prop('disabled', true);

            // Habilita o deshabilita el botón de enviar según la validez del formulario
            $('form.needs-validation').on('input change', function() {
                var esValido = true;

                $(this).find('.form-control').each(function() {
                    if ($(this).hasClass('is-invalid') || $(this).val().trim() === '') {
                        esValido = false;
                        return false; // Sale del bucle si encuentra un campo no válido
                    }
                });

                $(this).find('button[type="submit"]').prop('disabled', !esValido);
            });  
            //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
            function limpiarFormulario() {
                    document.getElementById("ALPREGUNTA").value = "";
                    document.getElementById("RESPUESTA").value = "";

                    const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
                    invalidFeedbackElements.forEach(element => {
                        element.textContent = "";
                    });

                    const invalidFields = document.querySelectorAll(".form-control.is-invalid");
                    invalidFields.forEach(field => {
                        field.classList.remove("is-invalid");
                    });
                }

                document.getElementById("btnCancelar").addEventListener("click", function() {
                    limpiarFormulario();
                });
                // Función que se ejecutará después de enviar el formulario
                function formSubmitHandler() {
                    showSuccessMessage();
                }
                document.querySelector('.respuestas-form').addEventListener('submit', formSubmitHandler); 

                function togglePasswordVisibility() {
                    var passwordInput = document.getElementById("RESPUESTA");
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
            /*Estilos para icono de ojo*/
            .eye-icon {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                cursor: pointer;
            }
        </style>
    </div>
        @stop

        @section('css')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <link rel="stylesheet" href="/css/admin_custom.css">
        @stop

        @section('js')
         <script> console.log('Hi!'); </script>
        @stop
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@stop
    