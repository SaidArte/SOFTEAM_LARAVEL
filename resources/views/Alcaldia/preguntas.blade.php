@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Alcaldia')

@section('content_header')
    @if(session()->has('user_data'))
            <center>
                <h1>Preguntas Almacenadas</h1>
            </center>
            <blockquote class="blockquote text-center">
                <p class="mb-0">Registro de Preguntas.</p>
                <footer class="blockquote-footer">Preguntas <cite title="Source Title">Registradas</cite></footer>
            </blockquote>

        @section('content')
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Preguntas">+ Nueva Pregunta</button>
            <div class="modal fade bd-example-modal-sm" id="Preguntas" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar una nueva pregunta</h5>
                           <!-- <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <p>Favor, ingrese la nueva pregunta:</p>
                            <form action="{{ url('Preguntas/insertar') }}" method="post" class="needs-validation preguntas-form">
                                @csrf
                                    <div class="mb-3 mt-3">
                                        <label for="PREGUNTA">Pregunta</label>
                                        <input type="text" id="PREGUNTA" class="form-control" name="PREGUNTA" placeholder="Ingrese una breve pregunta" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                        <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                            <script>
                                //Deshabilitar el envio de formularios si hay campos no validos
                                (function () {
                                    'use strict'
                                    //Obtener todos los formularios a los que queremos aplicar estilos de validacion de Bootstrap
                                    var forms = document.querySelectorAll('.needs-validation')
                                    //Bucle sobre ellos y evitar el envio
                                    Array.prototype.slice.call(forms)
                                        .forEach(function (form) {
                                            form.addEventListener('submit', function (event) {
                                                if (!form.checkValidity()) {
                                                    event.preventDefault()
                                                    event.stopPropagation()
                                                }
        
                                                form.classList.add('was-validated')
                                            }, false)
                                        })
                                })()
                                //Funcion de limpiar el formulario al momento que le demos al boton de cancelar
                                function limpiarFormulario() {
                                    document.getElementById("PREGUNTA").value = "";
                                    
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
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <table cellspacing="7" cellpadding="7" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" style="border:2px solid lime;">
                <thead>
                    <th>No.</th>
                    <th>Pregunta</th>
                    <th></th>
                </thead>
                <tbody>
                    <!-- Loop through $citaArreglo and show data -->
                    @foreach($PreguntasArreglo as $Preguntas)
                        <tr>
                            <td>{{$Preguntas['COD_PREGUNTA']}}</td>
                            <td>{{$Preguntas['PREGUNTA']}}</td>
                            <td>
                                <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#Preguntas-edit-{{$Preguntas['COD_PREGUNTA']}}">
                                    <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                                </button>
                                <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" onclick="confirmDelete({{$Preguntas['COD_PREGUNTA']}})">
                                    <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                                </button>
                            </td>
                        </tr>
                        <!-- Modal for editing goes here -->
                        <div class="modal fade bd-example-modal-sm" id="Preguntas-edit-{{$Preguntas['COD_PREGUNTA']}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar pregunta</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ingresar nuevos datos</p>
                                        <form action="{{ url('Preguntas/actualizar') }}" method="post">
                                            @csrf
                                                <input type="hidden" class="form-control" name="COD_PREGUNTA" value="{{$Preguntas['COD_PREGUNTA']}}">
                                                
                                                <div class="mb-3">
                                                    <label for="PREGUNTA">PREGUNTA</label>
                                                    <input type="text" class="form-control" id="PREGUNTA" name="PREGUNTA" placeholder="Ingrese una breve pregunta" value="{{$Preguntas['PREGUNTA']}}" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">Editar</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @stop

        @section('css')
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