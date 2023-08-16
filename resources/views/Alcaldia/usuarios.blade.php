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
        @if(session()->has('user_data'))

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

                <center>
                    <h1>Información de Usuarios</h1>
                </center>
                <blockquote class="blockquote text-center">
                    <p class="mb-0">Registro de Usuarios.</p>
                </blockquote>
            @stop

            @section('content')
                <p align="right">
                    <button type="button" class="Btn" data-toggle="modal" data-target="#Usuarios">
                        <div class="sign">+</div>
            
                        <div class="text">Nuevo</div>
                    </button>
                </p>
                <div class="modal fade bd-example-modal-sm" id="Usuarios" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ingresar un nuevo usuario</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Favor, ingrese los datos solicitados:</p>
                                <form action="{{ url('Usuarios/insertar') }}" method="post">
                                    @csrf
                                        
                                        <div class="mb-3 mt-3">
                                            <label for="NOM_ROL">Rol</label>
                                            <select class="form-select" id="NOM_ROL" name="NOM_ROL" required>
                                                <option value="X" selected = "selected" disabled>- Elija el rol -</option>
                                                @foreach ($rolesArreglo as $roles)
                                                    <option value="{{$roles['NOM_ROL']}}">{{$roles['NOM_ROL']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                
                                        <div class="mb-3">
                                            <label for="COD_PERSONA">Código de la persona</label>
                                            <input type="text" id="COD_PERSONA" class="form-control" name="COD_PERSONA" placeholder="Ingresar el código de la persona" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="LNOM_PERSONA">Usuario</label>
                                            <input type="text" id="NOM_PERSONA" class="form-control" name="NOM_PERSONA" placeholder="Ingresar el alias del usuario" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="PAS_USUARIO">Contraseña</label>
                                            <input type="password" id="PAS_USUARIO" class="form-control" name="PAS_USUARIO" placeholder="Ingresar una contraseña" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="IND_USUARIO">Estado del usuario</label>
                                            <select class="form-select" id="IND_USUARIO" name="IND_USUARIO">
                                                <option value="X" selected = "selected" disabled>- Elija un estado -</option>
                                                <option value="ACTIVO">Activo</option>
                                                <option value="INACTIVO">Inactivo</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="LIM_INTENTOS">Intentos permitidos (Login)</label>
                                            <input type="text" id="LIM_INTENTOS" class="form-control" name="LIM_INTENTOS" placeholder="Ingrese el número de intentos permitidos" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="NUM_INTENTOS_FALLIDOS">Intentos fallidos</label>
                                            <input type="text" id="NUM_INTENTOS_FALLIDOS" class="form-control" name="NUM_INTENTOS_FALLIDOS" placeholder="Ingresar el número de intentos fallidos" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="FEC_VENCIMIENTO">Fecha de Vencimiento de contraseña</label>
                                            <input type="date" id="FEC_VENCIMIENTO" class="form-control" name="FEC_VENCIMIENTO" placeholder="Ingrese la fecha de vencimiento." required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="PREGUNTA">Pregunta de seguridad</label>
                                            <select class="form-select" id="PREGUNTA" name="PREGUNTA" required>
                                                <option value="X" selected = "selected" disabled>- Elija una pregunta -</option>
                                                @foreach ($preguntasArreglo as $preguntas)
                                                    <option value="{{$preguntas['PREGUNTA']}}">{{$preguntas['PREGUNTA']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="RESPUESTA">Respuesta</label>
                                            <input type="text" id="RESPUESTA" class="form-control" name="RESPUESTA" placeholder="Ingrese la respuesta a la pregunta elegida" required>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit">Guardar</button>
                                            <button type="button" id="btnCancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        //Validaciones de los roles.
                                        $('#NOM_ROL').on('input', function() {
                                            var rol = $(this).val();
                                            var errorMessage = 'Favor, elija un rol';
                                            if (rol == 'X') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        //Validaciones del campo DNI el cual no permite el ingreso de letras (las bloquea y no se muestra)
                                        //y solo permite el ingreso de numeros
                                        $('#COD_PERSONA').on('input', function() {
                                            var id = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                            $(this).val(id); // Actualizar el valor del campo solo con números
                                            var errorMessage = 'Favor, ingrese un código de usuario valido';
                                            if (id == '') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        //Validaciones del campo Telefono en el cual no permite el ingreso de letras (las bloquea y no se muestra)
                                        //y solo permite el ingreso de numeros
                                        $('#PAS_USUARIO').on('input', function() {
                                            var password = $(this).val();
                                            var errorMessage = 'Favor, ingrese una contraseña';
                                            
                                            if (password == '') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        $('#IND_USUARIO').on('input', function() {
                                            var estado = $(this).val();
                                            var errorMessage = 'Favor, indique si el usuario está "Activo" o "INACTIVO"';
                                            if (estado == 'X') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        $('#LIM_INTENTOS').on('input', function() {
                                            var intentos = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                            $(this).val(intentos); // Actualizar el valor del campo solo con números
                                            var errorMessage = 'Favor, ingrese el número de intentos permitidos';
                                            if (intentos == '') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        //Esto no lo debería de poner
                                        $('#NUM_INTENTOS_FALLIDOS').on('input', function() {
                                            var intentosFallidos = $(this).val().replace(/\D/g, ''); // Eliminar no numéricos
                                            $(this).val(intentosFallidos); // Actualizar el valor del campo solo con números
                                            var errorMessage = 'Favor, ingrese el número de intentos fallidos';
                                            if (intentosFallidos == '') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        //Validaciones del campo Fecha Registro el cual no permitira el ingreso de una fecha anterior al dia de registro
                                        $('#FEC_VENCIMIENTO').on('input', function() {
                                            var fechaVencimiento = $(this).val();
                                            var currentDate = new Date().toISOString().split('T')[0];
                                            var errorMessage = 'La fecha debe ser válida y no puede ser anterior a hoy';
                                            
                                            if (!fechaVencimiento || fechaVencimiento < currentDate) {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        $('#PREGUNTA').on('input', function() {
                                            var pregunta = $(this).val();
                                            var errorMessage = 'Favor, ingrese una de las preguntas';
                                            if (pregunta == 'X') {
                                                $(this).addClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text(errorMessage);
                                            } else {
                                                $(this).removeClass('is-invalid');
                                                $(this).siblings('.invalid-feedback').text('');
                                            }
                                        });
                                        $('#RESPUESTA').on('input', function() {
                                            var respuesta = $(this).val();
                                            var errorMessage = 'La respuesta no debe ser mayor a 50 carácteres';
                                            
                                            if (respuestaSacrificio.length > 50) {
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
                                        document.getElementById("NOM_ROL").value = "";
                                        document.getElementById("COD_PERSONA").value = "";
                                        document.getElementById("NOM_USUARIO").value = "";
                                        document.getElementById("PAS_USUARIO").value = "";
                                        document.getElementById("IND_USUARIO").value = "";
                                        document.getElementById("LIM_INTENTOS").value = "";
                                        document.getElementById("NUM_INTENTOS_FALLIDOS").value = "";
                                        document.getElementById("FEC_VENCIMIENTO").value = "";
                                        document.getElementById("PREGUNTA").value = "";
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
                                    // Mostrar el modal de registro exitoso cuando se envíe el formulario
                                    $('#Usuarios form').submit(function() {
                                        $('#registroExitosoModal').modal('show');
                                    });    
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table width=100% cellspacing="8" cellpadding="8" class="table table-hover table-responsive table-verde-claro table-striped mt-1" id="usuarios">
                            <thead>
                                <tr>
                                    <th><center>Código de Usuario</center></th>
                                    <th><center>Usuario</center></th>
                                    <th><center>Nombre</center></th>
                                    <th><center>Rol</center></th>
                                    <th><center>Estado</center></th>
                                    <th><center>Ultimo Acceso</center></th>
                                    <th><center>Límite de Intentos</center></th>
                                    <th><center>Intentos Fallidos</center></th>
                                    <th><center>Vencimiento de contraseña</center></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through $citaArreglo and show data -->
                                @foreach($citaArreglo as $Usuarios)
                                    <tr>
                                        <td>{{$Usuarios['COD_USUARIO']}}</td>
                                        <td>{{$Usuarios['NOM_USUARIO']}}</td>
                                        <td>{{$Usuarios['NOM_PERSONA']}}</td>   
                                        <td>{{$Usuarios['NOM_ROL']}}</td> 
                                        <td>{{$Usuarios['IND_USUARIO']}}</td>
                                        <td>{{date('d-m-y', strtotime($Usuarios['FEC_ULTIMO_ACCESO']))}}</td>
                                        <td>{{$Usuarios['LIM_INTENTOS']}}</td>
                                        <td>{{$Usuarios['NUM_INTENTOS_FALLIDOS']}}</td>
                                        <td>{{date('d-m-y', strtotime($Usuarios['FEC_VENCIMIENTO']))}}</td>
                                        <td>
                                            <button value="Editar" title="Editar" class="edit-button" type="button" data-toggle="modal" data-target="#Usuarios-edit-{{$Usuarios['COD_USUARIO']}}">
                                                <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 
                                                    480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 
                                                    22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 
                                                    325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 
                                                    0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                                </svg>
                                            </button>


                                        </td>
                                    </tr>
                                    <!-- Modal for editing goes here -->
                                    <div class="modal fade bd-example-modal-sm" id="Usuarios-edit-{{$Usuarios['COD_USUARIO']}}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Actualizar datos del usuario</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Ingresar nuevos datos</p>
                                                    <form action="{{ url('Usuarios/actualizar') }}" method="post" class="row g-3 needs-validation" novalidate>
                                                        @csrf
                                                            <input type="hidden" class="form-control" name="COD_USUARIO" value="{{$Usuarios['COD_USUARIO']}}">
                                                            
                                                            <div class="mb-3">
                                                                <label for="Usuarios">Usuario</label>
                                                                <input type="text" class="form-control" id="NOM_USUARIO" name="NOM_USUARIO" placeholder="Ingrese el alias del usuario" value="{{$Usuarios['NOM_USUARIO']}}">
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="Usuarios" class="form-label">Rol</label>
                                                                <input type="text" readonly class="form-control" id="NOM_ROL" name="NOM_ROL" value="{{$Usuarios['NOM_ROL']}}">
                                                                <select class="form-select" id="NOM_ROL" name="NOM_ROL">
                                                                    <option value="X" selected = "selected" disabled>- Elija el rol -</option>
                                                                    <option value="Administrador">Administrador</option>
                                                                    <option value="Usuario">Usuario</option>
                                                                    <option value="Secretario">Secretario</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label for="Usuarios" class="form-label">Estado del usuario</label>
                                                                <input type="text" readonly class="form-control" id="IND_USUARIO" name="IND_USUARIO" value="{{$Usuarios['IND_USUARIO']}}">
                                                                <select class="form-select" id="IND_USUARIO" name="IND_USUARIO">
                                                                    <option value="X" selected = "selected" disabled>- Elija un estado -</option>
                                                                    <option value="ACTIVO">Activo</option>
                                                                    <option value="INACTIVO">Inactivo</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Usuarios">Fecha de ultimo acceso</label>
                                                                <?php $fecha_formateadaUA = date('Y-m-d', strtotime($Usuarios['FEC_ULTIMO_ACCESO'])); ?>
                                                                <input type="date" class="form-control" id="date-picker" name="FEC_ULTIMO_ACCESO" value="{{$fecha_formateadaUA}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Usuarios">Intentos permitidos (Login)</label>
                                                                <input type="text" class="form-control" id="LIM_INTENTOS" name="LIM_INTENTOS" placeholder="Ingrese los intentos permitidos" value="{{$Usuarios['LIM_INTENTOS']}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Usuarios">Intentos fallidos</label>
                                                                <input type="text" class="form-control" id="NUM_INTENTOS_FALLIDOS" name="NUM_INTENTOS_FALLIDOS" placeholder="Ingrese los intentos fallidos" value="{{$Usuarios['NUM_INTENTOS_FALLIDOS']}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Usuarios">Fecha de vencimiento de contraseña</label>
                                                                <?php $fecha_formateadaV = date('Y-m-d', strtotime($Usuarios['FEC_VENCIMIENTO'])); ?>
                                                                <input type="date" class="form-control" id="FEC_VENCIMIENTO" name="FEC_VENCIMIENTO" value="{{$fecha_formateadaV}}">
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
                    </div>
                </div>

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
                            $('#usuarios').DataTable({
                                responsive: true
                            });
                        });
                    </script>
                </script>   
            @stop

            @section('css')
                <link rel="stylesheet" href="/css/admin_custom.css">
            @stop
    @else
            <!-- Contenido para usuarios no autenticados -->
            <script>
                window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
            </script>   
    @endif
@stop

