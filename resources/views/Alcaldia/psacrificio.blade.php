@extends('adminlte::page')

@section('title', 'Alcaldia')

@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Clase CSS personalizada aquí -->
    <style>
        /* CSS personalizado */
        .custom-delete-button:hover .fas.fa-trash-alt {
            color: white !important;
        }
    </style>

    <style>
        /* Boton Nuevo */
        .Btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 40px;
            height: 40px;
            border-radius: calc(45px/2);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: rgb(0, 143, 0);
            }

        /* plus sign */
        .sign {
            width: 100%;
            font-size: 2.0em;
            color: white;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: white;
            font-size: 1.0em;
            font-weight: 300;
            transition-duration: .3s;
        }
        /* hover effect on button width */
        .Btn:hover {
            width: 125px;
            transition-duration: .3s;
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 15px;
        }
        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 15px;
        }
        /* button click effect*/
        .Btn:active {
            transform: translate(2px ,2px);
        }
    </style>
    <style>
        /* Estilos al boton editar */
        .edit-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgb(0, 150, 255);
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
            cursor: pointer;
            transition-duration: 0.3s;
            overflow: hidden;
            position: relative;
            text-decoration: none !important;
            }

        .edit-svgIcon {
            width: 17px;
            transition-duration: 0.3s;
        }

        .edit-svgIcon path {
            fill: white;
        }

        .edit-button:hover {
            width: 120px;
            border-radius: 50px;
            transition-duration: 0.3s;
            background-color: rgb(0, 100, 255);
            align-items: center;
        }

        .edit-button:hover .edit-svgIcon {
            width: 20px;
            transition-duration: 0.3s;
            transform: translateY(60%);
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }

        .edit-button::before {
            display: none;
            content: "Editar";
            color: white;
            transition-duration: 0.3s;
            font-size: 2px;
        }

        .edit-button:hover::before {
            display: block;
            padding-right: 10px;
            font-size: 13px;
            opacity: 1;
            transform: translateY(0px);
            transition-duration: 0.3s;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('content_header')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <center><br>
        <h1>INFORMACIÓN DE LOS PERMISOS DE SACRIFICIO</h1>
    </center></br>

    
@stop

@section('content')
    <p align="right">
        <button type="button" class="Btn" data-toggle="modal" data-target="#psacrificio">
            <div class="sign">+</div>
  
            <div class="text">Nuevo</div>
        </button>
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
                                <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el nombre completo de la persona" required>
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
                        $(document).ready(function() {
                            //Validaciones del nombre persona, no permite que se ingrese numeros solo letras
                            $('#NOM_PERSONA').on('input', function() {
                                var nombre = $(this).val();
                                var errorMessage = 'El nombre debe tener al menos 5 letras';
                                if (nombre.length < 5 || !/^[a-zA-Z\s]+$/.test(nombre)) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            //Validaciones del campo DNI el cual no permite el ingreso de letras (las bloquea y no se muestra)
                            //y solo permite el ingreso de numeros
                            $('#DNI_PERSONA').on('input', function() {
                                var dni = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                $(this).val(dni); // Actualizar el valor del campo solo con números
                                var errorMessage = 'El DNI debe tener exactamente 13 dígitos numéricos ';
                                if (dni.length !== 13) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            //Validaciones del campo Telefono en el cual no permite el ingreso de letras (las bloquea y no se muestra)
                            //y solo permite el ingreso de numeros
                            $('#TEL_PERSONA').on('input', function() {
                                var telefono = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                $(this).val(telefono); // Actualizar el valor del campo solo con números
                                var errorMessage = 'El teléfono debe tener exactamente 8 dígitos numéricos ';
                                if (telefono.length !== 8) {
                                    $(this).addClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text(errorMessage);
                                } else {
                                    $(this).removeClass('is-invalid');
                                    $(this).siblings('.invalid-feedback').text('');
                                }
                            });
                            //Validaciones del campo Fecha Registro el cual no permitira el ingreso de una fecha anterior al dia de registro
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
                            //
                            $('#COD_ANIMAL').on('input', function() {
                                var codigoAnimal = $(this).val();
                                // Implementar la lógica para verificar si el código ya existe y 
                                //mostrar el mensaje de error correspondiente si ya está en uso.
                            });
                            //Validaciones del campo direccion 
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
                            document.getElementById("NOM_PERSONA").value = "";
                            document.getElementById("DNI_PERSONA").value = "";
                            document.getElementById("TEL_PERSONA").value = "";
                            document.getElementById("FEC_SACRIFICIO").value = "";
                            document.getElementById("COD_ANIMAL").value = "";
                            document.getElementById("DIR_PSACRIFICIO").value = "";

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
                        // Mostrar el modal de registro exitoso cuando se envíe el formulario
                        $('#psacrificio form').submit(function() {
                            $('#registroExitosoModal').modal('show');
                        });    
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

        <table width=100% cellspacing="8" cellpadding="8" class="table table-hover table-responsive table-verde-claro table-striped mt-1" id="sacrificio">
        <thead>
            <tr>
                <th>Nº</th>
                <th><center>Nombre</center></th>
                <th><center>Numero de Identidad</center></th>
                <th><center>Telefono</center></th>
                <th><center>Fecha del Sacrificio</center></th>
                <th><center>Direccion del Sacrificio</center></th>
                <th><center>Registro del Animal</center></th>
                <th><center>Opciones de la Tabla</center></th>
            </tr>
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
                        <button value="Editar" title="Editar" class="edit-button" type="button" data-toggle="modal" data-target="#psacrificio-edit-{{$psacrificio['COD_PSACRIFICIO']}}">
                            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 
                                480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 
                                22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 
                                325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 
                                0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                            </svg>
                        </button>
                        <!--<button value="Eliminar" title="Eliminar" class="btn btn-outline-danger custom-delete-button" type="button" data-toggle="modal" data-target="#psacrificio-delete-confirm" data-id="{{$psacrificio['COD_PSACRIFICIO']}}">
                            <i class='fas fa-trash-alt' style='font-size:13px;color:Red'></i> Eliminar
                        </button>-->
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
                                            <label for="psacrificio" class="form-laabel">Fecha de Sacrificio</label>
                                            <!-- Codigo para que me muestre la fecha ya registrada al momento de actualizar --->
                                            <?php $fecha_formateada = date('Y-m-d', strtotime($psacrificio['FEC_SACRIFICIO'])); ?>
                                            <input type="date" class="form-control" id="FEC_SACRIFICIO" name="FEC_SACRIFICIO" placeholder="Ingrese la fecha del sacrificio" value="{{$fecha_formateada}}">
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

                <!-- Modal de Confirmación de Registro Exitoso -->
                <div class="modal fade" id="registroExitosoModal" tabindex="-1" aria-labelledby="registroExitosoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="registroExitosoModalLabel">Registro Exitoso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Permiso de sacrificio registrado exitosamente.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
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
    </div>
    </div>
@stop

@section('js')
   <script> console.log('Hi!'); </script>
   <script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#sacrificio').DataTable({
                    responsive: true
                });
            });
        </script>
    </script>
    <script>
        // Manejar el clic en el botón de eliminar
        $('.btn-outline-danger').on('click', function() {
                    var deleteId = $(this).data('id');
                    $('#delete_id').val(deleteId);
                });
            });
        //Función para confirmar eliminación
        function confirmDelete(id) {
            $('#psacrificio-delete-confirm').modal('show');
            $('#delete-form').attr('action', '{{ url("psacrificio/eliminar") }}/' + id);
        }
    </script>    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop