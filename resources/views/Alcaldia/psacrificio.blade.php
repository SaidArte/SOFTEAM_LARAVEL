@extends('adminlte::page')

@section('title', 'Alcaldia')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- confirmDelete -->
@section('js')
    <script>
        function confirmDelete(id) {
            $('#psacrificio-delete-confirm').modal('show');
            $('#delete-form').attr('action', '{{ url("psacrificio/eliminar") }}/' + id);
        }
    </script>
@stop

@section('css')
    <!-- Agrega la clase CSS personalizada aquí -->
    <style>
        /* CSS personalizado */
        .custom-delete-button:hover .fas.fa-trash-alt {
            color: white !important;
        }
    </style>
@stop

@section('content_header')

    <center>
        <h1>INFORMACIÓN DE LOS PERMISOS DE SACRIFICIO</h1>
    </center>

    <br>
        <center>
            <p class="mb-0">Permiso de Sacrificio</p>
            <footer class="blockquote-footer">Permisos <cite title="Source Title"> Otorgados</cite></footer>
        </center>
    </br>

@stop

@section('content')
    <p align="right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#psacrificio">+ Nuevo</button>
    </p>
    <div class="modal fade bd-example-modal-sm" id="psacrificio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title">Ingresa un Nuevo Permiso de Sacrificio</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                   
                </div>
                <div class="modal-body">
                    <p>Ingresar Datos Solicitados:</p>
                    <form action="{{ url('psacrificio/insertar') }}" method="post" class="needs-validation">
                        @csrf
                            
                            <div class="mb-3">
                                <label for="NOM_PERSONA">Nombre de la Persona</label>
                                <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre de la persona" required>
                                <div class="invalid-feedback"></div>
                            </div>
                       
                            <div class="mb-3">
                                <label for="DNI_PERSONA">Numero de Identidad</label>
                                <input type="text" id="DNI_PERSONA" class="form-control" name="DNI_PERSONA" placeholder="Ingresar el numero de identidad" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="TEL_PERSONA">Numero de Telefono</label>
                                <input type="text" id="TEL_PERSONA" class="form-control" name="TEL_PERSONA" placeholder="Ingresar el numero de telefono" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="FEC_SACRIFICIO">Fecha del Sacrificio</label>
                                <input type="date" id="FEC_SACRIFICIO" class="form-control" name="FEC_SACRIFICIO" placeholder="Inserte la fecha del sacrificio" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="COD_ANIMAL">Codigo del Animal</label>
                                <input type="text" id="COD_ANIMAL" class="form-control" name="COD_ANIMAL" placeholder="Inserte el codigo del animal" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="DIR_PSACRIFICIO">Direccion del Sacrificio</label>
                                <input type="text" id="DIR_PSACRIFICIO" class="form-control" name="DIR_PSACRIFICIO" placeholder="Ingresar la direccion del sacrificio" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                    </form>

                    <script>
                        // Aplicar las validaciones a cada dato solicitado en el formulario
                        $(document).ready(function() {
                            // Validaciones al campo Nombre Persona
                            $('#NOM_PERSONA').on('input', function() {
                                var nombre = $(this).val();
                                var errorMessage = 'El nombre debe tener al menos 3 caracteres';
                                if (nombre.length < 3) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            // Validaciones al campo DNI Persona
                            $('#DNI_PERSONA').on('input', function() {
                                var dni = $(this).val();
                                var errorMessage = 'El DNI debe tener exactamente 13 caracteres';
                                if (dni.length !== 13) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            // Validaciones al campo Telefono Persona
                            $('#TEL_PERSONA').on('input', function() {
                                var telefono = $(this).val();
                                var errorMessage = 'El teléfono debe tener exactamente 8 dígitos';
                                if (!/^\d{8}$/.test(telefono)) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            // Validaciones al campo Fecha de Sacrificio
                            $('#FEC_SACRIFICIO').on('input', function() {
                                var fechaSacrificio = $(this).val();
                                var currentDate = new Date().toISOString().split('T')[0];
                                var errorMessage = 'La fecha debe ser válida y no puede ser anterior a hoy';
                                
                                if (!fechaSacrificio || fechaSacrificio < currentDate) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            // Validaciones al Codigo del Animal
                            $('#COD_ANIMAL').on('input', function() {
                                var codigoAnimal = $(this).val();
                                // Implementar la lógica para verificar si el código ya existe
                                // y mostrar el mensaje de error correspondiente si ya está en uso.
                            });
                            // Validaciones a la Direccion del Sacrificio
                            $('#DIR_PSACRIFICIO').on('input', function() {
                                var direccionSacrificio = $(this).val();
                                var errorMessage = 'La dirección debe tener al menos 5 caracteres';
                                
                                if (direccionSacrificio.length < 5) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                        });

                        // Ejemplo de JavaScript inicial para deshabilitar el envío de formularios si hay campos no válidos
                        (function () {
                        'use strict'

                        // Obtener todos los formularios a los que queremos aplicar estilos de validación de Bootstrap personalizados
                        var forms = document.querySelectorAll('.needs-validation')

                        // Bucle sobre ellos y evitar el envío
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

                        // Función para limpiar los campos del formulario y las validaciones
                        function limpiarFormulario() {
                            document.getElementById("NOM_PERSONA").value = "";
                            document.getElementById("DNI_PERSONA").value = "";
                            document.getElementById("TEL_PERSONA").value = "";
                            document.getElementById("FEC_SACRIFICIO").value = "";
                            document.getElementById("COD_ANIMAL").value = "";
                            document.getElementById("DIR_PSACRIFICIO").value = "";

                            // Limpiar las clases de validación
                            const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
                            invalidFeedbackElements.forEach(element => {
                                element.textContent = "";
                            });

                            // Remover clases de validación de campos inválidos
                            const invalidFields = document.querySelectorAll(".form-control.is-invalid");
                            invalidFields.forEach(field => {
                                field.classList.remove("is-invalid");
                            });
                        }

                        // Evento click para el botón de "Cancelar"
                        document.getElementById("btnCancelar").addEventListener("click", function() {
                            limpiarFormulario();
                        });

                    </script>
                </div>
            </div>
        </div>
    </div>

    <table cellspacing="8" cellpadding="8" class="Table table-hover table-hover table-responsive table-verde-claro table-striped mt-1" >
        <thead>
            <th>Nº</th>
            <th>Nombre</th>
            <th>Numero de Identidad</th>
            <th>Telefono</th>
            <th>Fecha del Sacrificio</th>
            <th>Direccion del Sacrificio</th>
            <th>Registro del Animal</th>
            <th>Opciones de la Tabla</th>
            <th></th>
        </thead>
        <tbody>
            <!-- Loop through $citaArreglo and show data -->
            @foreach($citaArreglo as $psacrificio)
                <tr>
                    <td>{{$psacrificio['COD_PSACRIFICIO']}}</td>  
                    <td>{{$psacrificio['NOM_PERSONA']}}</td> 
                    <td>{{$psacrificio['DNI_PERSONA']}}</td>
                    <td>{{$psacrificio['TEL_PERSONA']}}</td>
                    <td>{{date('d/m/y',strtotime($psacrificio['FEC_SACRIFICIO']))}}</td>
                    <td>{{$psacrificio['DIR_PSACRIFICIO']}}</td>
                    <td>{{$psacrificio['COD_ANIMAL']}}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}">
                            <i class='fas fa-edit' style='font-size:13px;color:Orange'></i> Editar
                        </button>
                        <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger custom-delete-button" type="button" data-toggle="modal" data-target="#psacrificio-delete-confirm" data-id="{{$psacrificio['COD_PSACRIFICIO']}}">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>




                    </td>
                </tr>
                <!-- Modal for editing goes here -->
                <div class="modal fade bd-example-modal-sm" id="psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualizar Datos</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresa los Nuevos Datos</p>
                                <form action="{{ url('psacrificio/actualizar') }}" method="post" class="row g-3 needs-validation" novalidate>
                                    @csrf
                                        <input type="hidden" class="form-control" name="COD_PSACRIFICIO" value="{{$psacrificio['COD_PSACRIFICIO']}}">
                                        
                                        <div class="mb-3 mt-3">
                                            <label for="psacrificio" class="form-label">Nombre de la Persona</label>
                                            <input type="text" class="form-control" id="NOM_PERSONA" name="NOM_PERSONA" placeholder="Ingrese el nombre de la persona" value="{{$psacrificio['NOM_PERSONA']}}" required>
                                            <div class="valid-feedback"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Numero de Identidad</label>
                                            <input type="text" class="form-control" id="DNI_PERSONA" name="DNI_PERSONA" placeholder="Ingrese el numero de identidad" value="{{$psacrificio['DNI_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Numero de Telefono</label>
                                            <input type="text" class="form-control" id="TEL_PERSONA" name="TEL_PERSONA" placeholder="Ingrese el numero de telefono" value="{{$psacrificio['TEL_PERSONA']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Fecha de Sacrificio</label>
                                            <input type="date" class="form-control" id="FEC_SACRIFICIO" name="FEC_SACRIFICIO" placeholder="Ingrese la fecha del sacrificio" value="{{$psacrificio['FEC_SACRIFICIO']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Codigo del Animal</label>
                                            <input type="text" class="form-control" id="COD_ANIMAL" name="COD_ANIMAL" placeholder="Ingrese el codigo del animal" value="{{$psacrificio['COD_ANIMAL']}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="psacrificio">Direccion del Sacrificio</label>
                                            <input type="text" class="form-control" id="DIR_PSACRIFICIOL" name="DIR_PSACRIFICIO" placeholder="Ingrese la direccion del sacrificio" value="{{$psacrificio['DIR_PSACRIFICIO']}}">
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

                <!-- Modal Eliminar -->
                <div class="modal fade" id="psacrificio-delete-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar este registro?
                                </div>
                                    <div class="modal-footer">
                                        <form id="delete-form" method="post">
                                            @csrf
                                                @method('DELETE')
                                                    <input type="hidden" name="delete_id" id="delete_id"> <!-- Agrega este campo oculto, donde almacena el Id del registro que se va a eeliminar-->
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
   <script>
    $(document).ready(function() {
        // Manejar el clic en el botón de eliminar
        $('.btn-outline-danger').on('click', function() {
            var deleteId = $(this).data('id'); // Obtener el ID del registro a eliminar
            $('#delete_id').val(deleteId); // Asignar el ID al campo oculto
        });
    });
</script>

@stop


